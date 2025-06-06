<?php

namespace Database\Seeders;

use App\Models\CategoriaTienda;
use App\Models\ProductoTienda;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Str;

class TiendaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Crear categorías
        $categorias = [
            ['nombre' => 'Bebidas', 'slug' => 'bebidas', 'icono' => '🍹'],
            ['nombre' => 'Snacks', 'slug' => 'snacks', 'icono' => '🍿'],
            ['nombre' => 'Lácteos', 'slug' => 'lacteos', 'icono' => '🥛']
        ];

        foreach ($categorias as $cat) {
            $categoria = CategoriaTienda::create($cat);

            // 2. Crear productos para cada categoría
            $productos = [
                'Bebidas' => [
                    ['nombre' => 'Agua Mineral 1L', 'precio' => 1.20, 'stock' => 50],
                    ['nombre' => 'Refresco Cola', 'precio' => 1.80, 'stock' => 30],
                    ['nombre' => 'Zumo de Naranja', 'precio' => 2.10, 'stock' => 25],
                    ['nombre' => 'Cerveza Artesanal', 'precio' => 3.50, 'stock' => 40]
                ],
                'Snacks' => [
                    ['nombre' => 'Patatas Fritas', 'precio' => 1.50, 'stock' => 60],
                    ['nombre' => 'Barrita Energética', 'precio' => 1.20, 'stock' => 45],
                    ['nombre' => 'Frutos Secos', 'precio' => 2.30, 'stock' => 35]
                ],
                'Lácteos' => [
                    ['nombre' => 'Leche Entera', 'precio' => 1.10, 'stock' => 70],
                    ['nombre' => 'Yogur Natural', 'precio' => 0.90, 'stock' => 55],
                    ['nombre' => 'Queso Cheddar', 'precio' => 3.20, 'stock' => 30],
                    ['nombre' => 'Mantequilla', 'precio' => 1.80, 'stock' => 40],
                    ['nombre' => 'Natillas', 'precio' => 1.30, 'stock' => 25]
                ]
            ];

            foreach ($productos[$categoria->nombre] as $prod) {
                ProductoTienda::create(array_merge($prod, [
                    'categoria_id' => $categoria->id,
                    'slug' => Str::slug($prod['nombre']),
                    'activo' => true
                ]));
            }
        }
    }
}
