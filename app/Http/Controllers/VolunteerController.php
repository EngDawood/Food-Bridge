<?php

namespace App\Http\Controllers;

use App\Models\DeliveryTask;
use App\Models\Donation;
use App\Models\FoodRequest;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VolunteerController extends Controller
{
    protected NotificationService $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Show tasks assigned to the volunteer that are not started yet (available to start).
     */
    public function available()
    {
        $availableTasks = DeliveryTask::with(['donation', 'volunteer'])
            ->whereNull('volunteer_id')
            ->where('status', 'assigned')
            ->orderByDesc('id')
            ->get();

        return view('volunteer.available', [
            'availableTasks' => $availableTasks,
        ]);
    }

    /**
     * Show all tasks for the volunteer grouped by status.
     */
    public function myTasks()
    {
        $tasks = DeliveryTask::with(['donation'])
            ->where('volunteer_id', Auth::id())
            ->orderByDesc('id')
            ->get();

        $grouped = [
            'assigned' => $tasks->where('status', 'assigned'),
            'in_progress' => $tasks->where('status', 'in_progress'),
            'completed' => $tasks->where('status', 'completed'),
        ];

        return view('volunteer.my-tasks', [
            'tasks' => $tasks,
            'grouped' => $grouped,
        ]);
    }

    /**
     * Start a task: assigned -> in_progress
     */
    public function start(DeliveryTask $task)
    {
        // Verify ownership
        if ($task->volunteer_id !== Auth::id() || $task->status !== 'assigned') {
            abort(403);
        }

        $oldStatus = $task->status;
        $task->update(['status' => 'in_progress']);

        // Notify relevant parties
        $this->notificationService->notifyDeliveryStatusChange($task, $oldStatus);

        return back()->with('status', 'Delivery task started');
    }

    /**
     * Complete a task: in_progress -> completed
     */
    public function complete(DeliveryTask $task)
    {
        // Verify ownership
        if ($task->volunteer_id !== Auth::id() || $task->status !== 'in_progress') {
            abort(403);
        }

        $oldStatus = $task->status;
        $task->update(['status' => 'completed']);

        // Update donation status to delivered
        $donation = $task->donation;
        if ($donation) {
            $donation->update(['status' => 'delivered']);

            // Update associated request to fulfilled
            $request = FoodRequest::where('donation_id', $donation->id)->first();
            if ($request) {
                $request->update(['status' => 'fulfilled']);
            }
        }

        // Notify relevant parties
        $this->notificationService->notifyDeliveryStatusChange($task, $oldStatus);

        return back()->with('status', 'Delivery task completed successfully');
    }

    /**
     * Claim an unassigned task
     */
    public function claim(DeliveryTask $task)
    {
        if (!is_null($task->volunteer_id) || $task->status !== 'assigned') {
            abort(403);
        }

        $task->update(['volunteer_id' => Auth::id()]);

        // Optional: notify stakeholders about assignment change
        $this->notificationService->notifyDeliveryStatusChange($task, 'assigned');

        return back()->with('status', 'Task claimed successfully');
    }
}


