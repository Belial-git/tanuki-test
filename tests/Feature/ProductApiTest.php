<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductApiTest extends TestCase
{
    use RefreshDatabase;

    public function testCanGetAllProducts(): void
    {
        Product::factory()->count(3)->create();

        $response = $this->getJson('/api/v1/product');

        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'title',
                    'description',
                    'price',
                    'isStopped'
                ]
            ]);
    }

    public function testCanGetProductById(): void
    {
        $product = Product::factory()->create();

        $response = $this->getJson("/api/v1/product/{$product->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'title',
                'description',
                'price',
                'isStopped'
            ]);
    }

    public function testCanUpdateProduct(): void
    {
        $product = Product::factory()->create();
        $updateData = [
            'title' => 'Updated Product',
            'description' => 'Updated Description',
            'price' => 149.99
        ];

        $response = $this->patchJson("/api/v1/product/{$product->id}", $updateData);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'title',
                'description',
                'price',
                'isStopped'
            ]);

        $this->assertDatabaseHas('products', [
            'title' => 'Updated Product',
            'description' => 'Updated Description',
            'price' => 149.99
        ]);
    }
}
