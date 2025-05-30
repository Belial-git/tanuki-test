<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Product;

use App\Dto\Response\ProductDto;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;
use Spatie\LaravelData\DataCollection;

class AllController extends Controller
{
    #[
        OA\Get(
            path: '/api/v1/products',
            operationId: 'Get all products',
            description: 'Получить все товары',
            tags: ['Product'],
            responses: [
                new OA\Response(
                    response: 200,
                    description: 'Success response',
                    content: new OA\JsonContent(type: 'array', items: new OA\Items(ref: ProductDto::class))
                ),
            ]
        )
    ]
    public function __invoke(): JsonResponse
    {
        $products = Product::all();

        return response()->json(ProductDto::collect($products, DataCollection::class));
    }
}
