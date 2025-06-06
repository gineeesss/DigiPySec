<?php

namespace App\Livewire\Demos\Tienda;

use Livewire\Component;
use App\Models\PedidoTienda;
use App\Models\PedidoItemTienda;

class CheckoutTienda extends Component
{
    public $nombre;
    public $email;
    public $telefono;
    public $direccion;
    public $notas;

    protected $rules = [
        'nombre' => 'required|min:3',
        'email' => 'required|email',
        'telefono' => 'required',
        'direccion' => 'required'
    ];

    public function mount()
    {
        if (!session()->has('carrito') || count(session('carrito')) === 0) {
            return redirect()->route('tienda.index');
        }
    }

    public function realizarPedido()
    {
        $this->validate();

        // Crear pedido
        $pedido = PedidoTienda::create([
            'codigo' => 'PED-' . strtoupper(uniqid()),
            'cliente_nombre' => $this->nombre,
            'cliente_email' => $this->email,
            'cliente_telefono' => $this->telefono,
            'direccion' => $this->direccion,
            'notas' => $this->notas,
            'total' => $this->calcularTotal()
        ]);

        // Añadir items
        foreach (session('carrito') as $item) {
            PedidoItemTienda::create([
                'pedido_id' => $pedido->id,
                'producto_id' => $item['producto']->id,
                'cantidad' => $item['cantidad'],
                'precio_unitario' => $item['producto']->precio
            ]);
        }

        // Limpiar carrito
        session()->forget('carrito');
        $this->dispatch('carritoActualizado');

        return redirect()->route('tienda.gracias', $pedido->codigo);
    }

    private function calcularTotal()
    {
        return array_reduce(session('carrito'), function($total, $item) {
            return $total + ($item['producto']->precio * $item['cantidad']);
        }, 0);
    }

    public function render()
    {
        return view('livewire.demos.tienda.checkout-tienda', [
            'carrito' => session('carrito', []),
            'total' => $this->calcularTotal()
        ])->layout('layouts.demo-tienda');
    }
}
