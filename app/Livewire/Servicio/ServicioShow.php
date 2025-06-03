<?php

namespace App\Livewire\Servicio;

use App\Livewire\Carrito;
use App\Models\Servicio;
use Livewire\Component;

class ServicioShow extends Component
{
    public $servicio;
    public $categoria;
    public $serviciosRelacionados;
    public $cantidad = 1;

    public function mount2($servicio)
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
    }
    public function mount($servicio)
    {
        $this->servicio = Servicio::where('slug', $servicio)
            ->where('activo', true)
            ->firstOrFail();
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
    //CURIOSO
    public function agregarAlCarrito()
    {
        $this->dispatch('agregarAlCarrito', $this->servicio->id)
            ->to(Carrito::class);

        $this->dispatch('notify', 'Servicio agregado al carrito');
    }

    public function render()
    {
        return view('livewire.servicio.show')->layout('layouts.app');
    }
}
