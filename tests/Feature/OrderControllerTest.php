<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Basket;
use App\Models\Discount;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Enums\DiscountType;
use App\Enums\StatusType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_orders_endpoint_requires_user_parameter(): void
    {
        $product = Product::factory()->create(['price' => 1500.00]);
        $basket = Basket::factory()->create([
            'user_id' => 1,
            'products' => [$product->toArray()],
            'total_price' => 1500.00,
        ]);

        Order::factory()->create([
            'user_id' => 1,
            'basket_id' => $basket->id,
            'address' => 'Тестовый адрес 1',
            'phone' => '+79001234567',
            'status' => StatusType::CREATED->value,
            'discount' => 0,
            'final_price' => 1500.00,
        ]);

        $response = $this->getJson('/api/v1/orders');

        $response->assertStatus(Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function test_create_order_fails_with_minimum_amount_validation(): void
    {
        $product = Product::factory()->create(['price' => 500.00]);
        $basket = Basket::factory()->create([
            'user_id' => 1,
            'products' => [$product->toArray()],
            'total_price' => 500.00,
        ]);

        $orderData = [
            'basketId' => $basket->id,
            'address' => 'Тестовый адрес',
            'phone' => '+79001234567',
            'firstName' => 'Иван',
            'lastName' => 'Иванов',
            'patronymic' => 'Иванович',
        ];

        $response = $this->postJson('/api/v1/orders', $orderData);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    public function test_create_order_applies_discount_for_large_amount(): void
    {
        Discount::factory()->create([
            'type' => DiscountType::SUM->value,
            'condition' => 2000,
            'discountPercent' => 10,
        ]);

        $product = Product::factory()->create(['price' => 2500.00]);
        $basket = Basket::factory()->create([
            'user_id' => 1,
            'products' => [$product->toArray()],
            'total_price' => 2500.00,
        ]);

        $orderData = [
            'basketId' => $basket->id,
            'address' => 'Тестовый адрес',
            'phone' => '+79001234567',
            'firstName' => 'Иван',
            'lastName' => 'Иванов',
            'patronymic' => 'Иванович',
        ];

        $response = $this->postJson('/api/v1/orders', $orderData);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'discount' => 250.00,
                'finalPrice' => 2250.00,
            ]);
    }

    public function test_create_order_applies_promo_code_discount(): void
    {
        Discount::factory()->create([
            'type' => DiscountType::CODE->value,
            'condition' => 'PROMO10',
            'discountPercent' => 15,
        ]);

        $product = Product::factory()->create(['price' => 1500.00]);
        $basket = Basket::factory()->create([
            'user_id' => 1,
            'products' => [$product->toArray()],
            'total_price' => 1500.00,
        ]);

        $orderData = [
            'basketId' => $basket->id,
            'address' => 'Тестовый адрес',
            'phone' => '+79001234567',
            'firstName' => 'Иван',
            'lastName' => 'Иванов',
            'patronymic' => 'Иванович',
            'promoCode' => 'PROMO10',
        ];

        $response = $this->postJson('/api/v1/orders', $orderData);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'discount' => 225.00,
                'finalPrice' => 1275.00,
            ]);
    }

    public function test_create_order_validation_fails_with_missing_required_fields(): void
    {
        $response = $this->postJson('/api/v1/orders', []);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_create_order_validation_fails_with_invalid_basket_id(): void
    {
        $orderData = [
            'basketId' => 999,
            'address' => 'Тестовый адрес',
            'phone' => '+79001234567',
            'firstName' => 'Иван',
            'lastName' => 'Иванов',
            'patronymic' => 'Иванович',
        ];

        $response = $this->postJson('/api/v1/orders', $orderData);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_can_delete_order(): void
    {
        $product = Product::factory()->create(['price' => 1500.00]);
        $basket = Basket::factory()->create([
            'user_id' => 1,
            'products' => [$product->toArray()],
            'total_price' => 1500.00,
        ]);

        $order = Order::factory()->create([
            'user_id' => 1,
            'basket_id' => $basket->id,
            'address' => 'Тестовый адрес',
            'phone' => '+79001234567',
            'status' => StatusType::CREATED->value,
            'discount' => 0,
            'final_price' => 1500.00,
        ]);

        $response = $this->deleteJson("/api/v1/orders/{$order->id}");

        $response->assertStatus(Response::HTTP_NO_CONTENT);
        $this->assertDatabaseMissing('orders', ['id' => $order->id]);
    }

    public function test_delete_order_with_nonexistent_id_causes_error(): void
    {
        $response = $this->deleteJson('/api/v1/orders/999');

        $response->assertStatus(Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
