<?php

namespace Database\Factories;

use App\Models\Donation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Donation>
 */
class DonationFactory extends Factory
{
    protected $model = Donation::class;

    public function definition(): array
    {
        return [
            'donor_id' => User::factory(),
            'food_type' => fake()->randomElement(['Cooked Meal', 'Fresh Produce', 'Bakery', 'Canned Goods']),
            'quantity' => fake()->numberBetween(1, 50),
            'expiration_date' => fake()->optional()->dateTimeBetween('now', '+10 days'),
            'pickup_time' => fake()->optional()->dateTimeBetween('now', '+3 days'),
            'status' => fake()->randomElement(['pending', 'scheduled', 'delivered']),
        ];
    }
}


