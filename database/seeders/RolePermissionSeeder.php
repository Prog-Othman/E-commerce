<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // User permissions
            'view users',
            'create users',
            'edit users',
            'delete users',
            
            // Role permissions
            'view roles',
            'create roles',
            'edit roles',
            'delete roles',
            
            // Product permissions
            'view products',
            'create products',
            'edit products',
            'delete products',
            
            // Category permissions
            'view categories',
            'create categories',
            'edit categories',
            'delete categories',
            
            // Order permissions
            'view orders',
            'edit orders',
            'delete orders',
            'export orders',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles and assign created permissions
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminPermissions = [
            'view users', 'create users', 'edit users', 'delete users',
            'view roles', 'create roles', 'edit roles', 'delete roles',
            'view products', 'create products', 'edit products', 'delete products',
            'view categories', 'create categories', 'edit categories', 'delete categories',
            'view orders', 'edit orders', 'delete orders', 'export orders',
        ];
        $adminRole->syncPermissions($adminPermissions);

        $managerRole = Role::firstOrCreate(['name' => 'manager']);
        $managerPermissions = [
            'view users',
            'view products', 'create products', 'edit products',
            'view categories', 'create categories', 'edit categories',
            'view orders', 'edit orders', 'export orders',
        ];
        $managerRole->syncPermissions($managerPermissions);

        $editorRole = Role::firstOrCreate(['name' => 'editor']);
        $editorPermissions = [
            'view products', 'edit products',
            'view categories', 'edit categories',
            'view orders',
        ];
        $editorRole->syncPermissions($editorPermissions);

        // Assign admin role to the first user
        $user = \App\Models\User::first();
        if ($user) {
            $user->assignRole('admin');
        }
    }
}
