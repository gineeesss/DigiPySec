<div>
    <h1 class="text-2xl font-bold mb-4">Admin Restaurante</h1>

    <a href="{{ route('restaurante.admin.nuevo') }}" class="bg-green-500 text-white px-4 py-2 rounded mb-4 inline-block">+ Nuevo Plato</a>

    <table class="w-full bg-white rounded shadow">
        <thead>
        <tr>
            <th class="p-2">Nombre</th>
            <th class="p-2">Categoría</th>
            <th class="p-2">Precio</th>
            <th class="p-2">Acciones</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($platos as $plato)
            <tr>
                <td class="p-2">{{ $plato->nombre }}</td>
                <td class="p-2">{{ $plato->categoria->nombre }}</td>
                <td class="p-2">{{ $plato->precio }} €</td>
                <td class="p-2">
                    <a href="{{ route('restaurante.admin.editar', $plato->id) }}" class="text-blue-500">Editar</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
