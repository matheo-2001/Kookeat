<?php

namespace App\Services;
class UserService
{
    protected static $userId;

    public static function getUserId()
    {
        return self::$userId;
    }

    public static function setUserId($userId): void
    {
        self::$userId = $userId;
    }
}
