<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- Imagen principal -->
        <div class="h-64 bg-gray-200 flex items-center justify-center">
            @if($servicio->imagen_principal)
                <img src="{{ asset('storage/'.$servicio->imagen_principal) }}" alt="{{ $servicio->nombre }}" class="h-full w-full object-cover">
            @else
                <span class="text-gray-500">Sin imagen</span>
            @endif
        </div>

        <!-- Contenido -->
        <div class="p-6">
            <h1 class="text-3xl font-bold text-gray-800">{{ $servicio->nombre }}</h1>
            <div class="flex items-center mt-2">
                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">
                    {{ $servicio->categoria->nombre }}
                </span>
                <span class="ml-4 text-2xl font-bold text-gray-900">
                    ${{ number_format($servicio->precio_base, 2) }}
                </span>
            </div>

            <div class="mt-6 prose max-w-none">
                <h3 class="text-xl font-semibold">Descripción del servicio</h3>
                {!! nl2br(e($servicio->descripcion_larga)) !!}
            </div>

            <div class="mt-8">
                <h3 class="text-xl font-semibold mb-4">¿Qué incluye?</h3>
                <ul class="space-y-3">
                    @foreach($servicio->incluyes as $item)
                        <li class="flex items-start">
                            <svg class="h-6 w-6 text-green-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>{{ $item->caracteristica }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Cantidad y botón para agregar al carrito -->
            @auth
                <div class="mt-8">
                    <button
                        wire:click="agregarAlCarrito({{ $servicio->id }})"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition duration-200"
                    >
                        Añadir al carrito
                    </button>
                </div>
            @else
                <div class="mt-8 bg-blue-50 p-4 rounded-lg">
                    <p class="text-blue-800 mb-2">¿Quieres contratar este servicio?</p>
                    <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-medium">Inicia sesión</a> o
                    <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-800 font-medium">regístrate</a> para continuar.
                </div>
            @endauth
        </div>
    </div>

    <!-- Notificación flotante -->
    <div
        x-data="{ show: false, message: '' }"
        x-on:notify.window="show = true; message = $event.detail; setTimeout(() => show = false, 3000)"
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform translate-y-4"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 transform translate-y-0"
        x-transition:leave-end="opacity-0 transform translate-y-4"
        class="fixed top-5 right-5 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg flex items-center"
        style="display: none;"
    >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
        <span x-text="message"></span>
    </div>
</div>
