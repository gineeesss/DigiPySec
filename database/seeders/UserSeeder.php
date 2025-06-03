<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);
        $techRole = Role::firstOrCreate(['name' => 'technician']);

        // Admin
        $admin = User::create([
            'name' => 'Administrador',
            'email' => 'admin@a.com',
            'password' => Hash::make('a'),
            'email_verified_at' => now(),
        ]);
        $admin->assignRole($adminRole);
        $admin->client()->create([
            'phone' => '+34987654321',
            'company_name' => 'Empresa Admin'
        ]);

        // Técnico
        $technician = User::create([
            'name' => 'Técnico Principal',
            'email' => 'tecnico@a.com',
            'password' => Hash::make('t'),
            'email_verified_at' => now(),
        ]);
        $technician->assignRole($techRole);

        // Usuario normal
        $user = User::create([
            'name' => 'Usuario Demo',
            'email' => 'usuario@a.com',
            'password' => Hash::make('u'),
            'email_verified_at' => now(),
        ]);
        $user->assignRole($userRole);
        $client = $user->client()->create([
            'phone' => '+34611223344',
            'company_name' => 'Empresa Demo'
        ]);

        // Crear direcciones y métodos de pago para el usuario demo
        $user->addresses()->create([
            'type' => 'both',
            'contact_name' => 'Usuario Demo',
            'street' => 'Calle Ejemplo 123',
            'city' => 'Madrid',
            'state' => 'Madrid',
            'zip_code' => '28001',
            'is_default' => true
        ]);

        $user->paymentMethods()->create([
            'type' => 'credit_card',
            'alias' => 'Tarjeta Principal',
            'last_four' => '4242',
            'is_default' => true
        ]);

        // Usuarios adicionales
        User::factory()->count(5)->create()->each(function ($user) use ($userRole) {
            $user->assignRole($userRole);
            $user->client()->create([
                'phone' => '+34' . rand(600000000, 699999999),
                'company_name' => fake()->company()
            ]);
        });
    }
}
