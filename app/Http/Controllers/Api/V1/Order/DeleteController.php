<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Order;

use App\Http\Controllers\Controller;
use App\Models\Basket;
use App\Models\Order;
use Illuminate\Http\Response;
use OpenApi\Attributes as OA;

class DeleteController extends Controller
{
    #[
        OA\Delete(
            path: '/api/v1/order/{id}',
            operationId: 'Delete order',
            description: 'Удалить заказ',
            tags: ['Order'],
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
        Order::query()->find($id)->delete();

        return response()->noContent();
    }
}
