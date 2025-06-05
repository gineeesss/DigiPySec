<?php

namespace App\Livewire\Demos\Barberia;

use Livewire\Component;
use App\Models\HorarioDisponible;
use App\Models\Peluquero;
use App\Models\Cita;
use App\Models\Tratamiento;
use Illuminate\Support\Facades\Mail;

class CitaForm extends Component
{
    public $email;
    public $nombre;
    public $fecha;        // se cargará desde $listeners
    public $hora;         // se cargará desde $listeners
    public $barbero_id;   // se cargará desde $listeners
    public $tratamiento_id;
    public $mostrar = false;

    protected $listeners = [
        'barberoSeleccionado' => 'mostrarFormulario',
        'fechaSeleccionada'   => 'asignarFecha',   // asignamos fecha antes de mostrar
        'horaSeleccionada'    => 'asignarHora',    // asignamos hora antes de mostrar
    ];

    public function asignarFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    public function asignarHora($hora)
    {
        $this->hora = $hora;
    }

    public function mostrarFormulario($barberoId)
    {
        $this->barbero_id = $barberoId;
        $this->mostrar = true;
    }

    public function crearCita()
    {
        $this->validate([
            'nombre'         => 'required|string',
            'email'          => 'required|email',
            'fecha'          => 'required|date',
            'hora'           => 'required',
            'barbero_id'     => 'nullable|exists:peluqueros,id',
            'tratamiento_id' => 'required|exists:tratamientos,id',
        ]);

        // Marca la hora como reservada en HorarioDisponible (opcional)
        // HorarioDisponible::where('fecha', $this->fecha)->where('hora', $this->hora)
        //     ->update(['reservado' => true]);

        Cita::create([
            'nombre'         => $this->nombre,
            'email'          => $this->email,
            'fecha'          => $this->fecha,
            'hora'           => $this->hora,
            'peluquero_id'   => $this->barbero_id,
            'tratamiento_id' => $this->tratamiento_id,
        ]);

        // Enviar correo de confirmación
        Mail::raw(
            "Hola {$this->nombre},\n\nTu cita ha sido reservada:\n\n" .
            "✂️ Fecha: {$this->fecha}\n" .
            "⏰ Hora: {$this->hora}\n" .
            "💈 Barbero: " . ($this->barbero_id
                ? Peluquero::find($this->barbero_id)->nombre
                : 'Cualquiera') . "\n\n" .
            "¡Te esperamos!",
            function ($msg) {
                $msg->to($this->email)
                    ->subject('Confirmación de tu cita en Barbería');
            }
        );

        session()->flash('mensajeExito', '¡Cita creada con éxito! Revisa tu correo.');
        $this->reset(['email', 'nombre', 'mostrar', 'tratamiento_id']);
    }

    public function render()
    {
        // Cargamos barberos, tratamientos o lo que necesites
        $barberos = Peluquero::all();
        $tratamientos = Tratamiento::all();

        return view('livewire.demos.barberia.cita-form', [
            'barberos'     => $barberos,
            'tratamientos' => $tratamientos,
        ])->layout('layouts.demo-barberia');
    }
}
