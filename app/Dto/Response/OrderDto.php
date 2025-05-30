<?php

declare(strict_types=1);

namespace App\Dto\Response;

use App\Models\Basket;
use OpenApi\Attributes as OA;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Numeric;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;

#[OA\Schema(schema: 'ResponseOrderDto')]
class OrderDto extends Data
{
    #[OA\Property,IntegerType,Exists(table: 'orders', column: 'id')]
    public int $id;

    #[OA\Property,IntegerType,Exists(table: 'orders', column: 'id')]
    public Basket $basket;
    #[OA\Property,StringType]
    public string $status;
    #[OA\Property,Numeric]
    public float $discount;
    #[OA\Property,Numeric]
    public float $finalPrice;
}
