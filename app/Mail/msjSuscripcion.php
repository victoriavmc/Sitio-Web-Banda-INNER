<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class msjSuscripcion extends Mailable
{
    use Queueable, SerializesModels;

    public $idordenpago;
    public $factura;
    public $monto;
    public $diaPago;

    /**
     * Create a new message instance.
     */
    public function __construct($idordenpago, $factura, $monto, $diaPago)
    {
        $this->idordenpago = $idordenpago;
        $this->factura = $factura;
        $this->monto = $monto;
        $this->diaPago = $diaPago;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Msj Suscripcion',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.MsjSuscripcion',
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
