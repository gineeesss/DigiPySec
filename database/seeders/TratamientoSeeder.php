<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tratamiento;

class TratamientoSeeder extends Seeder
{
    public function run()
    {
        $tratamientos = [
            [
                'nombre' => 'Corte básico',
                'duracion' => 30,
                'precio' => 15.00,
                'descripcion' => 'Corte de pelo estándar',
            ],
            [
                'nombre' => 'Corte premium',
                'duracion' => 45,
                'precio' => 25.00,
                'descripcion' => 'Corte de pelo con lavado y acabado profesional',
            ],
            [
                'nombre' => 'Afeitado clásico',
                'duracion' => 30,
                'precio' => 20.00,
                'descripcion' => 'Afeitado con navaja y tratamientos posteriores',
            ],
            [
                'nombre' => 'Arreglo de barba',
                'duracion' => 20,
                'precio' => 12.00,
                'descripcion' => 'Perfilado y arreglo de barba',
            ],
            [
                'nombre' => 'Corte + barba',
                'duracion' => 60,
                'precio' => 30.00,
                'descripcion' => 'Corte de pelo completo más arreglo de barba',
            ],
        ];

        foreach ($tratamientos as $tratamiento) {
            Tratamiento::create($tratamiento);
        }
    }
}
