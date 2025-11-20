<?php

namespace App\Console\Commands;

use App\Models\DeliveryTask;
use App\Models\FoodRequest;
use Illuminate\Console\Command;

class ReleaseStaleMatches extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'matches:release-stale';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Release matched requests that exceeded the timeout without delivery completion';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $timeout = config('matching.stale_matches.release_after_hours', 3);
        $cutoffTime = now()->subHours($timeout);

        $this->info("Checking for stale matches older than {$timeout} hours (before {$cutoffTime})...");

        $staleMatches = FoodRequest::with('donation')
            ->where('status', 'matched')
            ->whereNotNull('matched_at')
            ->where('matched_at', '<=', $cutoffTime)
            ->get();

        $releasedCount = 0;
        $skippedCount = 0;

        foreach ($staleMatches as $request) {
            $donation = $request->donation;

            // Check if any delivery task for this donation is completed
            $isDelivered = false;
            if ($donation) {
                $isDelivered = DeliveryTask::where('donation_id', $donation->id)
                    ->where('status', 'completed')
                    ->exists();
            }

            if ($isDelivered) {
                $this->line("  Skipping request {$request->id} - delivery already completed");
                $skippedCount++;
                continue;
            }

            // Release the match
            if ($donation) {
                $donation->remaining_quantity = ($donation->remaining_quantity ?? 0) + $request->quantity;
                $donation->status = 'pending';
                $donation->save();

                $this->info("  Released stale match: Donation {$donation->id} <-> Request {$request->id}");
            } else {
                $this->warn("  Request {$request->id} is matched but has no associated donation");
            }

            $request->update([
                'status' => 'pending',
                'donation_id' => null,
                'matched_at' => null,
            ]);

            $releasedCount++;
        }

        $this->newLine();
        $this->info("Stale match release completed:");
        $this->info("  Released: {$releasedCount}");
        $this->info("  Skipped: {$skippedCount}");
        $this->info("  Total checked: " . ($releasedCount + $skippedCount));

        return Command::SUCCESS;
    }
}