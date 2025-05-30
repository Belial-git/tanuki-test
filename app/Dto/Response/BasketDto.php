<?php

declare(strict_types=1);

namespace App\Dto\Response;

use OpenApi\Attributes as OA;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\Validation\ArrayType;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Numeric;
use Spatie\LaravelData\Attributes\Validation\Sometimes;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

#[OA\Schema(schema: 'ResponseBasketDto')]
class BasketDto extends Data
{
    #[OA\Property,StringType]
    public int $id;
    #[OA\Property,IntegerType]
    public int $userId;

    /** @var DataCollection<int, ProductDto> */
    #[
        OA\Property(type: 'array', items: new OA\Items(ref: ProductDto::class)),
        Sometimes,
        ArrayType,
        DataCollectionOf(ProductDto::class),
    ]
    public DataCollection $products;
    #[OA\Property,Numeric,Nullable]
    public ?float $totalPrice;
}
