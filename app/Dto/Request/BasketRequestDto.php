<?php

declare(strict_types=1);

namespace App\Dto\Request;

use App\Dto\Response\ProductDto;
use OpenApi\Attributes as OA;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\Validation\ArrayType;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Sometimes;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Symfony\Contracts\Service\Attribute\Required;

#[OA\Schema(schema: 'RequestBasketRequestDto')]
class BasketRequestDto extends Data
{
    /** @var DataCollection<int, ProductDto> */
    #[
        OA\Property(type: 'array', items: new OA\Items(ref: ProductDto::class)),
        Sometimes,
        ArrayType,
        DataCollectionOf(ProductDto::class),
    ]
    public DataCollection $products;

    #[OA\Property,IntegerType]
    public int $userId;
}
