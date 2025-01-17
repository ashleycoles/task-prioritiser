<?php

namespace App\Services;

use App\Enums\TaskGroup;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class TaskService
{
    public function getPrioritisedTasks(User $user): Collection
    {
        $tasks = $user->tasks()->orderByPriority()->get(); // @phpstan-ignore-line

        $groupedByDeadline = $this->groupTasksByDeadline($tasks);

        $prioritisedTasks = $this->mergeTaskPriorityGroups($groupedByDeadline);

        return $this->divideTasksByUserAvailability($prioritisedTasks, $user);
    }

    private function groupTasksByDeadline(Collection $tasks): Collection
    {
        // Default order: Priority
        // Tasks overdue (deadline) by more than 5 days go to the top. If there are multiple, they are sorted by priority
        // Tasks overdue (deadline) by less than 5 days go after, if multiple they are sorted by priority
        // Followed by tasks due today, again in priority order if there are multiple
        // Then any tasks not overdue are in priority order

        $today = Carbon::today();

        return $tasks->mapToGroups(function (Task $task) use ($today) {
            $deadline = Carbon::parse($task->deadline);
            $daysDifference = $today->diffInDays($deadline);

            return [TaskGroup::getGroupByDaysDifference($daysDifference)->name => $task];
        });
    }

    private function mergeTaskPriorityGroups(Collection $tasks): Collection
    {
        return $tasks->get(TaskGroup::OVERDUE_BY_MORE_THAN_5_DAYS->name)
            ->concat($tasks->get(TaskGroup::OVERDUE_BY_LESS_THAN_5_DAYS->name))
            ->concat($tasks->get(TaskGroup::DUE_TODAY->name))
            ->concat($tasks->get(TaskGroup::NOT_OVERDUE->name))
            ->values();
    }

    private function divideTasksByUserAvailability(Collection $tasks, User $user): Collection
    {
        $availableDailyHours = $user->hours;
        $usedHours = 0;

        return $tasks->mapToGroups(function (Task $task) use ($availableDailyHours, &$usedHours) {
            if ($task->estimate + $usedHours <= $availableDailyHours) {
                $usedHours += $task->estimate;

                return ['today' => $task];
            }

            return ['future' => $task];
        });
    }
}
