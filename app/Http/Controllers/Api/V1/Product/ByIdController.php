<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Product;

use App\Dto\Response\ProductDto;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class ByIdController extends Controller
{
    #[
        OA\Get(
            path: '/api/v1/products/{id}',
            operationId: 'Get product by id',
            description: 'Получить товар',
            tags: ['Product'],
            parameters: [
                new OA\Parameter(
                    name: 'id',
                    description: 'ИД товара',
                    in: 'path',
                    required: true,
                    schema: new OA\Schema(type: 'integer'),
                ),
            ],
            responses: [
                new OA\Response(
                    response: 200,
                    description: 'Success response',
                    content: new OA\JsonContent(ref: ProductDto::class)
                ),
            ]
        )
    ]
    public function __invoke(int $id): JsonResponse
    {
        return response()->json(ProductDto::from(Product::query()->findOrFail($id)));
    }
}
