<!-- resources/views/livewire/catalogo/servicios-index.blade.php -->
<div>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Servicios</h2>
        @can('manage-servicios')
            <a href="{{ route('admin.servicios.create') }}"
               class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm">
                + Nuevo Servicio
            </a>
        @endcan
    </x-slot>


    <div class="flex overflow-x-auto py-4 space-x-4">
        @foreach($categorias as $categoria)
            <button wire:click="seleccionarCategoria({{ $categoria->id }})"
                    class="px-4 py-2 rounded-lg {{ $categoriaSeleccionada == $categoria->id ? 'bg-blue-600 text-white' : 'bg-gray-200' }}">
                {{ $categoria->nombre }}
            </button>
        @endforeach
    </div>
    <!-- ... resto del código igual ... -->

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
        @foreach($servicios as $servicio)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                <!-- ... contenido de la tarjeta igual ... -->
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-800">{{ $servicio->nombre }}</h3>
                    <p class="mt-2 text-gray-600">{{ $servicio->descripcion_corta }}</p>
                    <div class="mt-4">
                        <span class="text-2xl font-bold text-blue-600">${{ number_format($servicio->precio_base, 2) }}</span>
                        <span class="text-sm text-gray-500 ml-1">+ IVA</span>
                    </div>
                    <ul class="mt-4 space-y-2">
                        @foreach($servicio->incluyes->take(3) as $incluye)
                            <li class="flex items-center">
                                <svg class="h-5 w-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                {{ $incluye->caracteristica }}
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="mt-6 flex justify-between items-center">
                    <a href="{{ route('servicios.show', $servicio->slug) }}"
                       class="inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        Ver detalles
                    </a>

                    @can('manage-servicios')
                        <a href="{{ route('admin.servicios.edit', $servicio->id) }}"
                           class="inline-block px-3 py-1 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-colors text-sm"
                           title="Editar servicio">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                            </svg>
                        </a>
                    @endcan
                </div>
            </div>
        @endforeach
    </div>
</div>
