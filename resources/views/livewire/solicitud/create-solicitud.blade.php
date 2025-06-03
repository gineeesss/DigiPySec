<!-- resources/views/livewire/solicitud/create-solicitud.blade.php -->
<div>
    <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Nueva Solicitud de Servicio</h2>

            <form wire:submit.prevent="guardarSolicitud">
                <!-- Selección de cliente -->
                <div class="mb-6">
                    <label for="cliente_id" class="block text-sm font-medium text-gray-700 mb-1">Cliente</label>
                    <select wire:model="cliente_id" id="cliente_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Seleccione un cliente</option>
                        @foreach($clientes as $cliente)
                            <option value="{{ $cliente->id }}">{{ $cliente->user->name }}</option>
                        @endforeach
                    </select>
                    @error('cliente_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Agregar servicios -->
                <div class="mb-6 border border-gray-200 rounded-lg p-4">
                    <h3 class="text-lg font-medium text-gray-800 mb-4">Servicios Solicitados</h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <label for="servicioSeleccionado" class="block text-sm font-medium text-gray-700 mb-1">Servicio</label>
                            <select wire:model="servicioSeleccionado" id="servicioSeleccionado" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Seleccione un servicio</option>
                                @foreach($serviciosDisponibles as $servicio)
                                    <option value="{{ $servicio->id }}">{{ $servicio->nombre }} (${{ number_format($servicio->precio_base, 2) }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="cantidad" class="block text-sm font-medium text-gray-700 mb-1">Cantidad</label>
                            <input wire:model="cantidad" type="number" min="1" id="cantidad" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div class="flex items-end">
                            <button wire:click="agregarServicio" type="button" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md">
                                Agregar
                            </button>
                        </div>
                    </div>

                    <!-- Lista de servicios agregados -->
                    @if(count($servicios) > 0)
                        <div class="border-t border-gray-200 mt-4 pt-4">
                            <ul class="divide-y divide-gray-200">
                                @foreach($servicios as $index => $servicio)
                                    <li class="py-3 flex justify-between items-center">
                                        <div>
                                            <span class="font-medium">{{ $servicio['nombre'] }}</span>
                                            <span class="text-sm text-gray-600 ml-2">x{{ $servicio['cantidad'] }}</span>
                                            <span class="block text-sm text-blue-600">${{ number_format($servicio['precio_unitario'] * $servicio['cantidad'], 2) }}</span>
                                        </div>
                                        <button wire:click="removerServicio({{ $index }})" type="button" class="text-red-500 hover:text-red-700">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </li>
                                @endforeach
                            </ul>

                            <div class="mt-4 pt-4 border-t border-gray-200">
                                <div class="flex justify-between font-medium text-lg">
                                    <span>Total:</span>
                                    <span>${{ number_format(array_reduce($servicios, function($carry, $item) {
                                        return $carry + ($item['precio_unitario'] * $item['cantidad']);
                                    }, 0), 2) }}</span>
                                </div>
                            </div>
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-4">No hay servicios agregados</p>
                    @endif
                </div>

                <!-- Notas adicionales -->
                <div class="mb-6">
                    <label for="notas" class="block text-sm font-medium text-gray-700 mb-1">Notas Adicionales</label>
                    <textarea wire:model="notas" id="notas" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                </div>

                <!-- Botones de acción -->
                <!-- Botones de acción -->
                <div class="flex justify-end space-x-3">
                    <x-secondary-button href="{{ route('admin.solicitudes.index') }}">
                        <i class="fas fa-times mr-2"></i> Cancelar
                    </x-secondary-button>

                    <x-secondary-button wire:click.prevent="agregarServicio" type="button">
                        <i class="fas fa-plus mr-2"></i> Agregar Servicio
                    </x-secondary-button>

                    <x-secondary-button type="submit">
                        <i class="fas fa-save mr-2"></i> Crear Solicitud
                    </x-secondary-button>
                </div>
            </form>
        </div>
    </div>
</div>
