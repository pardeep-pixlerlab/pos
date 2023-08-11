<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create roles
        $admin_role = Role::create(['name' => 'admin']);
        $writer_role = Role::create(['name' => 'writer']);

        // Define permissions
        $permissions = [
            'Product access', 'Product edit', 'Product create', 'Product delete',
            'Role access', 'Role create', 'Role edit', 'Role delete',
            'Customer access', 'Customer edit', 'Customer create', 'Customer delete',
            'Permission access', 
            'Cart access', 'Cart edit', 'Cart delete',
            'Orders access', 'Orders edit', 'Orders create', 'Orders delete',
            'Setting access', 'Setting edit',
        ];

        // Create permissions
        foreach ($permissions as $permissionName) {
            Permission::create(['name' => $permissionName]);
        }

        // Create users dynamically
        for ($i = 1; $i <= 5; $i++) {
            $user = User::create([
                'first_name' => 'User' . $i,
                'last_name' => 'User' . $i,
                'email' => 'user' . $i . '@example.com',
                'password' => bcrypt('password')
            ]);

            // Assign roles and permissions
            if ($i % 2 === 0) {
                $user->assignRole($admin_role);
                $admin_role->givePermissionTo(Permission::all());
            } else {
                $user->assignRole($writer_role);
                $writer_role->givePermissionTo(['Product access', 'Product create']);
            }
        }
        $admin = User::create([
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin123'),
        ]);
        $admin->assignRole($admin_role);
        $admin_role->givePermissionTo(Permission::all());
    }
}
