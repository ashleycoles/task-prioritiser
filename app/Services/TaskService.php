<?php

namespace App\Services;

use App\Models\User;
use Carbon\Carbon;

class TaskService
{
    public function getPrioritisedTasks(User $user)
    {
        // Default order: Priority
        // Tasks overdue (deadline) by more than 5 days go to the top. If there are multiple, they are sorted by priority
        // Tasks overdue (deadline) by less than 5 days go after, if multiple they are sorted by priority
        // Followed by tasks due today, again in priority order if there are multiple
        // Then any tasks not overdue are in priority order
        $tasks = $user->tasks()->orderBy('priority', 'desc')->get();

        $today = Carbon::today();

        $overdueByMoreThan5Days = [];
        $overdueByLessThan5Days = [];
        $dueToday = [];
        $notOverdue = [];

        foreach ($tasks as $task) {
            $deadline = Carbon::parse($task->deadline);
            $daysDifference = $today->diffInDays($deadline, false);

            if ($daysDifference == 0) {
                $dueToday[] = $task;
            } elseif ($daysDifference < -5) {
                $overdueByMoreThan5Days[] = $task;
            } elseif ($daysDifference < 0) {
                $overdueByLessThan5Days[] = $task;
            } else {
                $notOverdue[] = $task;
            }
        }

        $this->prioritiseTasks($overdueByMoreThan5Days);
        $this->prioritiseTasks($overdueByLessThan5Days);
        $this->prioritiseTasks($dueToday);
        $this->prioritiseTasks($notOverdue);

        $prioritisedTasks = array_merge(
            $overdueByMoreThan5Days,
            $overdueByLessThan5Days,
            $dueToday,
            $notOverdue
        );

        $availableDailyHours = $user->hours;
        $usedHours = 0;

        $daysTasks = [];

        foreach ($prioritisedTasks as $task) {
            if ($task->estimate + $usedHours <= $availableDailyHours) {
                $daysTasks[] = $task;
                $usedHours += $task->estimate;
            }
        }


        return $daysTasks;
    }

    private function prioritiseTasks(array &$tasks): void
    {
        usort($tasks, fn($a, $b) => $b->priority - $a->priority);
    }
}
