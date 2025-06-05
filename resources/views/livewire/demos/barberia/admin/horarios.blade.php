<div>
    <h1 class="text-2xl font-bold mb-4">Horarios disponibles</h1>

    <form wire:submit.prevent="guardarHorario" class="mb-6 space-y-3">
        <div>
            <label class="block mb-1">Día</label>
            <input wire:model="fecha" type="date" class="w-full border rounded px-3 py-2">
            @error('fecha') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <div>
            <label class="block mb-1">Hora</label>
            <input wire:model="hora" type="time" class="w-full border rounded px-3 py-2">
            @error('hora') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Agregar horario</button>
    </form>

    <table class="w-full text-left border-collapse">
        <thead class="bg-gray-100">
        <tr>
            <th class="p-2 border">ID</th>
            <th class="p-2 border">Fecha</th>
            <th class="p-2 border">Hora</th>
            <th class="p-2 border">Acciones</th>
        </tr>
        </thead>
        <tbody>
        @foreach($horarios as $h)
            <tr class="border-t">
                <td class="p-2 border">{{ $h->id }}</td>
                <td class="p-2 border">{{ $h->fecha }}</td>
                <td class="p-2 border">{{ $h->hora }}</td>
                <td class="p-2 border">
                    <button wire:click="eliminar({{ $h->id }})" class="text-red-600 hover:underline">Eliminar</button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
