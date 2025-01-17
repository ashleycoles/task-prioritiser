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
            ->has(Task::factory()->count(5))
            ->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => 'password',
            ]);
    }
}
