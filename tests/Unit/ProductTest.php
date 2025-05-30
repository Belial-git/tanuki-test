<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Dto\Request\ProductRequestDto;
use App\Dto\Response\ProductDto;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function testProductHasCorrectFillableFields(): void
    {
        $product = new Product();
        $fillable = ['title', 'description', 'price', 'isStopped', 'is_stopped'];
        $this->assertEquals($fillable, $product->getFillable());
    }

    public function testProductCanBeCreatedFromDto(): void
    {
        $productDto = ProductRequestDto::from([
            'title' => 'Test Product',
            'description' => 'Test Description',
            'price' => 99.99
        ]);

        $product = Product::create($productDto->toArray());

        $this->assertInstanceOf(Product::class, $product);
        $this->assertEquals($productDto->title, $product->title);
        $this->assertEquals($productDto->description, $product->description);
        $this->assertEquals($productDto->price, $product->price);
    }

    public function testProductCanBeConvertedToResponseDto(): void
    {
        $product = Product::factory()->create([
            'title' => 'Test Product',
            'description' => 'Test Description',
            'price' => 99.99
        ]);

        $responseDto = ProductDto::from($product);

        $this->assertInstanceOf(ProductDto::class, $responseDto);
        $this->assertEquals($product->id, $responseDto->id);
        $this->assertEquals($product->title, $responseDto->title);
        $this->assertEquals($product->description, $responseDto->description);
        $this->assertEquals($product->price, $responseDto->price);
    }

    public function testProductPriceIsCastedToFloat(): void
    {
        $productDto = ProductRequestDto::from([
            'title' => 'Test Product',
            'description' => 'Test Description',
            'price' => '99.99'
        ]);

        $product = Product::create($productDto->toArray());

        $this->assertIsFloat($product->price);
        $this->assertEquals(99.99, $product->price);
    }
}
