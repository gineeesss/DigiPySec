<?php

namespace App\Mail;

use App\Models\SolicitudServicio;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotificacionCambioEstado extends Mailable
{
    use Queueable, SerializesModels;
    public $solicitud;
    public $comentario;
    public function __construct(SolicitudServicio $solicitud, ?string $comentario = null)
    {
        $this->solicitud = $solicitud;
        $this->comentario = $comentario;
    }
    public function build()
    {
        return $this->subject('Cambio de estado de tu solicitud')
            ->markdown('emails.solicitudes.cambio-estado');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Notificacion Cambio Estado',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.solicitudes.cambio-estado',
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
