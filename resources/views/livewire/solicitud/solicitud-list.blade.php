<div>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <!-- Encabezado y filtros -->
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex flex-col md:flex-row md:items-center md:justify-between">
                <h2 class="text-xl font-semibold text-gray-800 mb-4 md:mb-0">
                    {{ $isAdminView ? 'Solicitudes de Servicios' : 'Mis Solicitudes' }}
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Buscador -->
                    <div>
                        <input wire:model.debounce.300ms="search" type="text" placeholder="Buscar..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <!-- Filtro por estado -->
                    <div>
                        <select wire:model="estado" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @foreach($estados as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Botón nueva solicitud (solo para clientes) -->
                    @if(!$isAdminView)
                        <div>
                            <a href="{{ route('checkout') }}" class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Nueva Solicitud
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Tabla de solicitudes -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th wire:click="sortBy('id')" scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                            ID
                            @if($sortBy === 'id')
                                <i class="ml-1 fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                            @endif
                        </th>
                        <th wire:click="sortBy('created_at')" scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                            Fecha
                            @if($sortBy === 'created_at')
                                <i class="ml-1 fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                            @endif
                        </th>
                        @if($isAdminView)
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cliente</th>
                        @endif
                        <th wire:click="sortBy('total')" scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                            Total
                            @if($sortBy === 'total')
                                <i class="ml-1 fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                            @endif
                        </th>
                        <th wire:click="sortBy('estado')" scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                            Estado
                            @if($sortBy === 'estado')
                                <i class="ml-1 fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($solicitudes as $solicitud)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $solicitud->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $solicitud->created_at->format('d/m/Y H:i') }}</td>
                            @if($isAdminView)
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $solicitud->cliente->user->name ?? 'Sin cliente' }}</div>
                                    <div class="text-sm text-gray-500">{{ $solicitud->cliente->user->email ?? '' }}</div>
                                </td>
                            @endif
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">${{ number_format($solicitud->total, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @if($solicitud->estado == 'pendiente') bg-yellow-100 text-yellow-800
                                    @elseif($solicitud->estado == 'aprobada') bg-blue-100 text-blue-800
                                    @elseif($solicitud->estado == 'en_proceso') bg-purple-100 text-purple-800
                                    @elseif($solicitud->estado == 'completada') bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($solicitud->estado) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route($isAdminView ? 'admin.solicitudes.show' : 'solicitud.show', $solicitud->id) }}"
                                   class="text-blue-600 hover:text-blue-900 mr-3">Ver</a>
                                @if($solicitud->estado == 'pendiente' && auth()->user()->can('edit-solicitudes'))
                                    <a href="#" class="text-indigo-600 hover:text-indigo-900">Editar</a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ $isAdminView ? 6 : 5 }}" class="px-6 py-4 text-center text-sm text-gray-500">
                                No se encontraron solicitudes
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $solicitudes->links() }}
            </div>
        </div>
    </div>
</div>
