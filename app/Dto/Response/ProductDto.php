<?php

declare(strict_types=1);

namespace App\Dto\Response;

use OpenApi\Attributes as OA;
use Spatie\LaravelData\Attributes\Validation\BooleanType;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Numeric;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;

#[OA\Schema(schema: 'ResponseProductDto')]
class ProductDto extends Data
{
    #[OA\Property,Exists(table: 'products', column: 'id'),IntegerType]
    public int $id;
    #[OA\Property,StringType]
    public string $title;
    #[OA\Property,StringType]
    public string $description;
    #[OA\Property,Numeric]
    public float $price;
    #[OA\Property,BooleanType]
    public bool $isStopped;
}
