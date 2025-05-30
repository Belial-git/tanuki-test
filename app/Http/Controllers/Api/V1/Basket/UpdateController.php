<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Basket;

use App\Dto\Request\BasketRequestDto;
use App\Dto\Response\ProductDto;
use App\Http\Controllers\Controller;
use App\Models\Basket;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class UpdateController extends Controller
{
    #[
        OA\Patch(
            path: '/api/v1/baskets/{id}',
            operationId: 'Update basket',
            description: 'Изменить корзину',
            requestBody: new OA\RequestBody(content: new OA\JsonContent(ref: BasketRequestDto::class)),
            tags: ['Basket'],
            parameters: [
                new OA\Parameter(
                    name: 'id',
                    description: 'Идентификатор корзины',
                    in: 'path',
                    required: true,
                    schema: new OA\Schema(type: 'integer'),
                ),
            ],
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
        $basket = Basket::query()->findOrFail($id);
        $productsArray=[];
        $totalPrice = 0;
        $products = Product::query()
            ->whereIn('id',$data->productsIds)
            ->get();


        foreach ($data->productsIds as $productId) {
            /** @var Product $product */
            $product = $products->firstWhere(fn (Product $product) => $product->id === $productId);
            $productsArray[] = $product;
            $totalPrice += $product->price;
        }
        $basket->products = $productsArray;
        $basket->totalPrice = $totalPrice;

        $basket->save();

        return response()->json(ProductDto::from($basket));
    }
}
