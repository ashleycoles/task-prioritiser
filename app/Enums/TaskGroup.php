<?php

namespace App\Enums;

enum TaskGroup: int
{
    case OVERDUE_BY_MORE_THAN_5_DAYS = 0;
    case OVERDUE_BY_LESS_THAN_5_DAYS = 1;
    case DUE_TODAY = 2;
    case NOT_OVERDUE = 3;

    public static function getGroupByDaysDifference(float $daysDifference): TaskGroup
    {
        return match (true) {
            $daysDifference == 0 => self::DUE_TODAY,
            $daysDifference < -5 => self::OVERDUE_BY_MORE_THAN_5_DAYS,
            $daysDifference < 0 => self::OVERDUE_BY_LESS_THAN_5_DAYS,
            default => self::NOT_OVERDUE
        };
    }
}
