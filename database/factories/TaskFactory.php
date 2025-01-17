<?php

namespace Database\Factories;

use Carbon\Carbon;
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
            'description' => $this->faker->paragraph(1),
            'estimate' => $this->faker->randomFloat(2, 0.25, 8),
            'deadline' => $this->faker->dateTimeBetween('-2 week', '+2 week'),
            'priority' => rand(1, 5),
        ];
    }

    public function dueToday(): Factory
    {
        return $this->state(function () {
            return [
                'deadline' => Carbon::today(),
            ];
        });
    }

    public function notOverdue(): Factory
    {
        return $this->state(function () {
            return [
                'deadline' => Carbon::today()->addDays(rand(1, 30)),
            ];
        });
    }

    public function overdueLessThan5Days(): Factory
    {
        return $this->state(function () {
            return [
                'deadline' => Carbon::today()->subDays(rand(1, 4)),
            ];
        });
    }

    public function overdueMoreThan5Days(): Factory
    {
        return $this->state(function () {
            return [
                'deadline' => Carbon::today()->subDays(rand(6, 100)),
            ];
        });
    }
}
