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

    public function resume(Request $request): View
    {
        $orderId = $request->query('order_id');

        $transaction = Transaction::query()
            ->where('order_id', $orderId)
            ->where('user_id', auth()->id())
            ->where('status', 'pending')
            ->with('ticket.destination')
            ->first();

        if (!$transaction) {
            abort(404, 'Transaksi tidak ditemukan atau sudah tidak dapat dilanjutkan.');
        }

        // Regenerate snap token if missing
        if (!$transaction->snap_token) {
            $midtransService = app(MidtransService::class);
            $transaction->load(['user', 'ticket']);
            $snapToken = $midtransService->createSnapToken($transaction, $transaction->ticket);
            $transaction->update(['snap_token' => $snapToken]);
        }

        return view('checkout.resume', compact('transaction'));
    }

    public function store(CheckoutRequest $request, Ticket $ticket, MidtransService $midtransService): RedirectResponse
    {
        $payload = $request->validated();

        $transaction = DB::transaction(function () use ($ticket, $payload) {
            $lockedTicket = Ticket::query()->lockForUpdate()->findOrFail($ticket->id);

            if ($payload['qty'] > $lockedTicket->current_quota) {
                abort(422, 'Kuota tiket tidak mencukupi.');
            }

            $lockedTicket->decrement('current_quota', (int) $payload['qty']);

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

    public function finish(Request $request): View
    {
        $orderId = $request->query('order_id');
        $status = $request->query('transaction_status', $request->query('status', 'pending'));

        $transaction = null;
        if ($orderId) {
            $transaction = Transaction::query()
                ->where('order_id', $orderId)
                ->with('ticket.destination')
                ->first();
        }

        return view('checkout.finish', compact('transaction', 'status'));
    }
}
