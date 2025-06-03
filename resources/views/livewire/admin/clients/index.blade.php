<!-- resources/views/livewire/admin/clients/index.blade.php -->
<div>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Listado de Clientes</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <!-- Descripción -->
                <p class="mb-4 text-gray-600">Gestiona todos los clientes registrados</p>

                <!-- Barra de búsqueda -->
                <div class="mb-4">
                    <x-input wire:model.live.debounce.500ms="search" type="text" placeholder="Buscar por nombre o email..." class="w-full"/>
                </div>

                <!-- Tabla -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-gray-700 bg-gray-100">Nombre</th>
                            <th class="px-6 py-3 text-left text-gray-700 bg-gray-100">Email</th>
                            <th class="px-6 py-3 text-left text-gray-700 bg-gray-100">Responsable</th>
                            <th class="px-6 py-3 bg-gray-100"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($clients as $client)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-gray-900">{{ $client->user->name }}</td>
                                <td class="px-6 py-4 text-gray-900">{{ $client->user->email }}</td>
                                <td class="px-6 py-4 text-gray-900">{{ $client->user->name }}</td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('admin.clients.edit', $client) }}" class="text-blue-500 hover:text-blue-700">Editar</a>
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
            </div>
        </div>
    </div>
</div>
