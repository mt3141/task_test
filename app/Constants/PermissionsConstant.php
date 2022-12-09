<?php

namespace App\Constants;

class PermissionsConstant
{
    const ADMIN = 'admin';
    const MEMBER = 'member';

    /**
     * @var array|string[]
     */
    public static $statuses = [
        self::ADMIN,
        self::MEMBER,
    ];
}
