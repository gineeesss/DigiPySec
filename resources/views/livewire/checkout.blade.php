<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="p-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">Finalizar compra</h1>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="md:col-span-2">
                    <h2 class="text-xl font-semibold mb-4">Resumen de tu pedido</h2>

                    <ul class="divide-y divide-gray-200 mb-6">
                        @foreach($carrito as $item)
                            <li class="py-4 flex justify-between">
                                <div>
                                    <p class="font-medium">{{ $item['nombre'] }}</p>
                                </div>
                                <span>${{ number_format($item['precio'], 2) }}</span>
                            </li>
                        @endforeach
                    </ul>

                    <div class="border-t pt-4">
                        <div class="flex justify-between text-lg font-bold">
                            <span>Total:</span>
                            <span>${{ number_format($this->calcularTotal(), 2) }}</span>
                        </div>
                    </div>
                </div>

                <div>
                    <h2 class="text-xl font-semibold mb-4">Información adicional</h2>

                    <form wire:submit.prevent="submit">
                        <div class="mb-4">
                            <label for="notas" class="block text-sm font-medium text-gray-700 mb-1">Notas (opcional)</label>
                            <textarea
                                wire:model="notas"
                                id="notas"
                                rows="4"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            ></textarea>
                        </div>

                        <button
                            type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition duration-200"
                        >
                            Confirmar solicitud
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
