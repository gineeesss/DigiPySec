<?php

namespace Database\Seeders;

use App\Models\CategoriaServicio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriaServicioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $categorias = [
            [
                'nombre' => 'Desarrollo Web',
                'slug' => 'desarrollo-web',
                'descripcion' => 'Soluciones completas para presencia en línea',
                'icono' => 'code'
            ],
            [
                'nombre' => 'Ciberseguridad',
                'slug' => 'ciberseguridad',
                'descripcion' => 'Protección para tu negocio digital',
                'icono' => 'shield-check'
            ],
            [
                'nombre' => 'Optimización',
                'slug' => 'optimizacion',
                'descripcion' => 'Mejora el rendimiento de tu sitio web',
                'icono' => 'lightning-bolt'
            ],
            [
                'nombre' => 'Demos',
                'slug' => 'demos',
                'descripcion' => 'Sitios web de muestra representativos de nuestros servicios',
                'icono' => 'monitor'
            ],
        ];

        foreach ($categorias as $categoria) {
            CategoriaServicio::create($categoria);
        }
    }
}
