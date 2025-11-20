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

            // Notify volunteer
            SystemNotification::create([
                'user_id' => $task->volunteer_id,
                'message' => 'Thanks for completing the delivery task',
                'type' => 'update',
                'is_read' => false,
            ]);
        }
    }

    /**
     * Notify user when they receive feedback
     */
    public function notifyFeedbackReceived(int $userId, int $fromUserId, int $rating): void
    {
        $fromUser = User::find($fromUserId);
        
        SystemNotification::create([
            'user_id' => $userId,
            'message' => "You received new feedback ({$rating}/5) from {$fromUser->name}",
            'type' => 'update',
            'is_read' => false,
        ]);
    }
}


