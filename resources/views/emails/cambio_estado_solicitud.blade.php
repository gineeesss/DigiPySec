<h1>Estado de la Solicitud #{{ $solicitud->id }} actualizado</h1>

<p><strong>Cliente:</strong> {{ $solicitud->cliente->user->name }}</p>
<p><strong>Estado anterior:</strong> {{ $estadoAnterior }}</p>
<p><strong>Nuevo estado:</strong> {{ $estadoNuevo }}</p>
@if($comentario)
    <p><strong>Comentario:</strong> {{ $comentario }}</p>
@endif

<p>Fecha del cambio: {{ now()->format('d/m/Y H:i') }}</p>
