<?php

namespace App\Services;

use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class TaskService
{
    public function getPrioritisedTasks(User $user): \Illuminate\Support\Collection
    {
        // Default order: Priority
        // Tasks overdue (deadline) by more than 5 days go to the top. If there are multiple, they are sorted by priority
        // Tasks overdue (deadline) by less than 5 days go after, if multiple they are sorted by priority
        // Followed by tasks due today, again in priority order if there are multiple
        // Then any tasks not overdue are in priority order

        /** @var Collection<int, Task> $tasks */
        $tasks = $user->tasks()->orderBy('priority', 'desc')->get();

        $today = Carbon::today();

        $taskGroupedByDeadline = $tasks->mapToGroups(function ($task) use ($today) {
            $deadline = Carbon::parse($task->deadline);
            $daysDifference = $today->diffInDays($deadline, false);

            if ($daysDifference == 0) {
                return ['dueToday' => $task];
            } elseif ($daysDifference < -5) {
                return ['overdueByMoreThan5Days' => $task];
            } elseif ($daysDifference < 0) {
                return ['overdueByLessThan5Days' => $task];
            } else {
                return ['notOverdue' => $task];
            }
        });

        $prioritisedTasks = $taskGroupedByDeadline->get('overdueByMoreThan5Days')
            ->concat($taskGroupedByDeadline->get('overdueByLessThan5Days'))
            ->concat($taskGroupedByDeadline->get('dueToday'))
            ->concat($taskGroupedByDeadline->get('notOverdue'))
            ->values();

        $availableDailyHours = $user->hours;
        $usedHours = 0;

        return $prioritisedTasks->mapToGroups(function ($task) use ($availableDailyHours, &$usedHours) {
            if ($task->estimate + $usedHours <= $availableDailyHours) {
                $usedHours += $task->estimate;
                return ['today' => $task];
            }
            return ['future' => $task];
        });
    }
}
