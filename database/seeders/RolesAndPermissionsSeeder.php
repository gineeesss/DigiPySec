<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    // database/seeders/RolesAndPermissionsSeeder.php
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        // Crear permisos
        $permissions = [
            'view clients',
            'manage clients',
            'view services',
            'manage services',
            'view requests',
            'manage requests',
            'access catalog'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Crear roles y asignar permisos
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());

        $techRole = Role::create(['name' => 'technician']);
        $techRole->givePermissionTo(['view services', 'view requests']);

        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo(['access catalog']);

        // Asignar rol admin al primer usuario
        $user = User::first();
        if ($user) {
            $user->assignRole('admin');
        }
    }
}
