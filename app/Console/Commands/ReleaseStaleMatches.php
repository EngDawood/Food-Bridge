<?php

namespace App\Console\Commands;

use App\Models\FoodRequest;
use App\Models\DeliveryTask;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ReleaseStaleMatches extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'matching:release-stale';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Release matches that have not been delivered within the configured timeout';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $hours = config('matching.stale_matches.release_after_hours', 3);
        
        $this->info("Checking for matches older than {$hours} hours...");

        $stale = FoodRequest::with('donation')
            ->where('status', 'matched')
            ->whereNotNull('matched_at')
            ->where('matched_at', '<=', now()->subHours($hours))
            ->get();

        $count = 0;

        foreach ($stale as $request) {
            $donation = $request->donation;

            // Check if any delivery task for this donation is completed
            $isDelivered = false;
            if ($donation) {
                $isDelivered = DeliveryTask::where('donation_id', $donation->id)
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

                Log::info("Released stale match: Donation {$donation->id} and Request {$request->id}");
            } else {
                Log::warning("Request {$request->id} is matched but has no associated donation");
            }

            $request->update([
                'status' => 'pending',
                'donation_id' => null,
                'matched_at' => null,
            ]);

            $count++;
        }

        $this->info("Released {$count} stale matches.");
    }
}
