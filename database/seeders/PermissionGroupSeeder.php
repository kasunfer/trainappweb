<?php

namespace Database\Seeders;

use App\Models\PermissionGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $GroupNames=[
            [
                'name'=>'users'
            ],
            [
                'name'=>'roles-and-permission'
            ],
            [
                'name'=>'permissions'
            ],
            [
                'name'=>'stations'
            ],
            [
                'name'=>'trains'
            ],
            [
                'name'=>'route-fee'
            ],
            [
                'name'=>'trains-schedules'
            ],
            [
                'name'=>'booking'
            ],
            [
                'name'=>'ticket-verifying'
            ],
            [
                'name'=>'reports'
            ],
            [
                'name'=>'dashboard'
            ],
            [
                'name'=>'settings'
            ],
            [
                'name'=>'logs'
            ],
        ];
        foreach ($GroupNames as $key => $value) {
            $permissionGroup=new PermissionGroup();
            $permissionGroup->name=$value['name'];
            $permissionGroup->save();
        }
    }
}
