<?php

namespace App\Jobs;

use App\Mail\OwnerPartnerWelcomeMail;
use App\Models\Destination;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendOwnerPartnerWelcomeMailJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public User $user,
        public Destination $destination,
    ) {
    }

    public function handle(): void
    {
        if (! $this->user->email) {
            return;
        }

        Mail::to($this->user->email)->send(
            new OwnerPartnerWelcomeMail($this->user, $this->destination)
        );
    }
}
