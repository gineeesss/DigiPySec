<!-- resources/views/livewire/admin/client/index.blade.php -->
<div>
    <table class="table-auto w-full">
        <thead>
        <tr>
            <th>Nombre</th>
            <th>Email</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        @foreach($clients as $client)
            <tr>
                <td>{{ $client->name }}</td>
                <td>{{ $client->email }}</td>
                <td>
                    <a href="{{ route('clients.edit', $client) }}" class="btn btn-sm btn-primary">Editar</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
