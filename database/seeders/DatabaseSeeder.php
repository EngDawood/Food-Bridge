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
            'location' => 'الجوف، سكاكا',
        ]);

        // Create Donors
        $donors = [
            User::create([
                'name' => 'نورة عبدالعزيز',
                'email' => 'nora@foodbridge.sa',
                'password' => Hash::make('password'),
                'role' => 'donor',
                'location' => 'الجوف، سكاكا، حي النزهة',
            ]),
            User::create([
                'name' => 'خالد محمد',
                'email' => 'khaled@foodbridge.sa',
                'password' => Hash::make('password'),
                'role' => 'donor',
                'location' => 'الجوف، دومة الجندل',
            ]),
            User::create([
                'name' => 'مطعم الخير',
                'email' => 'alkheir@foodbridge.sa',
                'password' => Hash::make('password'),
                'role' => 'donor',
                'location' => 'الجوف، سكاكا، حي الورود',
            ]),
        ];

        // Create Beneficiaries
        $beneficiaries = [
            User::create([
                'name' => 'فاطمة أحمد',
                'email' => 'fatima@foodbridge.sa',
                'password' => Hash::make('password'),
                'role' => 'beneficiary',
                'location' => 'الجوف، سكاكا، حي النزهة',
            ]),
            User::create([
                'name' => 'عبدالله سعيد',
                'email' => 'abdullah@foodbridge.sa',
                'password' => Hash::make('password'),
                'role' => 'beneficiary',
                'location' => 'الجوف، دومة الجندل',
            ]),
            User::create([
                'name' => 'مريم حسن',
                'email' => 'maryam@foodbridge.sa',
                'password' => Hash::make('password'),
                'role' => 'beneficiary',
                'location' => 'الجوف، سكاكا، حي الصناعية',
            ]),
        ];

        // Create Volunteers
        $volunteers = [
            User::create([
                'name' => 'محمد العنزي',
                'email' => 'mohammed@foodbridge.sa',
                'password' => Hash::make('password'),
                'role' => 'volunteer',
                'location' => 'الجوف، سكاكا',
            ]),
            User::create([
                'name' => 'سارة الشمري',
                'email' => 'sara@foodbridge.sa',
                'password' => Hash::make('password'),
                'role' => 'volunteer',
                'location' => 'الجوف، دومة الجندل',
            ]),
        ];

        // Create Donations
        $donations = [
            Donation::create([
                'donor_id' => $donors[0]->id,
                'food_type' => 'وجبات مطبوخة',
                'quantity' => 10,
                'expiration_date' => now()->addDays(1),
                'pickup_time' => now()->addHours(2),
                'status' => 'pending',
            ]),
            Donation::create([
                'donor_id' => $donors[1]->id,
                'food_type' => 'خضروات طازجة',
                'quantity' => 5,
                'expiration_date' => now()->addDays(3),
                'pickup_time' => now()->addHours(4),
                'status' => 'pending',
            ]),
            Donation::create([
                'donor_id' => $donors[2]->id,
                'food_type' => 'وجبات مطبوخة',
                'quantity' => 20,
                'expiration_date' => now()->addDays(1),
                'pickup_time' => now()->addHours(3),
                'status' => 'scheduled',
            ]),
            Donation::create([
                'donor_id' => $donors[0]->id,
                'food_type' => 'فواكه طازجة',
                'quantity' => 8,
                'expiration_date' => now()->addDays(2),
                'pickup_time' => now()->addHours(5),
                'status' => 'pending',
            ]),
            Donation::create([
                'donor_id' => $donors[2]->id,
                'food_type' => 'معلبات وأطعمة معبأة',
                'quantity' => 15,
                'expiration_date' => now()->addDays(30),
                'pickup_time' => now()->addHours(6),
                'status' => 'pending',
            ]),
            Donation::create([
                'donor_id' => $donors[1]->id,
                'food_type' => 'وجبات مطبوخة',
                'quantity' => 12,
                'expiration_date' => now()->subDay(),
                'pickup_time' => now()->subHours(2),
                'status' => 'delivered',
            ]),
            Donation::create([
                'donor_id' => $donors[0]->id,
                'food_type' => 'خبز طازج',
                'quantity' => 25,
                'expiration_date' => now()->addDay(),
                'pickup_time' => now()->addHours(1),
                'status' => 'pending',
            ]),
            Donation::create([
                'donor_id' => $donors[2]->id,
                'food_type' => 'وجبات مطبوخة',
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
                'food_type' => 'وجبات مطبوخة',
                'quantity' => 5,
                'note' => 'لعائلة مكونة من 5 أفراد',
                'status' => 'pending',
            ]),
            FoodRequest::create([
                'beneficiary_id' => $beneficiaries[1]->id,
                'food_type' => 'خضروات طازجة',
                'quantity' => 3,
                'note' => 'نحتاج خضروات طازجة',
                'status' => 'pending',
            ]),
            FoodRequest::create([
                'beneficiary_id' => $beneficiaries[2]->id,
                'food_type' => 'وجبات مطبوخة',
                'quantity' => 8,
                'note' => 'عاجل - لعائلة كبيرة',
                'donation_id' => $donations[2]->id,
                'status' => 'matched',
            ]),
            FoodRequest::create([
                'beneficiary_id' => $beneficiaries[0]->id,
                'food_type' => 'فواكه طازجة',
                'quantity' => 4,
                'note' => 'للأطفال',
                'status' => 'pending',
            ]),
            FoodRequest::create([
                'beneficiary_id' => $beneficiaries[1]->id,
                'food_type' => 'معلبات وأطعمة معبأة',
                'quantity' => 10,
                'note' => 'أطعمة قابلة للتخزين',
                'status' => 'pending',
            ]),
            FoodRequest::create([
                'beneficiary_id' => $beneficiaries[2]->id,
                'food_type' => 'وجبات مطبوخة',
                'quantity' => 10,
                'note' => 'لحفل إفطار جماعي',
                'donation_id' => $donations[5]->id,
                'status' => 'fulfilled',
            ]),
            FoodRequest::create([
                'beneficiary_id' => $beneficiaries[0]->id,
                'food_type' => 'خبز طازج',
                'quantity' => 15,
                'note' => 'خبز يومي',
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
            'comment' => 'الطعام كان طازجاً وممتازاً، شكراً جزيلاً',
        ]);

        Feedback::create([
            'from_user_id' => $donors[2]->id,
            'to_user_id' => $volunteers[0]->id,
            'rating' => 5,
            'comment' => 'متطوع رائع، التوصيل كان سريعاً ومنظماً',
        ]);

        Feedback::create([
            'from_user_id' => $beneficiaries[1]->id,
            'to_user_id' => $volunteers[1]->id,
            'rating' => 4,
            'comment' => 'خدمة جيدة جداً',
        ]);

        // Create Notifications
        SystemNotification::create([
            'user_id' => $beneficiaries[0]->id,
            'message' => 'تم العثور على تبرع يطابق طلبك',
            'type' => 'match',
            'is_read' => false,
        ]);

        SystemNotification::create([
            'user_id' => $volunteers[0]->id,
            'message' => 'تم تعيينك لمهمة توصيل جديدة',
            'type' => 'alert',
            'is_read' => false,
        ]);

        SystemNotification::create([
            'user_id' => $donors[2]->id,
            'message' => 'تم مطابقة تبرعك مع طلب مستفيد',
            'type' => 'match',
            'is_read' => true,
        ]);

        SystemNotification::create([
            'user_id' => $beneficiaries[2]->id,
            'message' => 'تم تسليم طلبك بنجاح',
            'type' => 'update',
            'is_read' => false,
        ]);

        SystemNotification::create([
            'user_id' => $donors[1]->id,
            'message' => 'تلقيت تقييماً جديداً',
            'type' => 'update',
            'is_read' => false,
        ]);
    }
}
