<?php

namespace Database\Seeders;

use App\Models\CategoriaPlato;
use App\Models\Plato;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlatoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $entrantes = CategoriaPlato::where('nombre', 'Entrantes')->first();
        $principales = CategoriaPlato::where('nombre', 'Platos principales')->first();
        $postres = CategoriaPlato::where('nombre', 'Postres')->first();
        $bebidas = CategoriaPlato::where('nombre', 'Bebidas')->first();

        Plato::create([
            'nombre' => 'Ensalada de la casa',
            'descripcion' => 'Lechuga, tomate, cebolla, atún y huevo cocido.',
            'precio_tapa' => 3.00,
            'precio_racion' => 3.00,
            'categoria_plato_id' => $entrantes->id,
            'imagen_url' => 'https://source.unsplash.com/400x300/?Ensalada-de-la-casa',
        ]);

        Plato::create([
            'nombre' => 'Croquetas caseras',
            'descripcion' => 'Croquetas de jamón y pollo, crujientes por fuera y cremosas por dentro.',
            'precio_tapa' => 3.00,
            'precio_racion' => 3.00,
            'categoria_plato_id' => $entrantes->id,
        ]);

        Plato::create([
            'nombre' => 'Tabla de embutidos',
            'descripcion' => 'Selección de jamón, chorizo, salchichón y queso curado.',
            'precio_tapa' => 3.00,
            'precio_racion' => 3.00,
            'categoria_plato_id' => $entrantes->id,
        ]);

        // Principales
        Plato::create([
            'nombre' => 'Entrecot de ternera',
            'descripcion' => 'A la brasa, acompañado de patatas y pimientos del padrón.',
            'precio_tapa' => 3.00,
            'precio_racion' => 3.00,
            'categoria_plato_id' => $principales->id,
        ]);

        Plato::create([
            'nombre' => 'Paella mixta',
            'descripcion' => 'Arroz con mariscos y carne, receta tradicional.',
            'precio_tapa' => 3.00,
            'precio_racion' => 3.00,
            'categoria_plato_id' => $principales->id,
        ]);

        Plato::create([
            'nombre' => 'Hamburguesa gourmet',
            'descripcion' => 'Carne 100% vacuno, queso cheddar, cebolla caramelizada y salsa especial.',
            'precio_tapa' => 3.00,
            'precio_racion' => 3.00,
            'categoria_plato_id' => $principales->id,
        ]);

        // Postres
        Plato::create([
            'nombre' => 'Tarta de queso',
            'descripcion' => 'Cremosa, al horno, con mermelada de frutos rojos.',
            'precio_tapa' => 3.00,
            'precio_racion' => 3.00,
            'categoria_plato_id' => $postres->id,
        ]);

        Plato::create([
            'nombre' => 'Coulant de chocolate',
            'descripcion' => 'Bizcocho caliente con corazón de chocolate fundido.',
            'precio_tapa' => 3.00,
            'precio_racion' => 3.00,
            'categoria_plato_id' => $postres->id,
        ]);

        Plato::create([
            'nombre' => 'Helado artesanal',
            'descripcion' => 'Tres bolas a elegir: vainilla, chocolate, fresa o pistacho.',
            'precio_tapa' => 3.00,
            'precio_racion' => 3.00,
            'categoria_plato_id' => $postres->id,
        ]);

        // Bebidas
        Plato::create([
            'nombre' => 'Agua mineral',
            'descripcion' => 'Botella de 500ml.',
            'precio_tapa' => 3.00,
            'precio_racion' => 3.00,
            'categoria_plato_id' => $bebidas->id,
        ]);

        Plato::create([
            'nombre' => 'Refrescos variados',
            'descripcion' => 'Coca-Cola, Fanta, Sprite, etc.',
            'precio_tapa' => 3.00,
            'precio_racion' => 3.00,
            'categoria_plato_id' => $bebidas->id,
        ]);

        Plato::create([
            'nombre' => 'Cerveza artesanal',
            'descripcion' => 'Botella 330ml, tipo IPA.',
            'precio_tapa' => 3.00,
            'precio_racion' => 3.00,
            'categoria_plato_id' => $bebidas->id,
        ]);

    }
}
