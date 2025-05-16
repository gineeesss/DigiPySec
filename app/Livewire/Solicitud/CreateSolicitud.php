<?php

namespace App\Livewire\Solicitud;

use App\Models\SolicitudServicio;
use Livewire\Component;

// app/Http/Livewire/Solicitud/CreateSolicitud.php
class CreateSolicitud extends Component
{
    public $cliente_id;
    public $servicios = [];
    public $notas;
    public $clientes;
    public $serviciosDisponibles;
    public $servicioSeleccionado;
    public $cantidad = 1;
    public $opcionesPersonalizacion = [];

    protected $rules = [
        'cliente_id' => 'required|exists:clientes,id',
        'servicios' => 'required|array|min:1',
        'notas' => 'nullable|string|max:1000',
    ];

    public function mount()
    {
        $this->clientes = Cliente::all();
        $this->serviciosDisponibles = Servicio::where('activo', true)->get();
    }

    public function agregarServicio()
    {
        $servicio = Servicio::find($this->servicioSeleccionado);

        $this->servicios[] = [
            'servicio_id' => $servicio->id,
            'nombre' => $servicio->nombre,
            'cantidad' => $this->cantidad,
            'precio_unitario' => $servicio->precio_base,
            'opciones' => $servicio->es_personalizable ? $this->opcionesPersonalizacion : null,
            'notas' => null
        ];

        $this->reset(['servicioSeleccionado', 'cantidad', 'opcionesPersonalizacion']);
    }

    public function removerServicio($index)
    {
        unset($this->servicios[$index]);
        $this->servicios = array_values($this->servicios);
    }

    public function guardarSolicitud()
    {
        $this->validate();

        DB::transaction(function () {
            $solicitud = SolicitudServicio::create([
                'cliente_id' => $this->cliente_id,
                'user_id' => auth()->id(),
                'estado' => 'pendiente',
                'total' => collect($this->servicios)->sum(function ($item) {
                    return $item['precio_unitario'] * $item['cantidad'];
                }),
                'notas' => $this->notas
            ]);

            foreach ($this->servicios as $servicio) {
                $solicitud->items()->create([
                    'servicio_id' => $servicio['servicio_id'],
                    'cantidad' => $servicio['cantidad'],
                    'precio_unitario' => $servicio['precio_unitario'],
                    'opciones_personalizacion' => $servicio['opciones'],
                    'notas' => $servicio['notas'] ?? null
                ]);
            }

            session()->flash('message', 'Solicitud creada exitosamente');
            return redirect()->route('solicitudes.show', $solicitud->id);
        });
    }

    public function render()
    {
        return view('livewire.solicitud.create-solicitud')->layout('layouts.app');
    }
}
