<?php

namespace App\Livewire\Solicitud;

use App\Models\SolicitudServicio;
use App\Models\Client;
use App\Models\Servicio;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class SolicitudEdit extends Component
{
    public $solicitud;
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

    public function mount(SolicitudServicio $solicitud)
    {
        $this->solicitud = $solicitud;
        $this->cliente_id = $solicitud->cliente_id;
        $this->notas = $solicitud->notas;

        $this->clientes = Client::all();
        $this->serviciosDisponibles = Servicio::where('activo', true)->get();

        // Cargar los servicios existentes
        foreach ($solicitud->items as $item) {
            $this->servicios[] = [
                'id' => $item->id,
                'servicio_id' => $item->servicio_id,
                'nombre' => $item->servicio->nombre,
                'cantidad' => $item->cantidad,
                'precio_unitario' => $item->precio_unitario,
                'opciones' => $item->opciones_personalizacion,
                'notas' => $item->notas
            ];
        }
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
    }

    public function removerServicio($index)
    {
        unset($this->servicios[$index]);
        $this->servicios = array_values($this->servicios);
    }

    public function actualizarSolicitud()
    {
        $this->validate();

        DB::transaction(function () {
            // Actualizar datos básicos de la solicitud
            $this->solicitud->update([
                'cliente_id' => $this->cliente_id,
                'total' => collect($this->servicios)->sum(function ($item) {
                    return $item['precio_unitario'] * $item['cantidad'];
                }),
                'notas' => $this->notas
            ]);

            // Eliminar items que ya no están
            $idsMantener = collect($this->servicios)->pluck('id')->filter()->toArray();
            $this->solicitud->items()->whereNotIn('id', $idsMantener)->delete();

            // Actualizar o crear items
            foreach ($this->servicios as $servicio) {
                $itemData = [
                    'servicio_id' => $servicio['servicio_id'],
                    'cantidad' => $servicio['cantidad'],
                    'precio_unitario' => $servicio['precio_unitario'],
                    'opciones_personalizacion' => $servicio['opciones'],
                    'notas' => $servicio['notas'] ?? null
                ];

                if (isset($servicio['id'])) {
                    $this->solicitud->items()->where('id', $servicio['id'])->update($itemData);
                } else {
                    $this->solicitud->items()->create($itemData);
                }
            }

            session()->flash('message', 'Solicitud actualizada exitosamente');
            return redirect()->route('admin.solicitudes.show', $this->solicitud->id);
        });
    }

    public function render()
    {
        return view('livewire.solicitud.solicitud-edit')->layout('layouts.app');
    }
}
