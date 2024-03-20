<?php

namespace App\Services;
class UserService
{
    protected static $userId;
    protected static $email;

    public static function getUserId()
    {
        return self::$userId;
    }

    public static function setUserId($userId): void
    {
        self::$userId = $userId;
    }

    public static function getEmail()
    {
        return self::$email;
    }

    public static function setEmail($email): void
    {
        self::$email = $email;
    }
}
