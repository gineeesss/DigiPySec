<div>
    <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <!-- Encabezado -->
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                <div>
                    <h2 class="text-xl font-semibold text-gray-800">Solicitud #{{ $solicitud->id }}</h2>
                    <p class="text-sm text-gray-600 mt-1">
                        Creada el {{ $solicitud->created_at->format('d/m/Y H:i') }}
                        por {{ $solicitud->usuario->name ?? 'Usuario no disponible' }}
                    </p>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="px-3 py-1 rounded-full text-sm font-medium
                        @if($solicitud->estado == 'pendiente') bg-yellow-100 text-yellow-800
                        @elseif($solicitud->estado == 'aprobada') bg-blue-100 text-blue-800
                        @elseif($solicitud->estado == 'en_proceso') bg-purple-100 text-purple-800
                        @elseif($solicitud->estado == 'completada') bg-green-100 text-green-800
                        @else bg-red-100 text-red-800 @endif">
                        {{ $estadosDisponibles[$solicitud->estado] }}
                    </span>

                    @can('manage-servicios')
                        <button wire:click="toggleEdicion" class="text-indigo-600 hover:text-indigo-900">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                            </svg>
                        </button>
                    @endcan
                </div>
            </div>

            <!-- Información del cliente -->
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-800 mb-2">Información del Cliente</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Nombre</p>
                        <p class="font-medium">{{ $solicitud->cliente->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Contacto</p>
                        <p class="font-medium">{{ $solicitud->cliente->telefono }} / {{ $solicitud->cliente->email }}</p>
                    </div>
                </div>
            </div>

            <!-- Detalle de servicios -->
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-800 mb-2">Servicios Solicitados</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Servicio</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precio Unitario</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cantidad</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($solicitud->items as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="font-medium text-gray-900">{{ $item->servicio->nombre }}</div>
                                    @if($item->opciones_personalizacion)
                                        <div class="text-sm text-gray-500 mt-1">
                                            @foreach($item->opciones_personalizacion as $key => $value)
                                                <p><span class="font-medium">{{ ucfirst($key) }}:</span> {{ $value }}</p>
                                            @endforeach
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${{ number_format($item->precio_unitario, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->cantidad }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">${{ number_format($item->subtotal, 2) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50">
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-right font-medium text-gray-500">Total</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">${{ number_format($solicitud->total, 2) }}</td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- Notas y cambio de estado -->
            <div class="px-6 py-4">
                <h3 class="text-lg font-medium text-gray-800 mb-2">Notas</h3>
                <div class="bg-gray-50 p-4 rounded-lg mb-4 whitespace-pre-line">{{ $solicitud->notas }}</div>

                @if($mostrarFormularioEdicion)
                    <div class="mt-6 border-t border-gray-200 pt-4">
                        <h3 class="text-lg font-medium text-gray-800 mb-2">Editar Solicitud</h3>
                        <a href="{{ route('admin.solicitudes.edit', $solicitud->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Editar Contenido de la Solicitud
                        </a>
                    </div>
                @endif

                @can('manage-servicios')
                    <div class="mt-6 border-t border-gray-200 pt-4">
                        <h3 class="text-lg font-medium text-gray-800 mb-2">Cambiar Estado</h3>
                        <form wire:submit.prevent="cambiarEstado" class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="nuevoEstado" class="block text-sm font-medium text-gray-700 mb-1">Nuevo Estado</label>
                                    <select wire:model="nuevoEstado" id="nuevoEstado" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        @foreach($estadosDisponibles as $key => $estado)
                                            <option value="{{ $key }}" {{ $solicitud->estado == $key ? 'selected' : '' }}>{{ $estado }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="comentario" class="block text-sm font-medium text-gray-700 mb-1">Agregar Comentario</label>
                                    <input wire:model="comentario" type="text" id="comentario" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                            </div>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                Actualizar Estado
                            </button>
                        </form>
                    </div>
                @endcan
            </div>
        </div>
    </div>
</div>
