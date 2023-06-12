<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->word,
            'quantity'=>fake()->numberBetween(1,30),
            'price' => fake()->randomFloat(2, 10, 100),
            'description' => fake()->paragraph,
            'user_id' => User::factory(),
        ];
    }
}
