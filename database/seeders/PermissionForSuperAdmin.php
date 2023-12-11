<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;

class PermissionForSuperAdmin extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superadminRole = Role::firstOrCreate(['name' => 'superadmin', 'guard_name' => 'web']);

        Permission::create(['name' => 'delete student', 'guard_name' => 'web']);
        $deleteStudentPermission = Permission::where('name', 'delete student')->first();

        $superadminRole->givePermissionTo($deleteStudentPermission);

    }
}
