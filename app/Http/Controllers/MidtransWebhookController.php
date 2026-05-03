<?php

namespace App\Http\Controllers;

use App\Jobs\SendETicketMailJob;
use App\Models\Transaction;
use App\Services\MidtransService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MidtransWebhookController extends Controller
{
    public function handle(MidtransService $midtransService): JsonResponse
    {
        try {
            $notification = $midtransService->parseNotification();

            Log::info('Midtrans webhook received', [
                'order_id' => $notification->order_id ?? 'N/A',
                'status' => $notification->transaction_status ?? 'N/A',
            ]);

            // Find transaction by order_id (handle both original and resumed order_ids)
            $orderId = $notification->order_id;
            $transaction = Transaction::query()
                ->where('order_id', $orderId)
                ->with('ticket.destination.owner')
                ->first();

            // If not found, try searching without the -R suffix
            if (!$transaction && str_contains($orderId, '-R')) {
                $originalOrderId = str_replace('-R' . substr($orderId, strpos($orderId, '-R') + 2), '', $orderId);
                $transaction = Transaction::query()
                    ->where('order_id', 'like', $originalOrderId . '%')
                    ->with('ticket.destination.owner')
                    ->first();
            }

            if (!$transaction) {
                Log::warning('Transaction not found for webhook', ['order_id' => $orderId]);
                return response()->json(['message' => 'Order tidak ditemukan.'], 404);
            }

            $isSuccess = in_array($notification->transaction_status, ['settlement', 'success', 'capture'], true);
            if ($isSuccess) {
                DB::transaction(function () use ($transaction) {
                    if ($transaction->status === 'settlement' || $transaction->status === 'used') {
                        return;
                    }

                    $transaction->update(['status' => 'settlement']);

                    if ($transaction->ticket && $transaction->ticket->destination && $transaction->ticket->destination->owner) {
                        $owner = $transaction->ticket->destination->owner;
                        $owner->increment('balance', $transaction->total_price);
                    }
                });

                Log::info('Transaction marked as settled', ['order_id' => $transaction->order_id]);
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

                Log::info('Transaction marked as expired', ['order_id' => $transaction->order_id]);
            }

            return response()->json(['message' => 'Webhook diproses.']);
        } catch (\Exception $e) {
            Log::error('Midtrans webhook error', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }
}
