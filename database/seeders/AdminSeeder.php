<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = new User;
        $user->fname = 'John';
        $user->lname = 'Doe';
        $user->username = 'demouser';
        $user->nic = '123456789V';
        $user->code = 'EMP001';
        $user->email = 'demo@gmail.com';
        $user->contact = '0712345678';
        $user->description = 'Super Admin';
        $user->password = Hash::make('12345678');
        $user->photo = 'profile1.png';
        $user->added_by = 1;
        $user->save();
        $user->assignRole('Super Admin');

        $user = new User();
        $user->fname = 'Jane';
        $user->lname = 'Smith';
        $user->username = 'ticketchecker';
        $user->nic = '987654321V';
        $user->code = 'EMP002';
        $user->email = 'ticketchecker@gmail.com';
        $user->contact = '0712345679';
        $user->description = 'Ticket Checker';
        $user->password = Hash::make('12345678');
        $user->photo = 'profile2.png';
        $user->added_by = 1;
        $user->save();
        $user->assignRole('Ticket Checker');
    }
}
