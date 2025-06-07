<!-- resources/views/livewire/demos/index.blade.php -->
<div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Encabezado y filtros -->
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Nuestras Demostraciones</h1>
            <p class="text-lg text-gray-600">Descubre lo que podemos hacer por ti</p>

            <div class="mt-6 max-w-md mx-auto">
                <input
                    wire:model.debounce.300ms="search"
                    type="text"
                    placeholder="Buscar demostraciones..."
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                >
            </div>
        </div>

        <!-- Grid de servicios demo -->
        @if($servicios->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($servicios as $servicio)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                        <!-- Imagen del servicio (puedes cambiarlo por un campo real si lo tienes) -->
                        <div class="h-48 bg-gray-200 flex items-center justify-center">
                            <span class="text-gray-500">Imagen demostración</span>
                        </div>

                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $servicio->nombre }}</h3>
                            <p class="text-gray-600 mb-4">{{ $servicio->descripcion_corta }}</p>

                            <div class="flex justify-between items-center">
                                <span class="text-lg font-bold text-blue-600">
                                    ${{ number_format($servicio->precio_base, 2) }}
                                </span>

                                <a
                                    href="{{ route('servicios.show', $servicio->slug) }}"
                                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors"
                                >
                                    Ver detalles
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Paginación -->
            <div class="mt-8">
                {{ $servicios->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <p class="text-gray-500 text-lg">No se encontraron demostraciones.</p>
                @if($search)
                    <button wire:click="clearSearch" class="mt-4 text-blue-600 hover:text-blue-800">
                        Limpiar búsqueda
                    </button>
                @endif
            </div>
        @endif
    </div>
</div>
