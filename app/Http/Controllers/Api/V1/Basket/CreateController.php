<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Basket;

use App\Dto\Request\BasketRequestDto;
use App\Dto\Response\BasketDto;
use App\Dto\Response\ProductDto;
use App\Http\Controllers\Controller;
use App\Models\Basket;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class CreateController extends Controller
{
    #[
        OA\Post(
            path: '/api/v1/baskets',
            operationId: 'Create basket',
            description: 'Создать корзину',
            requestBody: new OA\RequestBody(content: new OA\JsonContent(ref: BasketRequestDto::class)),
            tags: ['Basket'],
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

        $basket = new Basket();
        $basket->products = $productsArray;
        $basket->userId = $data->userId;
        $basket->totalPrice = $totalPrice;
        $basket->save();

        return response()->json(BasketDto::from($basket));
    }
}
