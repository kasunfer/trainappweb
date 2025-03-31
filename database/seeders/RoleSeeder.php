<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $SuperAdminRole = Role::create(['name' => 'Super Admin', 'guard_name' => 'web']);
        $AdminRole = Role::create(['name' => 'Ticket Checker', 'guard_name' => 'web']);
 
        $permissions = Permission::all();
 
        foreach ($permissions as $permission) {
            if ($permission->guard_name == 'web') {
                $SuperAdminRole->givePermissionTo($permission->name);
                $AdminRole->givePermissionTo($permission->name);
            }
        }
    }
}
