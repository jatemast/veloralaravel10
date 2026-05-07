<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Services\UserService;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(UserService $userService): void
    {
        $userService->createUser([
            'name' => 'Admin Velora',
            'email' => 'admin@velora.com',
            'password' => 'password',
        ]);
    }
}
