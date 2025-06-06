<!-- resources/views/layouts/demo-tienda.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda Demo - {{ $title ?? 'Inicio' }}</title>
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
<header class="bg-white shadow-sm">
    <div class="container mx-auto px-4 py-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-indigo-600">
            <a href="{{ route('tienda.index') }}">Tienda Demo</a>
        </h1>
        <livewire:demos.tienda.carrito-tienda />
    </div>
</header>

<main>
    {{ $slot }}
</main>

<footer class="bg-gray-800 text-white py-8 mt-12">
    <div class="container mx-auto px-4 text-center">
        <p>&copy; {{ date('Y') }} Tienda Demo. Todos los derechos reservados.</p>
    </div>
</footer>
@livewireScripts

</body>
</html>
