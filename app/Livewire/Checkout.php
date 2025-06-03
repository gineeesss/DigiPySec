<?php

namespace App\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use App\Models\SolicitudServicio;
use App\Models\SolicitudServicioItem;
use Illuminate\Support\Facades\Auth;

class Checkout extends Component
{
    public $carrito = [];
    public $notas;

    protected $rules = [
        'notas' => 'nullable|string|max:1000',
    ];

    public function mount()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $this->carrito = session()->get('carrito', []);

        if (empty($this->carrito)) {
            return redirect()->route('servicios.index');
        }
    }

    public function submit()
    {
        $this->validate();

        DB::transaction(function () {
            // Crear la solicitud
            $solicitud = SolicitudServicio::create([
                'cliente_id' => Auth::user()->client->id,
                'user_id' => Auth::id(),
                'estado' => 'pendiente',
                'total' => $this->calcularTotal(),
                'notas' => $this->notas,
            ]);

            // Agregar los items
            foreach ($this->carrito as $item) {
                $solicitud->items()->create([
                    'servicio_id' => $item['id'],
                    'cantidad' => 1, // Siempre 1 por tu requerimiento
                    'precio_unitario' => $item['precio'],
                    'opciones_personalizacion' => null, // Puedes modificar esto si necesitas personalización
                ]);
            }

            // Limpiar el carrito
            session()->forget('carrito');
            $this->dispatch('actualizarContadorCarrito');
        });

        session()->flash('success', 'Tu solicitud ha sido creada exitosamente');
        return redirect()->route('mis-solicitudes');
    }

    public function calcularTotal()
    {
        return array_reduce($this->carrito, function($total, $item) {
            return $total + $item['precio'];
        }, 0);
    }

    public function render()
    {
        return view('livewire.checkout')->layout('layouts.app');
    }
}
