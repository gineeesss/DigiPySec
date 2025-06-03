<?php
namespace App\Mail;

use App\Models\SolicitudServicio;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CambioEstadoSolicitud extends Mailable
{
    use Queueable, SerializesModels;

    public $solicitud;
    public $estadoAnterior;
    public $estadoNuevo;
    public $comentario;

    public function __construct(SolicitudServicio $solicitud, $estadoAnterior, $estadoNuevo, $comentario = null)
    {
        $this->solicitud = $solicitud;
        $this->estadoAnterior = $estadoAnterior;
        $this->estadoNuevo = $estadoNuevo;
        $this->comentario = $comentario;
    }

    public function build()
    {
        return $this->subject('Estado de la solicitud #' . $this->solicitud->id . ' actualizado')
            ->view('emails.cambio_estado_solicitud');
    }
}
