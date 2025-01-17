<?php

namespace App\Services;

use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class TaskService
{
    public function getPrioritisedTasks(User $user): Collection
    {
        // Default order: Priority
        // Tasks overdue (deadline) by more than 5 days go to the top. If there are multiple, they are sorted by priority
        // Tasks overdue (deadline) by less than 5 days go after, if multiple they are sorted by priority
        // Followed by tasks due today, again in priority order if there are multiple
        // Then any tasks not overdue are in priority order

        $tasks = $user->tasks()->orderByPriority()->get(); // @phpstan-ignore-line

        $groupedByDeadline = $this->groupTasksByDeadline($tasks);

        $prioritisedTasks = $this->mergeTaskPriorityGroups($groupedByDeadline);

        return $this->divideTasksByUserAvailability($prioritisedTasks, $user);
    }

    private function groupTasksByDeadline(Collection $tasks): Collection
    {
        $today = Carbon::today();

        return $tasks->mapToGroups(function ($task) use ($today) {
            $deadline = Carbon::parse($task->deadline);
            $daysDifference = $today->diffInDays($deadline, false);

            if ($daysDifference == 0) {
                return ['dueToday' => $task];
            } elseif ($daysDifference < -5) {
                return ['overdueByMoreThan5Days' => $task];
            } elseif ($daysDifference < 0) {
                return ['overdueByLessThan5Days' => $task];
            }

            return ['notOverdue' => $task];
        });
    }

    private function mergeTaskPriorityGroups(Collection $tasks): Collection
    {
        return $tasks->get('overdueByMoreThan5Days')
            ->concat($tasks->get('overdueByLessThan5Days'))
            ->concat($tasks->get('dueToday'))
            ->concat($tasks->get('notOverdue'))
            ->values();
    }

    private function divideTasksByUserAvailability(Collection $tasks, User $user): Collection
    {
        $availableDailyHours = $user->hours;
        $usedHours = 0;

        return $tasks->mapToGroups(function ($task) use ($availableDailyHours, &$usedHours) {
            if ($task->estimate + $usedHours <= $availableDailyHours) {
                $usedHours += $task->estimate;
                return ['today' => $task];
            }
            return ['future' => $task];
        });
    }
}
