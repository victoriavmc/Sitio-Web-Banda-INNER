<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class msjReporto extends Mailable
{
    use Queueable, SerializesModels;

    public $genero;
    public $usuarioReportado;
    public $actividad;

    /**
     * Create a new message instance.
     */
    public function __construct($genero, $usuarioReportado, $actividad)
    {
        $this->genero = $genero;
        $this->usuarioReportado = $usuarioReportado;
        $this->actividad = $actividad;

        switch ($this->genero) {
            case 'Femenino':
                $this->genero = 'De la usuaria';
                break;
            case 'Masculino':
                $this->genero = 'Del usuario';
                break;
            default:
                $this->genero = 'De la persona';
                break;
        }

        switch ($this->actividad) {
            case 1:
                $this->actividad = 'Perfil';
                break;
            case 2:
                $this->actividad = 'Comentario';
                break;
            default:
                $this->actividad = 'Contenido';
                break;
        }
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reportaste una Cuenta',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.MsjReporto',
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
