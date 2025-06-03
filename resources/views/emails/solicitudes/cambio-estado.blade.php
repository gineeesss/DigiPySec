@component('mail::message')
    # Cambio de Estado en tu Solicitud

    Tu solicitud #{{ $solicitud->id }} ha cambiado de estado a **{{ strtoupper($solicitud->estado) }}**.

    @isset($comentario)
        **Comentario:** {{ $comentario }}
    @endisset

    **Fecha:** {{ $solicitud->updated_at->format('d/m/Y H:i') }}

    @component('mail::button', ['url' => route('servicios.index')]) //'solicitudes.show', $solicitud
        Ver Servicios
    @endcomponent

    Gracias,<br>
    {{ config('app.name') }}
@endcomponent
