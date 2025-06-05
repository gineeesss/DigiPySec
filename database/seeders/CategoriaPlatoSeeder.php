<?php

namespace Database\Seeders;

use App\Models\CategoriaPlato;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriaPlatoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CategoriaPlato::insert([
            ['nombre' => 'Entrantes'],
            ['nombre' => 'Platos principales'],
            ['nombre' => 'Postres'],
            ['nombre' => 'Bebidas'],
        ]);

    }
}
