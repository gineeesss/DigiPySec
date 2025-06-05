<?php

namespace App\Livewire\Demos\Restaurante;

use App\Models\CategoriaPlato;
use Livewire\Component;

class Carta extends Component
{
    public function render()
    {
        return view('livewire.demos.restaurante.carta')->layout('layouts.demo-restaurante');
    }
    public $categorias;

    public function mount()
    {
        $this->categorias = CategoriaPlato::with('platos')->get();
    }

}
