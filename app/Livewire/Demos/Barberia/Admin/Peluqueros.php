<?php

// app/Livewire/Demos/Barberia/Admin/Peluqueros.php
namespace App\Livewire\Demos\Barberia\Admin;

use Livewire\Component;
use App\Models\Peluquero;

class Peluqueros extends Component
{
    public $peluqueros;
    public $nombre, $especialidad, $foto;
    public $editId = null;

    public function mount()
    {
        $this->peluqueros = Peluquero::all();
    }

    public function save()
    {
        $this->validate([
            'nombre' => 'required',
            'especialidad' => 'required',
        ]);

        if ($this->editId) {
            $peluquero = Peluquero::find($this->editId);
            $peluquero->update([
                'nombre' => $this->nombre,
                'especialidad' => $this->especialidad,
                'foto' => $this->foto,
            ]);
        } else {
            Peluquero::create([
                'nombre' => $this->nombre,
                'especialidad' => $this->especialidad,
                'foto' => $this->foto,
                'activo' => true,
            ]);
        }

        $this->resetForm();
        $this->peluqueros = Peluquero::all();
    }

    public function edit($id)
    {
        $peluquero = Peluquero::find($id);
        $this->editId = $id;
        $this->nombre = $peluquero->nombre;
        $this->especialidad = $peluquero->especialidad;
        $this->foto = $peluquero->foto;
    }

    public function delete($id)
    {
        Peluquero::find($id)->delete();
        $this->peluqueros = Peluquero::all();
    }

    public function toggleStatus($id)
    {
        $peluquero = Peluquero::find($id);
        $peluquero->update(['activo' => !$peluquero->activo]);
        $this->peluqueros = Peluquero::all();
    }

    public function resetForm()
    {
        $this->reset(['nombre', 'especialidad', 'foto', 'editId']);
    }

    public function render()
    {
        return view('livewire.demos.barberia.admin.peluqueros');
    }
}
