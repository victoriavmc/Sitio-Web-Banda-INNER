<?php

namespace App\Mail;

use App\Models\Motivos;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class msjInformeBaneo extends Mailable
{
    use Queueable, SerializesModels;

    public $usuario;
    public $motivos;
    public $motivosNombres;
    public $fechaInicia;
    public $fechaFinal;

    /**
     * Create a new message instance.
     */
    public function __construct($usuario, $motivos, $fechaInicia, $fechaFinal)
    {
        $this->usuario = $usuario;
        $this->motivos = $motivos;
        $this->fechaInicia = $fechaInicia;
        $this->fechaFinal = $fechaFinal;
        $this->motivosNombres = [];

        foreach ($this->motivos as $motivo) {
            $motivo = Motivos::find($motivo);
            array_push($this->motivosNombres, $motivo->descripcion);
        }
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Su Cuenta ha Sido Suspendida Temporalmente',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.MsjInformeBaneo',
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
