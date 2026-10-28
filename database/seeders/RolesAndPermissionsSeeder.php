<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = [
            'view students', 'create students', 'edit students', 'delete students',
            'view courses', 'create courses', 'edit courses', 'delete courses',
            'manage registrations', 'manage users',
            'view assigned courses',
            'view available courses', 'register courses', 'view own registrations',
        ];

        foreach ($permissions as $name) {
            Permission::firstOrCreate(['name' => $name, 'guard_name' => 'web']);
        }

        Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web'])->syncPermissions([
            'view students', 'create students', 'edit students', 'delete students',
            'view courses', 'create courses', 'edit courses', 'delete courses',
            'manage registrations', 'manage users',
        ]);

        Role::firstOrCreate(['name' => 'lecturer', 'guard_name' => 'web'])->syncPermissions([
            'view assigned courses',
        ]);

        Role::firstOrCreate(['name' => 'student', 'guard_name' => 'web'])->syncPermissions([
            'view available courses', 'register courses', 'view own registrations',
        ]);
    }
}
