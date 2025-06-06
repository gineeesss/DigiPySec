<!-- resources/views/livewire/demos/tienda/gracias-tienda.blade.php -->
<div class="container mx-auto px-4 py-12 text-center">
    <div class="max-w-md mx-auto">
        <div class="text-green-500 text-6xl mb-4">
            <i class="fas fa-check-circle"></i>
        </div>
        <h2 class="text-2xl font-bold mb-4">¡Gracias por tu compra!</h2>
        <p class="mb-6">Tu pedido <strong>{{ $pedido->codigo }}</strong> ha sido recibido.</p>

        <a href="{{ route('tienda.index') }}"
           class="inline-block bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">
            Volver a la tienda
        </a>
    </div>
</div>
