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
     * Find and match suitable requests for a donation using simple rule-based matching.
     *
     * Matching rules (all must be satisfied):
     * 1. Exact food type match
     * 2. Sufficient quantity available
     * 3. Exact location match
     *
     * Tie-breaking: First-come-first-served (oldest request first)
     */
    public function matchDonation(Donation $donation): ?FoodRequest
    {
        // Release stale matches before attempting a new match
        $this->releaseStaleMatches();

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

        // Find matching requests using three conditions
        $matchingRequest = FoodRequest::where('status', 'pending')
            // Condition 1: Exact food type match
            ->where('food_type', $donation->food_type)
            // Condition 2: Sufficient quantity (donation can fulfill request)
            ->where('quantity', '<=', $donation->remaining_quantity ?? $donation->quantity)
            // Condition 3: Exact location match (join with users table)
            ->whereHas('beneficiary', function ($query) use ($donor) {
                $query->where('location', $donor->location);
            })
            // Tie-breaking: First-come-first-served
            ->orderBy('created_at', 'asc')
            ->first();

        if (! $matchingRequest) {
            return null;
        }

        // Create the match
        return $this->createMatch($donation, $matchingRequest);
    }

    /**
     * Find and match suitable donations for a request using simple rule-based matching.
     *
     * Matching rules (all must be satisfied):
     * 1. Exact food type match
     * 2. Sufficient quantity available
     * 3. Exact location match
     *
     * Tie-breaking: Earliest expiration date first (prioritize food that will expire soonest)
     */
    public function matchRequest(FoodRequest $request): ?Donation
    {
        // Release stale matches before attempting a new match
        $this->releaseStaleMatches();

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

        // Find matching donations using three conditions
        $matchingDonation = Donation::where('status', 'pending')
            // Condition 1: Exact food type match
            ->where('food_type', $request->food_type)
            // Condition 2: Sufficient quantity (donation can fulfill request)
            ->whereRaw('COALESCE(remaining_quantity, quantity) >= ?', [$request->quantity])
            // Condition 3: Exact location match (join with users table)
            ->whereHas('donor', function ($query) use ($beneficiary) {
                $query->where('location', $beneficiary->location);
            })
            // Tie-breaking: Earliest expiration date first
            ->orderBy('expiration_date', 'asc')
            ->first();

        if (! $matchingDonation) {
            return null;
        }

        // Create the match
        $this->createMatch($matchingDonation, $request);

        return $matchingDonation;
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
        // Optional: release stale matches before proceeding
        $this->releaseStaleMatches();

        return $this->createMatch($donation, $request);
    }

    /**
     * Release matched requests that exceeded 3 hours without delivery completion
     */
    private function releaseStaleMatches(): void
    {
        $stale = FoodRequest::with('donation')  // Eager load to prevent N+1 queries
            ->where('status', 'matched')
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

                \Log::info("Released stale match: Donation {$donation->id} and Request {$request->id}");
            } else {
                \Log::warning("Request {$request->id} is matched but has no associated donation");
            }

            $request->update([
                'status' => 'pending',
                'donation_id' => null,
                'matched_at' => null,
            ]);
        }
    }

    /**
     * Find potential matching requests for a donation (without creating the match).
     * Uses the same three-condition rule-based matching.
     */
    public function findMatchingRequests(Donation $donation, int $limit = 10): \Illuminate\Support\Collection
    {
        // Get donor location
        $donor = User::find($donation->donor_id);
        if (! $donor || ! $donor->location) {
            return collect();
        }

        // Get pending or matched requests that meet all three conditions
        $requests = FoodRequest::whereIn('status', ['pending', 'matched'])
            ->where(function ($query) use ($donation) {
                // If request is matched, show it only if it's matched with this donation
                $query->where('status', 'pending')
                    ->orWhere(function ($q) use ($donation) {
                        $q->where('status', 'matched')
                            ->where('donation_id', $donation->id);
                    });
            })
            // Condition 1: Exact food type match
            ->where('food_type', $donation->food_type)
            // Condition 2: Sufficient quantity
            ->where('quantity', '<=', $donation->remaining_quantity ?? $donation->quantity)
            // Condition 3: Exact location match
            ->whereHas('beneficiary', function ($query) use ($donor) {
                $query->where('location', $donor->location);
            })
            // Order by creation date (first-come-first-served)
            ->orderBy('created_at', 'asc')
            ->limit($limit)
            ->get();

        // Return in the same format as before for compatibility
        return $requests->map(function ($request) {
            return [
                'request' => $request,
                'score' => 100, // All matches are equal now (no scoring)
            ];
        });
    }

    /**
     * Find potential matching donations for a request (without creating the match).
     * Uses the same three-condition rule-based matching.
     */
    public function findMatchingDonations(FoodRequest $request, int $limit = 10): \Illuminate\Support\Collection
    {
        // Get beneficiary location
        $beneficiary = User::find($request->beneficiary_id);
        if (! $beneficiary || ! $beneficiary->location) {
            return collect();
        }

        // Get pending donations or the matched donation that meet all three conditions
        $donations = Donation::where(function ($query) use ($request) {
            $query->where('status', 'pending');

            // Also include the matched donation if exists
            if ($request->donation_id) {
                $query->orWhere('id', $request->donation_id);
            }
        })
            // Condition 1: Exact food type match
            ->where('food_type', $request->food_type)
            // Condition 2: Sufficient quantity
            ->whereRaw('COALESCE(remaining_quantity, quantity) >= ?', [$request->quantity])
            // Condition 3: Exact location match
            ->whereHas('donor', function ($query) use ($beneficiary) {
                $query->where('location', $beneficiary->location);
            })
            // Order by expiration date (earliest expiring first)
            ->orderBy('expiration_date', 'asc')
            ->limit($limit)
            ->get();

        // Return in the same format as before for compatibility
        return $donations->map(function ($donation) {
            return [
                'donation' => $donation,
                'score' => 100, // All matches are equal now (no scoring)
            ];
        });
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
}
