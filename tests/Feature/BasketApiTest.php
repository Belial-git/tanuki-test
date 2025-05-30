<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Basket;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BasketApiTest extends TestCase
{
    use RefreshDatabase;

    public function testCanDeleteBasket(): void
    {
        $user = User::factory()->create();
        $basket = Basket::factory()->create(['userId' => $user->id]);

        $response = $this->deleteJson("/api/v1/basket/{$basket->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('baskets', ['id' => $basket->id]);
    }
}
