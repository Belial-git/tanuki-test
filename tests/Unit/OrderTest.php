<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Dto\Request\OrderRequestDto;
use App\Dto\Response\OrderDto;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Basket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function testOrderHasCorrectFillableFields(): void
    {
        $order = new Order();
        $fillable = ['basketId', 'userId', 'address', 'phone', 'status', 'discount', 'finalPrice', 'basket_id', 'user_id', 'final_price'];
        $this->assertEquals($fillable, $order->getFillable());
    }

    public function testOrderCanBeCreatedFromDtoWithUserId(): void
    {
        $user = User::factory()->create();
        $basket = Basket::factory()->create(['userId' => $user->id]);

        $orderDto = OrderRequestDto::from([
            'userId' => $user->id,
            'basketId' => null,
            'address' => null,
            'phone' => null,
            'lastName' => null,
            'firstName' => null,
            'patronymic' => null,
            'promoCode' => null
        ]);

        $order = Order::create([
            'userId' => $orderDto->userId,
            'basketId' => $basket->id,
            'address' => 'Test Address',
            'phone' => '+79991234567',
            'status' => 'pending',
            'discount' => 0.0,
            'finalPrice' => 199.99
        ]);

        $this->assertInstanceOf(Order::class, $order);
        $this->assertEquals($orderDto->userId, $order->userId);
        $this->assertEquals('pending', $order->status);
        $this->assertEquals(0.0, $order->discount);
        $this->assertEquals(199.99, $order->finalPrice);
    }

    public function testOrderCanBeCreatedFromDtoWithoutUserId(): void
    {
        $user = User::factory()->create();
        $basket = Basket::factory()->create(['userId' => $user->id]);

        $orderDto = OrderRequestDto::from([
            'basketId' => $basket->id,
            'address' => 'Test Address',
            'phone' => '+79991234567',
            'lastName' => 'Test',
            'firstName' => 'User',
            'patronymic' => 'Middle',
            'promoCode' => null
        ]);

        $order = Order::create([
            'userId' => $user->id,
            'basketId' => $orderDto->basketId,
            'address' => $orderDto->address,
            'phone' => $orderDto->phone,
            'status' => 'pending',
            'discount' => 0.0,
            'finalPrice' => 199.99
        ]);

        $this->assertInstanceOf(Order::class, $order);
        $this->assertEquals($orderDto->basketId, $order->basketId);
        $this->assertEquals($orderDto->address, $order->address);
        $this->assertEquals($orderDto->phone, $order->phone);
        $this->assertEquals('pending', $order->status);
    }

    public function testOrderCanBeConvertedToResponseDto(): void
    {
        $user = User::factory()->create();
        $basket = Basket::factory()->create(['userId' => $user->id]);
        $order = Order::factory()->create(['userId' => $user->id, 'basketId' => $basket->id]);

        $responseDto = OrderDto::from($order);

        $this->assertInstanceOf(OrderDto::class, $responseDto);
        $this->assertEquals($order->id, $responseDto->id);
        $this->assertEquals($order->status, $responseDto->status);
        $this->assertEquals($order->discount, $responseDto->discount);
        $this->assertEquals($order->finalPrice, $responseDto->finalPrice);
    }
}
