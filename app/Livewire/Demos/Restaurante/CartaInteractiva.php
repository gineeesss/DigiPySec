<?php

namespace App\Livewire\Demos\Restaurante;

use Livewire\Component;
use App\Models\Plato;

class CartaInteractiva extends Component
{
    public $platos;
    public $carrito = [];
    public $personas = 1;

    public function mount()
    {
        $this->platos = Plato::with('categoria')->get();
    }

    public function agregarAlCarrito($platoId, $tipo)
    {
        $plato = Plato::find($platoId);
        $precio = $tipo === 'tapa' ? $plato->precio_tapa : $plato->precio_racion;

        $this->carrito[] = [
            'nombre' => $plato->nombre,
            'tipo' => $tipo,
            'precio' => $precio,
        ];
    }

    public function render()
    {
        $total = array_sum(array_column($this->carrito, 'precio'));
        $porPersona = $this->personas > 0 ? $total / $this->personas : 0;

        return view('livewire.demos.restaurante.carta-interactiva', [
            'total' => $total,
            'porPersona' => $porPersona,
        ]);
    }
}
