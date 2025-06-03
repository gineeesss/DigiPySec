<?php

namespace App\Listeners;

use App\Events\SolicitudEstadoActualizado;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\NotificacionCambioEstado;
use Mail;

class EnviarCorreoCambioEstado
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(SolicitudEstadoActualizado $event)
    {
        $solicitud = $event->solicitud;
        $comentario = $event->comentario;

        // Aquí puedes decidir a quién enviar el correo (cliente, admin, etc.)
        $destinatario = $solicitud->cliente->user->email;

        Mail::to($destinatario)->send(new NotificacionCambioEstado($solicitud, $comentario));
    }
}
