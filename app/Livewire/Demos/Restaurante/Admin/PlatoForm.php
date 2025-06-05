<?php

namespace App\Livewire\Demos\Restaurante\Admin;

use App\Models\Plato;
use Livewire\Component;

class PlatoForm extends Component
{
    public function render()
    {
        return view('livewire.demos.restaurante.admin.plato-form')->layout('layouts.demo-restaurante');
    }
    public $platoId;
    public $nombre, $descripcion, $precio, $categoria_plato_id;

    public function mount($id = null)
    {
        if ($id) {
            $plato = Plato::findOrFail($id);
            $this->platoId = $id;
            $this->nombre = $plato->nombre;
            $this->descripcion = $plato->descripcion;
            $this->precio = $plato->precio;
            $this->categoria_plato_id = $plato->categoria_plato_id;
        }
    }

    public function guardar()
    {
        $this->validate([
            'nombre' => 'required',
            'precio' => 'required|numeric',
            'categoria_plato_id' => 'required|exists:categoria_platos,id',
        ]);

        Plato::updateOrCreate(
            ['id' => $this->platoId],
            [
                'nombre' => $this->nombre,
                'descripcion' => $this->descripcion,
                'precio' => $this->precio,
                'categoria_plato_id' => $this->categoria_plato_id,
            ]
        );

        session()->flash('message', 'Plato guardado correctamente.');

        return redirect()->route('restaurante.admin');
    }

}
