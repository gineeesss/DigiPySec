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
                <div class="flex gap-6">
                    <!-- Columna principal: contenido dinámico -->
                    <div class="flex-1">
                        {{ $slot }}
                    </div>

                    <!-- Columna lateral derecha: Chatbot -->
                    <div class="w-80 relative mt-2">
                        <div x-data="{ open: false }" class="sticky top-6" x-cloak>
                            <!-- Botón flotante -->
                            <button @click="open = !open" class="bg-blue-600 hover:bg-blue-700 text-white p-4 rounded-full shadow-lg focus:outline-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M9 17v-2a4 4 0 014-4h1a4 4 0 014 4v2m-4 4h.01M12 11c1.104 0 2-.896 2-2s-.896-2-2-2-2 .896-2 2 .896 2 2 2z" />
                                </svg>
                            </button>

                            <!-- Chatbot -->
                            <div x-show="open" x-transition class="mt-2 bg-white rounded-lg shadow-lg">
                                <livewire:chatbot />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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
                            <p class="flex items-start"><i class="fas fa-map-marker-alt mr-2 mt-1"></i> Calle Ejemplo, 123</p>
                            <p class="flex items-start my-2"><i class="fas fa-city mr-2 mt-1"></i> 28001 Madrid, España</p>
                            <p class="flex items-start"><i class="fas fa-phone mr-2 mt-1"></i> +34 123 456 789</p>
                            <p class="flex items-start my-2"><i class="fas fa-envelope mr-2 mt-1"></i> info@empresa.com</p>
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
                            &copy; {{ date('Y') == '2023' ? '2023' : '2023-' . date('Y') }} Empresa SL<sup>®</sup> - Todos los derechos reservados
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
