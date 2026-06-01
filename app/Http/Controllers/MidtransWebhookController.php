<?php

namespace App\Http\Controllers;

use App\Services\MidtransService;
use App\Services\TransactionPaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class MidtransWebhookController extends Controller
{
    public function handle(
        MidtransService $midtransService,
        TransactionPaymentService $paymentService,
    ): JsonResponse {
        try {
            $notification = $midtransService->parseNotification();

            Log::info('Midtrans webhook received', [
                'order_id' => $notification->order_id ?? 'N/A',
                'status' => $notification->transaction_status ?? 'N/A',
            ]);

            $orderId = (string) ($notification->order_id ?? '');
            $transaction = TransactionPaymentService::findByMidtransOrderId($orderId);

            if (!$transaction) {
                Log::warning('Transaction not found for webhook', ['order_id' => $orderId]);

                return response()->json(['message' => 'Order tidak ditemukan.'], 404);
            }

            $transaction->load('ticket.destination.owner');

            if ($paymentService->isSuccessfulMidtransStatus($notification->transaction_status ?? null)) {
                $result = $paymentService->attemptSettle($transaction, $notification);

                if ($result === 'settled') {
                    Log::info('Transaction marked as settled', ['order_id' => $transaction->order_id]);
                } elseif ($result === 'rejected_late') {
                    Log::warning('Late payment rejected by platform policy', ['order_id' => $transaction->order_id]);
                }
            }

            if (in_array($notification->transaction_status, ['expire', 'cancel', 'failure'], true)) {
                if ($transaction->status === 'pending') {
                    $paymentService->expirePendingPayment($transaction->fresh(), cancelOnMidtrans: false);
                    Log::info('Transaction marked as expired from webhook', ['order_id' => $transaction->order_id]);
                }
            }

            return response()->json(['message' => 'Webhook diproses.']);
        } catch (\Exception $e) {
            Log::error('Midtrans webhook error', ['error' => $e->getMessage()]);

            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }
}
