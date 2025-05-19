<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Borrar datos existentes
        DB::table('clients')->delete();
        $users = User::all();

        $clients = [
            [
                'user_id' => $users->random()->id,
                'name' => 'Empresa Tecnológica S.A.',
                'email' => 'contacto@empresatecnologica.com',
                'phone' => '+34912345678',
                'address' => 'Calle Innovación 123, Madrid',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => $users->random()->id,
                'name' => 'Soluciones Digitales SL',
                'email' => 'info@solucionesdigitales.com',
                'phone' => '+34987654321',
                'address' => 'Avenida Digital 45, Barcelona',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => $users->random()->id,
                'name' => 'WebDesign Pro',
                'email' => 'hello@webdesignpro.com',
                'phone' => '+34611223344',
                'address' => 'Plaza Creativa 8, Valencia',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => $users->random()->id,
                'name' => 'Ciberseguridad Global',
                'email' => 'security@ciberseguridadglobal.com',
                'phone' => '+34900112233',
                'address' => 'Bulevar Seguridad 15, Sevilla',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => $users->random()->id,
                'name' => 'Cloud Services Corp',
                'email' => 'support@cloudservices.com',
                'phone' => '+34955443322',
                'address' => 'Calle Nube 77, Bilbao',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        Client::insert($clients);
    }
}
