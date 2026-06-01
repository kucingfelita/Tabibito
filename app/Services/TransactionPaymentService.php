<?php

namespace App\Services;

use App\Jobs\SendETicketMailJob;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransactionPaymentService
{
    public function __construct(
        private readonly MidtransService $midtrans,
    ) {}

    public static function findByMidtransOrderId(string $orderId): ?Transaction
    {
        $orderId = trim($orderId);

        $transaction = Transaction::query()
            ->where('order_id', $orderId)
            ->orWhere('last_midtrans_order_id', $orderId)
            ->first();

        if ($transaction) {
            return $transaction;
        }

        if (str_contains($orderId, '-R')) {
            $baseOrderId = explode('-R', $orderId, 2)[0];

            return Transaction::query()
                ->where('order_id', $baseOrderId)
                ->first();
        }

        return null;
    }

    public function canSettle(Transaction $transaction): bool
    {
        return $transaction->status === 'pending'
            && !$transaction->isPaymentWindowExpired();
    }

    /**
     * @return 'settled'|'already_settled'|'rejected_late'|'rejected_invalid'|'unchanged'
     */
    public function attemptSettle(Transaction $transaction, ?object $midtransPayload = null): string
    {
        return DB::transaction(function () use ($transaction, $midtransPayload) {
            $locked = Transaction::query()
                ->lockForUpdate()
                ->with('ticket.destination.owner', 'user')
                ->findOrFail($transaction->id);

            if (in_array($locked->status, ['settlement', 'used'], true)) {
                return 'already_settled';
            }

            if (in_array($locked->status, ['expire', 'cancelled'], true)) {
                $this->logLatePaymentRejected($locked, $midtransPayload);

                return 'rejected_late';
            }

            if ($locked->isPaymentWindowExpired()) {
                $this->expirePendingPayment($locked, cancelOnMidtrans: true);
                $this->logLatePaymentRejected($locked, $midtransPayload);

                return 'rejected_late';
            }

            if ($midtransPayload && !$this->validateMidtransAmount($locked, $midtransPayload)) {
                Log::warning('Midtrans gross_amount mismatch', [
                    'order_id' => $locked->order_id,
                    'expected' => (int) $locked->total_price,
                    'received' => $midtransPayload->gross_amount ?? null,
                ]);

                return 'rejected_invalid';
            }

            if ($locked->status !== 'pending') {
                return 'unchanged';
            }

            $locked->issueEntryQrToken();
            $locked->update(['status' => 'settlement']);

            if ($locked->ticket?->destination?->owner) {
                $locked->ticket->destination->owner->increment('balance', $locked->total_price);
            }

            SendETicketMailJob::dispatch($locked->fresh(['user', 'ticket.destination']));

            return 'settled';
        });
    }

    public function expirePendingPayment(Transaction $transaction, bool $cancelOnMidtrans = true, bool $force = false): bool
    {
        if ($transaction->status !== 'pending') {
            return false;
        }

        if (!$force && !$transaction->isPaymentWindowExpired()) {
            return false;
        }

        $transaction->update(['status' => 'expire']);

        if ($cancelOnMidtrans) {
            $this->midtrans->cancelOrExpireTransaction(
                $transaction->last_midtrans_order_id ?? $transaction->order_id
            );
        }

        return true;
    }

    public function expireOverduePendingPayments(): int
    {
        $paymentCutoff = Transaction::paymentTimeoutCutoff();
        $today = now()->toDateString();

        $transactions = Transaction::query()
            ->where('status', 'pending')
            ->where(function ($query) use ($paymentCutoff, $today) {
                $query->where('booking_date', '<', $today)
                    ->orWhere('payment_expires_at', '<=', now())
                    ->orWhere(function ($inner) use ($paymentCutoff) {
                        $inner->whereNull('payment_expires_at')
                            ->where('created_at', '<=', $paymentCutoff);
                    });
            })
            ->get();

        $count = 0;
        foreach ($transactions as $transaction) {
            if ($this->expirePendingPayment($transaction)) {
                $count++;
            }
        }

        return $count;
    }

    public function cancelByUser(Transaction $transaction): bool
    {
        if ($transaction->status !== 'pending') {
            return false;
        }

        $this->midtrans->cancelOrExpireTransaction(
            $transaction->last_midtrans_order_id ?? $transaction->order_id
        );

        $transaction->update(['status' => 'cancelled']);

        return true;
    }

    public function expireDuplicatePendingOrders(int $userId, int $ticketId, string $bookingDate, ?int $exceptId = null): void
    {
        $duplicates = Transaction::query()
            ->where('user_id', $userId)
            ->where('ticket_id', $ticketId)
            ->where('booking_date', $bookingDate)
            ->where('status', 'pending')
            ->when($exceptId, fn ($q) => $q->where('id', '!=', $exceptId))
            ->get();

        foreach ($duplicates as $duplicate) {
            $this->expirePendingPayment($duplicate, cancelOnMidtrans: true, force: true);
        }
    }

    public function recordSnapOrder(Transaction $transaction, string $midtransOrderId): void
    {
        $transaction->update(['last_midtrans_order_id' => $midtransOrderId]);
    }

    public function isSuccessfulMidtransStatus(?string $status): bool
    {
        if ($status === null) {
            return false;
        }

        if (in_array($status, ['settlement', 'success'], true)) {
            return true;
        }

        if ($status === 'capture') {
            return true;
        }

        return false;
    }

    private function validateMidtransAmount(Transaction $transaction, object $payload): bool
    {
        if (!isset($payload->gross_amount)) {
            return true;
        }

        return (int) $payload->gross_amount === (int) $transaction->total_price;
    }

    private function logLatePaymentRejected(Transaction $transaction, ?object $midtransPayload): void
    {
        Log::warning('Pembayaran ditolak: batas 6 jam telah lewat atau pesanan dibatalkan', [
            'order_id' => $transaction->order_id,
            'status' => $transaction->status,
            'payment_expires_at' => $transaction->paymentExpiresAt()->toIso8601String(),
            'midtrans_status' => $midtransPayload->transaction_status ?? null,
        ]);
    }
}
