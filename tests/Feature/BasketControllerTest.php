<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Basket;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class BasketControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_baskets_endpoint_requires_user_parameter(): void
    {
        $product = Product::factory()->create(['price' => 100.00]);
        $basket = Basket::factory()->create([
            'user_id' => 1,
            'products' => [$product->toArray()],
            'total_price' => 100.00,
        ]);

        $response = $this->getJson("/api/v1/baskets?id={$basket->id}");

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'id',
                'userId',
                'products',
                'totalPrice',
            ]);
    }

    public function test_can_create_basket_with_products(): void
    {
        $product1 = Product::factory()->create(['price' => 150.00]);
        $product2 = Product::factory()->create(['price' => 250.00]);

        $basketData = [
            'userId' => 1,
            'productsIds' => [$product1->id, $product2->id],
        ];

        $response = $this->postJson('/api/v1/baskets', $basketData);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'id',
                'userId',
                'products',
                'totalPrice',
            ])
            ->assertJson([
                'userId' => 1,
                'totalPrice' => 400.00,
            ]);

        $this->assertDatabaseHas('baskets', [
            'user_id' => 1,
            'total_price' => 400.00,
        ]);
    }

    public function test_create_basket_validation_fails_with_invalid_product_ids(): void
    {
        $basketData = [
            'userId' => 1,
            'productsIds' => [999, 998],
        ];

        $response = $this->postJson('/api/v1/baskets', $basketData);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_create_basket_validation_fails_with_missing_required_fields(): void
    {
        $response = $this->postJson('/api/v1/baskets', []);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_can_update_basket(): void
    {
        $product1 = Product::factory()->create(['price' => 100.00]);
        $product2 = Product::factory()->create(['price' => 200.00]);
        $product3 = Product::factory()->create(['price' => 300.00]);

        $basket = Basket::factory()->create([
            'userId' => 1,
            'products' => [$product1->toArray()],
            'totalPrice' => 100.00,
        ]);

        $updateData = [
            'userId' => 1,
            'productsIds' => [$product2->id, $product3->id],
        ];

        $response = $this->patchJson("/api/v1/baskets/{$basket->id}", $updateData);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'id',
            ]);

        $this->assertDatabaseHas('baskets', [
            'id' => $basket->id,
            'user_id' => 1,
            'total_price' => 500.00,
        ]);
    }

    public function test_update_basket_returns_404_when_basket_not_found(): void
    {
        $product = Product::factory()->create();
        $updateData = [
            'userId' => 1,
            'productsIds' => [$product->id],
        ];

        $response = $this->patchJson('/api/v1/baskets/999', $updateData);

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_can_delete_basket(): void
    {
        $product = Product::factory()->create();
        $basket = Basket::factory()->create([
            'userId' => 1,
            'products' => [$product->toArray()],
            'totalPrice' => 100.00,
        ]);

        $response = $this->deleteJson("/api/v1/baskets/{$basket->id}");

        $response->assertStatus(Response::HTTP_NO_CONTENT);
        $this->assertDatabaseMissing('baskets', ['id' => $basket->id]);
    }

    public function test_delete_basket_with_nonexistent_id_causes_error(): void
    {
        $response = $this->deleteJson('/api/v1/baskets/999');

        $response->assertStatus(Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function test_create_basket_calculates_total_price_correctly(): void
    {
        $product1 = Product::factory()->create(['price' => 99.99]);
        $product2 = Product::factory()->create(['price' => 149.99]);
        $product3 = Product::factory()->create(['price' => 49.99]);

        $basketData = [
            'userId' => 1,
            'productsIds' => [$product1->id, $product2->id, $product3->id],
        ];

        $response = $this->postJson('/api/v1/baskets', $basketData);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'totalPrice' => 299.97,
            ]);
    }

    public function test_create_basket_with_duplicate_product_ids(): void
    {
        $product = Product::factory()->create(['price' => 100.00]);

        $basketData = [
            'userId' => 1,
            'productsIds' => [$product->id, $product->id, $product->id],
        ];

        $response = $this->postJson('/api/v1/baskets', $basketData);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'totalPrice' => 300.00,
            ]);
    }
}
