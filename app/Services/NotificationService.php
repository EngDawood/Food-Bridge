<?php

namespace App\Services;

use App\Models\SystemNotification;
use App\Models\User;
use App\Models\Donation;
use App\Models\FoodRequest;
use App\Models\DeliveryTask;

class NotificationService
{
    /**
     * Notify donor and beneficiary when a match is made
     */
    public function notifyMatch(Donation $donation, FoodRequest $request): void
    {
        // Notify donor
        SystemNotification::create([
            'user_id' => $donation->donor_id,
            'message' => "Your donation ({$donation->food_type}) was matched with a beneficiary request",
            'type' => 'match',
            'is_read' => false,
        ]);

        // Notify beneficiary
        SystemNotification::create([
            'user_id' => $request->beneficiary_id,
            'message' => "A donation ({$request->food_type}) was found that matches your request",
            'type' => 'match',
            'is_read' => false,
        ]);
    }

    /**
     * Notify volunteer when a delivery task is assigned
     */
    public function notifyVolunteerAssigned(DeliveryTask $task): void
    {
        SystemNotification::create([
            'user_id' => $task->volunteer_id,
            'message' => 'You have been assigned a new delivery task',
            'type' => 'alert',
            'is_read' => false,
        ]);
    }

    /**
     * Notify all parties when delivery task status changes
     */
    public function notifyDeliveryStatusChange(DeliveryTask $task, string $oldStatus): void
    {
        $donation = $task->donation;

        // Early return if donation doesn't exist
        if (!$donation) {
            \Log::warning("DeliveryTask {$task->id} has no associated donation");
            return;
        }

        if ($task->status === 'in_progress') {
            // Notify donor that pickup is in progress
            SystemNotification::create([
                'user_id' => $donation->donor_id,
                'message' => 'The volunteer is on the way to pick up your donation',
                'type' => 'update',
                'is_read' => false,
            ]);

            // Notify beneficiary
            $request = FoodRequest::where('donation_id', $donation->id)->first();
            if ($request) {
                SystemNotification::create([
                    'user_id' => $request->beneficiary_id,
                    'message' => 'The donation is on its way to you',
                    'type' => 'update',
                    'is_read' => false,
                ]);
            }
        }

        if ($task->status === 'completed') {
            // Notify donor
            SystemNotification::create([
                'user_id' => $donation->donor_id,
                'message' => 'Your donation was delivered successfully. Thank you for your contribution!',
                'type' => 'update',
                'is_read' => false,
            ]);

            // Notify beneficiary
            $request = FoodRequest::where('donation_id', $donation->id)->first();
            if ($request) {
                SystemNotification::create([
                    'user_id' => $request->beneficiary_id,
                    'message' => 'Your request was delivered successfully',
                    'type' => 'update',
                    'is_read' => false,
                ]);
            }

            // Notify volunteer only if assigned
            if ($task->volunteer_id) {
                SystemNotification::create([
                    'user_id' => $task->volunteer_id,
                    'message' => 'Thanks for completing the delivery task',
                    'type' => 'update',
                    'is_read' => false,
                ]);
            }
        }
    }

    /**
     * Notify user when they receive feedback
     */
    public function notifyFeedbackReceived(int $userId, int $fromUserId, int $rating): void
    {
        $fromUser = User::find($fromUserId);
        $fromUserName = $fromUser ? $fromUser->name : 'A user';

        SystemNotification::create([
            'user_id' => $userId,
            'message' => "You received new feedback ({$rating}/5) from {$fromUserName}",
            'type' => 'update',
            'is_read' => false,
        ]);
    }

    /**
     * Notify all beneficiaries when a new donation is created
     */
    public function notifyNewDonation(Donation $donation): void
    {
        $beneficiaries = User::where('role', 'beneficiary')->get();
        
        foreach ($beneficiaries as $beneficiary) {
            SystemNotification::create([
                'user_id' => $beneficiary->id,
                'message' => "New donation available: {$donation->food_type} (Quantity: {$donation->quantity})",
                'type' => 'new_donation',
                'is_read' => false,
            ]);
        }
    }

    /**
     * Notify all donors and volunteers when a new request is created
     */
    public function notifyNewRequest(FoodRequest $request): void
    {
        // Notify all donors
        $donors = User::where('role', 'donor')->get();
        foreach ($donors as $donor) {
            SystemNotification::create([
                'user_id' => $donor->id,
                'message' => "New food request: {$request->food_type} (Quantity: {$request->quantity})",
                'type' => 'new_request',
                'is_read' => false,
            ]);
        }

        // Notify all volunteers
        $volunteers = User::where('role', 'volunteer')->get();
        foreach ($volunteers as $volunteer) {
            SystemNotification::create([
                'user_id' => $volunteer->id,
                'message' => "New food request created: {$request->food_type} (Quantity: {$request->quantity})",
                'type' => 'new_request',
                'is_read' => false,
            ]);
        }
    }

    /**
     * Notify all volunteers when a new delivery task is created
     */
    public function notifyNewDeliveryTask(DeliveryTask $task): void
    {
        $volunteers = User::where('role', 'volunteer')->get();
        
        foreach ($volunteers as $volunteer) {
            SystemNotification::create([
                'user_id' => $volunteer->id,
                'message' => "New delivery task available: Pickup from {$task->pickup_location} to {$task->dropoff_location}",
                'type' => 'new_delivery_task',
                'is_read' => false,
            ]);
        }
    }
}


