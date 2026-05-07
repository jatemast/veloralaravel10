<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear usuario admin por defecto
        User::create([
            'name' => 'Admin Velora',
            'email' => 'admin@velora.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Crear usuario de prueba
        User::create([
            'name' => 'Usuario Prueba',
            'email' => 'user@velora.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
    }
}
