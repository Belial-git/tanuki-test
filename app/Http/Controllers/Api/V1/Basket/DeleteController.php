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
            path: '/api/v1/basket/{id}',
            operationId: 'Delete basket',
            description: 'Удалить корзину',
            tags: ['Basket'],
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
