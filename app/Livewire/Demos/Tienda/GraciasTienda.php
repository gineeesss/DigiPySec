<?php

namespace App\Livewire\Demos\Tienda;

use Livewire\Component;
use App\Models\PedidoTienda;

class GraciasTienda extends Component
{
    public $pedido;

    public function mount($codigo)
    {
        $this->pedido = PedidoTienda::where('codigo', $codigo)->firstOrFail();
    }

    public function render()
    {
        return view('livewire.demos.tienda.gracias-tienda')
            ->layout('layouts.demo-tienda');
    }
}
