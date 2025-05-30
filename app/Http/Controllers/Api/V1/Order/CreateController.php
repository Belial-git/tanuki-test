<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Order;

use App\Dto\Request\OrderRequestDto;
use App\Dto\Response\OrderDto;
use App\Enums\DiscountType;
use App\Enums\StatusType;
use App\Facades\Utils\PhoneNumberNormalizer;
use App\Http\Controllers\Controller;
use App\Models\Basket;
use App\Models\Discount;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;
use Random\RandomException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class CreateController extends Controller
{
    #[
        OA\Post(
            path: '/api/v1/orders',
            operationId: 'Create order',
            description: 'Создать заказ',
            requestBody: new OA\RequestBody(content: new OA\JsonContent(ref: OrderRequestDto::class)),
            tags: ['Order'],
            responses: [
                new OA\Response(
                    response: 200,
                    description: 'Success response',
                    content: new OA\JsonContent(ref: OrderDto::class)
                ),
            ]
        )

    ]
    public function __invoke(OrderRequestDto $data): JsonResponse
    {
        $totalPrice = 0;
        $order = new Order();
        if ($data->userId) {
            $user = User::query()->where('id', $data->userId)->first();
            $order->userId = $user->id;
            $order->phone = PhoneNumberNormalizer::normalize($user->phone);
            $order->address = $user->address;
            $order->status = StatusType::CREATED->value;
        }

        $basket = Basket::query()->where('id', $data->basketId)->first();
        $totalPrice = $basket->totalPrice;

        $order->phone = PhoneNumberNormalizer::normalize($data->phone);
        $order->address = $data->address;
        $order->status = StatusType::CREATED->value;

        if ($totalPrice < 1000) {
            throw new BadRequestHttpException('Минимальная сумма заказа 1000р');
        }

        if ($totalPrice > 2000) {
            $discount = Discount::query()->where('condition', '>=', $totalPrice)->first();
            $discountSum = ($totalPrice * $discount->discountPercent) / 100;
            $order->discount = $discountSum;
            $order->finalPrice = $totalPrice - $discountSum;
        }
        if ($totalPrice > 2000) {
            $discount = Discount::query()
                ->where('type', DiscountType::SUM->value)
                ->where('condition', '<=', $totalPrice)
                ->first();
            $discountSum = ($totalPrice * $discount->discountPercent) / 100;
            $order->discount = $discountSum;
            $order->finalPrice = $totalPrice - $discountSum;
        }
        if ($data->promoCode) {
            $discount = Discount::query()
                ->where('type', DiscountType::CODE->value)
                ->where('condition', $data->promoCode)->first();
            $discountSum = ($totalPrice * $discount->discountPercent) / 100;
            $order->discount = $discountSum;
            $order->finalPrice = $totalPrice - $discountSum;
        }

        $order->userId = $data->userId ?? random_int(1000,100000);
        $order->basketId = $data->basketId;

        $order->save();

        return response()->json(OrderDto::from([
            'id' => $order->id,
            'status' => $order->status,
            'finalPrice' => $order->finalPrice,
            'discount' => $order->discount,
        ]));
    }
}
