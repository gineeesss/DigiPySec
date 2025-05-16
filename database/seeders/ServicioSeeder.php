<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServicioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $servicios = [
            [
                'categoria_servicio_id' => 1,
                'nombre' => 'Landing Page Básica',
                'slug' => 'landing-page-basica',
                'descripcion_corta' => 'Página de aterrizaje simple para promocionar tu producto o servicio',
                'descripcion_larga' => '...',
                'precio_base' => 499.00,
                'es_personalizable' => true,
                'tiempo_estimado' => 7,
                'activo' => true
            ],
            // Más servicios...
        ];

        foreach ($servicios as $servicio) {
            $servicioCreado = Servicio::create($servicio);

            // Características incluidas
            $caracteristicas = [
                ['caracteristica' => 'Diseño responsive'],
                ['caracteristica' => 'Optimización SEO básica'],
                ['caracteristica' => 'Formulario de contacto'],
                ['caracteristica' => 'Integración con redes sociales'],
            ];

            foreach ($caracteristicas as $caracteristica) {
                $servicioCreado->incluyes()->create($caracteristica);
            }
        }
    }
}
