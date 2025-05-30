<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Product;

use App\Dto\Request\ProductRequestDto;
use App\Dto\Response\ProductDto;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class CreateController extends Controller
{
    #[
        OA\Post(
            path: '/api/v1/products',
            operationId: 'Create product',
            description: 'Создать товар',
            requestBody: new OA\RequestBody(content: new OA\JsonContent(ref: ProductRequestDto::class)),
            tags: ['Product'],
            responses: [
                new OA\Response(
                    response: 200,
                    description: 'Success response',
                    content: new OA\JsonContent(ref: ProductDto::class)
                ),
            ]
        )
    ]
    public function __invoke(ProductRequestDto $data): JsonResponse
    {
        $product = new Product();
        $product->fill($data->toArray());
        $product->save();

        return response()->json(ProductDto::from($product));
    }
}
