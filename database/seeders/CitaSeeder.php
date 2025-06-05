<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cita;
use App\Models\Peluquero;
use App\Models\Tratamiento;
use Carbon\Carbon;

class CitaSeeder extends Seeder
{
    public function run()
    {
        $peluqueros = Peluquero::all();
        $tratamientos = Tratamiento::all();

        // Citas pasadas
        foreach (range(1, 3) as $i) {
            $peluquero = $peluqueros->random();
            $tratamiento = $tratamientos->random();
            $fecha = Carbon::today()->subDays(rand(1, 30));

            $cita = Cita::create([
                'peluquero_id' => $peluquero->id,
                'fecha' => $fecha,
                'hora_inicio' => $this->getRandomHora(),
                'hora_fin' => $this->getRandomHora(),
                'estado' => $this->getRandomEstado(),
                'notas' => 'Nota de prueba para la cita ' . $i,
                'nombre_cliente' => $this->getRandomNombre(),
                'telefono_cliente' => $this->getRandomTelefono(),
                'email_cliente' => $this->getRandomEmail(),
            ]);

            $cita->tratamientos()->attach($tratamiento->id);
        }

        // Citas futuras
        foreach (range(1, 3) as $i) {
            $peluquero = $peluqueros->random();
            $tratamiento = $tratamientos->random();
            $fecha = Carbon::today()->addDays(rand(1, 30));

            $cita = Cita::create([
                'peluquero_id' => $peluquero->id,
                'fecha' => $fecha,
                'hora_inicio' => $this->getRandomHora(),
                'hora_fin' => Carbon::parse($this->getRandomHora())->addMinutes($tratamiento->duracion),
                'estado' => 'pendiente',
                'notas' => 'Nota de prueba para la cita futura ' . $i,
                'nombre_cliente' => $this->getRandomNombre(),
                'telefono_cliente' => $this->getRandomTelefono(),
                'email_cliente' => $this->getRandomEmail(),
            ]);

            $cita->tratamientos()->attach($tratamiento->id);
        }
    }

    private function getRandomHora()
    {
        $horas = ['09:00', '10:00', '11:00', '12:00', '16:00', '17:00', '18:00', '19:00'];
        return $horas[array_rand($horas)];
    }

    private function getRandomEstado()
    {
        $estados = ['pendiente', 'confirmada', 'completada', 'cancelada'];
        return $estados[array_rand($estados)];
    }

    private function getRandomNombre()
    {
        $estados = ['Paco', 'Daniel', 'Rosa', 'Mandarina'];
        return $estados[array_rand($estados)];
    }
    private function getRandomEmail()
    {
        $estados = ['paco@gmail.com', 'miau@hotmail.com', 'rosamelano@yopmail.com', 'dmorenop01@iescastelar.com'];
        return $estados[array_rand($estados)];
    }
    private function getRandomTelefono()
    {
        $estados = ['666 666 666', '679 679 679', '696 969 696', '011235813'];
        return $estados[array_rand($estados)];
    }
}
