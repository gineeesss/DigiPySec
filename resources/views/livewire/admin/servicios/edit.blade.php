<!-- resources/views/livewire/admin/servicios/edit.blade.php -->
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Editar Servicio: {{ $servicio->nombre }}</h2>

        <form wire:submit.prevent="update">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nombre -->
                <div class="col-span-1">
                    <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre del Servicio</label>
                    <input wire:model="servicio.nombre" type="text" id="nombre" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @error('servicio.nombre') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Categoría -->
                <div class="col-span-1">
                    <label for="categoria_id" class="block text-sm font-medium text-gray-700 mb-1">Categoría</label>
                    <select wire:model="servicio.categoria_id" id="categoria_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Seleccione una categoría</option>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id }}" {{ $servicio->categoria_id == $categoria->id ? 'selected' : '' }}>
                                {{ $categoria->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('servicio.categoria_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Descripción -->
                <div class="col-span-2">
                    <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                    <textarea wire:model="servicio.descripcion" id="descripcion" rows="4" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                    @error('servicio.descripcion') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Precio -->
                <div class="col-span-1">
                    <label for="precio" class="block text-sm font-medium text-gray-700 mb-1">Precio</label>
                    <input wire:model="servicio.precio" type="number" step="0.01" min="0" id="precio" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @error('servicio.precio') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Imagen -->
                <div class="col-span-1">
                    <label for="imagen" class="block text-sm font-medium text-gray-700 mb-1">Imagen</label>
                    @if($servicio->imagen)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $servicio->imagen) }}" alt="Imagen actual" class="h-20">
                        </div>
                    @endif
                    <input wire:model="nueva_imagen" type="file" id="imagen" class="w-full">
                    @error('nueva_imagen') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Características -->
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Características Incluidas</label>
                    <div class="space-y-2">
                        @foreach($servicio->incluye as $index => $caracteristica)
                            <div class="flex items-center">
                                <input wire:model="servicio.incluye.{{ $index }}" type="text" class="flex-grow rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <button wire:click="removeCaracteristica({{ $index }})" type="button" class="ml-2 text-red-500">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        @endforeach
                        <button wire:click="addCaracteristica" type="button" class="mt-2 px-3 py-1 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">
                            + Añadir Característica
                        </button>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('admin.servicios.index') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">
                    Cancelar
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    Actualizar Servicio
                </button>
            </div>
        </form>
    </div>
</div>
