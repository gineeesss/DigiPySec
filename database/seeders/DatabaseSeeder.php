<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->withPersonalTeam()->create();

        /*User::factory()->withPersonalTeam()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);*/
        $this->call([
            RolesAndPermissionsSeeder::class,
            UserSeeder::class,
            //ClientSeeder::class,
            CategoriaServicioSeeder::class,
            ServicioSeeder::class,
            PostSeeder::class,

            //seeders para paginas demo
            CategoriaPlatoSeeder::class,
            PlatoSeeder::class,

            //seeders para barberia
            PeluqueroSeeder::class,
            TratamientoSeeder::class,
            HorarioDisponibleSeeder::class,
            CitaSeeder::class,

        ]);

    }
}
