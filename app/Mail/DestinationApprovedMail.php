<?php

namespace App\Mail;

use App\Models\Destination;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DestinationApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Destination $destination)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Destinasi Disetujui — Siap Dipesan di Tabibito',
        );
    }

    public function content(): Content
    {
        $this->destination->loadMissing('owner');

        return new Content(
            view: 'emails.destination-approved',
            with: [
                'destination' => $this->destination,
                'owner' => $this->destination->owner,
            ],
        );
    }
}
