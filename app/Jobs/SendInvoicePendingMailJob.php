<?php

namespace App\Jobs;

use App\Mail\InvoicePendingMail;
use App\Models\Transaction;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendInvoicePendingMailJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public Transaction $transaction)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->transaction->loadMissing(['user', 'ticket.destination']);
        Mail::to($this->transaction->user->email)->send(new InvoicePendingMail($this->transaction));
    }
}
