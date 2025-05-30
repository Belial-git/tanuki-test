<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Order;

use App\Dto\Response\BasketDto;
use App\Dto\Response\OrderDto;
use App\Dto\UserDto;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class GetController extends Controller
{
    #[
        OA\Get(
            path: '/api/v1/order',
            operationId: 'Get order ',
            description: 'Получить заказ',
            tags: ['Order'],
            parameters: [
                new OA\Parameter(
                    name: 'id',
                    description: 'id пользователя',
                    in: 'query',
                    explode: true
                ),
            ],
            responses: [
                new OA\Response(
                    response: 200,
                    description: 'Success response',
                    content: new OA\JsonContent(ref: OrderDto::class)
                ),
            ]
        )
    ]
    public function __invoke(UserDto $user): JsonResponse
    {
        $order = Order::query()
                ->with('basket')
                ->where('user_id', $user->id)
                ->firstOrFail();

        return response()->json(OrderDto::from($order));
    }
}
