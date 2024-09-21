<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class msjRegistro extends Mailable
{
    use Queueable, SerializesModels;

    public $nombre;
    public $genero;

    /**
     * Create a new message instance.
     */
    public function __construct($nombre, $genero)
    {
        $this->nombre = $nombre;
        $this->genero = $genero;

        switch ($this->genero) {
            case 'Femenino':
                $this->genero = 'a';
                break;
            case 'Masculino':
                $this->genero = 'o';
                break;
            default:
                $this->genero = '@';
                break;
        }
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Registrado en INNER',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.MsjRegistro',
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
