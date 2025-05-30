<?php

declare(strict_types=1);

namespace App\Dto\Request;

use App\Dto\Response\ProductDto;
use App\Facades\Utils\PhoneNumberNormalizer;
use OpenApi\Attributes as OA;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\Validation\ArrayType;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Sometimes;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Support\Validation\ValidationContext;

#[OA\Schema(schema: 'RequestBasketRequestDto')]
class BasketRequestDto extends Data
{
    #[
        OA\Property(type: 'array', items: new OA\Items(type: 'integer')),
        Sometimes,
        ArrayType,
    ]
    public array $productsIds;

    #[OA\Property,IntegerType]
    public int $userId;

    /**
     * @return array<string, mixed>
     */
    public static function rules(ValidationContext $context): array
    {
        return [
            'productsIds.*' => ['integer', 'exists:products,id'],
        ];
    }
}

