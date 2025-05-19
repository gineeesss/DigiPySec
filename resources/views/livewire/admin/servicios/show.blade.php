<!-- resources/views/livewire/admin/servicios/show.blade.php -->
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <div class="p-6">
            <div class="flex justify-between items-start mb-6">
                <h2 class="text-2xl font-semibold text-gray-800">{{ $servicio->nombre }}</h2>
                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                    {{ $servicio->categoria->nombre }}
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Información Principal -->
                <div class="md:col-span-2">
                    <div class="prose max-w-none mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Descripción</h3>
                        <p>{{ $servicio->descripcion }}</p>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Características Incluidas</h3>
                        <ul class="space-y-2">
                            @foreach($servicio->incluye as $caracteristica)
                                <li class="flex items-start">
                                    <svg class="h-5 w-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span>{{ $caracteristica }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Detalles Secundarios -->
                <div>
                    <div class="bg-gray-50 p-4 rounded-lg mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Detalles del Servicio</h3>
                        <div class="space-y-3">
                            <div>
                                <p class="text-sm text-gray-500">Precio:</p>
                                <p class="font-medium">${{ number_format($servicio->precio, 2) }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Estado:</p>
                                <p class="font-medium">
                                    <span class="px-2 py-1 rounded-full text-xs {{ $servicio->activo ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $servicio->activo ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Creado:</p>
                                <p class="font-medium">{{ $servicio->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Última actualización:</p>
                                <p class="font-medium">{{ $servicio->updated_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>

                    @if($servicio->imagen)
                        <div class="border rounded-lg overflow-hidden">
                            <img src="{{ asset('storage/' . $servicio->imagen) }}" alt="{{ $servicio->nombre }}" class="w-full h-auto">
                        </div>
                    @endif
                </div>
            </div>

            <div class="mt-6 pt-6 border-t border-gray-200 flex justify-end space-x-3">
                <a href="{{ route('admin.servicios.index') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">
                    Volver al listado
                </a>
                <a href="{{ route('admin.servicios.edit', $servicio) }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    Editar Servicio
                </a>
            </div>
        </div>
    </div>
</div>
