<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Crear Permisos (opcional pero recomendado para granularidad)
        Permission::create(['name' => 'manage products']);
        Permission::create(['name' => 'view inventory']);
        Permission::create(['name' => 'manage categories']);
        Permission::create(['name' => 'manage users']); // Solo Admin
        Permission::create(['name' => 'manage promotions']); // Futuro

        // Crear Rol Administrador y asignar todos los permisos (o los necesarios)
        $adminRole = Role::create(['name' => 'Admin']);
        $adminRole->givePermissionTo(Permission::all()); // O sé más específico

        // Crear Rol Vendedor y asignar permisos específicos
        $sellerRole = Role::create(['name' => 'Vendedor']);
        $sellerRole->givePermissionTo(['view inventory']); // Por ahora solo ver inventario

        // Asignar Rol Admin al primer usuario (o a un usuario específico)
        // Asegúrate de que el usuario con ID 1 exista o ajusta el ID/email
        $adminUser = User::find(1);
        if ($adminUser) {
            $adminUser->assignRole('Admin');
        } else {
            // O crea un usuario admin si no existe
            $admin = User::factory()->create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                // 'password' => bcrypt('password'), // Define una contraseña segura
            ]);
            $admin->assignRole('Admin');
        }

        // Puedes crear un usuario Vendedor de ejemplo aquí también si quieres
        // $seller = User::factory()->create([
        //     'name' => 'Vendedor Ejemplo',
        //     'email' => 'vendedor@example.com',
        // ]);
        // $seller->assignRole('Vendedor');
    }
}
