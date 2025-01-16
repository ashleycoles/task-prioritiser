<?php

namespace App\Services;

use App\Models\User;

class TaskService
{
    public function getPrioritisedTasks(User $user)
    {
        $tasks = $user->tasks()->get();
        return $tasks;
    }
}
