<?php

namespace App\Livewire\Catalogo;

use App\Models\CategoriaServicio;
use App\Models\Servicio;
use Livewire\Component;

class ServiciosIndex extends Component
{
    public $categoriaSeleccionada = null;

    public function render()
    {
        $categorias = CategoriaServicio::with(['servicios' => function($query) {
            $query->where('activo', true);
        }])->get();

        $servicios = $this->categoriaSeleccionada
            ? Servicio::where('categoria_servicio_id', $this->categoriaSeleccionada)->where('activo', true)->get()
            : Servicio::where('activo', true)->get();

        return view('livewire.catalogo.servicios-index', compact('categorias', 'servicios'))->layout('layouts.app');
    }

    public function seleccionarCategoria($categoriaId)
    {
        $this->categoriaSeleccionada = $categoriaId;
    }
}
