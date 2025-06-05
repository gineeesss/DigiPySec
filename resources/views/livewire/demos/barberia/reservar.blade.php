<!-- resources/views/livewire/demos/barberia/reservar.blade.php -->
<div>
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold mb-6 text-center">Reserva tu cita</h2>

        <!-- Pasos -->
        <div class="flex justify-between mb-8">
            @foreach([1 => 'Peluquero', 2 => 'Tratamiento', 3 => 'Fecha', 4 => 'Hora', 5 => 'Datos'] as $step => $label)
                <div class="text-center">
                    <div class="w-10 h-10 mx-auto rounded-full flex items-center justify-center
                        {{ $paso >= $step ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-600' }}">
                        {{ $step }}
                    </div>
                    <div class="mt-2 text-sm {{ $paso >= $step ? 'font-bold text-blue-600' : 'text-gray-500' }}">
                        {{ $label }}
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Paso 1: Seleccionar peluquero -->
        @if($paso == 1)
            <h3 class="text-xl font-semibold mb-4">Selecciona tu peluquero</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach($peluqueros as $peluquero)
                    <div class="border rounded-lg p-4 text-center cursor-pointer hover:bg-gray-50"
                         wire:click="seleccionarPeluquero({{ $peluquero->id }})">
                        <div class="w-24 h-24 mx-auto rounded-full bg-gray-200 mb-3 overflow-hidden">
                            @if($peluquero->foto)
                                <img src="{{ asset($peluquero->foto) }}" alt="{{ $peluquero->nombre }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                    <i class="fas fa-user text-4xl"></i>
                                </div>
                            @endif
                        </div>
                        <h4 class="font-bold">{{ $peluquero->nombre }}</h4>
                        <p class="text-sm text-gray-600">{{ $peluquero->especialidad }}</p>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Paso 2: Seleccionar tratamiento -->
        @if($paso == 2)
            <h3 class="text-xl font-semibold mb-4">Selecciona un tratamiento</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($tratamientos as $tratamiento)
                    <div class="border rounded-lg p-4 cursor-pointer hover:bg-gray-50"
                         wire:click="seleccionarTratamiento({{ $tratamiento->id }})">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="font-bold">{{ $tratamiento->nombre }}</h4>
                                <p class="text-sm text-gray-600">{{ $tratamiento->descripcion }}</p>
                            </div>
                            <span class="font-bold">{{ $tratamiento->precio }}€</span>
                        </div>
                        <div class="mt-2 text-xs text-gray-500">
                            <i class="far fa-clock mr-1"></i> Duración: {{ $tratamiento->duracion }} min
                        </div>
                    </div>
                @endforeach
            </div>
            <button class="mt-6 px-4 py-2 bg-gray-200 rounded-lg" wire:click="paso = 1">
                <i class="fas fa-arrow-left mr-2"></i> Volver
            </button>
        @endif

        @if($paso == 3)
            <h3 class="text-xl font-semibold mb-4">Selecciona una fecha</h3>
            <livewire:demos.barberia.calendar-selector
                wire:key="calendar-{{ now()->timestamp }}" />

            <div class="flex justify-between mt-6">
                <button class="px-4 py-2 bg-gray-200 rounded-lg" wire:click="paso = 2">
                    <i class="fas fa-arrow-left mr-2"></i> Volver
                </button>
            </div>
        @endif

        <!-- Paso 4: Seleccionar hora -->
        @if($paso == 4)
            <h3 class="text-xl font-semibold mb-4">Selecciona una hora</h3>
            <div class="grid grid-cols-3 gap-3">
                @foreach($horasDisponibles as $hora)
                    <button class="py-2 px-4 border rounded-lg hover:bg-blue-50 focus:bg-blue-100 focus:border-blue-500"
                            wire:click="seleccionarHora('{{ $hora }}')">
                        {{ $hora }}
                    </button>
                @endforeach
            </div>
            <div class="flex justify-between mt-6">
                <button class="px-4 py-2 bg-gray-200 rounded-lg" wire:click="paso = 3">
                    <i class="fas fa-arrow-left mr-2"></i> Volver
                </button>
            </div>
        @endif

        <!-- Paso 5: Datos del cliente -->
        @if($paso == 5)
            <h3 class="text-xl font-semibold mb-4">Tus datos</h3>
            <form wire:submit.prevent="confirmarCita">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 mb-2">Nombre completo</label>
                        <input type="text" wire:model="nombreCliente" class="w-full px-4 py-2 border rounded-lg">
                        @error('nombreCliente') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-2">Teléfono</label>
                        <input type="tel" wire:model="telefonoCliente" class="w-full px-4 py-2 border rounded-lg">
                        @error('telefonoCliente') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Email</label>
                    <input type="email" wire:model="emailCliente" class="w-full px-4 py-2 border rounded-lg">
                    @error('emailCliente') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 mb-2">Notas adicionales</label>
                    <textarea wire:model="notas" class="w-full px-4 py-2 border rounded-lg" rows="3"></textarea>
                </div>
                <div class="flex justify-between">
                    <button type="button" class="px-4 py-2 bg-gray-200 rounded-lg" wire:click="paso = 4">
                        <i class="fas fa-arrow-left mr-2"></i> Volver
                    </button>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Confirmar cita
                    </button>
                </div>
            </form>
        @endif

        <!-- Paso 6: Confirmación -->
        @if($paso == 6)
            <div class="text-center py-8">
                <div class="w-16 h-16 mx-auto bg-green-100 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-check text-green-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold mb-2">¡Cita reservada con éxito!</h3>
                <p class="text-gray-600 mb-6">Hemos enviado los detalles a tu correo electrónico.</p>
                <div class="max-w-md mx-auto bg-gray-50 rounded-lg p-4 text-left">
                    <h4 class="font-semibold mb-2">Detalles de la cita:</h4>
                    <p><span class="font-medium">Peluquero:</span> {{ $peluqueros->find($peluqueroSeleccionado)->nombre }}</p>
                    <p><span class="font-medium">Tratamiento:</span> {{ $tratamientos->find($tratamientoSeleccionado)->nombre }}</p>
                    <p><span class="font-medium">Fecha:</span> {{ $fechaSeleccionada }} a las {{ $horaSeleccionada }}</p>
                </div>
                <button class="mt-6 px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700"
                        wire:click="$dispatch('citaCreada')">
                    Finalizar
                </button>
            </div>
        @endif
    </div>
</div>
