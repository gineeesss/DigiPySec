<div>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Editar Cliente</h2>
        <p class="text-gray-500 text-sm">ID: {{ $client->id }}</p>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form wire:submit="update">
                    <div class="space-y-6">
                        <!-- Campo Nombre -->
                        <div>
                            <x-label for="name" value="Nombre completo" />
                            <x-input wire:model="name" id="name" type="text" class="mt-1 block w-full" />
                            <x-input-error for="name" class="mt-2" />
                        </div>

                        <!-- Campo Email -->
                        <div>
                            <x-label for="email" value="Email" />
                            <x-input wire:model="email" id="email" type="email" class="mt-1 block w-full" />
                            <x-input-error for="email" class="mt-2" />
                        </div>

                        <!-- Campo Teléfono -->
                        <div>
                            <x-label for="phone" value="Teléfono" />
                            <x-input wire:model="phone" id="phone" type="tel" class="mt-1 block w-full" />
                            <x-input-error for="phone" class="mt-2" />
                        </div>

                        <!-- Botones -->
                        <div class="flex items-center justify-end gap-4">
                            <x-secondary-button href="{{ route('admin.clients.index') }}">
                                <i class="fas fa-times mr-2">Cancelar</i>
                            </x-secondary-button>
                            <x-secondary-button type="submit">
                                <i class="fas fa-save mr-2">Actualizar</i>
                            </x-secondary-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
