<?php

namespace Database\Seeders;

use App\Models\PermissionGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $GroupNames = [
            [
                'name' => 'view-dashboard',
                'group_id' => PermissionGroup::where('name','dashboard')->first()->id,
                'guard_name' => 'web',
            ],
            // -----------------Users------------------
            [
                'name' => 'view-user',
                'group_id' => PermissionGroup::where('name', 'users')->first()->id,
                'guard_name' => 'web',
            ],
            [
                'name' => 'create-user',
                'group_id' => PermissionGroup::where('name', 'users')->first()->id,
                'guard_name' => 'web',
            ],
            [
                'name' => 'edit-user',
                'group_id' => PermissionGroup::where('name', 'users')->first()->id,
                'guard_name' => 'web',
            ],
            [
                'name' => 'delete-user',
                'group_id' => PermissionGroup::where('name', 'users')->first()->id,
                'guard_name' => 'web',
            ],
            // -----------------Roles and Permissions------------------
            [
                'name' => 'view-roles',
                'group_id' => PermissionGroup::where('name', 'roles-and-permission')->first()->id,
                'guard_name' => 'web',
            ],
            [
                'name' => 'create-roles',
                'group_id' => PermissionGroup::where('name', 'roles-and-permission')->first()->id,
                'guard_name' => 'web',
            ],
            [
                'name' => 'edit-roles',
                'group_id' => PermissionGroup::where('name', 'roles-and-permission')->first()->id,
                'guard_name' => 'web',
            ],
            [
                'name' => 'delete-roles',
                'group_id' => PermissionGroup::where('name', 'roles-and-permission')->first()->id,
                'guard_name' => 'web',
            ],
            // -----------------Permissions------------------
            [
                'name' => 'view-permissions',
                'group_id' => PermissionGroup::where('name', 'permissions')->first()->id,
                'guard_name' => 'web',
            ],
            [
                'name' => 'create-permissions',
                'group_id' => PermissionGroup::where('name', 'permissions')->first()->id,
                'guard_name' => 'web',
            ],
            [
                'name' => 'edit-permissions',
                'group_id' => PermissionGroup::where('name', 'permissions')->first()->id,
                'guard_name' => 'web',
            ],
            [
                'name' => 'delete-permissions',
                'group_id' => PermissionGroup::where('name', 'permissions')->first()->id,
                'guard_name' => 'web',
            ],
            [
                'name' => 'view-active-users',
                'group_id' => PermissionGroup::where('name','logs')->first()->id,
                'guard_name' => 'web',
            ],
            [
                'name' => 'view-activity-log',
                'group_id' => PermissionGroup::where('name','logs')->first()->id,
                'guard_name' => 'web',
            ],
            // -----------------Stations------------------
            [
                'name' => 'view-stations',
                'group_id' => PermissionGroup::where('name', 'stations')->first()->id,
                'guard_name' => 'web',
            ],
            [
                'name' => 'create-stations',
                'group_id' => PermissionGroup::where('name', 'stations')->first()->id,
                'guard_name' => 'web',
            ],
            [
                'name' => 'edit-stations',
                'group_id' => PermissionGroup::where('name', 'stations')->first()->id,
                'guard_name' => 'web',
            ],
            [
                'name' => 'delete-stations',
                'group_id' => PermissionGroup::where('name', 'stations')->first()->id,
                'guard_name' => 'web',
            ],
            // -----------------Trains------------------
            [
                'name' => 'view-trains',
                'group_id' => PermissionGroup::where('name', 'trains')->first()->id,
                'guard_name' => 'web',
            ],
            [
                'name' => 'create-trains',
                'group_id' => PermissionGroup::where('name', 'trains')->first()->id,
                'guard_name' => 'web',
            ],
            [
                'name' => 'edit-trains',
                'group_id' => PermissionGroup::where('name', 'trains')->first()->id,
                'guard_name' => 'web',
            ],
            [
                'name' => 'delete-trains',
                'group_id' => PermissionGroup::where('name', 'trains')->first()->id,
                'guard_name' => 'web',
            ],
            // -----------------route-fee------------------
            [
                'name' => 'view-route-fee',
                'group_id' => PermissionGroup::where('name', 'route-fee')->first()->id,
                'guard_name' => 'web',
            ],
            [
                'name' => 'create-route-fee',
                'group_id' => PermissionGroup::where('name', 'route-fee')->first()->id,
                'guard_name' => 'web',
            ],
            [
                'name' => 'edit-route-fee',
                'group_id' => PermissionGroup::where('name', 'route-fee')->first()->id,
                'guard_name' => 'web',
            ],
            [
                'name' => 'delete-route-fee',
                'group_id' => PermissionGroup::where('name', 'route-fee')->first()->id,
                'guard_name' => 'web',
            ],
            // -----------------Trains schedules------------------
            [
                'name' => 'view-trains-schedules',
                'group_id' => PermissionGroup::where('name', 'trains-schedules')->first()->id,
                'guard_name' => 'web',
            ],
            [
                'name' => 'create-trains-schedules',
                'group_id' => PermissionGroup::where('name', 'trains-schedules')->first()->id,
                'guard_name' => 'web',
            ],
            [
                'name' => 'edit-trains-schedules',
                'group_id' => PermissionGroup::where('name', 'trains-schedules')->first()->id,
                'guard_name' => 'web',
            ],
            [
                'name' => 'delete-trains-schedules',
                'group_id' => PermissionGroup::where('name', 'trains-schedules')->first()->id,
                'guard_name' => 'web',
            ],
            // -----------------Bookings------------------
            [
                'name' => 'view-booking',
                'group_id' => PermissionGroup::where('name', 'booking')->first()->id,
                'guard_name' => 'web',
            ],
            [
                'name' => 'create-booking',
                'group_id' => PermissionGroup::where('name', 'booking')->first()->id,
                'guard_name' => 'web',
            ],
            [
                'name' => 'edit-booking',
                'group_id' => PermissionGroup::where('name', 'booking')->first()->id,
                'guard_name' => 'web',
            ],
            [
                'name' => 'delete-booking',
                'group_id' => PermissionGroup::where('name', 'booking')->first()->id,
                'guard_name' => 'web',
            ],
            // -----------------Settings------------------
            [
                'name' => 'view-settings',
                'group_id' => PermissionGroup::where('name', 'settings')->first()->id,
                'guard_name' => 'web',
            ],
            [
                'name' => 'edit-settings',
                'group_id' => PermissionGroup::where('name', 'settings')->first()->id,
                'guard_name' => 'web',
            ],
            [
                'name' => 'delete-settings',
                'group_id' => PermissionGroup::where('name', 'settings')->first()->id,
                'guard_name' => 'web',
            ],
            // -----------------reports------------------
            [
                'name' => 'view-reports',
                'group_id' => PermissionGroup::where('name', 'reports')->first()->id,
                'guard_name' => 'web',
            ],
            [
                'name' => 'export-reports',
                'group_id' => PermissionGroup::where('name', 'reports')->first()->id,
                'guard_name' => 'web',
            ],
            // -----------------verifying------------------
            [
                'name' => 'view-ticket-verifying',
                'group_id' => PermissionGroup::where('name', 'ticket-verifying')->first()->id,
                'guard_name' => 'web',
            ],
            [
                'name' => 'able-ticket-verifying',
                'group_id' => PermissionGroup::where('name', 'ticket-verifying')->first()->id,
                'guard_name' => 'web',
            ],
        ];
        foreach ($GroupNames as $key => $value) {
            $permissionGroup = new Permission();
            $permissionGroup->name = $value['name'];
            $permissionGroup->permission_group_id = $value['group_id'];
            $permissionGroup->guard_name = $value['guard_name'];
            $permissionGroup->save();
        }
    }
}
