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
        Product::query()->first($id)->delete();

        return response()->noContent();
    }
}
