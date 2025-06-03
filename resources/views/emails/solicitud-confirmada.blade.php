<!-- resources/views/emails/solicitud-confirmada.blade.php -->
@component('mail::message')
    # Confirmación de Solicitud de Servicio

    ¡Gracias por tu solicitud! Hemos recibido tu pedido correctamente y lo estamos procesando.

    **Número de solicitud:** #{{ $solicitud->id }}
    **Fecha:** {{ $solicitud->created_at->format('d/m/Y H:i') }}
    **Estado:** {{ ucfirst($solicitud->estado) }}
    **Total:** ${{ number_format($solicitud->total, 2) }}
    **Método de pago:** {{ $solicitud->metodo_pago === 'card' ? 'Tarjeta' : 'Transferencia bancaria' }}

    ## Servicios solicitados

    @component('mail::table')
        | Servicio | Cantidad | Precio Unitario | Total |
        |----------|----------|-----------------|-------|
        @foreach($solicitud->items as $item)
            | {{ $item->servicio->nombre }} | {{ $item->cantidad }} | ${{ number_format($item->precio_unitario, 2) }} | ${{ number_format($item->precio_unitario * $item->cantidad, 2) }} |
        @endforeach
    @endcomponent

    **Notas adicionales:**
    {{ $solicitud->notas ?? 'Ninguna' }}

    @component('mail::button', ['url' => route('solicitud.show', $solicitud->id)])
        Ver detalles de la solicitud
    @endcomponent

    Si tienes alguna pregunta, no dudes en contactarnos.

    Saludos cordiales,
    {{ config('app.name') }}
@endcomponent
