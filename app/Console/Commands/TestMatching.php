<?php

namespace App\Console\Commands;

use App\Models\Donation;
use App\Models\FoodRequest;
use App\Models\User;
use App\Services\MatchingService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TestMatching extends Command
{
    protected $signature = 'test:matching';
    protected $description = 'Test matching logic scenarios';

    public function handle(MatchingService $matchingService)
    {
        $this->info('Starting Matching Logic Tests...');

        DB::beginTransaction();

        try {
            // Setup Users
            $donor = User::factory()->create(['role' => 'donor', 'location' => 'North District']);
            $beneficiarySame = User::factory()->create(['role' => 'beneficiary', 'location' => 'North District']);
            $beneficiaryDiff = User::factory()->create(['role' => 'beneficiary', 'location' => 'South District']);
            $beneficiaryFlex = User::factory()->create(['role' => 'beneficiary', 'location' => 'Northern Area']); // Should match 'North'

            // Test 1: Exact Location Match
            $this->info("\nTest 1: Exact Location Match");
            $donation1 = Donation::create([
                'donor_id' => $donor->id,
                'food_type' => 'bread',
                'quantity' => 10,
                'status' => 'pending',
                'expiration_date' => now()->addDays(2),
            ]);
            
            $request1 = FoodRequest::create([
                'beneficiary_id' => $beneficiarySame->id,
                'food_type' => 'bread',
                'quantity' => 10,
                'status' => 'pending',
            ]);

            $matches = $matchingService->findMatchingRequests($donation1);
            $this->assert($matches->isNotEmpty(), "Match found for exact location");
            $this->assert($matches->first()['score'] >= 100, "Score is high for exact match");

            // Test 2: Flexible Location Match
            $this->info("\nTest 2: Flexible Location Match");
            $request2 = FoodRequest::create([
                'beneficiary_id' => $beneficiaryFlex->id,
                'food_type' => 'bread',
                'quantity' => 10,
                'status' => 'pending',
            ]);

            $matches = $matchingService->findMatchingRequests($donation1);
            // Filter for our specific request
            $match = $matches->firstWhere('request.id', $request2->id);
            $this->assert($match !== null, "Match found for flexible location");
            if ($match) {
                $this->info("Flexible match score: " . $match['score']);
            }

            // Test 3: Different Location (Should fail or have low score)
            $this->info("\nTest 3: Different Location");
            $request3 = FoodRequest::create([
                'beneficiary_id' => $beneficiaryDiff->id,
                'food_type' => 'bread',
                'quantity' => 10,
                'status' => 'pending',
            ]);

            $matches = $matchingService->findMatchingRequests($donation1);
            $match = $matches->firstWhere('request.id', $request3->id);
            $this->assert($match === null || $match['score'] < 60, "No match or low score for different location");

            // Test 4: Food Category Match
            $this->info("\nTest 4: Food Category Match");
            $donation2 = Donation::create([
                'donor_id' => $donor->id,
                'food_type' => 'bread', // Category: bakery
                'quantity' => 10,
                'status' => 'pending',
                'expiration_date' => now()->addDays(2),
            ]);

            $request4 = FoodRequest::create([
                'beneficiary_id' => $beneficiarySame->id,
                'food_type' => 'pastries', // Category: bakery
                'quantity' => 10,
                'status' => 'pending',
            ]);

            $matches = $matchingService->findMatchingRequests($donation2);
            $match = $matches->firstWhere('request.id', $request4->id);
            $this->assert($match !== null, "Match found for same food category");
            if ($match) {
                $this->info("Category match score: " . $match['score']);
            }

            // Test 5: Quantity Partial Match
            $this->info("\nTest 5: Quantity Partial Match");
            $donation3 = Donation::create([
                'donor_id' => $donor->id,
                'food_type' => 'bread',
                'quantity' => 8, // 80% of requested
                'status' => 'pending',
                'expiration_date' => now()->addDays(2),
            ]);

            $request5 = FoodRequest::create([
                'beneficiary_id' => $beneficiarySame->id,
                'food_type' => 'bread',
                'quantity' => 10,
                'status' => 'pending',
            ]);

            $matches = $matchingService->findMatchingRequests($donation3);
            $match = $matches->firstWhere('request.id', $request5->id);
            $this->assert($match !== null, "Match found for partial quantity (80%)");
            if ($match) {
                $this->info("Partial quantity match score: " . $match['score']);
            }

        } catch (\Exception $e) {
            $this->error("Test failed: " . $e->getMessage());
            $this->error($e->getTraceAsString());
        } finally {
            DB::rollBack();
            $this->info("\nTests completed (Database transactions rolled back).");
        }
    }

    private function assert($condition, $message)
    {
        if ($condition) {
            $this->info("PASS: $message");
        } else {
            $this->error("FAIL: $message");
        }
    }
}
