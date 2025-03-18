<?php

declare (strict_types=1);

namespace App\Enum;

enum ProductEnum: string
{
    case EXCELLENT = 'Excellent';
    case TRESBON = 'Très bon';
    case BON = 'Bon';
    case SATISFAISANT = 'Satisfaisant';
}