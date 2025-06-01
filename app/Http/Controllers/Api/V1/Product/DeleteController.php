<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Response;
use OpenApi\Attributes as OA;

class DeleteController extends Controller
{
    #[
        OA\Delete(
            path: '/api/v1/products/{id}',
            operationId: 'Delete product',
            description: 'Удалить товар',
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
                ),
            ]
        )
    ]
    public function __invoke(int $id): Response
    {
        Product::query()->find($id)->delete();

        return response()->noContent();
    }
}
