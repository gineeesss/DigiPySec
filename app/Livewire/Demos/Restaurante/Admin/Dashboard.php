<?php

namespace App\Livewire\Demos\Restaurante\Admin;

use App\Models\Plato;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.demos.restaurante.admin.dashboard')->layout('layouts.demo-restaurante');
    }
    public $platos;

    public function mount()
    {
        $this->platos = Plato::with('categoria')->get();
    }
}
