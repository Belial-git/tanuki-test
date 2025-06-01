<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Basket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BasketFactory extends Factory
{
    protected $model = Basket::class;

    public function definition(): array
    {
        return [
            'userId' => User::factory(),
            'products' => $this->faker->optional(0.8)->randomElements([
                ['id' => 1, 'quantity' => 2],
                ['id' => 2, 'quantity' => 1],
                ['id' => 3, 'quantity' => 3],
            ], $this->faker->numberBetween(1, 3)),
            'totalPrice' => $this->faker->optional(0.9)->randomFloat(2, 50, 500),
        ];
    }

    public function empty(): static
    {
        return $this->state(fn (array $attributes) => [
            'products' => null,
            'totalPrice' => null,
        ]);
    }

    public function withoutUser(): static
    {
        return $this->state(fn (array $attributes) => [
            'userId' => null,
        ]);
    }
}
