<?php

declare(strict_types=1);

namespace App\Enums;

enum DiscountType: string
{
    case SUM = 'SUM';
    case CODE = 'CODE';
}
