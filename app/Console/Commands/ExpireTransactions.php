<?php

namespace App\Console\Commands;

use App\Models\Transaction;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ExpireTransactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:expire-transactions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically expire unpaid pending transactions that have passed their booking date';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = now()->toDateString();

        $count = Transaction::query()
            ->where('status', 'pending')
            ->where('booking_date', '<', $today)
            ->update(['status' => 'expire']);

        if ($count > 0) {
            $message = "Successfully expired {$count} unpaid pending transactions that passed their booking date.";
            $this->info($message);
            Log::info($message);
        } else {
            $this->info("No past-due unpaid pending transactions found.");
        }
    }
}
