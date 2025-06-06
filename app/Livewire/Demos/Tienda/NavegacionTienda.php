<?php

namespace App\Livewire\Demos\Tienda;

use App\Models\CategoriaTienda;
use Livewire\Component;

class NavegacionTienda extends Component
{
    public $categoriaActiva;

    public function mount($categoriaSlug = null)
    {
        $this->categoriaActiva = $categoriaSlug;
    }

    public function render()
    {
        return view('livewire.demos.tienda.navegacion-tienda', [
            'categorias' => CategoriaTienda::where('activa', true)->get()
        ]);
    }
}
