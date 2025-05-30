<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_all_products(): void
    {
        Product::factory()->create([
            'title' => 'Тест Продукт 1',
            'description' => 'Описание продукта 1',
            'price' => 100.50,
            'isStopped' => false,
        ]);

        Product::factory()->create([
            'title' => 'Тест Продукт 2',
            'description' => 'Описание продукта 2',
            'price' => 200.75,
            'isStopped' => true,
        ]);

        $response = $this->getJson('/api/v1/products');

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonCount(2)
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'title',
                    'description',
                    'price',
                    'isStopped',
                ]
            ])
            ->assertJsonFragment([
                'title' => 'Тест Продукт 1',
                'description' => 'Описание продукта 1',
                'price' => 100.50,
                'isStopped' => false,
            ])
            ->assertJsonFragment([
                'title' => 'Тест Продукт 2',
                'description' => 'Описание продукта 2',
                'price' => 200.75,
                'isStopped' => true,
            ]);
    }

    public function test_can_get_product_by_id(): void
    {
        $product = Product::factory()->create([
            'title' => 'Тестовый Продукт',
            'description' => 'Описание тестового продукта',
            'price' => 150.25,
            'isStopped' => false,
        ]);

        $response = $this->getJson("/api/v1/products/{$product->id}");

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'id',
                'title',
                'description',
                'price',
                'isStopped',
            ])
            ->assertJson([
                'id' => $product->id,
                'title' => 'Тестовый Продукт',
                'description' => 'Описание тестового продукта',
                'price' => 150.25,
                'isStopped' => false,
            ]);
    }

    public function test_returns_404_when_product_not_found(): void
    {
        $response = $this->getJson('/api/v1/products/999');

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_can_create_product(): void
    {
        $productData = [
            'title' => 'Новый Продукт',
            'description' => 'Описание нового продукта',
            'price' => 250.99,
        ];

        $response = $this->postJson('/api/v1/products', $productData);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'id',
                'title',
                'description',
                'price',
            ])
            ->assertJson([
                'title' => 'Новый Продукт',
                'description' => 'Описание нового продукта',
                'price' => 250.99,
            ]);

        $this->assertDatabaseHas('products', [
            'title' => 'Новый Продукт',
            'description' => 'Описание нового продукта',
            'price' => 250.99,
            'is_stopped' => false,
        ]);
    }

    public function test_create_product_validation_fails_with_missing_required_fields(): void
    {
        $response = $this->postJson('/api/v1/products', []);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_create_product_validation_fails_with_invalid_price(): void
    {
        $productData = [
            'title' => 'Тестовый Продукт',
            'description' => 'Описание',
            'price' => 'invalid_price',
        ];

        $response = $this->postJson('/api/v1/products', $productData);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_can_update_product(): void
    {
        $product = Product::factory()->create([
            'title' => 'Старое название',
            'description' => 'Старое описание',
            'price' => 100.00,
            'isStopped' => false,
        ]);

        $updateData = [
            'title' => 'Новое название',
            'description' => 'Новое описание',
            'price' => 150.50,
        ];

        $response = $this->patchJson("/api/v1/products/{$product->id}", $updateData);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'id' => $product->id,
                'title' => 'Новое название',
                'description' => 'Новое описание',
                'price' => 150.50,
            ]);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'title' => 'Новое название',
            'description' => 'Новое описание',
            'price' => 150.50,
        ]);
    }

    public function test_update_product_returns_404_when_product_not_found(): void
    {
        $updateData = [
            'title' => 'Новое название',
            'description' => 'Новое описание',
            'price' => 150.50,
        ];

        $response = $this->patchJson('/api/v1/products/999', $updateData);

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_can_delete_product(): void
    {
        $product = Product::factory()->create();

        $response = $this->deleteJson("/api/v1/products/{$product->id}");

        $response->assertStatus(Response::HTTP_NO_CONTENT);
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    public function test_delete_product_with_nonexistent_id_causes_error(): void
    {
        $response = $this->deleteJson('/api/v1/products/999');

        $response->assertStatus(Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
