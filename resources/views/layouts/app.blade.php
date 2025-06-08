<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <x-banner />

        <div class="min-h-screen bg-gray-100">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <main class="min-h-screen">
                {{ $slot }}
            </main>
        </div>

        <!-- Footer -->
        <footer class="bg-gray-800 text-white pt-12 pb-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex  justify-between">
                    <!-- Columna 1: Logos/Imágenes -->
                    <div class="w-full md:w-1/4 px-4 mb-8 md:mb-0">
                        <h3 class="text-lg font-semibold mb-4">Certificaciones</h3>
                        <div class="flex flex-col space-y-4">
                            <img src="{{ asset('banner.png') }}" alt="Certificación 1" class="h-8 w-auto">
                            <img src="{{ asset('titulo_web_iescastelar_2425.png') }}" alt="Certificación 2" class="h-8 w-auto">
                            <img src="{{ asset('INE_Black_Logo_Retina.avif') }}" alt="Certificación 3" class="h-8 w-auto">
                        </div>
                    </div>

                    <!-- Columna 2: Servicios -->
                    <div class="w-1/2 sm:w-1/2 md:w-1/4 px-4 mb-8">
                        <h3 class="text-lg font-semibold mb-4">Servicios</h3>
                        <ul class="space-y-2">
                            <li><a href="{{ route('servicios.index') }}" class="hover:text-blue-300 transition">Digitalización</a></li>
                            <li><a href="{{ route('servicios.index') }}" class="hover:text-blue-300 transition">Ciberseguridad</a></li>
                            <li><a href="{{ route('servicios.index') }}" class="hover:text-blue-300 transition">Desarrollo Web</a></li>
                            <li><a href="{{ route('servicios.index') }}" class="hover:text-blue-300 transition">Consultoría IT</a></li>
                            <li><a href="{{ route('servicios.index') }}" class="hover:text-blue-300 transition">Cloud Computing</a></li>
                        </ul>
                    </div>

                    <!-- Columna 3: Portafolio -->
                    <div class="w-full md:w-1/4 px-4 mb-8 md:mb-0">
                        <h3 class="text-lg font-semibold mb-4">Portafolio</h3>
                        <ul class="space-y-2">
                            <li><a href="servicios.index" class="hover:text-blue-300 transition">Web Corporativa</a></li>
                            <li><a href="servicios.index" class="hover:text-blue-300 transition">Tienda Online</a></li>
                            <li><a href="servicios.index" class="hover:text-blue-300 transition">Aplicación SaaS</a></li>
                            <li><a href="servicios.index" class="hover:text-blue-300 transition">Plataforma Educativa</a></li>
                            <li><a href="servicios.index" class="hover:text-blue-300 transition">Sistema de Gestión</a></li>
                        </ul>
                    </div>

                    <!-- Columna 4: Contacto y Empresa -->
                    <div class="w-full md:w-1/4 px-4">
                        <h3 class="text-lg font-semibold mb-4">Contacto</h3>
                        <address class="not-italic mb-4">
                            <p class="flex items-start"><i class="fas fa-map-marker-alt mr-2 mt-1"></i> Calle Inventada, 69</p>
                            <p class="flex items-start my-2"><i class="fas fa-city mr-2 mt-1"></i> 06003 Badajoz, España</p>
                            <p class="flex items-start"><i class="fas fa-phone mr-2 mt-1"></i> +34 696 696 696</p>
                            <p class="flex items-start my-2"><i class="fas fa-envelope mr-2 mt-1"></i> info@digipysec.com</p>
                        </address>

                        <h3 class="text-lg font-semibold mb-2 mt-6">Empresa</h3>
                        <ul class="space-y-2">
                            <li><a href="{{ route('servicios.index') }}" class="hover:text-blue-300 transition">Sobre Nosotros</a></li>
                            <li><a href="{{ route('servicios.index') }}" class="hover:text-blue-300 transition">Equipo</a></li>
                            <li><a href="{{ route('servicios.index') }}" class="hover:text-blue-300 transition">Blog</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Línea divisoria -->
                <div class="border-t border-gray-700 mt-8 pt-6">
                    <div class="flex flex-col md:flex-row justify-between items-center">
                        <div class="mb-4 md:mb-0">
                            &copy; {{ date('Y') == '2023' ? '2023' : '2023-' . date('Y') }} DigiPySec SL<sup>®</sup> - Todos los derechos reservados
                        </div>
                        <div class="flex flex-wrap justify-center space-x-4">
                            <a href="{{ route('servicios.index') }}" class="hover:text-blue-300 transition">Aviso Legal</a>
                            <a href="{{ route('servicios.index') }}" class="hover:text-blue-300 transition">Política de Privacidad</a>
                            <a href="{{ route('servicios.index') }}" class="hover:text-blue-300 transition">Política de Cookies</a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>


        @stack('modals')
        <div x-data="{ open: false }"
             x-cloak
             class="position-fixed bottom-0 end-0 p-4 z-50 d-flex flex-column align-items-end"
             style="pointer-events: none;">   {{-- evita tapar enlaces debajo --}}

            {{-- Botón redondo --}}
            <button @click="open = !open"
                    class="btn btn-primary rounded-circle shadow-lg d-flex align-items-center justify-content-center"
                    style="width:56px;height:56px;pointer-events:auto;"
                    aria-label="Abrir chat">
                <i class="bi bi-chat-dots-fill fs-4"></i>
            </button>

            {{-- Panel del chat --}}
            <div x-show="open"
                 x-transition.scale.origin.bottom.right
                 @click.outside="open = false"
                 class="card shadow-lg mt-3"
                 style="width:320px;max-height:80vh;pointer-events:auto;">
                <div class="card-body p-0">
                    <livewire:chatbot />
                </div>
            </div>
        </div>
        @livewireScripts

    </body>
</html>

<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('actualizarContadorCarrito', () => {
            // Puedes agregar animaciones o efectos aquí si lo deseas
        });
    });
   /* document.addEventListener('DOMContentLoaded', function() {
        // Persistir carrito en localStorage
        Livewire.on('carritoActualizado', (carrito) => {
            localStorage.setItem('carrito', JSON.stringify(carrito));
        });

        // Cargar carrito desde localStorage
        Livewire.on('cargarCarritoDesdeStorage', () => {
            const carritoGuardado = localStorage.getItem('carrito');
            if (carritoGuardado) {
                Livewire.dispatch('carritoGuardadoEnStorage', {
                    carrito: JSON.parse(carritoGuardado)
                });
            }
        });

        // Escuchar eventos de notificación
        Livewire.on('notify', (message) => {
            const event = new CustomEvent('notify', { detail: message });
            window.dispatchEvent(event);
        });
    });*/
</script>
