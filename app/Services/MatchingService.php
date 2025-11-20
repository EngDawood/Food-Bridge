<?php

namespace App\Services;

use App\Models\Donation;
use App\Models\FoodRequest;
use App\Models\DeliveryTask;
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
     * Find and match suitable requests for a donation
     */
    public function matchDonation(Donation $donation): ?FoodRequest
    {
        // Release stale matches before attempting a new match
        $this->releaseStaleMatches();

        // Only match pending donations
        if ($donation->status !== 'pending') {
            return null;
        }

        // Get all pending requests
        $requests = FoodRequest::where('status', 'pending')->get();

        if ($requests->isEmpty()) {
            return null;
        }

        // Score each request
        $scoredRequests = $requests->map(function ($request) use ($donation) {
            return [
                'request' => $request,
                'score' => $this->calculateMatchScore($donation, $request),
            ];
        })->filter(function ($item) {
            return $item['score'] > 0; // Only keep matches with positive scores
        })->sortByDesc('score');

        if ($scoredRequests->isEmpty()) {
            return null;
        }

        // Get the best match
        $bestMatch = $scoredRequests->first()['request'];

        // Create the match
        return $this->createMatch($donation, $bestMatch);
    }

    /**
     * Find and match suitable donations for a request
     */
    public function matchRequest(FoodRequest $request): ?Donation
    {
        // Release stale matches before attempting a new match
        $this->releaseStaleMatches();

        // Only match pending requests
        if ($request->status !== 'pending') {
            return null;
        }

        // Get all pending donations
        $donations = Donation::where('status', 'pending')->get();

        if ($donations->isEmpty()) {
            return null;
        }

        // Score each donation
        $scoredDonations = $donations->map(function ($donation) use ($request) {
            return [
                'donation' => $donation,
                'score' => $this->calculateMatchScore($donation, $request),
            ];
        })->filter(function ($item) {
            return $item['score'] > 0; // Only keep matches with positive scores
        })->sortByDesc('score');

        if ($scoredDonations->isEmpty()) {
            return null;
        }

        // Get the best match
        $bestMatch = $scoredDonations->first()['donation'];

        // Create the match
        $this->createMatch($bestMatch, $request);
        
        return $bestMatch;
    }

    /**
     * Calculate match score between donation and request
     * Higher score = better match
     */
    protected function calculateMatchScore(Donation $donation, FoodRequest $request): float
    {
        $score = 0;

        // 1. Food Type Similarity (40 points max)
        $foodTypeScore = $this->calculateFoodTypeSimilarity($donation->food_type, $request->food_type);
        $score += $foodTypeScore * 40;

        // 2. Quantity Match (30 points max) — use remaining_quantity
        if (isset($donation->remaining_quantity) && $donation->remaining_quantity >= $request->quantity) {
            $quantityRatio = $request->quantity / max(1, $donation->remaining_quantity);
            // Perfect match is when request takes 50-100% of donation
            if ($quantityRatio >= 0.5) {
                $score += 30;
            } else {
                $score += $quantityRatio * 60; // Scale down for smaller ratios
            }
        } else {
            // Donation has less than needed, but could be partial match
            $available = isset($donation->remaining_quantity) ? $donation->remaining_quantity : $donation->quantity;
            $score += (max(0, $available) / max(1, $request->quantity)) * 15;
        }

        // 3. Location Proximity (30 points max)
        $donor = User::find($donation->donor_id);
        $beneficiary = User::find($request->beneficiary_id);
        
        if ($donor && $beneficiary && $donor->location && $beneficiary->location) {
            $locationScore = $this->calculateLocationSimilarity($donor->location, $beneficiary->location);
            $score += $locationScore * 30;
        }

        // 4. Freshness (up to 30 points total: 20 for expiration, 10 for pickup proximity)
        $freshness = 0;
        if ($donation->expiration_date) {
            $days = now()->diffInDays($donation->expiration_date, false);
            if ($days >= 0) {
                $freshness += max(0, 20 - min(20, $days));
            }
        }
        if ($donation->pickup_time) {
            $mins = abs(now()->diffInMinutes($donation->pickup_time));
            $freshness += max(0, 10 - min(10, intdiv($mins, 30)));
        }

        return $score + $freshness;
    }

    /**
     * Calculate similarity between food types
     * Since food types are now enums, we do exact matching with some category grouping
     */
    protected function calculateFoodTypeSimilarity(string $type1, string $type2): float
    {
        // Exact match
        if ($type1 === $type2) {
            return 1.0;
        }

        // Category groups for partial matching
        $categories = [
            'prepared' => ['cooked'],
            'fresh' => ['fresh', 'vegetables', 'fruits'],
            'packaged' => ['canned', 'bread', 'grains'],
            'protein' => ['meat', 'dairy'],
        ];

        // Find which category each type belongs to
        $cat1 = null;
        $cat2 = null;

        foreach ($categories as $categoryName => $types) {
            if (in_array($type1, $types, true)) {
                $cat1 = $categoryName;
            }
            if (in_array($type2, $types, true)) {
                $cat2 = $categoryName;
            }
        }

        // If both are in the same category, give partial score
        if ($cat1 && $cat1 === $cat2) {
            return 0.7;
        }

        // No match
        return 0;
    }

    /**
     * Calculate location proximity using string matching
     */
    protected function calculateLocationSimilarity(string $loc1, string $loc2): float
    {
        $loc1 = mb_strtolower(trim($loc1));
        $loc2 = mb_strtolower(trim($loc2));

        // Exact match
        if ($loc1 === $loc2) {
            return 1.0;
        }

        // Split by common delimiters
        $parts1 = preg_split('/[،,\s]+/', $loc1);
        $parts2 = preg_split('/[،,\s]+/', $loc2);

        // Count matching parts
        $matches = 0;
        foreach ($parts1 as $part1) {
            foreach ($parts2 as $part2) {
                if ($part1 === $part2 && mb_strlen($part1) > 2) {
                    $matches++;
                    break;
                }
            }
        }

        $totalParts = max(count($parts1), count($parts2));
        if ($totalParts === 0) {
            return 0;
        }

        return $matches / $totalParts;
    }

    /**
     * Create a match between donation and request
     */
    protected function createMatch(Donation $donation, FoodRequest $request): FoodRequest
    {
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

            // Send notifications
            $this->notificationService->notifyMatch($donation, $request);

            // Create delivery task
            $this->createDeliveryTask($donation, $request);
        });

        return $request;
    }

    /**
     * Public API: manually create a match between a donation and a request
     */
    public function manualMatch(Donation $donation, FoodRequest $request): FoodRequest
    {
        // Optional: release stale matches before proceeding
        $this->releaseStaleMatches();

        return $this->createMatch($donation, $request);
    }

    /**
     * Release matched requests that exceeded 3 hours without delivery completion
     */
    private function releaseStaleMatches(): void
    {
        $stale = FoodRequest::where('status', 'matched')
            ->whereNotNull('matched_at')
            ->where('matched_at', '<=', now()->subHours(3))
            ->get();

        foreach ($stale as $request) {
            $donation = $request->donation;

            // Check if any delivery task for this donation is completed
            $isDelivered = false;
            if ($donation) {
                $isDelivered = \App\Models\DeliveryTask::where('donation_id', $donation->id)
                    ->where('status', 'completed')
                    ->exists();
            }

            if ($isDelivered) {
                continue;
            }

            if ($donation) {
                $donation->remaining_quantity = ($donation->remaining_quantity ?? 0) + $request->quantity;
                $donation->status = 'pending';
                $donation->save();
            }

            $request->update([
                'status' => 'pending',
                'donation_id' => null,
                'matched_at' => null,
            ]);
        }
    }

    /**
     * Find potential matching requests for a donation (without creating the match)
     */
    public function findMatchingRequests(Donation $donation, int $limit = 10): \Illuminate\Support\Collection
    {
        // Get pending or matched requests (show all potential matches)
        $requests = FoodRequest::whereIn('status', ['pending', 'matched'])
            ->where(function ($query) use ($donation) {
                // If request is matched, show it only if it's matched with this donation
                $query->where('status', 'pending')
                    ->orWhere(function ($q) use ($donation) {
                        $q->where('status', 'matched')
                            ->where('donation_id', $donation->id);
                    });
            })
            ->get();

        if ($requests->isEmpty()) {
            return collect();
        }

        // Score each request
        $scoredRequests = $requests->map(function ($request) use ($donation) {
            return [
                'request' => $request,
                'score' => $this->calculateMatchScore($donation, $request),
            ];
        })->filter(function ($item) {
            return $item['score'] > 0; // Only keep matches with positive scores
        })->sortByDesc('score')
            ->take($limit)
            ->values();

        return $scoredRequests;
    }

    /**
     * Find potential matching donations for a request (without creating the match)
     */
    public function findMatchingDonations(FoodRequest $request, int $limit = 10): \Illuminate\Support\Collection
    {
        // Get pending donations or the matched donation
        $donations = Donation::where(function ($query) use ($request) {
            $query->where('status', 'pending');
            
            // Also include the matched donation if exists
            if ($request->donation_id) {
                $query->orWhere('id', $request->donation_id);
            }
        })->get();

        if ($donations->isEmpty()) {
            return collect();
        }

        // Score each donation
        $scoredDonations = $donations->map(function ($donation) use ($request) {
            return [
                'donation' => $donation,
                'score' => $this->calculateMatchScore($donation, $request),
            ];
        })->filter(function ($item) {
            return $item['score'] > 0; // Only keep matches with positive scores
        })->sortByDesc('score')
            ->take($limit)
            ->values();

        return $scoredDonations;
    }

    /**
     * Create delivery task without assigning a volunteer (volunteers will claim tasks)
     */
    protected function createDeliveryTask(Donation $donation, FoodRequest $request): ?DeliveryTask
    {
        $donor = User::find($donation->donor_id);
        $beneficiary = User::find($request->beneficiary_id);

        if (!$donor || !$beneficiary) {
            return null;
        }
        
        // Create delivery task without volunteer assignment
        $task = DeliveryTask::create([
            'volunteer_id' => null,
            'donation_id' => $donation->id,
            'pickup_location' => $donor->location ?? 'غير محدد',
            'dropoff_location' => $beneficiary->location ?? 'غير محدد',
            'status' => 'assigned',
        ]);

        return $task;
    }
}


