<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title'         => fake()->text(50),
            'description'   => fake()->paragraph,
            'status'        => fake()->randomElement(['pendente', 'concluída']),
            'user_id'       => 1,
        ];
    }
}
