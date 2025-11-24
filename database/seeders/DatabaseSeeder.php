<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Donation;
use App\Models\FoodRequest;
use App\Models\DeliveryTask;
use App\Models\Feedback;
use App\Models\SystemNotification;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@foodbridge.sa',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'location' => 'Al-Jouf, Sakaka',
        ]);

        // Create Donors
        $donors = [
            User::create([
                'name' => 'Nora Abdulaziz',
                'email' => 'nora@foodbridge.sa',
                'password' => Hash::make('password'),
                'role' => 'donor',
                'location' => 'Al-Jouf, Sakaka, Al-Nuzha District',
            ]),
            User::create([
                'name' => 'Khaled Mohammed',
                'email' => 'khaled@foodbridge.sa',
                'password' => Hash::make('password'),
                'role' => 'donor',
                'location' => 'Al-Jouf, Dumat Al-Jandal',
            ]),
            User::create([
                'name' => 'Al-Khair Restaurant',
                'email' => 'alkheir@foodbridge.sa',
                'password' => Hash::make('password'),
                'role' => 'donor',
                'location' => 'Al-Jouf, Sakaka, Al-Wurud District',
            ]),
        ];

        // Create Beneficiaries
        $beneficiaries = [
            User::create([
                'name' => 'Fatima Ahmed',
                'email' => 'fatima@foodbridge.sa',
                'password' => Hash::make('password'),
                'role' => 'beneficiary',
                'location' => 'Al-Jouf, Sakaka, Al-Nuzha District',
            ]),
            User::create([
                'name' => 'Abdullah Saeed',
                'email' => 'abdullah@foodbridge.sa',
                'password' => Hash::make('password'),
                'role' => 'beneficiary',
                'location' => 'Al-Jouf, Dumat Al-Jandal',
            ]),
            User::create([
                'name' => 'Maryam Hassan',
                'email' => 'maryam@foodbridge.sa',
                'password' => Hash::make('password'),
                'role' => 'beneficiary',
                'location' => 'Al-Jouf, Sakaka, Industrial District',
            ]),
        ];

        // Create Volunteers
        $volunteers = [
            User::create([
                'name' => 'Mohammed Al-Anazi',
                'email' => 'mohammed@foodbridge.sa',
                'password' => Hash::make('password'),
                'role' => 'volunteer',
                'location' => 'Al-Jouf, Sakaka',
            ]),
            User::create([
                'name' => 'Sara Al-Shammari',
                'email' => 'sara@foodbridge.sa',
                'password' => Hash::make('password'),
                'role' => 'volunteer',
                'location' => 'Al-Jouf, Dumat Al-Jandal',
            ]),
        ];

        // Create Donations
        $donations = [
            Donation::create([
                'donor_id' => $donors[0]->id,
                'food_type' => 'cooked',
                'quantity' => 10,
                'expiration_date' => now()->addDays(1),
                'pickup_time' => now()->addHours(2),
                'status' => 'pending',
            ]),
            Donation::create([
                'donor_id' => $donors[1]->id,
                'food_type' => 'vegetables',
                'quantity' => 5,
                'expiration_date' => now()->addDays(3),
                'pickup_time' => now()->addHours(4),
                'status' => 'pending',
            ]),
            Donation::create([
                'donor_id' => $donors[2]->id,
                'food_type' => 'cooked',
                'quantity' => 20,
                'expiration_date' => now()->addDays(1),
                'pickup_time' => now()->addHours(3),
                'status' => 'scheduled',
            ]),
            Donation::create([
                'donor_id' => $donors[0]->id,
                'food_type' => 'fruits',
                'quantity' => 8,
                'expiration_date' => now()->addDays(2),
                'pickup_time' => now()->addHours(5),
                'status' => 'pending',
            ]),
            Donation::create([
                'donor_id' => $donors[2]->id,
                'food_type' => 'canned',
                'quantity' => 15,
                'expiration_date' => now()->addDays(30),
                'pickup_time' => now()->addHours(6),
                'status' => 'pending',
            ]),
            Donation::create([
                'donor_id' => $donors[1]->id,
                'food_type' => 'cooked',
                'quantity' => 12,
                'expiration_date' => now()->subDay(),
                'pickup_time' => now()->subHours(2),
                'status' => 'delivered',
            ]),
            Donation::create([
                'donor_id' => $donors[0]->id,
                'food_type' => 'bread',
                'quantity' => 25,
                'expiration_date' => now()->addDay(),
                'pickup_time' => now()->addHours(1),
                'status' => 'pending',
            ]),
            Donation::create([
                'donor_id' => $donors[2]->id,
                'food_type' => 'cooked',
                'quantity' => 30,
                'expiration_date' => now()->addHours(12),
                'pickup_time' => now()->addHours(2),
                'status' => 'delivered',
            ]),
        ];

        // Create Food Requests
        $requests = [
            FoodRequest::create([
                'beneficiary_id' => $beneficiaries[0]->id,
                'food_type' => 'cooked',
                'quantity' => 5,
                'note' => 'For family of 5 members',
                'status' => 'pending',
            ]),
            FoodRequest::create([
                'beneficiary_id' => $beneficiaries[1]->id,
                'food_type' => 'vegetables',
                'quantity' => 3,
                'note' => 'We need fresh vegetables',
                'status' => 'pending',
            ]),
            FoodRequest::create([
                'beneficiary_id' => $beneficiaries[2]->id,
                'food_type' => 'cooked',
                'quantity' => 8,
                'note' => 'Urgent - for large family',
                'donation_id' => $donations[2]->id,
                'status' => 'matched',
            ]),
            FoodRequest::create([
                'beneficiary_id' => $beneficiaries[0]->id,
                'food_type' => 'fruits',
                'quantity' => 4,
                'note' => 'For children',
                'status' => 'pending',
            ]),
            FoodRequest::create([
                'beneficiary_id' => $beneficiaries[1]->id,
                'food_type' => 'canned',
                'quantity' => 10,
                'note' => 'Storable food items',
                'status' => 'pending',
            ]),
            FoodRequest::create([
                'beneficiary_id' => $beneficiaries[2]->id,
                'food_type' => 'cooked',
                'quantity' => 10,
                'note' => 'For community breakfast event',
                'donation_id' => $donations[5]->id,
                'status' => 'fulfilled',
            ]),
            FoodRequest::create([
                'beneficiary_id' => $beneficiaries[0]->id,
                'food_type' => 'bread',
                'quantity' => 15,
                'note' => 'Daily bread',
                'status' => 'pending',
            ]),
        ];

        // Create Delivery Tasks
        $tasks = [
            DeliveryTask::create([
                'volunteer_id' => $volunteers[0]->id,
                'donation_id' => $donations[2]->id,
                'pickup_location' => $donors[2]->location,
                'dropoff_location' => $beneficiaries[2]->location,
                'status' => 'assigned',
            ]),
            DeliveryTask::create([
                'volunteer_id' => $volunteers[1]->id,
                'donation_id' => $donations[5]->id,
                'pickup_location' => $donors[1]->location,
                'dropoff_location' => $beneficiaries[2]->location,
                'status' => 'completed',
            ]),
            DeliveryTask::create([
                'volunteer_id' => $volunteers[0]->id,
                'donation_id' => $donations[7]->id,
                'pickup_location' => $donors[2]->location,
                'dropoff_location' => $beneficiaries[1]->location,
                'status' => 'completed',
            ]),
        ];

        // Create Feedback
        Feedback::create([
            'from_user_id' => $beneficiaries[2]->id,
            'to_user_id' => $donors[1]->id,
            'rating' => 5,
            'comment' => 'The food was fresh and excellent, thank you very much',
        ]);

        Feedback::create([
            'from_user_id' => $donors[2]->id,
            'to_user_id' => $volunteers[0]->id,
            'rating' => 5,
            'comment' => 'Great volunteer, delivery was fast and well organized',
        ]);

        Feedback::create([
            'from_user_id' => $beneficiaries[1]->id,
            'to_user_id' => $volunteers[1]->id,
            'rating' => 4,
            'comment' => 'Very good service',
        ]);

        // Create Notifications
        SystemNotification::create([
            'user_id' => $beneficiaries[0]->id,
            'message' => 'A donation matching your request was found',
            'type' => 'match',
            'is_read' => false,
        ]);

        SystemNotification::create([
            'user_id' => $volunteers[0]->id,
            'message' => 'You have been assigned to a new delivery task',
            'type' => 'alert',
            'is_read' => false,
        ]);

        SystemNotification::create([
            'user_id' => $donors[2]->id,
            'message' => 'Your donation has been matched with a beneficiary request',
            'type' => 'match',
            'is_read' => true,
        ]);

        SystemNotification::create([
            'user_id' => $beneficiaries[2]->id,
            'message' => 'Your request has been successfully delivered',
            'type' => 'update',
            'is_read' => false,
        ]);

        SystemNotification::create([
            'user_id' => $donors[1]->id,
            'message' => 'You received new feedback',
            'type' => 'update',
            'is_read' => false,
        ]);
    }
}
