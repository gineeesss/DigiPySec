<div class="bg-white rounded shadow p-4">
    <h2 class="text-2xl font-bold mb-4">Mi solicitud</h2>

    @if($solicitud && $solicitud->items->count())
        <ul class="divide-y divide-gray-200">
            @foreach($solicitud->items as $item)
                <li class="py-4 flex justify-between items-center">
                    <div>
                        <p class="font-semibold">{{ $item->servicio->nombre }}</p>
                        <p class="text-sm text-gray-600">Cantidad: {{ $item->cantidad }}</p>
                        @if($item->opciones_personalizacion)
                            <p class="text-sm text-gray-500">Personalización: {{ json_encode($item->opciones_personalizacion) }}</p>
                        @endif
                    </div>
                    <div class="text-right">
                        <p class="text-lg font-bold">${{ number_format($item->subtotal, 2) }}</p>
                        <button wire:click="removeItem({{ $item->id }})" class="text-red-600 text-sm hover:underline">Eliminar</button>
                    </div>
                </li>
            @endforeach
        </ul>

        <div class="text-right mt-4 font-bold text-xl">
            Total: ${{ number_format($solicitud->total, 2) }}
        </div>
    @else
        <p>No hay servicios añadidos aún.</p>
    @endif
</div>
