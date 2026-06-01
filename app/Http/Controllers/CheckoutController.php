<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Jobs\SendInvoicePendingMailJob;
use App\Models\Ticket;
use App\Models\Transaction;
use App\Services\MidtransService;
use App\Services\TransactionPaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function show(Ticket $ticket): View
    {
        return view('checkout.show', compact('ticket'));
    }

    public function quotaCheck(Ticket $ticket, Request $request): \Illuminate\Http\JsonResponse
    {
        $date = $request->query('date');
        if (!$date) {
            return response()->json(['available' => $ticket->daily_quota]);
        }

        return response()->json(['available' => $ticket->getAvailableQuota($date)]);
    }

    public function quotasMonth(Ticket $ticket, Request $request): \Illuminate\Http\JsonResponse
    {
        $year = $request->integer('year', now()->year);
        $month = $request->integer('month', now()->month);

        $start = \Illuminate\Support\Carbon::createFromDate($year, $month, 1)->startOfMonth()->toDateString();
        $end = \Illuminate\Support\Carbon::createFromDate($year, $month, 1)->endOfMonth()->toDateString();

        $sold = $ticket->transactions()
            ->whereBetween('booking_date', [$start, $end])
            ->whereIn('status', ['pending', 'settlement', 'used'])
            ->groupBy('booking_date')
            ->select('booking_date', DB::raw('SUM(qty) as sold_qty'))
            ->get()
            ->pluck('sold_qty', 'booking_date')
            ->toArray();

        $dailyQuota = $ticket->daily_quota;
        $quotas = [];
        $daysInMonth = \Illuminate\Support\Carbon::createFromDate($year, $month, 1)->daysInMonth;

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $dateStr = sprintf('%04d-%02d-%02d', $year, $month, $day);
            $soldQty = 0;
            foreach ($sold as $dateKey => $qty) {
                $formattedKey = $dateKey;
                if ($dateKey instanceof \DateTimeInterface) {
                    $formattedKey = $dateKey->format('Y-m-d');
                } else {
                    $formattedKey = date('Y-m-d', strtotime($dateKey));
                }
                if ($formattedKey === $dateStr) {
                    $soldQty = (int) $qty;
                    break;
                }
            }
            $quotas[$dateStr] = max(0, $dailyQuota - $soldQty);
        }

        return response()->json($quotas);
    }

    public function resume(Request $request, MidtransService $midtransService, TransactionPaymentService $paymentService): View|RedirectResponse
    {
        $orderId = $request->query('order_id');

        if (!$orderId || !auth()->check()) {
            abort(404, 'Transaksi tidak ditemukan atau sudah tidak dapat dilanjutkan.');
        }

        $transaction = Transaction::query()
            ->where('order_id', trim($orderId))
            ->where('user_id', auth()->id())
            ->where('status', 'pending')
            ->with(['ticket.destination.coverImage', 'ticket.destination.images'])
            ->first();

        if (!$transaction) {
            abort(404, 'Transaksi tidak ditemukan atau sudah tidak dapat dilanjutkan.');
        }

        $transaction->refreshPaymentExpiresAt();
        $transaction->refresh();

        if ($paymentService->expirePendingPayment($transaction) || $transaction->fresh()->status !== 'pending') {
            return redirect()
                ->route('history.index')
                ->with('error', 'Batas waktu pembayaran (' . Transaction::paymentTimeoutLabel() . ') telah habis. Pesanan dibatalkan, kuota dikembalikan, dan kode pembayaran tidak lagi berlaku.');
        }

        $transaction->load(['user', 'ticket']);
        $snapOrderId = $transaction->order_id . '-R' . now()->format('His');
        $snapToken = $midtransService->createSnapToken($transaction, $transaction->ticket, $snapOrderId);
        $transaction->update(['snap_token' => $snapToken]);
        $paymentService->recordSnapOrder($transaction, $snapOrderId);

        return view('checkout.resume', compact('transaction'));
    }

    public function store(
        CheckoutRequest $request,
        Ticket $ticket,
        MidtransService $midtransService,
        TransactionPaymentService $paymentService,
    ): RedirectResponse {
        $payload = $request->validated();

        $transaction = DB::transaction(function () use ($ticket, $payload, $paymentService) {
            $lockedTicket = Ticket::query()->lockForUpdate()->findOrFail($ticket->id);

            $paymentService->expireDuplicatePendingOrders(
                (int) auth()->id(),
                $lockedTicket->id,
                $payload['booking_date'],
            );

            $availableQuota = $lockedTicket->getAvailableQuota($payload['booking_date']);

            if ($payload['qty'] > $availableQuota) {
                abort(422, 'Kuota tiket tidak mencukupi untuk tanggal tersebut.');
            }

            $paymentExpiresAt = Transaction::paymentExpiresAfter(now());

            return Transaction::query()->create([
                'order_id' => 'ORD-' . now()->format('YmdHis') . '-' . strtoupper(str()->random(6)),
                'user_id' => auth()->id(),
                'ticket_id' => $lockedTicket->id,
                'qty' => (int) $payload['qty'],
                'total_price' => $lockedTicket->price * (int) $payload['qty'],
                'booking_date' => $payload['booking_date'],
                'status' => 'pending',
                'payment_expires_at' => $paymentExpiresAt,
                'last_midtrans_order_id' => null,
                'qr_code_token' => null,
            ]);
        });

        $transaction->load(['user', 'ticket']);
        $snapToken = $midtransService->createSnapToken($transaction, $transaction->ticket);
        $transaction->update(['snap_token' => $snapToken]);
        $paymentService->recordSnapOrder($transaction, $transaction->order_id);
        SendInvoicePendingMailJob::dispatch($transaction);

        return back()->with('success', 'Token pembayaran berhasil dibuat.')->with('snap_token', $snapToken);
    }

    public function finish(Request $request, MidtransService $midtransService, TransactionPaymentService $paymentService): RedirectResponse|View
    {
        if (!auth()->check()) {
            return redirect()->guest(route('login'));
        }

        $orderId = $request->query('order_id');

        if (!$orderId) {
            return view('checkout.finish', [
                'transaction' => null,
                'status' => 'not_found',
                'showQr' => false,
            ]);
        }

        $transaction = TransactionPaymentService::findByMidtransOrderId((string) $orderId);

        if (!$transaction) {
            return view('checkout.finish', [
                'transaction' => null,
                'status' => 'not_found',
                'showQr' => false,
            ]);
        }

        $transaction->load(['ticket.destination.coverImage', 'ticket.destination.images', 'user']);

        if ($transaction->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke transaksi ini.');
        }

        $displayStatus = $transaction->status;

        if ($transaction->status === 'pending') {
            $midtransStatus = $midtransService->checkTransactionStatus((string) $orderId);

            if ($midtransStatus && $paymentService->isSuccessfulMidtransStatus($midtransStatus->transaction_status ?? null)) {
                $result = $paymentService->attemptSettle($transaction, $midtransStatus);

                $transaction->refresh();

                if ($result === 'settled' || $result === 'already_settled') {
                    if (empty($transaction->qr_code_token)) {
                        $transaction->issueEntryQrToken();
                    }
                    $transaction->refresh();
                    $displayStatus = 'settlement';
                } elseif ($result === 'rejected_late') {
                    $displayStatus = 'late_payment_rejected';
                } else {
                    $displayStatus = $transaction->status;
                }
            } elseif ($midtransStatus && in_array($midtransStatus->transaction_status, ['expire', 'cancel', 'failure'], true)) {
                $paymentService->expirePendingPayment($transaction->fresh(), cancelOnMidtrans: false);
                $transaction->refresh();
                $displayStatus = 'expire';
            } elseif ($transaction->isPaymentWindowExpired()) {
                $paymentService->expirePendingPayment($transaction);
                $transaction->refresh();
                $displayStatus = 'expire';
            } else {
                return redirect()->route('checkout.resume', ['order_id' => $transaction->order_id])
                    ->with('warning', 'Silakan lanjutkan pembayaran Anda.');
            }
        }

        $showQr = $displayStatus === 'settlement'
            && $transaction->user_id === auth()->id()
            && ! empty($transaction->qr_code_token);

        return view('checkout.finish', [
            'transaction' => $transaction,
            'status' => $displayStatus,
            'showQr' => $showQr,
        ]);
    }

    public function expirePayment(Request $request, TransactionPaymentService $paymentService): JsonResponse
    {
        $orderId = trim((string) $request->input('order_id', ''));

        if ($orderId === '') {
            return response()->json(['success' => false, 'message' => 'Order ID tidak valid.'], 422);
        }

        $transaction = Transaction::query()
            ->where('order_id', $orderId)
            ->where('user_id', auth()->id())
            ->first();

        if (!$transaction) {
            return response()->json(['success' => false, 'message' => 'Transaksi tidak ditemukan.'], 404);
        }

        if ($transaction->status !== 'pending') {
            return response()->json([
                'success' => true,
                'already_expired' => true,
                'redirect' => route('history.index'),
            ]);
        }

        if (!$transaction->isPaymentWindowExpired()) {
            return response()->json([
                'success' => false,
                'message' => 'Batas waktu pembayaran belum habis.',
                'expires_at' => $transaction->paymentExpiresAt()->toIso8601String(),
            ], 422);
        }

        $paymentService->expirePendingPayment($transaction);

        return response()->json([
            'success' => true,
            'message' => 'Pesanan dibatalkan. Kuota tiket telah dikembalikan dan kode pembayaran tidak lagi berlaku.',
            'redirect' => route('history.index'),
        ]);
    }
}
