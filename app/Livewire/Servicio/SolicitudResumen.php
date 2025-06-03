<?php

namespace App\Livewire\Servicio;

use App\Models\SolicitudServicio;
use Livewire\Component;

class SolicitudResumen extends Component
{
    public $solicitud;

    protected $listeners = ['solicitudUpdated' => 'loadSolicitud'];

    public function mount()
    {
        $this->loadSolicitud();
    }

    public function loadSolicitud()
    {
        if (auth()->check()) {
            $this->solicitud = SolicitudServicio::with('items.servicio')
                ->where('user_id', auth()->id())
                ->where('estado', 'pendiente')
                ->first();
        }
    }

    public function removeItem($itemId)
    {
        $item = $this->solicitud->items()->find($itemId);
        if ($item) {
            $item->delete();
            $this->solicitud->refresh();
            $this->solicitud->update(['total' => $this->solicitud->calcularTotal()]);
        }
    }

    public function render()
    {
        return view('livewire.servicio.solicitud-resumen')->layout('layouts.app');
    }
}
