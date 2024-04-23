<?php

namespace App\Statuses;


class UserType
{
    public const SUPER_ADMIN = 1;
    public const INSTRUCTOR = 2;
    public const STUDENT = 3;

    public static array $statuses = [self::SUPER_ADMIN, self::INSTRUCTOR, self::STUDENT];
}
