<?php

namespace App\Livewire\Demos;

use App\Models\Servicio;
use Livewire\Component;
use Livewire\WithPagination;

class DemosIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $sortBy = 'nombre';
    public $sortDirection = 'asc';
    public $perPage = 12;
    public $categoriaDemoId = 4; // ID de la categoría "demo"

    protected $queryString = [
        'search' => ['except' => ''],
        'sortBy' => ['except' => 'nombre'],
        'sortDirection' => ['except' => 'asc'],
        'perPage' => ['except' => 12]
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

    public function clearSearch()
    {
        $this->search = '';
        $this->resetPage();
    }

    public function render()
    {
        $servicios = Servicio::query()
            ->with('categoriaServicio')
            ->where('categoria_servicio_id', $this->categoriaDemoId)
            ->where('activo', true)
            ->when($this->search, function ($query) {
                $query->where('nombre', 'like', '%'.$this->search.'%')
                    ->orWhere('descripcion_corta', 'like', '%'.$this->search.'%');
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.demos.demos-index', [
            'servicios' => $servicios
        ])->layout('layouts.app');
    }
}
