<div>
    <h2>Menú</h2>
    @foreach($platos as $plato)
        <div>
            <img src="{{ $plato->imagen_url }}" alt="{{ $plato->nombre }}" width="100">
            <p>{{ $plato->nombre }}</p>
            <p>Tapa: €{{ $plato->precio_tapa }}</p>
            <p>Ración: €{{ $plato->precio_racion }}</p>
            <button wire:click="agregarAlCarrito({{ $plato->id }}, 'tapa')">Añadir Tapa</button>
            <button wire:click="agregarAlCarrito({{ $plato->id }}, 'racion')">Añadir Ración</button>
        </div>
    @endforeach

    <h2>Comanda</h2>
    <ul>
        @foreach($carrito as $item)
            <li>{{ $item['nombre'] }} ({{ $item['tipo'] }}) - €{{ $item['precio'] }}</li>
        @endforeach
    </ul>

    <p>Total: €{{ number_format($total, 2) }}</p>

    <label for="personas">Número de personas:</label>
    <input type="number" id="personas" wire:model="personas" min="1">

    <p>Por persona: €{{ number_format($porPersona, 2) }}</p>
</div>
