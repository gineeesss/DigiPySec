<?php

namespace App\Livewire\Solicitud;

use App\Models\SolicitudServicio;
use App\Models\Client;
use App\Models\Servicio;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

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
        'cliente_id' => 'required|exists:clients,id',
        'servicios' => 'required|array|min:1',
        'notas' => 'nullable|string|max:1000',
    ];

    public function mount()
    {
        $this->clientes = Client::all();
        $this->serviciosDisponibles = Servicio::where('activo', true)->get();
    }

    public function agregarServicio()
    {
        $this->validate([
            'servicioSeleccionado' => 'required|exists:servicios,id',
            'cantidad' => 'required|integer|min:1'
        ]);

        $servicio = Servicio::findOrFail($this->servicioSeleccionado);

        $this->servicios[] = [
            'servicio_id' => $servicio->id,
            'nombre' => $servicio->nombre,
            'cantidad' => $this->cantidad,
            'precio_unitario' => $servicio->precio_base,
            'opciones' => $servicio->es_personalizable ? $this->opcionesPersonalizacion : null,
            'notas' => null
        ];

        $this->reset(['servicioSeleccionado', 'cantidad', 'opcionesPersonalizacion']);

        // Emitir evento para actualizar la UI si es necesario
        $this->dispatch('servicioAgregado');
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
            return redirect()->route('admin.solicitudes.show', $solicitud->id);
        });
    }

    public function render()
    {
        return view('livewire.solicitud.create-solicitud')->layout('layouts.app');
    }
}
