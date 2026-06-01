<?php

namespace App\Console\Commands;

use App\Models\Transaction;
use App\Services\TransactionPaymentService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ExpireTransactions extends Command
{
    protected $signature = 'app:expire-transactions {--sync : Perbarui payment_expires_at pending sesuai konfigurasi .env saat ini}';

    protected $description = 'Expire unpaid pending transactions past payment window or booking date';

    public function handle(TransactionPaymentService $paymentService): int
    {
        $label = Transaction::paymentTimeoutLabel();
        $this->info("Konfigurasi batas pembayaran: {$label}");

        if ($this->option('sync')) {
            $pending = Transaction::query()->where('status', 'pending')->get();
            $synced = 0;
            foreach ($pending as $transaction) {
                $transaction->refreshPaymentExpiresAt();
                $synced++;
            }
            $this->info("Disinkronkan payment_expires_at untuk {$synced} transaksi pending.");
        }

        $pendingCount = Transaction::query()->where('status', 'pending')->count();
        $this->line("Transaksi pending saat ini: {$pendingCount}");

        $count = $paymentService->expireOverduePendingPayments();

        if ($count > 0) {
            $message = "Berhasil expire {$count} transaksi pending (timeout pembayaran / tanggal kunjungan lewat).";
            $this->info($message);
            Log::info($message);
        } else {
            $this->warn('Tidak ada transaksi pending yang perlu di-expire.');
            $this->line('Tips: buat pesanan baru setelah ubah .env, atau jalankan dengan --sync lalu coba lagi.');
        }

        return self::SUCCESS;
    }
}
