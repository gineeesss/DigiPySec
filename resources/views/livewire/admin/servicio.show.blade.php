<?php
<div class="max-w-7xl mx-auto px-4 py-6">
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800">Detalles del Servicio</h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.servicios.edit', $servicio) }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
Editar
                </a>
                <a href="{{ route('admin.servicios.index') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">
Volver
                </a>
            </div>
        </div>

        <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Información principal -->
            <div class="md:col-span-2">
                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Información Básica</h3>
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-gray-500">Nombre</p>
                            <p class="font-medium">{{ $servicio->nombre }}</p>
</div>
<div>
    <p class="text-sm text-gray-500">Categoría</p>
    <p class="font-medium">{{ $servicio->categoria->nombre }}</p>
</div>
<div>
    <p class="text-sm text-gray-500">Precio</p>
    <p class="font-medium">${{ number_format($servicio->precio, 2) }}</p>
</div>
<div>
    <p class="text-sm text-gray-500">Estado</p>
    <p class="font-medium">
                                <span class="px-2 py-1 rounded-full text-xs {{ $servicio->activo ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $servicio->activo ? 'Activo' : 'Inactivo' }}
                                </span>
    </p>
</div>
</div>
</div>

<div class="mb-6">
    <h3 class="text-lg font-medium text-gray-900 mb-2">Descripción</h3>
    <div class="prose max-w-none">
        {!! nl2br(e($servicio->descripcion_larga)) !!}
    </div>
</div>
</div>

<!-- Detalles adicionales -->
<div>
    <div class="bg-gray-50 p-4 rounded-lg mb-6">
        <h3 class="text-lg font-medium text-gray-900 mb-2">Características Incluidas</h3>
        <ul class="space-y-2">
            @foreach($servicio->incluye as $item)
                <li class="flex items-start">
                    <svg class="h-5 w-5 text-green-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>{{ $item }}</span>
                </li>
            @endforeach
        </ul>
    </div>

    @if($servicio->imagen_principal)
        <div class="border rounded-lg overflow-hidden">
            <img src="{{ asset('storage/'.$servicio->imagen_principal) }}" alt="Imagen principal" class="w-full h-auto">
        </div>
    @endif
</div>
</div>
</div>
</div>
