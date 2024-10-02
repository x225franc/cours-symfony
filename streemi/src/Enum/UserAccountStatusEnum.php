<?php

namespace App\Enum;

enum UserAccountStatusEnum: string
{
    const VALID = 'valid';
    const PENDING = 'pending';
    const BLOCKED = 'blocked';
    const BANNED = 'banned';
    const DELETED = 'deleted';
}
