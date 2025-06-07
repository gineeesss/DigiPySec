<?php

namespace Database\Seeders;

use App\Models\Servicio;
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
            // Servicios PAI
            [
                'categoria_servicio_id' => 2, // Ciberseguridad
                'nombre' => 'Auditoría Automática de Seguridad',
                'slug' => 'auditoria-automatica-seguridad',
                'descripcion_corta' => 'Escaneo automático de seguridad en tus sistemas',
                'descripcion_larga' => 'Servicio automatizado de análisis de vulnerabilidades, con informes detallados y recomendaciones.',
                'precio_base' => 249.00,
                'es_personalizable' => false,
                'tiempo_estimado' => 2,
                'activo' => true
            ],
            [
                'categoria_servicio_id' => 2, // Ciberseguridad
                'nombre' => 'Hardening Automatizado',
                'slug' => 'hardening-automatizado',
                'descripcion_corta' => 'Aplicación automática de medidas de seguridad recomendadas',
                'descripcion_larga' => 'Configuración segura de sistemas y servicios siguiendo buenas prácticas y normativas.',
                'precio_base' => 349.00,
                'es_personalizable' => true,
                'tiempo_estimado' => 3,
                'activo' => true
            ],
            [
                'categoria_servicio_id' => 4, // Demos
                'nombre' => 'Demo Carta Restaurante',
                'slug' => 'restaurante-carta',
                'url' => 'demo-carta',
                'descripcion_corta' => 'Demostración de una auditoría de seguridad web realizada con DigiPySecs',
                'descripcion_larga' => 'Explora una demo funcional que simula una auditoría real en un entorno controlado.',
                'precio_base' => 0.00,
                'es_personalizable' => false,
                'tiempo_estimado' => 0,
                'activo' => true
            ],
            [
                'categoria_servicio_id' => 4,
                'nombre' => 'Demo Gestión Citas Barbería',
                'slug' => 'demo-gestion-barberia',
                'url' => 'demos/barberia/reservar',
                'descripcion_corta' => 'Interfaz de gestión de solicitudes, usuarios y servicios',
                'descripcion_larga' => 'Visualiza la experiencia completa del panel administrativo y la gestión de clientes.',
                'precio_base' => 0.00,
                'es_personalizable' => false,
                'tiempo_estimado' => 0,
                'activo' => true
            ],
            [
                'categoria_servicio_id' => 4,
                'nombre' => 'Demo Tienda Pequeño Negocio',
                'slug' => 'demo-tienda',
                'url' => 'demos/tienda',
                'descripcion_corta' => 'Vista interactiva de proyectos y servicios anteriores',
                'descripcion_larga' => 'Presentación visual y funcional del portafolio de servicios implementados.',
                'precio_base' => 0.00,
                'es_personalizable' => false,
                'tiempo_estimado' => 0,
                'activo' => true
            ],
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
