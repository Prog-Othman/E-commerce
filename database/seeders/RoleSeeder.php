<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Create roles
        $customer = Role::firstOrCreate(['name' => 'customer']);
        $admin = Role::firstOrCreate(['name' => 'admin']);

        // Create permissions
        $permissions = [
            'view products',
            'purchase products',
            'view orders',
            'manage products',
            'manage orders',
            'manage users',
            'view dashboard'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assign permissions to roles
        $customer->givePermissionTo([
            'view products',
            'purchase products',
            'view orders'
        ]);

        $admin->givePermissionTo($permissions);
    }
} 