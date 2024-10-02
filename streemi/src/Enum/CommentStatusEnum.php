<?php 

namespace App\Enum;

enum CommentStatusEnum: string
{
    const VALID = 'valid';
    const PENDING = 'pending';
    const APPROVED = 'approved';
    const REJECTED = 'rejected';
    const DELETED = 'deleted';
}
