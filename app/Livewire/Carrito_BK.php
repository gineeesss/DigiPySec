<?php

namespace App\Livewire;

use Livewire\Component;

class Carrito_BK extends Component
{
    public $items = [];

    public function mount()
    {
        $this->items = session()->get('carrito', []);
        $this->actualizarCantidad();
    }

    public function eliminar($id)
    {
        $carrito = session()->get('carrito', []);
        unset($carrito[$id]);
        session()->put('carrito', $carrito);
        $this->items = $carrito;
    }

    public $cantidadItems = 0;


    public function actualizarCantidad()
    {
        $carrito = session()->get('carrito', []);
        $this->cantidadItems = count($carrito);
    }

// Llama a actualizarCantidad cada vez que se añada algo
    protected $listeners = ['servicioAñadido' => 'actualizarCantidad'];


    public function render()
    {
        return view('livewire.carrito.index')->layout('layouts.app');
    }
}
