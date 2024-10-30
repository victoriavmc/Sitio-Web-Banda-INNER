<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class msjNotificaciones extends Mailable
{
    use Queueable, SerializesModels;

    public $nombreDescripcion;
    public $msj;

    /**
     * Create a new message instance.
     */
    public function __construct($nombreDescripcion, $msj)
    {
        $this->nombreDescripcion = $nombreDescripcion;
        $this->msj = $msj;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Tienes nuevas notificaciones',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.MsjNotificaciones',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
