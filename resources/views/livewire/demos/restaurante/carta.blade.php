<div x-data="carta()">
    <div class="flex justify-between items-start mb-4">
        <!-- Selector de personas -->
        <div>
            <label class="block text-sm font-medium mb-1">¿Cuántas personas comen?</label>
            <input type="number" min="1" x-model.number="personas" class="border rounded p-2 w-24">
        </div>

        <!-- Carrito de la comanda -->
        <div class="bg-white shadow rounded p-4 w-80 border">
            <h3 class="text-lg font-bold mb-2">Tu comanda</h3>
            <ul class="mb-2 max-h-40 overflow-y-auto">
                <template x-for="(item, index) in items" :key="index">
                    <li class="text-sm flex justify-between mb-1">
                        <span x-text="item.nombre"></span>
                        <span x-text="item.precio.toFixed(2) + ' €'"></span>
                        <button @click="quitar(index)" class="text-red-500 hover:text-red-700 ml-2 text-xs">✖</button>
                    </li>

                </template>
            </ul>
            <div class="text-md font-semibold border-t pt-2 mt-2">
                Total: <span x-text="total().toFixed(2) + ' €'"></span><br>
                Por persona: <span x-text="(total()/personas).toFixed(2) + ' €'"></span>
            </div>
        </div>
    </div>


    @foreach ($categorias as $categoria)
        <div class="mb-8">
            <h2 class="text-2xl font-bold mb-4 border-b pb-2">{{ $categoria->nombre }}</h2>
            <table class="w-full text-left border">
                <thead class="bg-gray-100">
                <tr>
                    <th class="p-2">Imagen</th>
                    <th class="p-2">Plato</th>
                    <th class="p-2">Descripción</th>
                    <th class="p-2">Tapa</th>
                    <th class="p-2">Ración</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($categoria->platos as $plato)
                    <tr class="border-t">
                        <td class="p-2">
                            <img src="{{ $plato->imagen_url }}" alt="Imagen {{ $plato->nombre }}" class="w-24 h-24 object-cover rounded">
                        </td>
                        <td class="p-2 font-bold">{{ $plato->nombre }}</td>
                        <td class="p-2 text-sm">{{ $plato->descripcion }}</td>
                        <td class="p-2">
                            @if($plato->precio_tapa)
                                <button @click="agregar('{{ $plato->nombre }}', {{ $plato->precio_tapa }})"
                                        class="bg-blue-500 text-white px-2 py-1 rounded">
                                    {{ number_format($plato->precio_tapa, 2) }} €
                                </button>
                            @else
                                -
                            @endif
                        </td>
                        <td class="p-2">
                            @if($plato->precio_racion)
                                <button @click="agregar('{{ $plato->nombre }}', {{ $plato->precio_racion }})"
                                        class="bg-green-500 text-white px-2 py-1 rounded">
                                    {{ number_format($plato->precio_racion, 2) }} €
                                </button>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endforeach

    <!-- Carrito -->
    <div class="fixed bottom-4 right-4 bg-white shadow-lg rounded p-4 w-80 border" x-show="true">
        <h3 class="text-lg font-bold mb-2">Tu comanda</h3>
        <ul class="mb-2 max-h-40 overflow-y-auto">
            <template x-for="(item, index) in items" :key="index">
                <li class="text-sm flex justify-between mb-1">
                    <span x-text="item.nombre"></span>
                    <span x-text="item.precio.toFixed(2) + ' €'"></span>
                </li>

            </template>
        </ul>
        <div class="text-md font-semibold border-t pt-2 mt-2">
            Total: <span x-text="total().toFixed(2) + ' €'"></span><br>
            Por persona: <span x-text="(total()/personas).toFixed(2) + ' €'"></span>
        </div>
    </div>
</div>

<script>
    function carta() {
        return {
            personas: 1,
            items: [],
            agregar(nombre, precio) {
                this.items.push({ nombre, precio });
            },
            quitar(index) {
                this.items.splice(index, 1);
            },
            total() {
                return this.items.reduce((sum, item) => sum + item.precio, 0);
            }
        };
    }
</script>
