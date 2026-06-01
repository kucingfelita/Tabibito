<?php

namespace App\Jobs;

use App\Mail\DestinationRejectedMail;
use App\Models\Destination;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendDestinationRejectedMailJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Destination $destination,
        public string $rejectionReason,
    ) {
    }

    public function handle(): void
    {
        $this->destination->loadMissing('owner');

        if (! $this->destination->owner?->email) {
            return;
        }

        Mail::to($this->destination->owner->email)->send(
            new DestinationRejectedMail($this->destination, $this->rejectionReason)
        );
    }
}
