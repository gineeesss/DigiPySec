<!-- resources/views/livewire/demos/barberia/admin/panel.blade.php -->
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Panel de Administración</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <a href="{{ route('barberia.admin.peluqueros') }}"
               class="bg-blue-50 border border-blue-200 rounded-lg p-5 hover:bg-blue-100 transition-colors">
                <div class="flex items-center">
                    <div class="bg-blue-100 p-3 rounded-full mr-4">
                        <i class="fas fa-user-tie text-blue-600"></i>
                    </div>
                    <div>
                        <h2 class="font-semibold text-lg text-gray-800">Peluqueros</h2>
                        <p class="text-sm text-gray-600">Gestiona los profesionales</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('barberia.admin.citas') }}"
               class="bg-green-50 border border-green-200 rounded-lg p-5 hover:bg-green-100 transition-colors">
                <div class="flex items-center">
                    <div class="bg-green-100 p-3 rounded-full mr-4">
                        <i class="fas fa-calendar-check text-green-600"></i>
                    </div>
                    <div>
                        <h2 class="font-semibold text-lg text-gray-800">Citas</h2>
                        <p class="text-sm text-gray-600">Administra las reservas</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('barberia.admin.horarios') }}"
               class="bg-yellow-50 border border-yellow-200 rounded-lg p-5 hover:bg-yellow-100 transition-colors">
                <div class="flex items-center">
                    <div class="bg-yellow-100 p-3 rounded-full mr-4">
                        <i class="fas fa-clock text-yellow-600"></i>
                    </div>
                    <div>
                        <h2 class="font-semibold text-lg text-gray-800">Horarios</h2>
                        <p class="text-sm text-gray-600">Configura disponibilidad</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Resumen rápido -->
        <div class="bg-gray-50 rounded-lg p-6">
            <h2 class="font-semibold text-lg mb-4">Resumen</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white p-4 rounded-lg shadow-sm">
                    <p class="text-gray-500 text-sm">Peluqueros activos</p>
                    <p class="text-2xl font-bold">{{ \App\Models\Peluquero::where('activo', true)->count() }}</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-sm">
                    <p class="text-gray-500 text-sm">Citas hoy</p>
                    <p class="text-2xl font-bold">{{ \App\Models\Cita::whereDate('fecha', today())->count() }}</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-sm">
                    <p class="text-gray-500 text-sm">Citas pendientes</p>
                    <p class="text-2xl font-bold">{{ \App\Models\Cita::where('estado', 'pendiente')->count() }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
