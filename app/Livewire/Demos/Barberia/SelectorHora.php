<?php

namespace App\Livewire\Demos\Barberia;

use Livewire\Component;

class SelectorHora extends Component
{
    // Horas fijas de ejemplo; puedes adaptarlas o cargarlas desde otro lugar
    public $horasDisponibles = [
        '10:00', '10:30', '11:00', '11:30',
        '12:00', '12:30', '16:00', '16:30',
        '17:00', '17:30', '18:00', '18:30',
        '19:00'
    ];

    // Flag interno para saber si debe mostrarse el bloque de horas
    public $mostrar = false;

    // Almacenamos la fecha seleccionada para poder validar disponibilidad real si
    // en el futuro lo necesitas (por ahora solo sirve de trigger visual)
    public $fechaSeleccionada = null;

    // Listener para el evento que emite el calendario
    protected $listeners = ['fechaSeleccionada' => 'mostrarHoras'];

    public function mostrarHoras($fecha)
    {
        $this->fechaSeleccionada = $fecha;
        $this->mostrar = true;
    }

    public function render()
    {
        return view('livewire.demos.barberia.selector-hora')
            ->layout('layouts.demo-barberia');
    }
}
