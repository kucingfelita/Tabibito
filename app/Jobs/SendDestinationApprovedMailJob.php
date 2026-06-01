<?php

namespace App\Jobs;

use App\Mail\DestinationApprovedMail;
use App\Models\Destination;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendDestinationApprovedMailJob implements ShouldQueue
{
    use Queueable;

    public function __construct(public Destination $destination)
    {
    }

    public function handle(): void
    {
        $this->destination->loadMissing('owner');

        if (! $this->destination->owner?->email) {
            return;
        }

        Mail::to($this->destination->owner->email)->send(
            new DestinationApprovedMail($this->destination)
        );
    }
}
