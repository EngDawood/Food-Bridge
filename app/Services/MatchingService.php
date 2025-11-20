<?php

namespace App\Services;

use App\Helpers\FoodTypes;
use App\Models\DeliveryTask;
use App\Models\Donation;
use App\Models\FoodRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MatchingService
{
    protected NotificationService $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Find and match suitable requests for a donation using flexible matching strategies.
     */
    public function matchDonation(Donation $donation): ?FoodRequest
    {
        // Only match pending donations
        if ($donation->status !== 'pending') {
            Log::info("Cannot match donation {$donation->id}: status is '{$donation->status}', expected 'pending'");
            return null;
        }

        $matches = $this->findMatchingRequests($donation, 1);

        if ($matches->isEmpty()) {
            return null;
        }

        // Get the best match
        $bestMatch = $matches->first();
        $request = $bestMatch['request'];
        
        // Log the match details
        if (config('matching.debug.enabled')) {
            Log::channel(config('matching.debug.log_channel'))->info("Match found for donation {$donation->id}", [
                'request_id' => $request->id,
                'score' => $bestMatch['score'],
                'details' => $bestMatch['details'] ?? []
            ]);
        }

        // Create the match
        return $this->createMatch($donation, $request);
    }

    /**
     * Find and match suitable donations for a request using flexible matching strategies.
     */
    public function matchRequest(FoodRequest $request): ?Donation
    {
        // Only match pending requests
        if ($request->status !== 'pending') {
            Log::info("Cannot match request {$request->id}: status is '{$request->status}', expected 'pending'");
            return null;
        }

        $matches = $this->findMatchingDonations($request, 1);

        if ($matches->isEmpty()) {
            return null;
        }

        // Get the best match
        $bestMatch = $matches->first();
        $donation = $bestMatch['donation'];

        // Log the match details
        if (config('matching.debug.enabled')) {
            Log::channel(config('matching.debug.log_channel'))->info("Match found for request {$request->id}", [
                'donation_id' => $donation->id,
                'score' => $bestMatch['score'],
                'details' => $bestMatch['details'] ?? []
            ]);
        }

        // Create the match
        $this->createMatch($donation, $request);

        return $donation;
    }

    /**
     * Create a match between donation and request
     */
    protected function createMatch(Donation $donation, FoodRequest $request): FoodRequest
    {
        try {
            DB::transaction(function () use ($donation, $request) {
                // Ensure sufficient remaining quantity
                $available = $donation->remaining_quantity ?? $donation->quantity;
                if ($available < $request->quantity) {
                    // In flexible matching, we might allow partial fulfillment in the future,
                    // but for now we enforce availability check again to be safe
                    throw new \RuntimeException('Insufficient remaining quantity');
                }

                // Decrement remaining quantity and schedule donation
                $donation->remaining_quantity = $available - $request->quantity;
                $donation->status = 'scheduled';
                $donation->save();

                // Update request with donation link
                $request->update([
                    'donation_id' => $donation->id,
                    'status' => 'matched',
                    'matched_at' => now(),
                ]);

                // Send notifications
                try {
                    $this->notificationService->notifyMatch($donation, $request);
                } catch (\Exception $e) {
                    Log::error("Failed to send match notifications: " . $e->getMessage());
                }

                // Create delivery task
                $task = $this->createDeliveryTask($donation, $request);
                if (!$task) {
                    Log::warning("Failed to create delivery task for donation {$donation->id} and request {$request->id}");
                }
            });

            Log::info("Successfully created match between donation {$donation->id} and request {$request->id}");
        } catch (\RuntimeException $e) {
            Log::error("Match creation failed: " . $e->getMessage());
            throw $e;
        } catch (\Exception $e) {
            Log::error("Unexpected error in createMatch: " . $e->getMessage());
            throw new \RuntimeException("Failed to create match: " . $e->getMessage());
        }

        return $request;
    }

    /**
     * Public API: manually create a match between a donation and a request
     */
    public function manualMatch(Donation $donation, FoodRequest $request): FoodRequest
    {
        return $this->createMatch($donation, $request);
    }

    /**
     * Find potential matching requests for a donation with scoring.
     */
    public function findMatchingRequests(Donation $donation, int $limit = 10): \Illuminate\Support\Collection
    {
        $donor = User::find($donation->donor_id);
        if (!$donor || !$donor->location) {
            return collect();
        }

        // Get all pending requests to score them
        // In a real production system with many records, we would need to filter this query more
        // but for now we'll fetch pending requests and filter in memory for flexibility
        $requests = FoodRequest::whereIn('status', ['pending'])
            ->orWhere(function ($q) use ($donation) {
                $q->where('status', 'matched')
                  ->where('donation_id', $donation->id);
            })
            ->with('beneficiary')
            ->get();

        $matches = $requests->map(function ($request) use ($donation, $donor) {
            $scoreResult = $this->calculateMatchScore($donation, $request, $donor, $request->beneficiary);
            
            return [
                'request' => $request,
                'score' => $scoreResult['total_score'],
                'details' => $scoreResult['details']
            ];
        })->filter(function ($match) {
            return $match['score'] >= config('matching.algorithm.minimum_score', 60);
        })->sortByDesc('score')->values()->take($limit);

        return $matches;
    }

    /**
     * Find potential matching donations for a request with scoring.
     */
    public function findMatchingDonations(FoodRequest $request, int $limit = 10): \Illuminate\Support\Collection
    {
        $beneficiary = User::find($request->beneficiary_id);
        if (!$beneficiary || !$beneficiary->location) {
            return collect();
        }

        // Get all pending donations
        $donations = Donation::where('status', 'pending')
            ->orWhere('id', $request->donation_id)
            ->with('donor')
            ->get();

        $matches = $donations->map(function ($donation) use ($request, $beneficiary) {
            $scoreResult = $this->calculateMatchScore($donation, $request, $donation->donor, $beneficiary);
            
            return [
                'donation' => $donation,
                'score' => $scoreResult['total_score'],
                'details' => $scoreResult['details']
            ];
        })->filter(function ($match) {
            return $match['score'] >= config('matching.algorithm.minimum_score', 60);
        })->sortByDesc('score')->values()->take($limit);

        return $matches;
    }

    /**
     * Calculate match score based on configured weights and rules.
     */
    protected function calculateMatchScore(Donation $donation, FoodRequest $request, $donor, $beneficiary): array
    {
        $weights = config('matching.score_weights');
        $details = [];
        $totalScore = 0;

        // 1. Location Score
        $locationScore = $this->calculateLocationScore($donor->location, $beneficiary->location);
        $totalScore += $locationScore * ($weights['location'] / 100);
        $details['location'] = $locationScore;

        // 2. Food Type Score
        $foodTypeScore = $this->calculateFoodTypeScore($donation->food_type, $request->food_type);
        $totalScore += $foodTypeScore * ($weights['food_type'] / 100);
        $details['food_type'] = $foodTypeScore;

        // 3. Quantity Score
        $quantityScore = $this->calculateQuantityScore(
            $donation->remaining_quantity ?? $donation->quantity, 
            $request->quantity
        );
        $totalScore += $quantityScore * ($weights['quantity'] / 100);
        $details['quantity'] = $quantityScore;

        // 4. Expiration Score
        $expirationScore = $this->calculateExpirationScore($donation->expiration_date);
        $totalScore += $expirationScore * ($weights['expiration'] / 100);
        $details['expiration'] = $expirationScore;

        return [
            'total_score' => round($totalScore),
            'details' => $details
        ];
    }

    protected function calculateLocationScore($loc1, $loc2): int
    {
        $config = config('matching.location');
        
        // Exact match
        if (strcasecmp($loc1, $loc2) === 0) {
            return $config['exact_match_score'];
        }

        if (!$config['flexible_matching']) {
            return 0;
        }

        // Check districts
        $districts = $config['districts'];
        $d1 = $this->extractDistrict($loc1, $districts);
        $d2 = $this->extractDistrict($loc2, $districts);

        if ($d1 && $d2 && $d1 === $d2) {
            return $config['same_district_score'];
        }

        return $config['different_district_score'];
    }

    protected function extractDistrict($location, $districts)
    {
        $location = strtolower($location);
        foreach ($districts as $key => $keywords) {
            foreach ($keywords as $keyword) {
                if (str_contains($location, $keyword)) {
                    return $key;
                }
            }
        }
        return null;
    }

    protected function calculateFoodTypeScore($type1, $type2): int
    {
        $config = config('matching.food_type');

        // Exact match
        if (strcasecmp($type1, $type2) === 0) {
            return $config['exact_match_score'];
        }

        if (!$config['category_matching']) {
            return 0;
        }

        // Category match
        if (FoodTypes::areSameCategory($type1, $type2)) {
            return $config['same_category_score'];
        }

        return $config['different_category_score'];
    }

    protected function calculateQuantityScore($available, $requested): int
    {
        $config = config('matching.quantity');

        if ($available >= $requested) {
            return $config['exact_match_score']; // Or over_supply_score
        }

        if (!$config['allow_partial']) {
            return 0;
        }

        $percentage = ($available / $requested) * 100;
        if ($percentage >= $config['minimum_percentage']) {
            return $config['partial_match_base_score'] + ($percentage / 2); // Bonus for higher percentage
        }

        return 0;
    }

    protected function calculateExpirationScore($expirationDate): int
    {
        // If no expiration date, neutral score
        if (!$expirationDate) return 50;

        $config = config('matching.expiration');
        $hoursUntilExpiration = now()->diffInHours($expirationDate, false);

        if ($hoursUntilExpiration < 0) return 0; // Expired

        // Urgent boost
        if ($hoursUntilExpiration <= $config['urgent_hours']) {
            return 100; // High priority
        }

        // Standard priority (inverse to time remaining, closer is better)
        // Cap at 100, min 0
        return max(0, 100 - ($hoursUntilExpiration / 2)); 
    }

    protected function createDeliveryTask(Donation $donation, FoodRequest $request): ?DeliveryTask
    {
        $donor = User::find($donation->donor_id);
        $beneficiary = User::find($request->beneficiary_id);

        if (!$donor || !$beneficiary) {
            return null;
        }

        $task = DeliveryTask::create([
            'volunteer_id' => null,
            'donation_id' => $donation->id,
            'pickup_location' => $donor->location ?? 'Not specified',
            'dropoff_location' => $beneficiary->location ?? 'Not specified',
            'status' => 'assigned',
        ]);

        Log::info("Created delivery task {$task->id} for donation {$donation->id} and request {$request->id}");

        return $task;
    }
}
