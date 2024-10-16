<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class msjReportaron extends Mailable
{
    use Queueable, SerializesModels;

    public $usuarioQueReporta;
    public $genero;
    public $usuarioReportado;
    public $tipoActividad;

    /**
     * Create a new message instance.
     */
    public function __construct($usuarioQueReporta, $genero, $usuarioReportado, $tipoActividad)
    {
        $this->usuarioQueReporta = $usuarioQueReporta;
        $this->genero = $genero;
        $this->usuarioReportado = $usuarioReportado;
        $this->tipoActividad = $tipoActividad;

        switch ($this->genero) {
            case 'Femenino':
                $this->genero = 'La usuaria';
                break;
            case 'Masculino':
                $this->genero = 'El usuario';
                break;
            default:
                $this->genero = 'La persona';
                break;
        }

        switch ($this->tipoActividad) {
            case '1':
                $this->tipoActividad = 'El perfil';
                break;
            case '2':
                $this->tipoActividad = 'El comentario';
                break;
            default:
                $this->tipoActividad = 'La publicacion';
                break;
        }
    }
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reportaron una Cuenta',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.MsjReportaron',
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
