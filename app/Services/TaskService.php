<?php

namespace App\Services;

use App\Models\User;

class TaskService
{
    public function getPrioritisedTasks(User $user)
    {
        // Default order: Priority
        $tasks = $user->tasks()->orderBy('priority', 'desc')->get();

        // Only return the highest priority tasks that don't exceed the hours the user works in a day
        $availableDailyHours = $user->hours;

        return $tasks;
    }
}
