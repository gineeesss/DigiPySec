<!-- resources/views/livewire/demos/tienda/checkout-tienda.blade.php -->
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <h2 class="text-2xl font-bold mb-6">Finalizar Compra</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Formulario de envío -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Datos de contacto</h3>

                <form wire:submit.prevent="realizarPedido">
                    <div class="space-y-4">
                        <div>
                            <label class="block mb-1">Nombre completo</label>
                            <input type="text" wire:model="nombre" class="w-full border rounded px-3 py-2">
                            @error('nombre') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block mb-1">Email</label>
                            <input type="email" wire:model="email" class="w-full border rounded px-3 py-2">
                            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block mb-1">Teléfono</label>
                            <input type="text" wire:model="telefono" class="w-full border rounded px-3 py-2">
                            @error('telefono') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block mb-1">Dirección de envío</label>
                            <textarea wire:model="direccion" rows="3" class="w-full border rounded px-3 py-2"></textarea>
                            @error('direccion') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block mb-1">Notas adicionales</label>
                            <textarea wire:model="notas" rows="2" class="w-full border rounded px-3 py-2"></textarea>
                        </div>
                    </div>

                    <button type="submit" class="mt-6 w-full bg-indigo-600 text-white py-2 px-4 rounded hover:bg-indigo-700">
                        Confirmar Pedido
                    </button>
                </form>
            </div>

            <!-- Resumen del pedido -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Tu pedido</h3>
                <div class="bg-white rounded-lg shadow p-6">
                    <ul class="divide-y">
                        @foreach($carrito as $item)
                            <li class="py-3 flex justify-between">
                                <span>{{ $item['producto']->nombre }} x{{ $item['cantidad'] }}</span>
                                <span>{{ number_format($item['producto']->precio * $item['cantidad'], 2) }} €</span>
                            </li>
                        @endforeach
                    </ul>

                    <div class="border-t pt-4 mt-4">
                        <div class="flex justify-between font-bold">
                            <span>Total:</span>
                            <span>{{ number_format($total, 2) }} €</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
