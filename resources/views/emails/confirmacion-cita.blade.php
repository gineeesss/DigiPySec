<h1>Confirmación de Cita</h1>

<p>¡Hola {{ $detalles['nombreCliente'] }}!</p>

<p>Tu cita ha sido reservada con éxito. Aquí tienes los detalles:</p>

<ul>
    <li><strong>Peluquero:</strong> {{ $detalles['peluquero'] }}</li>
    <li><strong>Fecha:</strong> {{ $detalles['fecha'] }}</li>
    <li><strong>Hora:</strong> {{ $detalles['hora'] }}</li>
    <li><strong>Tratamiento:</strong> {{ $detalles['tratamiento'] }}</li>
    <li><strong>Duración:</strong> {{ $detalles['duracion'] }} minutos</li>
    <li><strong>Precio:</strong> {{ number_format($detalles['precio'], 2) }} €</li>
</ul>

<p>
    <a href="{{ url('/') }}" style="display:inline-block;padding:10px 20px;background-color:#3490dc;color:white;text-decoration:none;border-radius:5px;">
        Visitar nuestra web
    </a>
</p>

<p>Gracias por confiar en nosotros,<br>
    <strong>El equipo de Barbería Digital</strong></p>
