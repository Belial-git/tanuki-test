<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use App\Models\Basket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderApiTest extends TestCase
{
    use RefreshDatabase;

    public function testCanDeleteOrder(): void
    {
        $user = User::factory()->create();
        $basket = Basket::factory()->create(['userId' => $user->id]);
        $order = Order::factory()->create(['userId' => $user->id, 'basketId' => $basket->id]);

        $response = $this->deleteJson("/api/v1/order/{$order->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('orders', ['id' => $order->id]);
    }
}
