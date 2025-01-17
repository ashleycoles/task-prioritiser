<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()
            ->has(Task::factory()->dueToday()->count(5))
            ->has(Task::factory()->notOverdue()->count(5))
            ->has(Task::factory()->overdueLessThan5Days()->count(5))
            ->has(Task::factory()->overdueMoreThan5Days()->count(5))
            ->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => 'password',
            ]);
    }
}
