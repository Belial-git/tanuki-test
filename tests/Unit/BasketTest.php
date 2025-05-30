<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Dto\Request\BasketRequestDto;
use App\Dto\Response\BasketDto;
use App\Dto\Response\ProductDto;
use App\Models\Basket;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\LaravelData\DataCollection;
use Tests\TestCase;

class BasketTest extends TestCase
{
    use RefreshDatabase;

    public function testBasketHasCorrectFillableFields(): void
    {
        $basket = new Basket();
        $fillable = ['userId', 'products', 'totalPrice', 'user_id', 'total_price'];
        $this->assertEquals($fillable, $basket->getFillable());
    }

    public function testBasketCanBeCreatedFromDto(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $productDto = ProductDto::from($product);
        $products = new DataCollection(ProductDto::class, [$productDto]);

        $basketDto = BasketRequestDto::from([
            'userId' => $user->id,
            'products' => $products
        ]);

        $basket = Basket::create([
            'userId' => $basketDto->userId,
            'products' => $basketDto->products->toArray(),
            'totalPrice' => 100.0
        ]);

        $this->assertInstanceOf(Basket::class, $basket);
        $this->assertEquals($basketDto->userId, $basket->userId);
        $this->assertIsArray($basket->products);
        $this->assertCount(1, $basket->products);
    }

    public function testBasketCanBeConvertedToResponseDto(): void
    {
        $user = User::factory()->create();
        $basket = Basket::factory()->create(['userId' => $user->id]);

        $responseDto = BasketDto::from($basket);

        $this->assertInstanceOf(BasketDto::class, $responseDto);
        $this->assertEquals($basket->id, $responseDto->id);
        $this->assertEquals($basket->userId, $responseDto->userId);
    }

    public function testBasketCanHaveProducts(): void
    {
        $basket = Basket::factory()->create([
            'products' => [
                ['id' => 1, 'quantity' => 2],
                ['id' => 2, 'quantity' => 1]
            ]
        ]);

        $this->assertIsArray($basket->products);
        $this->assertCount(2, $basket->products);
        $this->assertEquals(1, $basket->products[0]['id']);
        $this->assertEquals(2, $basket->products[0]['quantity']);
    }
}
