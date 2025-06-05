<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Carta Restaurante' }}</title>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gray-100 text-gray-900">

<header class="bg-white shadow p-4 text-center text-2xl font-bold">
    🍽️ Carta del Restaurante
</header>
    <div class="flex gap-6">

<main class="p-6 max-w-5xl mx-auto">
    {{ $slot }}
</main>
    </div>
<footer class="text-center text-sm text-gray-500 py-4">
    Demo | DigiPySecs
</footer>
@livewireScripts
</body>
</html>
