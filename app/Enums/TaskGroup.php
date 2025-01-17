<?php

namespace App\Enums;

enum TaskGroup
{
    case DUE_TODAY;
    case OVERDUE_BY_MORE_THAN_5_DAYS;
    case OVERDUE_BY_LESS_THAN_5_DAYS;
    case NOT_OVERDUE;
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
