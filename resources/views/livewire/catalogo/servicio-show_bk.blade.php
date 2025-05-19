<!-- resources/views/livewire/catalogo/servicio-show.blade.php -->
<div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumbs -->
        <nav class="flex mb-6" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('servicios.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                        Servicios
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-3 h-3 mx-1 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">{{ $servicio->nombre }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Galería de imágenes -->
            <div>
                <div class="mb-4 rounded-lg overflow-hidden">
                    <img src="{{ $servicio->imagen_principal_url }}" alt="{{ $servicio->nombre }}" class="w-full h-96 object-cover">
                </div>
                @if($servicio->imagenes->count() > 0)
                    <div class="grid grid-cols-4 gap-2">
                        @foreach($servicio->imagenes as $imagen)
                            <div class="border rounded-md overflow-hidden">
                                <img src="{{ $imagen->imagen_url }}" alt="" class="w-full h-24 object-cover">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Información del servicio -->
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $servicio->nombre }}</h1>

                <div class="flex items-center mb-4">
                    <span class="text-2xl font-bold text-blue-600">${{ number_format($servicio->precio_base, 2) }}</span>
                    <span class="text-sm text-gray-500 ml-1">+ IVA</span>
                    <span class="ml-4 text-sm text-gray-500">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Entrega en {{ $servicio->tiempo_estimado }} días
                    </span>
                </div>

                <div class="prose max-w-none mb-6">
                    {!! nl2br(e($servicio->descripcion_larga)) !!}
                </div>

                <!-- Características incluidas -->
                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Este servicio incluye:</h3>
                    <ul class="space-y-2">
                        @foreach($servicio->incluyes as $incluye)
                            <li class="flex items-start">
                                <svg class="h-5 w-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>{{ $incluye->caracteristica }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Formulario de compra -->
                <div class="border-t border-gray-200 pt-6">
                    @if($servicio->es_personalizable)
                        <div class="mb-4">
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Personaliza tu servicio</h3>
                            <!-- Aquí irían los campos de personalización -->
                        </div>
                    @endif

                    <div class="flex items-center space-x-4 mb-6">
                        <div class="flex items-center border border-gray-300 rounded-md">
                            <button wire:click="decrement" type="button" class="px-3 py-1 text-gray-600 hover:bg-gray-100">
                                -
                            </button>
                            <span class="px-3 py-1">{{ $cantidad }}</span>
                            <button wire:click="increment" type="button" class="px-3 py-1 text-gray-600 hover:bg-gray-100">
                                +
                            </button>
                        </div>
                        <button wire:click="addToCart" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md">
                            Añadir al carrito
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Servicios relacionados -->
        @if($serviciosRelacionados->count() > 0)
            <div class="mt-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Otros servicios de {{ $categoria->nombre }}</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($serviciosRelacionados as $servicioRel)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                            <a href="{{ route('servicios.show', $servicioRel->slug) }}">
                                <div class="h-48 overflow-hidden">
                                    <img src="{{ $servicioRel->imagen_principal_url }}" alt="{{ $servicioRel->nombre }}" class="w-full h-full object-cover">
                                </div>
                                <div class="p-4">
                                    <h3 class="text-lg font-semibold text-gray-800">{{ $servicioRel->nombre }}</h3>
                                    <p class="mt-2 text-gray-600 line-clamp-2">{{ $servicioRel->descripcion_corta }}</p>
                                    <div class="mt-3">
                                        <span class="text-lg font-bold text-blue-600">${{ number_format($servicioRel->precio_base, 2) }}</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
