<?php

namespace Database\Seeders;

use App\Models\Club;
use App\Models\ClubMember;
use App\Models\Court;
use App\Models\User;
use Illuminate\Database\Seeder;

class ClubSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear usuarios adicionales
        $users = User::factory(10)->create();

        // Crear clubs con dueños aleatorios
        Club::factory(5)
            ->has(Court::factory()->count(3), 'courts')
            ->create()
            ->each(function ($club) use ($users) {
                // Agregar al dueño como miembro
                ClubMember::create([
                    'club_id' => $club->id,
                    'user_id' => $club->owner_id,
                    'role' => 'owner',
                    'status' => 'active',
                ]);

                // Agregar algunos usuarios como miembros
                $randomUsers = $users->random(rand(2, 5));
                foreach ($randomUsers as $user) {
                    ClubMember::create([
                        'club_id' => $club->id,
                        'user_id' => $user->id,
                        'role' => 'member',
                        'status' => 'active',
                    ]);
                }
            });
    }
}
