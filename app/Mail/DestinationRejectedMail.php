<?php

namespace App\Mail;

use App\Models\Destination;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DestinationRejectedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Destination $destination,
        public string $rejectionReason,
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pengajuan Destinasi Ditolak — Tabibito Jawa Tengah',
        );
    }

    public function content(): Content
    {
        $this->destination->loadMissing('owner');

        return new Content(
            view: 'emails.destination-rejected',
            with: [
                'destination' => $this->destination,
                'rejectionReason' => $this->rejectionReason,
                'owner' => $this->destination->owner,
            ],
        );
    }
}
