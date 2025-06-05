<div>
    <h2 class="text-xl font-semibold mb-2">Elige tu barbero</h2>

    <div class="flex gap-4">
        <button
            wire:click="$emit('barberoSeleccionado', null)"
            class="border rounded-lg p-3 text-center hover:bg-gray-100"
        >
            Sin preferencia
        </button>

        @foreach($barberos as $barbero)
            <button
                wire:click="$emit('barberoSeleccionado', {{ $barbero->id }})"
                class="border rounded-lg p-3 text-center hover:bg-gray-100"
            >
                {{ $barbero->nombre }}
            </button>
        @endforeach
    </div>
</div>
