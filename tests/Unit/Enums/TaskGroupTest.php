<?php

namespace Tests\Unit\Enums;

use App\Enums\TaskGroup;
use PHPUnit\Framework\TestCase;

class TaskGroupTest extends TestCase
{
    public function test_getGroupByDaysDifference_notOverdue(): void
    {
        $case = TaskGroup::getGroupByDaysDifference(10);
        $this->assertEquals(TaskGroup::NOT_OVERDUE, $case);
    }

    public function test_getGroupByDaysDifference_dueToday(): void
    {
        $case = TaskGroup::getGroupByDaysDifference(0);
        $this->assertEquals(TaskGroup::DUE_TODAY, $case);
    }

    public function test_getGroupByDaysDifference_overdueLessThan5Days(): void
    {
        $case = TaskGroup::getGroupByDaysDifference(-1);
        $this->assertEquals(TaskGroup::OVERDUE_BY_LESS_THAN_5_DAYS, $case);
    }

    public function test_getGroupByDaysDifference_overdueMoreThan5Days(): void
    {
        $case = TaskGroup::getGroupByDaysDifference(-10);
        $this->assertEquals(TaskGroup::OVERDUE_BY_MORE_THAN_5_DAYS, $case);
    }
}
