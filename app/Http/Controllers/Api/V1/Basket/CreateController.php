<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Basket;

use App\Dto\Request\BasketRequestDto;
use App\Dto\Response\BasketDto;
use App\Dto\Response\ProductDto;
use App\Http\Controllers\Controller;
use App\Models\Basket;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class CreateController extends Controller
{
    #[
        OA\Post(
            path: '/api/v1/basket',
            operationId: 'Create basket',
            description: 'Создать корзину',
            requestBody: new OA\RequestBody(content: new OA\JsonContent(ref: BasketRequestDto::class)),
            tags: ['Product'],
            responses: [
                new OA\Response(
                    response: 200,
                    description: 'Success response',
                    content: new OA\JsonContent(ref: BasketDto::class)
                ),
            ]
        )

    ]
    public function __invoke(BasketRequestDto $data): JsonResponse
    {
        $totalPrice = 0;
        /** @var ProductDto $product */
        foreach ($data->products as $product) {
            $totalPrice = $totalPrice + $product->price;
        }

        $basket = new Basket();
        $basket->products = $data->products;
        $basket->userId = $data->userId;
        $basket->totalPrice = $totalPrice;
        $basket->save();

        return response()->json(BasketDto::from($basket));
    }
}
