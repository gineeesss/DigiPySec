<?php

namespace App\Livewire\Solicitud;

use App\Models\SolicitudServicio;
use Livewire\Component;

// app/Http/Livewire/Solicitud/SolicitudShow.php
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

    public function mount($id)
    {
        $this->solicitud = SolicitudServicio::with(['cliente', 'usuario', 'items.servicio'])->findOrFail($id);
        $this->nuevoEstado = $this->solicitud->estado;
    }

    public function cambiarEstado()
    {
        $this->validate([
            'nuevoEstado' => 'required|in:' . implode(',', array_keys($this->estadosDisponibles)),
            'comentario' => 'nullable|string|max:500'
        ]);

        DB::transaction(function () {
            $this->solicitud->actualizarEstado($this->nuevoEstado);

            if ($this->comentario) {
                $this->solicitud->notas .= "\n\n[" . now()->format('d/m/Y H:i') . "] " . $this->comentario;
                $this->solicitud->save();
            }

            session()->flash('message', 'Estado actualizado correctamente');
        });
    }

    public function render()
    {
        return view('livewire.solicitud.solicitud-show')->layout('layouts.app');
    }
}
