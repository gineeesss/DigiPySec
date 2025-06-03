<!-- resources/views/livewire/admin/servicio-form.blade.php -->
<div>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Crear Servicio</h2>
            <p class="text-gray-500 text-sm">Hola</p>
    </x-slot>
    <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            <form wire:submit.prevent="save">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Campo Categoría -->
                    <div class="col-span-1">
                        <label for="categoria_servicio_id" class="block text-sm font-medium text-gray-700">Categoría</label>
                        <select wire:model="categoria_servicio_id" id="categoria_servicio_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Seleccione una categoría</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                            @endforeach
                        </select>
                        @error('categoria_servicio_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <!-- Campo Nombre -->
                    <div class="col-span-1">
                        <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre del Servicio</label>
                        <input wire:model="nombre" type="text" id="nombre" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('nombre') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <!-- Campo Slug -->
                    <div class="col-span-1">
                        <label for="slug" class="block text-sm font-medium text-gray-700">Slug (URL)</label>
                        <input wire:model="slug" type="text" id="slug" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('slug') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <!-- Campo Precio -->
                    <div class="col-span-1">
                        <label for="precio_base" class="block text-sm font-medium text-gray-700">Precio Base</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">$</span>
                            </div>
                            <input wire:model="precio_base" type="number" step="0.01" min="0" id="precio_base" class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md">
                        </div>
                        @error('precio_base') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <!-- Campo Tiempo Estimado -->
                    <div class="col-span-1">
                        <label for="tiempo_estimado" class="block text-sm font-medium text-gray-700">Tiempo Estimado (días)</label>
                        <input wire:model="tiempo_estimado" type="number" min="1" id="tiempo_estimado" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('tiempo_estimado') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <!-- Checkbox Personalizable -->
                    <div class="col-span-1">
                        <div class="flex items-center">
                            <input wire:model="es_personalizable" id="es_personalizable" type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="es_personalizable" class="ml-2 block text-sm text-gray-700">Servicio personalizable</label>
                        </div>
                    </div>

                    <!-- Checkbox Activo -->
                    <div class="col-span-1">
                        <div class="flex items-center">
                            <input wire:model="activo" id="activo" type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="activo" class="ml-2 block text-sm text-gray-700">Activo</label>
                        </div>
                    </div>

                    <!-- Campo Descripción Corta -->
                    <div class="col-span-2">
                        <label for="descripcion_corta" class="block text-sm font-medium text-gray-700">Descripción Corta</label>
                        <textarea wire:model="descripcion_corta" id="descripcion_corta" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                        @error('descripcion_corta') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <!-- Campo Descripción Larga -->
                    <div class="col-span-2">
                        <label for="descripcion_larga" class="block text-sm font-medium text-gray-700">Descripción Larga</label>
                        <textarea wire:model="descripcion_larga" id="descripcion_larga" rows="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                        @error('descripcion_larga') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <!-- Características Incluidas -->
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Características Incluidas</label>
                        <div class="mt-1 space-y-2">
                            @foreach($caracteristicas as $index => $caracteristica)
                                <div class="flex items-center">
                                    <span class="mr-2 text-green-500">✓</span>
                                    <span class="flex-grow">{{ $caracteristica }}</span>
                                    <button type="button" wire:click="removeCaracteristica({{ $index }})" class="text-red-500 hover:text-red-700">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            @endforeach
                            <div class="flex mt-2">
                                <input wire:model="nuevaCaracteristica" type="text" class="flex-grow rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Añadir nueva característica">
                                <button type="button" wire:click="addCaracteristica" class="ml-2 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                    Añadir
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <a href="{{ route('admin.servicios.index') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">
                        Cancelar
                    </a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Guardar Servicio
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
