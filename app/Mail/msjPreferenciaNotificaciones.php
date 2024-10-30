<?php

namespace App\Mail;

use App\Models\TipoNotificacion;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class msjPreferenciaNotificaciones extends Mailable
{
    use Queueable, SerializesModels;

    public $notificacionesMarcadas;
    public $nombreNotificacion;
    public $accion;

    /**
     * Create a new message instance.
     */
    public function __construct($notificacionesMarcadas = [], $accion = 0)
    {
        $this->notificacionesMarcadas = $notificacionesMarcadas;

        foreach ($this->notificacionesMarcadas as $notificacion) {
            // Agregar a un array las notificaciones de la base de datos
            $this->nombreNotificacion[] = TipoNotificacion::find($notificacion)->nombreNotificacion;
        }

        $this->accion = $accion;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Actualizaste tus preferencias!',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.MsjPreferenciaNotificaciones',
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
