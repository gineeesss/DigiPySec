<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Peluquero;

class PeluqueroSeeder extends Seeder
{
    public function run()
    {
        $peluqueros = [
            [
                'nombre' => 'Juan Pérez',
                'especialidad' => 'Cortes clásicos y modernos',
                'foto' => null,
                'activo' => true,
            ],
            [
                'nombre' => 'María García',
                'especialidad' => 'Coloración y tratamientos capilares',
                'foto' => null,
                'activo' => true,
            ],
            [
                'nombre' => 'Carlos López',
                'especialidad' => 'Barbas y afeitado clásico',
                'foto' => null,
                'activo' => true,
            ],
        ];

        foreach ($peluqueros as $peluquero) {
            Peluquero::create($peluquero);
        }
    }
}
