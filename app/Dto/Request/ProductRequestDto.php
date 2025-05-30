<?php

declare(strict_types=1);

namespace App\Dto\Request;

use OpenApi\Attributes as OA;
use Spatie\LaravelData\Attributes\Validation\Numeric;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;

#[OA\Schema(schema: 'RequestProductRequestDto')]
class ProductRequestDto extends Data
{
    #[OA\Property,StringType]
    public string $title;
    #[OA\Property,StringType]
    public string $description;
    #[OA\Property,Numeric]
    public float $price;
}
