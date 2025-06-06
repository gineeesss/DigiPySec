<!-- resources/views/livewire/demos/tienda/navegacion-tienda.blade.php -->
<div class="bg-white shadow-sm">
    <div class="container mx-auto px-4">
        <nav class="flex space-x-6 overflow-x-auto py-4 hide-scrollbar">
            <a
                href="{{ route('tienda.index') }}"
                class="whitespace-nowrap px-3 py-2 rounded-full {{ !$categoriaActiva ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}"
            >
                Todos
            </a>

            @foreach($categorias as $categoria)
                <a
                    href="{{ route('tienda.categoria', $categoria->slug) }}"
                    wire:key="cat-{{ $categoria->id }}"
                    class="whitespace-nowrap px-3 py-2 rounded-full flex items-center {{ $categoriaActiva == $categoria->slug ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}"
                >
                    <span class="mr-2">{{ $categoria->icono }}</span>
                    {{ $categoria->nombre }}
                </a>
            @endforeach
        </nav>
    </div>
</div>
