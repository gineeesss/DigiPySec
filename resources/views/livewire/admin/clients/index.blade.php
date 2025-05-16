<!-- resources/views/livewire/admin/clients/index.blade.php -->
<div>
    <x-action-section>
        <x-slot name="title">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Listado de Clientes') }}
            </h2>
        </x-slot>

        <x-slot name="description">
            Gestiona todos los clientes registrados
        </x-slot>

        <x-slot name="content">
            <!-- Barra de búsqueda -->
            <div class="mb-4">
                <x-input wire:model="search" type="text" placeholder="Buscar..." class="w-full"/>
            </div>

            <!-- Tabla -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                    <tr>
                        <th class="px-6 py-3 bg-gray-50 text-left">Nombre</th>
                        <th class="px-6 py-3 bg-gray-50 text-left">Email</th>
                        <th class="px-6 py-3 bg-gray-50 text-left">Responsable</th>
                        <th class="px-6 py-3 bg-gray-50"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($clients as $client)
                        <tr>
                            <td class="px-6 py-4">{{ $client->name }}</td>
                            <td class="px-6 py-4">{{ $client->email }}</td>
                            <td class="px-6 py-4">{{ $client->user->name }}</td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('clients.edit', $client) }}" class="text-blue-500 hover:text-blue-700">Editar</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            <div class="mt-4">
                {{ $clients->links() }}
            </div>
        </x-slot>
    </x-action-section>
</div>
