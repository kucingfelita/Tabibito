<?php

namespace App\Services;

use App\Models\Ticket;
use App\Models\Transaction;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Notification;
use Midtrans\Snap;
use Midtrans\Transaction as MidtransTransaction;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey = (string) config('services.midtrans.server_key');
        Config::$isProduction = (bool) config('services.midtrans.is_production', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function createSnapToken(Transaction $transaction, Ticket $ticket, ?string $orderId = null): string
    {
        $expiry = Transaction::midtransExpiryConfig();
        $snapOrderId = $orderId ?? $transaction->order_id;

        $params = [
            'enabled_payments' => [
                'credit_card',
                'gopay',
                'shopeepay',
                'bank_transfer',
                'bca_va',
                'bni_va',
                'bri_va',
                'permata_va',
                'indomaret',
                'alfamart',
                'echannel',
                'cimb_clicks',
            ],
            'transaction_details' => [
                'order_id' => $snapOrderId,
                'gross_amount' => (int) $transaction->total_price,
            ],
            'expiry' => [
                'start_time' => now()->timezone('Asia/Jakarta')->format('Y-m-d H:i:s O'),
                'unit' => $expiry['unit'],
                'duration' => $expiry['duration'],
            ],
            'item_details' => [
                [
                    'id' => (string) $ticket->id,
                    'price' => (int) $ticket->price,
                    'quantity' => (int) $transaction->qty,
                    'name' => $ticket->name,
                ],
            ],
            'customer_details' => [
                'first_name' => $transaction->user->name,
                'email' => $transaction->user->email,
                'phone' => $transaction->user->phone,
            ],
            'callbacks' => [
                'finish' => url('/payment/finish'),
                'unfinish' => url('/checkout/' . $ticket->id),
                'error' => url('/checkout/' . $ticket->id),
            ],
        ];

        return Snap::getSnapToken($params);
    }

    /**
     * Batalkan transaksi di Midtrans agar VA/QRIS tidak dapat dibayar setelah batas 6 jam.
     */
    public function cancelOrExpireTransaction(string $orderId): void
    {
        if ($orderId === '') {
            return;
        }

        try {
            MidtransTransaction::cancel($orderId);
            Log::info('Midtrans transaction cancelled', ['order_id' => $orderId]);

            return;
        } catch (\Exception $e) {
            Log::debug('Midtrans cancel failed, trying expire', [
                'order_id' => $orderId,
                'error' => $e->getMessage(),
            ]);
        }

        try {
            MidtransTransaction::expire($orderId);
            Log::info('Midtrans transaction expired', ['order_id' => $orderId]);
        } catch (\Exception $e) {
            Log::warning('Midtrans cancel/expire failed', [
                'order_id' => $orderId,
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function parseNotification(): Notification
    {
        return new Notification();
    }

    public function checkTransactionStatus(string $orderId): ?object
    {
        try {
            return MidtransTransaction::status($orderId);
        } catch (\Exception $e) {
            return null;
        }
    }
}
