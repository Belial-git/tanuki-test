<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Basket;

use App\Dto\Response\BasketDto;
use App\Dto\UserDto;
use App\Http\Controllers\Controller;
use App\Models\Basket;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class GetController extends Controller
{
    #[
        OA\Get(
            path: '/api/v1/basket',
            operationId: 'Get all basket ',
            description: 'Получить корзину',
            tags: ['Basket'],
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
                    content: new OA\JsonContent(ref: BasketDto::class)
                ),
            ]
        )
    ]
    public function __invoke(UserDto $user): JsonResponse
    {
        $user = Basket::query()
            ->where('id', $user->id)
            ->firstOrFail();

        return response()->json(BasketDto::from($user->basket));
    }
}
