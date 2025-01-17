<?php

namespace Tests\Unit\Enums;

use App\Enums\TaskGroup;
use PHPUnit\Framework\TestCase;

class TaskGroupTest extends TestCase
{
    public function test_get_group_by_days_difference_not_overdue(): void
    {
        $case = TaskGroup::getGroupByDaysDifference(10);
        $this->assertEquals(TaskGroup::NOT_OVERDUE, $case);
    }

    public function test_get_group_by_days_difference_due_today(): void
    {
        $case = TaskGroup::getGroupByDaysDifference(0);
        $this->assertEquals(TaskGroup::DUE_TODAY, $case);
    }

    public function test_get_group_by_days_difference_overdue_less_than5_days(): void
    {
        $case = TaskGroup::getGroupByDaysDifference(-1);
        $this->assertEquals(TaskGroup::OVERDUE_BY_LESS_THAN_5_DAYS, $case);
    }

    public function test_get_group_by_days_difference_overdue_more_than5_days(): void
    {
        $case = TaskGroup::getGroupByDaysDifference(-10);
        $this->assertEquals(TaskGroup::OVERDUE_BY_MORE_THAN_5_DAYS, $case);
    }
}
