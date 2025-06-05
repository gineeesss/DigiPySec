<?php

// app/Livewire/Demos/Barberia/Reservar.php
namespace App\Livewire\Demos\Barberia;

use App\Models\HorarioDisponible;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\Peluquero;
use App\Models\Tratamiento;
use App\Models\Cita;
use Carbon\Carbon;
use Mail;

class Reservar extends Component
{
    public $paso = 1;
    public $peluqueros;
    public $tratamientos;
    public $peluqueroSeleccionado;
    public $tratamientoSeleccionado;
    public $fechaSeleccionada;
    public $horasDisponibles = [];
    public $horaSeleccionada;
    public $nombreCliente;
    public $telefonoCliente;
    public $emailCliente;
    public $notas;

    #[On('date-selected')]
    public function handleDateSelected($date)
    {
        $this->fechaSeleccionada = $date;
        $this->cargarHorasDisponibles();
        $this->paso = 4;
    }

    public function mount()
    {
        $this->peluqueros = Peluquero::where('activo', true)->get();
        $this->tratamientos = Tratamiento::all();
        $this->dispatch('initCalendar');
    }

    public function seleccionarPeluquero($peluqueroId)
    {
        $this->peluqueroSeleccionado = $peluqueroId;
        $this->paso = 2;
    }

    public function seleccionarTratamiento($tratamientoId)
    {
        $this->tratamientoSeleccionado = $tratamientoId;
        $this->paso = 3;
    }

    public function seleccionarFecha($fecha)
    {
        $this->fechaSeleccionada = $fecha;
        $this->cargarHorasDisponibles();
        $this->paso = 4;
    }

    protected function cargarHorasDisponibles()
    {
        if (!$this->peluqueroSeleccionado || !$this->fechaSeleccionada) {
            return;
        }

        $fecha = Carbon::parse($this->fechaSeleccionada);
        $diaSemana = $fecha->dayOfWeekIso; // 1 (Lunes) - 7 (Domingo)

        $horarios = HorarioDisponible::where('peluquero_id', $this->peluqueroSeleccionado)
            ->where('dia_semana', $diaSemana)
            ->where('activo', true)
            ->get();

        $citas = Cita::where('peluquero_id', $this->peluqueroSeleccionado)
            ->whereDate('fecha', $this->fechaSeleccionada)
            ->get();

        $this->horasDisponibles = [];

        foreach ($horarios as $horario) {
            $horaInicio = Carbon::parse($horario->hora_inicio);
            $horaFin = Carbon::parse($horario->hora_fin);
            $duracionTratamiento = Tratamiento::find($this->tratamientoSeleccionado)->duracion;

            while ($horaInicio->addMinutes($duracionTratamiento) <= $horaFin) {
                $horaFormato = $horaInicio->format('H:i');

                $ocupado = $citas->contains(function ($cita) use ($horaFormato) {
                    return $cita->hora_inicio <= $horaFormato && $cita->hora_fin > $horaFormato;
                });

                if (!$ocupado) {
                    $this->horasDisponibles[] = $horaFormato;
                }
            }
        }
    }

    public function seleccionarHora($hora)
    {
        $this->horaSeleccionada = $hora;
        $this->paso = 5;
    }

    public function confirmarCita()
    {
        $this->validate([
            'nombreCliente' => 'required',
            'telefonoCliente' => 'required',
            'emailCliente' => 'required|email',
        ]);


        $cita = Cita::create([
            'peluquero_id' => $this->peluqueroSeleccionado,
            'fecha' => $this->fechaSeleccionada,
            'hora_inicio' => $this->horaSeleccionada,
            'hora_fin' => Carbon::parse($this->horaSeleccionada)->addMinutes($this->tratamientos->find($this->tratamientoSeleccionado)->duracion),
            'estado' => 'pendiente',
            'notas' => $this->notas,
            'nombre_cliente' => $this->nombreCliente,
            'email_cliente' => $this->emailCliente,
            'telefono_cliente' => $this->telefonoCliente,
        ]);

        $cita->tratamientos()->attach($this->tratamientoSeleccionado);

        $this->enviarEmailConfirmacion($cita);

        $this->paso = 6; // Paso de confirmación
    }
    protected function enviarEmailConfirmacion($cita)
    {
        $peluquero = Peluquero::find($this->peluqueroSeleccionado);
        $tratamiento = Tratamiento::find($this->tratamientoSeleccionado);

        $detalles = [
            'peluquero' => $peluquero->nombre,
            'fecha' => Carbon::parse($this->fechaSeleccionada)->translatedFormat('l, d \d\e F \d\e Y'),
            'hora' => $this->horaSeleccionada,
            'tratamiento' => $tratamiento->nombre,
            'duracion' => $tratamiento->duracion,
            'precio' => $tratamiento->precio,
            'nombreCliente' => $this->nombreCliente,
        ];

        Mail::to($this->emailCliente)
            ->send(new \App\Mail\ConfirmacionCita($detalles));
    }
    public function onDateSelected($date)
    {
        $this->seleccionarFecha($date['date']);
    }

    public function render()
    {
        return view('livewire.demos.barberia.reservar')
            ->layout('layouts.demo-barberia');
    }
}
