<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Basket;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'userId' => $this->faker->optional(0.8)->randomElement([User::factory(), null]),
            'basketId' => Basket::factory(),
            'address' => $this->faker->address,
            'phone' => $this->faker->phoneNumber,
            'status' => $this->faker->randomElement(['pending', 'processing', 'completed', 'cancelled']),
            'discount' => $this->faker->randomFloat(2, 0, 100),
            'finalPrice' => $this->faker->randomFloat(2, 50, 1000),
        ];
    }

    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
        ]);
    }

    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'completed',
        ]);
    }

    public function withoutUser(): static
    {
        return $this->state(fn (array $attributes) => [
            'userId' => null,
        ]);
    }

    public function withDiscount(float $discount): static
    {
        return $this->state(fn (array $attributes) => [
            'discount' => $discount,
        ]);
    }
}
