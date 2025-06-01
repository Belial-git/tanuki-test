<?php

declare(strict_types=1);

namespace App\Facades\Utils;

use App\Utils\PhoneNumberNormalizer as PhoneNumberNormalizerAccessor;
use Illuminate\Support\Facades\Facade;

/**
 * @method static string|null                   normalize(string|null $phone)
 * @method static PhoneNumberNormalizerAccessor getFacadeRoot()
 */
class PhoneNumberNormalizer extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return PhoneNumberNormalizerAccessor::class;
    }
}
