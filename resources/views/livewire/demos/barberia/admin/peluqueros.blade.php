<div>
    <h1 class="text-2xl font-bold mb-4">Barberos</h1>

    <form wire:submit.prevent="guardarBarbero" class="mb-6 space-y-3">
        <div>
            <label class="block mb-1">Nombre del barbero</label>
            <input wire:model="nombre" type="text" class="w-full border rounded px-3 py-2" placeholder="Ej: Carlos">
            @error('nombre') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Agregar/Actualizar</button>
    </form>

    <table class="w-full text-left border-collapse">
        <thead class="bg-gray-100">
        <tr>
            <th class="p-2 border">ID</th>
            <th class="p-2 border">Nombre</th>
            <th class="p-2 border">Acciones</th>
        </tr>
        </thead>
        <tbody>
        @foreach($barberos as $barbero)
            <tr class="border-t">
                <td class="p-2 border">{{ $barbero->id }}</td>
                <td class="p-2 border">{{ $barbero->nombre }}</td>
                <td class="p-2 border">
                    <button wire:click="editar({{ $barbero->id }})" class="text-blue-600 hover:underline mr-2">Editar</button>
                    <button wire:click="eliminar({{ $barbero->id }})" class="text-red-600 hover:underline">Eliminar</button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
