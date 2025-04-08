<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Administrador
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role' => 1,
            'password' => Hash::make('password'),
            'profile_photo' => 'default-profile.png',
            'phone' => '123456789',
        ]);

        // Vendedor
        User::create([
            'name' => 'Vendor User',
            'email' => 'vendor@example.com',
            'role' => 2,
            'password' => Hash::make('password'),
            'profile_photo' => 'default-profile.png',
            'phone' => '987654321',
        ]);

        // Cliente
        User::create([
            'name' => 'Customer User',
            'email' => 'customer@example.com',
            'role' => 3,
            'password' => Hash::make('password'),
            'profile_photo' => 'default-profile.png',
            'phone' => '555555555',
        ]);
    }
}
