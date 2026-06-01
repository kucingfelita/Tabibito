<?php

namespace App\Mail;

use App\Models\Destination;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OwnerPartnerWelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $user,
        public Destination $destination,
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Selamat Datang, Mitra Tabibito Jawa Tengah!',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.owner-partner-welcome',
            with: [
                'user' => $this->user,
                'destination' => $this->destination,
            ],
        );
    }
}
