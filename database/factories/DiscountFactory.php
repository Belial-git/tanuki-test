<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Discount;
use Illuminate\Database\Eloquent\Factories\Factory;

class DiscountFactory extends Factory
{
    protected $model = Discount::class;

    public function definition(): array
    {
        $isPercentage = $this->faker->boolean();

        return [
            'type' => $this->faker->randomElement(['percentage', 'fixed', 'promo_code']),
            'condition' => $this->faker->randomElement(['min_amount', 'first_order', 'category']),
            'discountSum' => $isPercentage ? null : $this->faker->numberBetween(50, 500),
            'discountPercent' => $isPercentage ? $this->faker->numberBetween(5, 50) : null,
        ];
    }

    public function percentage(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'percentage',
            'discountSum' => null,
            'discountPercent' => $this->faker->numberBetween(5, 50),
        ]);
    }

    public function fixed(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'fixed',
            'discountSum' => $this->faker->numberBetween(50, 500),
            'discountPercent' => null,
        ]);
    }

    public function promoCode(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'promo_code',
        ]);
    }
}
