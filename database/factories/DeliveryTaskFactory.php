<?php

namespace Database\Factories;

use App\Models\DeliveryTask;
use App\Models\Donation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DeliveryTask>
 */
class DeliveryTaskFactory extends Factory
{
    protected $model = DeliveryTask::class;

    public function definition(): array
    {
        return [
            'volunteer_id' => User::factory(),
            'donation_id' => Donation::factory(),
            'pickup_location' => fake()->address(),
            'dropoff_location' => fake()->address(),
            'status' => fake()->randomElement(['assigned', 'in_progress', 'completed']),
        ];
    }
}


