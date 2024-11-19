<?php 

namespace App\Enum;

enum CommentStatusEnum: string
{
    case VALID = 'valid';
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
    case DELETED = 'deleted';
}
