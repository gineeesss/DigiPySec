<?php

namespace App\Livewire;

use Livewire\Component;

class AgregarAlCarrito extends Component
{
    public $servicio;
    public $cantidad = 1;

    public function agregar()
    {
        $this->dispatch('agregarAlCarrito', $this->servicio->id);
        $this->dispatch('notify', 'Servicio agregado al carrito');
        $this->cantidad = 1;
    }

    public function render()
    {
        return view('livewire.agregar-al-carrito');
    }
}
