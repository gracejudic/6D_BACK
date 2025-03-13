<?php

declare (strict_types=1);

namespace App\Enum;

enum StatusEnum: string
{
    case PENDING = 'PENDING';
    case VALIDATED = 'VALIDATED';
    case REFUSED = 'REFUSED';
    case DELETED = 'DELETED';
}