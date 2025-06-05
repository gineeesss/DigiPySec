<?php

namespace App\Livewire\Demos\Barberia\Admin;

use Livewire\Component;
use App\Models\Cita;
use App\Models\Peluquero;
use Carbon\Carbon;

class Citas extends Component
{
    public $citas;
    public $peluqueros;
    public $filtroEstado = '';
    public $filtroPeluquero = '';
    public $filtroFecha = '';

    public $editId = null;
    public $peluquero_id;
    public $fecha;
    public $hora_inicio;
    public $hora_fin;
    public $estado = 'pendiente';
    public $notas;
    public $nombre_cliente;
    public $email_cliente;
    public $telefono_cliente;

    public function mount()
    {
        $this->peluqueros = Peluquero::where('activo', true)->get();
        $this->loadCitas();
    }

    public function loadCitas()
    {
        $query = Cita::with(['peluquero', 'tratamientos'])
            ->orderBy('fecha', 'desc')
            ->orderBy('hora_inicio', 'desc');

        if ($this->filtroEstado) {
            $query->where('estado', $this->filtroEstado);
        }

        if ($this->filtroPeluquero) {
            $query->where('peluquero_id', $this->filtroPeluquero);
        }

        if ($this->filtroFecha) {
            $query->whereDate('fecha', $this->filtroFecha);
        }

        $this->citas = $query->get();
    }

    public function updatedFiltroEstado()
    {
        $this->loadCitas();
    }

    public function updatedFiltroPeluquero()
    {
        $this->loadCitas();
    }

    public function updatedFiltroFecha()
    {
        $this->loadCitas();
    }
    public function updated($property)
    {
        if (in_array($property, ['filtroEstado', 'filtroPeluquero', 'filtroFecha'])) {
            $this->loadCitas();
        }
    }


    public function save()
    {
        $this->validate([
            'peluquero_id' => 'required|exists:peluqueros,id',
            'fecha' => 'required|date',
            'hora_inicio' => 'required',
            'estado' => 'required|in:pendiente,confirmada,completada,cancelada',
            'nombre_cliente' => 'required|string|max:255',
            'email_cliente' => 'required|email|max:255',
            'telefono_cliente' => 'required|string|max:20',
            'notas' => 'nullable|string',
        ]);

        $data = [
            'peluquero_id' => $this->peluquero_id,
            'fecha' => $this->fecha,
            'hora_inicio' => $this->hora_inicio,
            'hora_fin' => $this->hora_fin ?? Carbon::parse($this->hora_inicio)->addHour(),
            'estado' => $this->estado,
            'notas' => $this->notas,
            'nombre_cliente' => $this->nombre_cliente,
            'email_cliente' => $this->email_cliente,
            'telefono_cliente' => $this->telefono_cliente,
        ];

        if ($this->editId) {
            $cita = Cita::find($this->editId);
            $cita->update($data);
        } else {
            Cita::create($data);
        }

        $this->resetForm();
        $this->loadCitas();
    }

    public function edit($id)
    {
        $cita = Cita::find($id);
        $this->editId = $id;
        $this->peluquero_id = $cita->peluquero_id;
        $this->fecha = $cita->fecha;
        $this->hora_inicio = $cita->hora_inicio;
        $this->hora_fin = $cita->hora_fin;
        $this->estado = $cita->estado;
        $this->notas = $cita->notas;
        $this->nombre_cliente = $cita->nombre_cliente;
        $this->email_cliente = $cita->email_cliente;
        $this->telefono_cliente = $cita->telefono_cliente;
    }

    public function delete($id)
    {
        Cita::find($id)->delete();
        $this->loadCitas();
    }

    public function changeStatus($id, $status)
    {
        $cita = Cita::find($id);
        $cita->update(['estado' => $status]);
        $this->loadCitas();
    }

    public function resetForm()
    {
        $this->reset([
            'editId', 'peluquero_id', 'fecha', 'hora_inicio', 'hora_fin',
            'estado', 'notas', 'nombre_cliente', 'email_cliente', 'telefono_cliente'
        ]);
    }

    public function render()
    {
        return view('livewire.demos.barberia.admin.citas')
            ->layout('layouts.demo-barberia');
    }
}
