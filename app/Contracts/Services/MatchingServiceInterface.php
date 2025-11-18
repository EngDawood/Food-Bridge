<?php

namespace App\Contracts\Services;

use App\Models\Donation;
use App\Models\FoodRequest;

interface MatchingServiceInterface
{
    /**
     * Attempt to match a donation with eligible requests based on proximity, urgency, and type.
     * Returns matched request IDs.
     */
    public function matchDonation(Donation $donation): array;

    /**
     * Attempt to find a donation for the given request.
     * Returns donation ID or null.
     */
    public function matchRequest(FoodRequest $request): ?int;
}


