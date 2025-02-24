<?php

namespace Database\Factories;

use App\Models\tasks;
use App\Models\User; 
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\tasks>
 */
class TasksFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        
            return [
                'title' => $this->faker->sentence(), // Un titre aléatoire
                'description' => $this->faker->paragraph(), // Une description aléatoire
                'status' => $this->faker->randomElement(['pending', 'in_progress', 'completed']), // Un statut aléatoire
                'due_date' => $this->faker->date(), // Une date aléatoire
                'user_id' => User::factory(), // Associer la tâche à un utilisateur existant
            ];
    
    }
}
