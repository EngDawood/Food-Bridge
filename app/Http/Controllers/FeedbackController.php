<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    protected NotificationService $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Store feedback from authenticated user
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'to_user_id' => ['required', 'exists:users,id', 'different:from_user_id'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string', 'max:500'],
        ]);

        $feedback = Feedback::create([
            'from_user_id' => Auth::id(),
            'to_user_id' => $validated['to_user_id'],
            'rating' => $validated['rating'],
            'comment' => $validated['comment'] ?? null,
        ]);

        // Notify the user who received feedback
        $this->notificationService->notifyFeedbackReceived(
            $validated['to_user_id'],
            Auth::id(),
            $validated['rating']
        );

        return back()->with('status', 'تم إرسال التقييم بنجاح');
    }
}


