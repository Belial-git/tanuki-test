<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Basket;

use App\Http\Controllers\Controller;
use App\Models\Basket;
use Illuminate\Http\Response;
use OpenApi\Attributes as OA;

class DeleteController extends Controller
{
    #[
        OA\Delete(
            path: '/api/v1/baskets/{id}',
            operationId: 'Delete basket',
            description: 'Удалить корзину',
            tags: ['Basket'],
            parameters: [
                new OA\Parameter(
                    name: 'id',
                    description: 'ИД корзины',
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
        Basket::query()->find($id)->delete();

        return response()->noContent();
    }
}
