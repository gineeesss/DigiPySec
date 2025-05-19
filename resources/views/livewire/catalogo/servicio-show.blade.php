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
                    ${{ number_format($servicio->precio, 2) }}
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

            <!-- Botón para solicitar servicio (visible solo para autenticados) -->
            @auth
                <div class="mt-8">
                    <button wire:click="agregarASolicitud" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        Solicitar este servicio
                    </button>
                </div>
            @endauth
        </div>
    </div>
</div>
