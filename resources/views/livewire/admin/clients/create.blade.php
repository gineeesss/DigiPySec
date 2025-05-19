<div>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Crear Cliente</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form wire:submit="save">
                    <div class="space-y-6">
                        <x-input wire:model="name" label="Nombre" placeholder="Ej: Juan Pérez" />
                        <x-input wire:model="email" type="email" label="Email" placeholder="ejemplo@mail.com" />
                        <x-input wire:model="phone" label="Teléfono" placeholder="+34 600 000 000" />

                        <div class="flex justify-end space-x-4">
                            <x-button secondary :href="route('admin.clients.index')">Cancelar</x-button>
                            <x-button type="submit">Guardar</x-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
