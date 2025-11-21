<?php

namespace App\Services;

use App\Models\DeliveryTask;
use App\Models\Donation;
use App\Models\FoodRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class MatchingService
{
    protected NotificationService $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Find and match suitable requests for a donation using flexible matching.
     *
     * Matching rules:
     * 1. Food type match (exact or same category)
     * 2. Sufficient quantity available
     * 3. Location match (exact or same district)
     *
     * Tie-breaking: Highest match score, then first-come-first-served
     */
    public function matchDonation(Donation $donation): ?FoodRequest
    {
        // Only match pending donations
        if ($donation->status !== 'pending') {
            \Log::info("Cannot match donation {$donation->id}: status is '{$donation->status}', expected 'pending'");
            return null;
        }

        // Get donor location
        $donor = User::find($donation->donor_id);
        if (!$donor) {
            \Log::error("Donor not found for donation {$donation->id}");
            return null;
        }

        if (!$donor->location) {
            \Log::warning("Donor {$donor->id} has no location set for donation {$donation->id}");
            return null;
        }

        // Find all potential matching requests
        $potentialRequests = FoodRequest::where('status', 'pending')
            ->where('quantity', '<=', $donation->remaining_quantity ?? $donation->quantity)
            ->with('beneficiary')
            ->get();

        // Score each request and find the best match
        $bestMatch = null;
        $bestScore = config('matching.algorithm.minimum_score', 60);

        foreach ($potentialRequests as $request) {
            $score = $this->calculateMatchScore($donation, $request, $donor, $request->beneficiary);

            if ($score >= $bestScore) {
                $bestScore = $score;
                $bestMatch = $request;
            }
        }

        if (!$bestMatch) {
            return null;
        }

        // Create the match
        return $this->createMatch($donation, $bestMatch);
    }

    /**
     * Find and match suitable donations for a request using flexible matching.
     *
     * Matching rules:
     * 1. Food type match (exact or same category)
     * 2. Sufficient quantity available
     * 3. Location match (exact or same district)
     *
     * Tie-breaking: Highest match score, then earliest expiration
     */
    public function matchRequest(FoodRequest $request): ?Donation
    {
        // Only match pending requests
        if ($request->status !== 'pending') {
            \Log::info("Cannot match request {$request->id}: status is '{$request->status}', expected 'pending'");
            return null;
        }

        // Get beneficiary location
        $beneficiary = User::find($request->beneficiary_id);
        if (!$beneficiary) {
            \Log::error("Beneficiary not found for request {$request->id}");
            return null;
        }

        if (!$beneficiary->location) {
            \Log::warning("Beneficiary {$beneficiary->id} has no location set for request {$request->id}");
            return null;
        }

        // Find all potential matching donations
        $potentialDonations = Donation::where('status', 'pending')
            ->whereRaw('COALESCE(remaining_quantity, quantity) >= ?', [$request->quantity])
            ->with('donor')
            ->get();

        // Score each donation and find the best match
        $bestMatch = null;
        $bestScore = config('matching.algorithm.minimum_score', 60);

        foreach ($potentialDonations as $donation) {
            $score = $this->calculateMatchScore($donation, $request, $donation->donor, $beneficiary);

            if ($score >= $bestScore) {
                $bestScore = $score;
                $bestMatch = $donation;
            }
        }

        if (!$bestMatch) {
            return null;
        }

        // Create the match
        $this->createMatch($bestMatch, $request);

        return $bestMatch;
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

                // Send notifications (non-critical, log if fails)
                try {
                    $this->notificationService->notifyMatch($donation, $request);
                } catch (\Exception $e) {
                    \Log::error("Failed to send match notifications: " . $e->getMessage());
                }

                // Create delivery task
                $task = $this->createDeliveryTask($donation, $request);
                if (!$task) {
                    \Log::warning("Failed to create delivery task for donation {$donation->id} and request {$request->id}");
                }
            });

            \Log::info("Successfully created match between donation {$donation->id} and request {$request->id}");
        } catch (\RuntimeException $e) {
            \Log::error("Match creation failed: " . $e->getMessage());
            throw $e;
        } catch (\Exception $e) {
            \Log::error("Unexpected error in createMatch: " . $e->getMessage());
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
     * Find potential matching requests for a donation (without creating the match).
     * Uses flexible matching with scoring.
     */
    public function findMatchingRequests(Donation $donation, int $limit = 10): \Illuminate\Support\Collection
    {
        // Get donor location
        $donor = User::find($donation->donor_id);
        if (! $donor || ! $donor->location) {
            return collect();
        }

        // Get all pending or matched requests
        $potentialRequests = FoodRequest::whereIn('status', ['pending', 'matched'])
            ->where(function ($query) use ($donation) {
                // If request is matched, show it only if it's matched with this donation
                $query->where('status', 'pending')
                    ->orWhere(function ($q) use ($donation) {
                        $q->where('status', 'matched')
                            ->where('donation_id', $donation->id);
                    });
            })
            ->where('quantity', '<=', $donation->remaining_quantity ?? $donation->quantity)
            ->with('beneficiary')
            ->get();

        $minimumScore = config('matching.algorithm.minimum_score', 60);
        $matches = collect();

        // Score each request
        foreach ($potentialRequests as $request) {
            if (!$request->beneficiary) {
                continue;
            }

            $score = $this->calculateMatchScore($donation, $request, $donor, $request->beneficiary);

            if ($score >= $minimumScore) {
                $matches->push([
                    'request' => $request,
                    'score' => $score,
                ]);
            }
        }

        // Sort by score descending, then by created_at ascending
        return $matches->sortByDesc('score')
            ->take($limit)
            ->values();
    }

    /**
     * Find potential matching donations for a request (without creating the match).
     * Uses flexible matching with scoring.
     */
    public function findMatchingDonations(FoodRequest $request, int $limit = 10): \Illuminate\Support\Collection
    {
        // Get beneficiary location
        $beneficiary = User::find($request->beneficiary_id);
        if (! $beneficiary || ! $beneficiary->location) {
            return collect();
        }

        // Get all pending donations or the matched donation
        $potentialDonations = Donation::where(function ($query) use ($request) {
            $query->where('status', 'pending');

            // Also include the matched donation if exists
            if ($request->donation_id) {
                $query->orWhere('id', $request->donation_id);
            }
        })
            ->whereRaw('COALESCE(remaining_quantity, quantity) >= ?', [$request->quantity])
            ->with('donor')
            ->get();

        $minimumScore = config('matching.algorithm.minimum_score', 60);
        $matches = collect();

        // Score each donation
        foreach ($potentialDonations as $donation) {
            if (!$donation->donor) {
                continue;
            }

            $score = $this->calculateMatchScore($donation, $request, $donation->donor, $beneficiary);

            if ($score >= $minimumScore) {
                $matches->push([
                    'donation' => $donation,
                    'score' => $score,
                ]);
            }
        }

        // Sort by score descending
        return $matches->sortByDesc('score')
            ->take($limit)
            ->values();
    }

    /**
     * Create delivery task without assigning a volunteer (volunteers will claim tasks)
     */
    protected function createDeliveryTask(Donation $donation, FoodRequest $request): ?DeliveryTask
    {
        $donor = User::find($donation->donor_id);
        $beneficiary = User::find($request->beneficiary_id);

        if (!$donor) {
            \Log::error("Cannot create delivery task: donor not found for donation {$donation->id}");
            return null;
        }

        if (!$beneficiary) {
            \Log::error("Cannot create delivery task: beneficiary not found for request {$request->id}");
            return null;
        }

        // Create delivery task without volunteer assignment
        $task = DeliveryTask::create([
            'volunteer_id' => null,
            'donation_id' => $donation->id,
            'pickup_location' => $donor->location ?? 'Not specified',
            'dropoff_location' => $beneficiary->location ?? 'Not specified',
            'status' => 'assigned',
        ]);

        \Log::info("Created delivery task {$task->id} for donation {$donation->id} and request {$request->id}");

        return $task;
    }

    /**
     * Calculate match score between donation and request
     */
    protected function calculateMatchScore(
        Donation $donation,
        FoodRequest $request,
        User $donor,
        User $beneficiary
    ): float {
        $weights = config('matching.score_weights');

        // Calculate individual scores
        $locationScore = $this->calculateLocationScore($donor->location, $beneficiary->location);
        $foodTypeScore = $this->calculateFoodTypeScore($donation->food_type, $request->food_type);
        $quantityScore = $this->calculateQuantityScore(
            $donation->remaining_quantity ?? $donation->quantity,
            $request->quantity
        );

        // Calculate weighted total
        $totalScore = (
            ($locationScore * $weights['location']) +
            ($foodTypeScore * $weights['food_type']) +
            ($quantityScore * $weights['quantity'])
        );

        return $totalScore;
    }

    /**
     * Calculate location match score
     */
    protected function calculateLocationScore(string $location1, string $location2): float
    {
        // Exact match
        if (strcasecmp($location1, $location2) === 0) {
            return config('matching.location.exact_match_score', 100);
        }

        // Check if flexible matching is enabled
        if (!config('matching.location.flexible_matching', true)) {
            return config('matching.location.different_location_score', 0);
        }

        // Try district-based matching
        $district1 = $this->extractDistrict($location1);
        $district2 = $this->extractDistrict($location2);

        if ($district1 && $district2 && $district1 === $district2) {
            return config('matching.location.same_district_score', 80);
        }

        // Check for partial match (one location contains the other)
        if (
            stripos($location1, $location2) !== false ||
            stripos($location2, $location1) !== false
        ) {
            return config('matching.location.partial_match_score', 60);
        }

        return config('matching.location.different_location_score', 0);
    }

    /**
     * Extract district from location string
     */
    protected function extractDistrict(string $location): ?string
    {
        $districts = config('matching.location.districts', []);
        $locationLower = mb_strtolower($location);

        foreach ($districts as $district => $keywords) {
            foreach ($keywords as $keyword) {
                if (stripos($locationLower, $keyword) !== false) {
                    return $district;
                }
            }
        }

        return null;
    }

    /**
     * Calculate food type match score
     */
    protected function calculateFoodTypeScore(string $foodType1, string $foodType2): float
    {
        // Exact match
        if ($foodType1 === $foodType2) {
            return config('matching.food_type.exact_match_score', 100);
        }

        // Check if category matching is enabled
        if (!config('matching.food_type.category_matching', true)) {
            return config('matching.food_type.different_category_score', 0);
        }

        // Check if they are in the same category
        if (\App\Helpers\FoodTypes::areSameCategory($foodType1, $foodType2)) {
            return config('matching.food_type.same_category_score', 70);
        }

        return config('matching.food_type.different_category_score', 0);
    }

    /**
     * Calculate quantity match score
     */
    protected function calculateQuantityScore(int $availableQuantity, int $requestedQuantity): float
    {
        if ($availableQuantity < $requestedQuantity) {
            return 0; // Insufficient quantity
        }

        if ($availableQuantity == $requestedQuantity) {
            return config('matching.quantity.exact_match_score', 100);
        }

        // Over-supply (donation > request)
        return config('matching.quantity.over_supply_score', 95);
    }
}
