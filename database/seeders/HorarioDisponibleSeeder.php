<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HorarioDisponible;
use App\Models\Peluquero;

class HorarioDisponibleSeeder extends Seeder
{
    public function run()
    {
        $peluqueros = Peluquero::all();

        foreach ($peluqueros as $peluquero) {
            // Lunes a Viernes
            for ($dia = 1; $dia <= 5; $dia++) {
                HorarioDisponible::create([
                    'peluquero_id' => $peluquero->id,
                    'dia_semana' => $dia,
                    'hora_inicio' => '09:00',
                    'hora_fin' => '13:00',
                    'activo' => true,
                ]);

                HorarioDisponible::create([
                    'peluquero_id' => $peluquero->id,
                    'dia_semana' => $dia,
                    'hora_inicio' => '16:00',
                    'hora_fin' => '20:00',
                    'activo' => true,
                ]);
            }

            // Sábado (solo mañana)
            HorarioDisponible::create([
                'peluquero_id' => $peluquero->id,
                'dia_semana' => 6,
                'hora_inicio' => '09:00',
                'hora_fin' => '14:00',
                'activo' => true,
            ]);
        }
    }
}
