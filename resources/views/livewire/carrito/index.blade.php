<div>
    <!-- Botón para mostrar/ocultar carrito -->
    <button wire:click="toggleCarrito" class="relative p-2 text-gray-700 hover:text-gray-900">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
        </svg>
        @if(count($carrito) > 0)
            <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-500 rounded-full">
                {{ count($carrito) }}
            </span>
        @endif
    </button>

    <!-- Panel del carrito -->
    @if($mostrarCarrito)
        <div class="absolute right-0 mt-2 w-80 bg-white rounded-md shadow-lg z-50">
            <div class="p-4 border-b">
                <h3 class="text-lg font-medium">Tu carrito</h3>
            </div>

            <div class="p-4 max-h-96 overflow-y-auto">
                @if(count($carrito) > 0)
                    <ul class="divide-y divide-gray-200">
                        @foreach($carrito as $item)
                            <li class="py-4 flex justify-between items-center">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $item['nombre'] }}</p>
                                    <p class="text-sm text-gray-500">${{ number_format($item['precio'], 2) }}</p>
                                </div>
                                <button
                                    wire:click="removerServicio({{ $item['id'] }})"
                                    class="text-red-500 hover:text-red-700"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-sm text-gray-500">Tu carrito está vacío</p>
                @endif
            </div>

            @if(count($carrito) > 0)
                <div class="p-4 border-t">
                    <div class="flex justify-between mb-4">
                        <span class="font-medium">Total:</span>
                        <span class="font-bold">${{ number_format($this->calcularTotal(), 2) }}</span>
                    </div>
                    <a
                        href="{{ route('checkout') }}"
                        class="block w-full bg-blue-600 hover:bg-blue-700 text-white text-center py-2 px-4 rounded"
                    >
                        Finalizar compra
                    </a>
                </div>
            @endif
        </div>
    @endif
</div>
