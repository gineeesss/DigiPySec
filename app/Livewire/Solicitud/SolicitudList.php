<?php

namespace App\Livewire\Solicitud;

use App\Models\SolicitudServicio;
use Livewire\Component;
use Livewire\WithPagination;

class SolicitudList extends Component
{
    use WithPagination;

    public $search = '';
    public $estado = '';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    public $perPage = 10;
    public $isAdminView = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'estado' => ['except' => ''],
        'sortBy' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
        'perPage' => ['except' => 10]
    ];

    public function mount()
    {
        // Determinar si es vista de admin o cliente
        $this->isAdminView = auth()->user()->can('manage-solicitudes');
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortBy = $field;
    }

    public function cambiarEstadoRapido($solicitudId, $nuevoEstado)
    {
        if (!auth()->user()->can('manage-solicitudes')) {
            abort(403);
        }

        $solicitud = SolicitudServicio::findOrFail($solicitudId);
        $solicitud->update(['estado' => $nuevoEstado]);

        session()->flash('message', 'Estado actualizado correctamente');
    }

    public function render()
    {
        $query = SolicitudServicio::query()
            ->with(['cliente', 'usuario'])
            ->when(!$this->isAdminView, function($query) {
                // Filtro para cliente: solo sus propias solicitudes
                $query->where('cliente_id', auth()->user()->client->id);
            })
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->whereHas('cliente.user', function ($q) {
                        $q->where('name', 'like', '%'.$this->search.'%')
                            ->orWhere('email', 'like', '%'.$this->search.'%');
                    })
                        ->orWhere('id', 'like', '%'.$this->search.'%');
                });
            })
            ->when($this->estado, function ($query) {
                $query->where('estado', $this->estado);
            })
            ->orderBy($this->sortBy, $this->sortDirection);

        $solicitudes = $query->paginate($this->perPage);

        return view('livewire.solicitud.solicitud-list', [
            'solicitudes' => $solicitudes,
            'estados' => $this->getEstadosDisponibles(),
            'isAdminView' => $this->isAdminView
        ])->layout('layouts.app');
    }

    protected function getEstadosDisponibles()
    {
        $baseEstados = [
            'pendiente' => 'Pendiente',
            'aprobada' => 'Aprobada',
            'en_proceso' => 'En Proceso',
            'completada' => 'Completada',
            'cancelada' => 'Cancelada'
        ];

        if ($this->isAdminView) {
            return ['' => 'Todos'] + $baseEstados;
        }

        // Para clientes, mostrar solo estados relevantes
        return ['' => 'Todos'] + array_filter($baseEstados, function($key) {
                return in_array($key, ['pendiente', 'aprobada', 'en_proceso', 'completada']);
            }, ARRAY_FILTER_USE_KEY);
    }
}
