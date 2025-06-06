<!-- resources/views/livewire/demos/tienda/productos-tienda.blade.php -->
<div>
    <livewire:demos.tienda.navegacion-tienda :categoriaSlug="$categoriaSlug" />

    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($productos as $producto)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                    <div class="h-48 bg-gray-200 flex items-center justify-center">
                        @if($producto->imagen)
                            <img src="{{ asset($producto->imagen) }}" alt="{{ $producto->nombre }}" class="h-full w-full object-cover">
                        @else
                            <span class="text-5xl">{{ $producto->categoria->icono }}</span>
                        @endif
                    </div>

                    <div class="p-4">
                        <h3 class="font-bold text-lg">{{ $producto->nombre }}</h3>
                        <p class="text-gray-600 mt-1">{{ $producto->categoria->nombre }}</p>

                        <div class="mt-4 flex justify-between items-center">
                            <span class="font-bold text-indigo-600">{{ number_format($producto->precio, 2) }} €</span>
                            <button
                                wire:click="añadirAlCarrito({{ $producto->id }})"
                                class="bg-indigo-600 text-white px-3 py-1 rounded hover:bg-indigo-700 transition"
                            >
                                Añadir
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-12 text-gray-500">
                    No hay productos disponibles en esta categoría
                </div>
            @endforelse
        </div>
    </div>
</div>
