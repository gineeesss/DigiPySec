<!-- resources/views/livewire/demos/barberia/admin/citas.blade.php -->
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Gestión de Citas</h1>
            <a href="{{ route('barberia.admin') }}"
               class="text-blue-600 hover:text-blue-800 flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Volver al panel
            </a>
        </div>

        <!-- Filtros -->
        <div class="mb-6 bg-gray-50 p-4 rounded-lg">
            <h2 class="font-medium text-gray-700 mb-3">Filtrar citas</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-gray-700 mb-1">Estado</label>
                    <select wire:model.live="filtroEstado" class="w-full border rounded-lg px-3 py-2">
                        <option value="">Todos</option>
                        <option value="pendiente">Pendiente</option>
                        <option value="confirmada">Confirmada</option>
                        <option value="completada">Completada</option>
                        <option value="cancelada">Cancelada</option>
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 mb-1">Peluquero</label>
                    <select wire:model.live="filtroPeluquero" class="w-full border rounded-lg px-3 py-2">
                        <option value="">Todos</option>
                        @foreach($peluqueros as $peluquero)
                            <option value="{{ $peluquero->id }}">{{ $peluquero->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 mb-1">Fecha</label>
                    <input type="date" wire:model.live="filtroFecha" class="w-full border rounded-lg px-3 py-2">
                </div>
            </div>
        </div>

        <!-- Formulario de creación/edición -->
        <form wire:submit.prevent="save" class="mb-8 bg-gray-50 p-6 rounded-lg">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 mb-2">Peluquero</label>
                    <select wire:model="peluquero_id" class="w-full border rounded-lg px-3 py-2">
                        <option value="">Seleccione un peluquero</option>
                        @foreach($peluqueros as $peluquero)
                            <option value="{{ $peluquero->id }}">{{ $peluquero->nombre }}</option>
                        @endforeach
                    </select>
                    @error('peluquero_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-gray-700 mb-2">Estado</label>
                    <select wire:model="estado" class="w-full border rounded-lg px-3 py-2">
                        <option value="pendiente">Pendiente</option>
                        <option value="confirmada">Confirmada</option>
                        <option value="completada">Completada</option>
                        <option value="cancelada">Cancelada</option>
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 mb-2">Fecha</label>
                    <input type="date" wire:model="fecha" class="w-full border rounded-lg px-3 py-2">
                    @error('fecha') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-gray-700 mb-2">Hora inicio</label>
                    <input type="time" wire:model="hora_inicio" class="w-full border rounded-lg px-3 py-2">
                    @error('hora_inicio') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-gray-700 mb-2">Nombre cliente</label>
                    <input type="text" wire:model="nombre_cliente" class="w-full border rounded-lg px-3 py-2">
                    @error('nombre_cliente') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-gray-700 mb-2">Email cliente</label>
                    <input type="email" wire:model="email_cliente" class="w-full border rounded-lg px-3 py-2">
                    @error('email_cliente') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-gray-700 mb-2">Teléfono cliente</label>
                    <input type="text" wire:model="telefono_cliente" class="w-full border rounded-lg px-3 py-2">
                    @error('telefono_cliente') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-gray-700 mb-2">Notas</label>
                    <textarea wire:model="notas" rows="3" class="w-full border rounded-lg px-3 py-2"></textarea>
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                @if($editId)
                    <button type="button" wire:click="resetForm"
                            class="mr-4 px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">
                        Cancelar
                    </button>
                @endif
                <button type="submit"
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center">
                    <i class="fas fa-save mr-2"></i>
                    {{ $editId ? 'Actualizar' : 'Guardar' }}
                </button>
            </div>
        </form>

        <!-- Lista de citas -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-lg overflow-hidden">
                <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="py-3 px-4 text-left">ID</th>
                    <th class="py-3 px-4 text-left">Cliente</th>
                    <th class="py-3 px-4 text-left">Peluquero</th>
                    <th class="py-3 px-4 text-left">Fecha/Hora</th>
                    <th class="py-3 px-4 text-left">Estado</th>
                    <th class="py-3 px-4 text-right">Acciones</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                @forelse($citas as $cita)
                    <tr class="hover:bg-gray-50">
                        <td class="py-4 px-4">{{ $cita->id }}</td>
                        <td class="py-4 px-4">
                            <div class="font-medium">{{ $cita->nombre_cliente }}</div>
                            <div class="text-sm text-gray-600">{{ $cita->email_cliente }}</div>
                        </td>
                        <td class="py-4 px-4">{{ $cita->peluquero->nombre }}</td>
                        <td class="py-4 px-4">
                            {{ Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}
                            <div class="text-sm text-gray-600">{{ $cita->hora_inicio }}</div>
                        </td>
                        <td class="py-4 px-4">
                                <span class="px-2 py-1 text-xs rounded-full
                                    {{ $cita->estado === 'pendiente' ? 'bg-yellow-100 text-yellow-800' :
                                       ($cita->estado === 'confirmada' ? 'bg-blue-100 text-blue-800' :
                                       ($cita->estado === 'completada' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800')) }}">
                                    {{ ucfirst($cita->estado) }}
                                </span>
                        </td>
                        <td class="py-4 px-4 text-right">
                            <div class="flex justify-end space-x-2">
                                <button wire:click="edit({{ $cita->id }})"
                                        class="p-2 text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <div class="relative inline-block">
                                    <button class="p-2 text-gray-600 hover:text-gray-800">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <div class="absolute right-0 mt-1 w-48 bg-white rounded-md shadow-lg z-10 hidden">
                                        <div class="py-1">
                                            <button wire:click="changeStatus({{ $cita->id }}, 'pendiente')"
                                                    class="block px-4 py-2 text-sm text-yellow-600 hover:bg-yellow-50 w-full text-left">
                                                Marcar como Pendiente
                                            </button>
                                            <button wire:click="changeStatus({{ $cita->id }}, 'confirmada')"
                                                    class="block px-4 py-2 text-sm text-blue-600 hover:bg-blue-50 w-full text-left">
                                                Marcar como Confirmada
                                            </button>
                                            <button wire:click="changeStatus({{ $cita->id }}, 'completada')"
                                                    class="block px-4 py-2 text-sm text-green-600 hover:bg-green-50 w-full text-left">
                                                Marcar como Completada
                                            </button>
                                            <button wire:click="changeStatus({{ $cita->id }}, 'cancelada')"
                                                    class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50 w-full text-left">
                                                Marcar como Cancelada
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <button wire:click="delete({{ $cita->id }})"
                                        class="p-2 text-red-600 hover:text-red-800"
                                        onclick="confirm('¿Eliminar esta cita?') || event.stopImmediatePropagation()">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-4 px-4 text-center text-gray-500">
                            No hay citas registradas
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
