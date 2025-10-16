<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'admin@packagetour.test'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password123'), // ganti password default sesuai kebutuhan
                'phone' => '081234567890',
                'role' => 'admin',
            ]
        );
    }
}
