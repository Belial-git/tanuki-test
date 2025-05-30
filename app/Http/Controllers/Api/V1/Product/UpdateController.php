<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Product;

use App\Dto\Request\ProductRequestDto;
use App\Dto\Response\ProductDto;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class UpdateController extends Controller
{
    #[
        OA\Patch(
            path: '/api/v1/products/{id}',
            operationId: 'Update product',
            description: 'Изменить товар',
            requestBody: new OA\RequestBody(content: new OA\JsonContent(ref: ProductRequestDto::class)),
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
    public function __invoke(int $id, ProductRequestDto $data): JsonResponse
    {
        $product = Product::query()->findOrFail($id);
        $product->fill($data->toArray());
        $product->save();

        return response()->json(ProductDto::from($product));
    }
}
