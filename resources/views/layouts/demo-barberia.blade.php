<!-- resources/views/layouts/demo-barberia.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barbería Digital - @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
    /* Estilos para el dropdown de acciones */
    .relative:hover .absolute {
    display: block;
    }

    /* Transiciones suaves */
    .transition-colors {
    transition: background-color 0.2s ease;
    }

    /* Mejora la apariencia de las tablas */
    table {
    border-collapse: separate;
    border-spacing: 0;
    }

    th {
    position: sticky;
    top: 0;
    }
    </style>
    @livewireStyles
</head>
<body class="bg-gray-100">
<header class="bg-gray-900 text-white shadow-lg">
    <div class="container mx-auto px-4 py-6">
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold">Barbería Digital</h1>
            <nav>
                <ul class="flex space-x-6">
                    <li><a href="{{ route('barberia.reservar') }}" class="hover:text-yellow-400">Reservar Cita</a></li>
                    <li><a href="{{ route('barberia.admin') }}" class="hover:text-yellow-400">Admin</a></li>
                </ul>
            </nav>
        </div>
    </div>
</header>

<main class="container mx-auto px-4 py-8">
    {{ $slot }}
</main>

<footer class="bg-gray-800 text-white py-6 mt-12">
    <div class="container mx-auto px-4 text-center">
        <p>&copy; {{ date('Y') }} Barbería Digital. Todos los derechos reservados.</p>
    </div>
</footer>

@livewireScripts
</body>
</html>

