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
        // Crear roles primero si no existen
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);
        $techRole = Role::firstOrCreate(['name' => 'technician']);

        // Crear usuario admin
        $admin = User::create([
            'name' => 'Administrador',
            'email' => 'admin@a.com',
            'password' => Hash::make('a'),
            'email_verified_at' => now(),
        ]);
        $admin->assignRole($adminRole);

        // Crear usuario técnico
        $technician = User::create([
            'name' => 'Técnico Principal',
            'email' => 'tecnico@a.com',
            'password' => Hash::make('t'),
            'email_verified_at' => now(),
        ]);
        $technician->assignRole($techRole);

        // Crear usuario normal
        $user = User::create([
            'name' => 'Usuario Demo',
            'email' => 'usuario@a.com',
            'password' => Hash::make('u'),
            'email_verified_at' => now(),
        ]);
        $user->assignRole($userRole);

        // Crear usuarios adicionales con factory
        User::factory()->count(5)->create()->each(function ($user) use ($userRole) {
            $user->assignRole($userRole);
        });
    }
}
