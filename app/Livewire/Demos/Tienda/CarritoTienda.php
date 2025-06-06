<?php

namespace App\Livewire\Demos\Tienda;

use App\Models\ProductoTienda;
use Livewire\Component;

class CarritoTienda extends Component
{
    public $carrito = [];
    public $total = 0;

    protected $listeners = ['productoAñadido' => 'actualizarCarrito'];

    public function mount()
    {
        // Inicializar con datos de sesión o carrito vacío
        $this->carrito = session()->get('carrito', []);
        $this->calcularTotal();
    }

    public function irACheckout()
    {
        if (count($this->carrito) > 0) {
            return redirect()->route('tienda.checkout');
        }
    }
    public function actualizarCarrito($productoId)
    {
        $producto = ProductoTienda::find($productoId);

        if (isset($this->carrito[$productoId])) {
            $this->carrito[$productoId]['cantidad']++;
        } else {
            $this->carrito[$productoId] = [
                'producto' => $producto,
                'cantidad' => 1,
                'precio' => $producto->precio
            ];
        }

        session()->put('carrito', $this->carrito);
        $this->calcularTotal();
    }

    private function calcularTotal()
    {
        $this->total = array_reduce($this->carrito, function($carry, $item) {
            return $carry + ($item['precio'] * $item['cantidad']);
        }, 0);
    }

    public function render()
    {
        return view('livewire.demos.tienda.carrito-tienda')
            ->layout('layouts.demo-tienda');
    }
}
