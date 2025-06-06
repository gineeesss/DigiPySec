<!-- resources/views/livewire/demos/tienda/carrito-tienda.blade.php -->
<div class="container mx-auto px-4 py-8">
    <h2 class="text-2xl font-bold mb-6">Tu Carrito</h2>

    @if(count($carrito) > 0)
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <table class="min-w-full">
                <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left">Producto</th>
                    <th class="px-4 py-2 text-left">Precio</th>
                    <th class="px-4 py-2 text-left">Cantidad</th>
                    <th class="px-4 py-2 text-left">Subtotal</th>
                </tr>
                </thead>
                <tbody>
                @foreach($carrito as $item)
                    <tr class="border-t">
                        <td class="px-4 py-3">{{ $item['producto']->nombre }}</td>
                        <td class="px-4 py-3">{{ number_format($item['precio'], 2) }} €</td>
                        <td class="px-4 py-3">{{ $item['cantidad'] }}</td>
                        <td class="px-4 py-3">{{ number_format($item['precio'] * $item['cantidad'], 2) }} €</td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot class="bg-gray-50">
                <tr class="font-bold">
                    <td colspan="3" class="px-4 py-3 text-right">Total:</td>
                    <td class="px-4 py-3">{{ number_format($total, 2) }} €</td>
                </tr>
                </tfoot>
            </table>
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md p-6 text-center">
            <p class="text-gray-600">Tu carrito está vacío</p>
            <a href="{{ route('tienda.index') }}" class="text-indigo-600 hover:underline mt-2 inline-block">
                Volver a la tienda
            </a>
        </div>
    @endif
    @if(count($carrito) > 0)
        <div class="mt-6">
            <button wire:click="irACheckout"
                    class="w-full bg-indigo-600 text-white py-2 px-4 rounded hover:bg-indigo-700">
                Proceder al pago
            </button>
        </div>
    @endif
</div>
