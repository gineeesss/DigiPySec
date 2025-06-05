<?php

namespace App\Livewire\Demos\Barberia;

use App\Models\Peluquero;
use Livewire\Component;

class SelectorBarbero extends Component
{
    // Lista de barberos que pasaremos a la vista
    public $barberos;

    // Flag para mostrar u ocultar el bloque de selección de barbero
    public $mostrar = false;

    // La hora seleccionada (puede venir desde el listener)
    public $horaSeleccionada;

    // Listener para el evento que emite SelectorHora
    protected $listeners = [
        'horaSeleccionada' => 'mostrarBarberos'
    ];

    public function mount()
    {
        // Cargamos todos los barberos desde la base de datos
        $this->barberos = Peluquero::all();
    }

    public function mostrarBarberos($hora)
    {
        $this->horaSeleccionada = $hora;
        $this->mostrar = true;
    }

    public function render()
    {
        return view('livewire.demos.barberia.selector-barbero')
            ->layout('layouts.demo-barberia');
    }
}
