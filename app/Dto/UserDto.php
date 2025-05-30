<?php

declare(strict_types=1);

namespace App\Dto;

use OpenApi\Attributes as OA;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Sometimes;
use Spatie\LaravelData\Data;

#[OA\Schema(schema: 'UserDto')]
class UserDto extends Data
{
    #[OA\Property,IntegerType,Sometimes]
    public int $id;
}
