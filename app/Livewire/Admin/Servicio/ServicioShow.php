<?php

namespace App\Livewire\Admin\Servicio;

use App\Models\Servicio;
use Livewire\Component;

class ServicioShow extends Component
{
    public Servicio $servicio;

    public function mount(Servicio $servicio)
    {
        $this->servicio = $servicio->load('categoria');
    }

    public function render()
    {
        return view('livewire.admin.servicios.show')->layout('layouts.admin');
    }
}
