<?php

namespace App\Livewire\Solicitud;

use App\Models\SolicitudServicio;
use Livewire\Component;

// app/Http/Livewire/Solicitud/SolicitudList.php
class SolicitudList extends Component
{
    public $search = '';
    public $estado = '';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    public $perPage = 10;

    protected $queryString = [
        'search' => ['except' => ''],
        'estado' => ['except' => ''],
        'sortBy' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
        'perPage' => ['except' => 10]
    ];

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortBy = $field;
    }

    public function render()
    {
        $solicitudes = SolicitudServicio::query()
            ->with(['cliente', 'usuario'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->whereHas('cliente', function ($q) {
                        $q->where('nombre', 'like', '%'.$this->search.'%')
                            ->orWhere('email', 'like', '%'.$this->search.'%')
                            ->orWhere('telefono', 'like', '%'.$this->search.'%');
                    })
                        ->orWhere('id', 'like', '%'.$this->search.'%');
                });
            })
            ->when($this->estado, function ($query) {
                $query->where('estado', $this->estado);
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.solicitud.solicitud-list', [
            'solicitudes' => $solicitudes,
            'estados' => [
                '' => 'Todos',
                'pendiente' => 'Pendiente',
                'aprobada' => 'Aprobada',
                'en_proceso' => 'En Proceso',
                'completada' => 'Completada',
                'cancelada' => 'Cancelada'
            ]
        ])->layout('layouts.app');
    }
}
