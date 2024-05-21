<?php

namespace App\Statuses;


class CourseStatus
{
    public const ACTIVE = 1;
    public const UN_ACTIVE = 2;

    public static array $statuses = [self::ACTIVE, self::UN_ACTIVE];
}
