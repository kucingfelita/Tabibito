<?php

namespace App\Services;

use App\Models\Ticket;
use App\Models\Transaction;
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

    public function createSnapToken(Transaction $transaction, Ticket $ticket): string
    {
        $params = [
            'enabled_payments' => [
                'bank_transfer',
                'bca_va',
                'bni_va',
                'bri_va',
                'permata_va',
            ],
            'transaction_details' => [
                'order_id' => $transaction->order_id,
                'gross_amount' => (int) $transaction->total_price,
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
                'finish' => url('/checkout/finish'),
                'unfinish' => url('/checkout/' . $ticket->id),
                'error' => url('/checkout/' . $ticket->id),
            ],
        ];

        return Snap::getSnapToken($params);
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
