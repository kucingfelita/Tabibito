<?php

namespace App\Http\Controllers;

use App\Jobs\SendETicketMailJob;
use App\Models\Transaction;
use App\Services\MidtransService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class MidtransWebhookController extends Controller
{
    public function handle(MidtransService $midtransService): JsonResponse
    {
        $notification = $midtransService->parseNotification();

        $transaction = Transaction::query()
            ->where('order_id', $notification->order_id)
            ->with('ticket.destination.owner')
            ->first();

        if (! $transaction) {
            return response()->json(['message' => 'Order tidak ditemukan.'], 404);
        }

        if ($notification->transaction_status === 'settlement') {
            DB::transaction(function () use ($transaction) {
                if ($transaction->status === 'settlement' || $transaction->status === 'used') {
                    return;
                }

                $transaction->update(['status' => 'settlement']);
                $owner = $transaction->ticket->destination->owner;
                $owner->increment('balance', $transaction->total_price);
            });

            SendETicketMailJob::dispatch($transaction->fresh(['user', 'ticket.destination']));
        }

        if (in_array($notification->transaction_status, ['expire', 'cancel', 'failure'], true)) {
            DB::transaction(function () use ($transaction) {
                if ($transaction->status !== 'pending') {
                    return;
                }

                $transaction->update(['status' => 'expire']);
                $transaction->ticket->increment('current_quota', $transaction->qty);
            });
        }

        return response()->json(['message' => 'Webhook diproses.']);
    }
}
