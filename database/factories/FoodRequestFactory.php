<?php

namespace Database\Factories;

use App\Models\FoodRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FoodRequest>
 */
class FoodRequestFactory extends Factory
{
    protected $model = FoodRequest::class;

    public function definition(): array
    {
        return [
            'beneficiary_id' => User::factory(),
            'food_type' => fake()->randomElement(['Cooked Meal', 'Fresh Produce', 'Bakery', 'Canned Goods']),
            'quantity' => fake()->numberBetween(1, 30),
            'note' => fake()->optional()->sentence(8),
            'donation_id' => null,
            'status' => fake()->randomElement(['pending', 'matched', 'fulfilled']),
        ];
    }
}


