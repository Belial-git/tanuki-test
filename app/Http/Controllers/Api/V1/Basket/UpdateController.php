<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Basket;

use App\Dto\Request\BasketRequestDto;
use App\Dto\Response\ProductDto;
use App\Http\Controllers\Controller;
use App\Models\Basket;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class UpdateController extends Controller
{
    #[
        OA\Patch(
            path: '/api/v1/basket/{id}',
            operationId: 'Update basket',
            description: 'Изменить корзину',
            requestBody: new OA\RequestBody(content: new OA\JsonContent(ref: BasketRequestDto::class)),
            tags: ['Basket'],
            responses: [
                new OA\Response(
                    response: 200,
                    description: 'Success response',
                    content: new OA\JsonContent(ref: BasketRequestDto::class)
                ),
            ]
        )
    ]
    public function __invoke(int $id, BasketRequestDto $data): JsonResponse
    {
        $totalPrice = 0;
        $basket = Basket::query()->findOrFail($id);

        /** @var ProductDto $product */
        foreach ($data->products as $product) {
            $totalPrice = $totalPrice + $product->price;
        }
        $basket->products = $data->products;
        $basket->totalPrice = $totalPrice;

        $basket->save();

        return response()->json(ProductDto::from($basket));
    }
}
