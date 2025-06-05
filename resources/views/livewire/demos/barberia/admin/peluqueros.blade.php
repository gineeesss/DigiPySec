<!-- resources/views/livewire/demos/barberia/admin/peluqueros.blade.php -->
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Gestión de Peluqueros</h1>
            <a href="{{ route('barberia.admin') }}"
               class="text-blue-600 hover:text-blue-800 flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Volver al panel
            </a>
        </div>

        <!-- Formulario de creación/edición -->
        <form wire:submit.prevent="save" class="mb-8 bg-gray-50 p-6 rounded-lg">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 mb-2">Nombre completo</label>
                    <input type="text" wire:model="nombre"
                           class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    @error('nombre') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-gray-700 mb-2">Especialidad</label>
                    <input type="text" wire:model="especialidad"
                           class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    @error('especialidad') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-gray-700 mb-2">Foto (URL)</label>
                    <input type="text" wire:model="foto"
                           class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500"
                           placeholder="https://ejemplo.com/foto.jpg">
                </div>

                @if($foto)
                    <div class="flex items-center justify-center">
                        <img src="{{ $foto }}" alt="Vista previa" class="h-20 w-20 rounded-full object-cover">
                    </div>
                @endif
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

        <!-- Lista de peluqueros -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-lg overflow-hidden">
                <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="py-3 px-4 text-left">ID</th>
                    <th class="py-3 px-4 text-left">Nombre</th>
                    <th class="py-3 px-4 text-left">Especialidad</th>
                    <th class="py-3 px-4 text-left">Estado</th>
                    <th class="py-3 px-4 text-right">Acciones</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                @forelse($peluqueros as $peluquero)
                    <tr class="hover:bg-gray-50">
                        <td class="py-4 px-4">{{ $peluquero->id }}</td>
                        <td class="py-4 px-4 font-medium">{{ $peluquero->nombre }}</td>
                        <td class="py-4 px-4">{{ $peluquero->especialidad }}</td>
                        <td class="py-4 px-4">
                                <span class="px-2 py-1 text-xs rounded-full
                                    {{ $peluquero->activo ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $peluquero->activo ? 'Activo' : 'Inactivo' }}
                                </span>
                        </td>
                        <td class="py-4 px-4 text-right">
                            <div class="flex justify-end space-x-2">
                                <button wire:click="edit({{ $peluquero->id }})"
                                        class="p-2 text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button wire:click="toggleStatus({{ $peluquero->id }})"
                                        class="p-2 {{ $peluquero->activo ? 'text-yellow-600 hover:text-yellow-800' : 'text-green-600 hover:text-green-800' }}">
                                    <i class="fas {{ $peluquero->activo ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                                </button>
                                <button wire:click="delete({{ $peluquero->id }})"
                                        class="p-2 text-red-600 hover:text-red-800"
                                        onclick="confirm('¿Eliminar este peluquero?') || event.stopImmediatePropagation()">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-4 px-4 text-center text-gray-500">
                            No hay peluqueros registrados
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
