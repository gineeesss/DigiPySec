<?php

namespace App\Livewire\Catalogo;

use App\Models\Servicio;
use Livewire\Component;

// app/Http/Livewire/Catalogo/ServicioShow.php
class ServicioShow extends Component
{
    public $servicio;
    public $categoria;
    public $serviciosRelacionados;
    public $cantidad = 1;
    public $opcionesPersonalizacion = [];

    public function mount($servicio)
    {
        $this->servicio = Servicio::with(['categoria', 'incluyes', 'imagenes'])
            ->where('slug', $servicio)
            ->where('activo', true)
            ->firstOrFail();

        $this->categoria = $this->servicio->categoria;

        $this->serviciosRelacionados = Servicio::where('categoria_servicio_id', $this->categoria->id)
            ->where('id', '!=', $this->servicio->id)
            ->where('activo', true)
            ->inRandomOrder()
            ->limit(3)
            ->get();

        if ($this->servicio->es_personalizable) {
            $this->opcionesPersonalizacion = [
                'tipo' => '',
                'caracteristicas_extra' => []
            ];
        }
    }

    public function increment()
    {
        $this->cantidad++;
    }

    public function decrement()
    {
        if ($this->cantidad > 1) {
            $this->cantidad--;
        }
    }

    public function addToCart()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Crear o obtener solicitud activa del usuario
        $solicitud = SolicitudServicio::firstOrCreate(
            [
                'user_id' => auth()->id(),
                'estado' => 'pendiente',
                'cliente_id' => null // El cliente puede ser asignado después
            ],
            ['total' => 0]
        );

        // Añadir el servicio a la solicitud
        $solicitud->addItem(
            $this->servicio->id,
            $this->cantidad,
            $this->servicio->es_personalizable ? $this->opcionesPersonalizacion : null
        );

        // Actualizar el total
        $solicitud->update(['total' => $solicitud->calcularTotal()]);

        session()->flash('message', 'Servicio añadido a tu solicitud');
        $this->emit('solicitudUpdated');
    }

    public function render()
    {
        return view('livewire.catalogo.servicio-show')->layout('layouts.app');
    }
}
