<div>
    <form wire:submit.prevent="guardar" class="space-y-4 max-w-lg mx-auto bg-white p-6 rounded shadow">
        <h2 class="text-xl font-bold">{{ $platoId ? 'Editar Plato' : 'Nuevo Plato' }}</h2>

        <div>
            <label>Nombre</label>
            <input wire:model="nombre" type="text" class="w-full border p-2 rounded">
        </div>

        <div>
            <label>Descripción</label>
            <textarea wire:model="descripcion" class="w-full border p-2 rounded"></textarea>
        </div>

        <div>
            <label>Precio (€)</label>
            <input wire:model="precio" type="number" step="0.01" class="w-full border p-2 rounded">
        </div>

        <div>
            <label>Categoría</label>
            <select wire:model="categoria_plato_id" class="w-full border p-2 rounded">
                <option value="">-- Selecciona --</option>
                @foreach (\App\Models\CategoriaPlato::all() as $categoria)
                    <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                @endforeach
            </select>
        </div>

        <button class="bg-blue-600 text-white px-4 py-2 rounded">Guardar</button>
    </form>

</div>
