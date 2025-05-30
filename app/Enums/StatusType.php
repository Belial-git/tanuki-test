<?php

declare(strict_types=1);

namespace App\Enums;

enum StatusType: string
{
    case CREATED = 'CREATED';
    case PREPARING = 'PREPARING';
    case DELIVER = 'DELIVER';
    case READY = 'READY';
}
