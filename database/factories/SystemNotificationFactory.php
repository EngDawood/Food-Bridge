<?php

namespace Database\Factories;

use App\Models\SystemNotification;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SystemNotification>
 */
class SystemNotificationFactory extends Factory
{
    protected $model = SystemNotification::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'message' => fake()->sentence(10),
            'type' => fake()->randomElement(['match', 'update', 'alert']),
            'is_read' => fake()->boolean(30),
        ];
    }
}


