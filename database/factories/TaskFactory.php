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
            'title' => $this->faker->words(3, true),
            'description' => $this->faker->paragraph(),
            'estimate' => $this->faker->randomFloat(2, 0.25, 8),
            'deadline' => $this->faker->dateTimeBetween('now', '+1 year'),
            'priority' => rand(1, 5)
        ];
    }
}
