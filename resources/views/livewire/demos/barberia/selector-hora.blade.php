<div x-data="{ mostrar: @entangle('mostrar') }"
     x-on:fecha-selected.window="() => mostrar = true">

    <template x-if="mostrar">
        <div class="bg-white border rounded-lg p-4 shadow">
            <h2 class="text-xl font-semibold mb-2">Elige tu hora</h2>
            <div class="flex flex-wrap gap-2">
                @foreach($horasDisponibles as $hora)
                    <button
                        wire:click="$emit('horaSeleccionada', '{{ $hora }}')"
                        class="px-3 py-1 rounded bg-gray-200 hover:bg-gray-300 text-sm"
                    >
                        {{ $hora }}
                    </button>
                @endforeach
            </div>
        </div>
    </template>
</div>
