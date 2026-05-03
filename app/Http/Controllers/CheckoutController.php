<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Jobs\SendInvoicePendingMailJob;
use App\Models\Ticket;
use App\Models\Transaction;
use App\Services\MidtransService;
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

    public function resume(Request $request): View
    {
        $orderId = $request->query('order_id');

        if (!$orderId || !auth()->check()) {
            abort(404, 'Transaksi tidak ditemukan atau sudah tidak dapat dilanjutkan.');
        }

        $transaction = Transaction::query()
            ->where('order_id', trim($orderId))
            ->where('user_id', auth()->id())
            ->where('status', 'pending')
            ->with('ticket.destination')
            ->first();

        if (!$transaction) {
            abort(404, 'Transaksi tidak ditemukan atau sudah tidak dapat dilanjutkan.');
        }

        // Always regenerate snap token to ensure it's valid
        $midtransService = app(MidtransService::class);
        $transaction->load(['user', 'ticket']);

        // Keep the original transaction order_id in the DB, but use a temporary one for Midtrans snap re-creation.
        $snapOrderId = $transaction->order_id . '-R' . now()->format('His');
        $snapToken = $midtransService->createSnapToken($transaction, $transaction->ticket, $snapOrderId);
        $transaction->update(['snap_token' => $snapToken]);

        return view('checkout.resume', compact('transaction'));
    }

    public function store(CheckoutRequest $request, Ticket $ticket, MidtransService $midtransService): RedirectResponse
    {
        $payload = $request->validated();

        $transaction = DB::transaction(function () use ($ticket, $payload) {
            $lockedTicket = Ticket::query()->lockForUpdate()->findOrFail($ticket->id);
            $availableQuota = $lockedTicket->getAvailableQuota($payload['booking_date']);

            if ($payload['qty'] > $availableQuota) {
                abort(422, 'Kuota tiket tidak mencukupi untuk tanggal tersebut.');
            }

            return Transaction::query()->create([
                'order_id' => 'ORD-' . now()->format('YmdHis') . '-' . strtoupper(str()->random(6)),
                'user_id' => auth()->id(),
                'ticket_id' => $lockedTicket->id,
                'qty' => (int) $payload['qty'],
                'total_price' => $lockedTicket->price * (int) $payload['qty'],
                'booking_date' => $payload['booking_date'],
                'status' => 'pending',
                'qr_code_token' => (string) str()->uuid(),
            ]);
        });

        $transaction->load(['user', 'ticket']);
        $snapToken = $midtransService->createSnapToken($transaction, $transaction->ticket);
        $transaction->update(['snap_token' => $snapToken]);
        SendInvoicePendingMailJob::dispatch($transaction);

        return back()->with('success', 'Token pembayaran berhasil dibuat.')->with('snap_token', $snapToken);
    }

    public function finish(Request $request): RedirectResponse|View
    {
        $orderId = $request->query('order_id');
        $status = $request->query('transaction_status', $request->query('status', ''));

        // If no order_id, show not found
        if (!$orderId) {
            return view('checkout.finish', ['transaction' => null, 'status' => 'not_found']);
        }

        $transaction = Transaction::query()
            ->where('order_id', $orderId)
            ->with('ticket.destination')
            ->first();

        // If not found, try searching without the -R suffix (for resumed transactions)
        if (!$transaction && str_contains($orderId, '-R')) {
            $originalOrderId = explode('-R', $orderId)[0];
            $transaction = Transaction::query()
                ->where('order_id', 'like', $originalOrderId . '%')
                ->with('ticket.destination')
                ->first();
        }

        // If transaction doesn't exist, show not found
        if (!$transaction) {
            return view('checkout.finish', ['transaction' => null, 'status' => 'not_found']);
        }

        // If payment is still pending, double check with Midtrans API directly.
        // This is crucial for local testing where webhooks can't reach localhost.
        if ($transaction->status === 'pending') {
            $midtransService = app(MidtransService::class);
            $midtransStatus = $midtransService->checkTransactionStatus($orderId);

            if ($midtransStatus && in_array($midtransStatus->transaction_status, ['settlement', 'success', 'capture'], true)) {
                DB::transaction(function () use ($transaction) {
                    $transaction->update(['status' => 'settlement']);
                    if ($transaction->ticket && $transaction->ticket->destination && $transaction->ticket->destination->owner) {
                        $owner = $transaction->ticket->destination->owner;
                        $owner->increment('balance', $transaction->total_price);
                    }
                });
                
                \App\Jobs\SendETicketMailJob::dispatch($transaction->fresh(['user', 'ticket.destination']));
            } elseif ($midtransStatus && in_array($midtransStatus->transaction_status, ['expire', 'cancel', 'failure'], true)) {
                DB::transaction(function () use ($transaction) {
                    $transaction->update(['status' => 'expire']);
                });
            } else {
                return redirect()->route('checkout.resume', ['order_id' => $transaction->order_id])
                    ->with('warning', 'Silakan lanjutkan pembayaran Anda.');
            }
        }

        // For successful or failed payments, show the appropriate finish page
        return view('checkout.finish', ['transaction' => $transaction, 'status' => $transaction->status]);
    }
}
