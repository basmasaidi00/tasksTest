<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\tasks;

class TasksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Créer un certain nombre d'utilisateurs avec des tâches
        $users = User::factory(10)->create(); // Créer 10 utilisateurs

        // Pour chaque utilisateur, créer des tâches associées
        $users->each(function ($user) {
            // Créer 5 tâches pour chaque utilisateur
            tasks::factory(5)->create([
                'user_id' => $user->id, // Associer chaque tâche à l'utilisateur
            ]);
        });
    }
}
