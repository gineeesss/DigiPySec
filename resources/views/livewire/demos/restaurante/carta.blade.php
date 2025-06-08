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
                            <img x-bind:src="obtenerImagen('{{ $plato->nombre }}')"
                                 alt="Imagen {{ $plato->nombre }}"
                                 class="w-24 h-24 object-cover rounded"
                                 @click="buscarImagen('{{ $plato->nombre }}')">                        </td>
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
            imagenesCache: {},
            apiKey: 'tHTkM4F1A7doxVR0dhkYE5fi7myKA4uej5jysw2XKGw9olDMdiafhmLQ', // Reemplaza con tu API key

            async obtenerImagen(query) {
                // Si ya tenemos la imagen en caché, la devolvemos
                if(this.imagenesCache[query]) {
                    return this.imagenesCache[query];
                }

                // Si no, intentamos obtenerla de Pexels
                try {
                    const response = await fetch(`https://api.pexels.com/v1/search?query=${encodeURIComponent(query)}&per_page=1`, {
                        headers: {
                            'Authorization': this.apiKey
                        }
                    });

                    const data = await response.json();
                    if(data.photos && data.photos.length > 0) {
                        this.imagenesCache[query] = data.photos[0].src.small;
                        return data.photos[0].src.small;
                    }
                } catch (error) {
                    console.error('Error al obtener imagen:', error);
                }

                // Si no encontramos imagen, devolvemos una por defecto
                return '{{ $plato->imagen_url }}';
            },

            async buscarImagen(query) {
                try {
                    const response = await fetch(`https://api.pexels.com/v1/search?query=${encodeURIComponent(query)}&per_page=10`, {
                        headers: {
                            'Authorization': this.apiKey
                        }
                    });

                    const data = await response.json();
                    if(data.photos && data.photos.length > 0) {
                        // Aquí podrías mostrar un modal con las imágenes para seleccionar
                        console.log('Imágenes encontradas:', data.photos);
                        // Por ahora, usamos la primera
                        this.imagenesCache[query] = data.photos[0].src.medium;
                    }
                } catch (error) {
                    console.error('Error al buscar imágenes:', error);
                }
            },

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
