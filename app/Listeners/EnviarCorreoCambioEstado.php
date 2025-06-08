<?php

namespace App\Listeners;

use App\Events\SolicitudEstadoActualizado;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\NotificacionCambioEstado;
use Mail;

class EnviarCorreoCambioEstado
{
    public function handle(SolicitudEstadoActualizado $event)
    {
        $solicitud = $event->solicitud;
        $comentario = $event->comentario;
        $destinatario = $solicitud->cliente->user->email;

        Mail::to($destinatario)->send(new NotificacionCambioEstado($solicitud, $comentario));
    }
}
