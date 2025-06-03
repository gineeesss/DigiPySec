<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Servicio;
use Illuminate\Support\Facades\Auth;

class Carrito extends Component
{
    public $carrito = [];
    public $mostrarCarrito = false;

    protected $listeners = ['agregarAlCarrito' => 'agregarServicio'];

    public function mount()
    {
        $this->carrito = session()->get('carrito', []);
    }

    public function agregarServicio($servicioId)
    {
        $servicio = Servicio::findOrFail($servicioId);

        // Verificar si el servicio ya está en el carrito
        if (array_key_exists($servicio->id, $this->carrito)) {
            $this->dispatch('notify', 'Este servicio ya está en tu carrito');
            return;
        }

        $this->carrito[$servicio->id] = [
            'id' => $servicio->id,
            'nombre' => $servicio->nombre,
            'precio' => $servicio->precio_base,
            'cantidad' => 1 // Siempre 1 por tu requerimiento
        ];

        session()->put('carrito', $this->carrito);
        $this->dispatch('actualizarContadorCarrito');
        $this->dispatch('notify', 'Servicio agregado al carrito');
    }

    public function removerServicio($servicioId)
    {
        unset($this->carrito[$servicioId]);
        session()->put('carrito', $this->carrito);
        $this->dispatch('actualizarContadorCarrito');
    }

    public function toggleCarrito()
    {
        $this->mostrarCarrito = !$this->mostrarCarrito;
    }

    public function calcularTotal()
    {
        return array_reduce($this->carrito, function($total, $item) {
            return $total + ($item['precio'] * $item['cantidad']);
        }, 0);
    }

    public function render()
    {
        return view('livewire.carrito.index')->layout('layouts.app');
    }
}
