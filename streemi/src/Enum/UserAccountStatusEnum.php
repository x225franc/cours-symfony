<?php

namespace App\Enum;

enum UserAccountStatusEnum: string
{
    case VALID = 'valid';
    case PENDING = 'pending';
    case BLOCKED = 'blocked';
    case BANNED = 'banned';
    case DELETED = 'deleted';
}