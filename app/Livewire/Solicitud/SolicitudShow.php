<?php

namespace App\Livewire\Solicitud;

use App\Events\SolicitudEstadoActualizado;
use App\Models\SolicitudServicio;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class SolicitudShow extends Component
{
    public $solicitud;
    public $estadosDisponibles = [
        'pendiente' => 'Pendiente',
        'aprobada' => 'Aprobada',
        'en_proceso' => 'En Proceso',
        'completada' => 'Completada',
        'cancelada' => 'Cancelada'
    ];
    public $nuevoEstado;
    public $comentario;
    public $mostrarFormularioEdicion = false;

    public function mount(SolicitudServicio $solicitud)
    {
        $this->solicitud = $solicitud->load(['cliente', 'usuario', 'items.servicio']);
        $this->nuevoEstado = $this->solicitud->estado;
    }

    public function cambiarEstado()
    {
        $this->validate([
            'nuevoEstado' => 'required|in:' . implode(',', array_keys($this->estadosDisponibles)),
            'comentario' => 'nullable|string|max:500'
        ]);
        DB::transaction(function () {
            $this->solicitud->update(['estado' => $this->nuevoEstado]);
            if ($this->comentario) {
                $this->solicitud->notas .= "\n\n[" . now()->format('d/m/Y H:i') . "] " . $this->comentario;
                $this->solicitud->save();
                event(new SolicitudEstadoActualizado($this->solicitud, $this->comentario));
            }
            session()->flash('message', 'Estado actualizado correctamente');
            $this->dispatch('estadoActualizado');
        });
    }

    public function toggleEdicion()
    {
        $this->mostrarFormularioEdicion = !$this->mostrarFormularioEdicion;
    }

    public function render()
    {
        return view('livewire.solicitud.solicitud-show')->layout('layouts.app');
    }
}
