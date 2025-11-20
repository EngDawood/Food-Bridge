<?php

namespace App\Http\Controllers;

use App\Models\SystemNotification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display the notifications page
     */
    public function index()
    {
        $user = auth()->user();
        if (!$user) {
            abort(401, 'Unauthorized');
        }

        $notifications = $user->systemNotifications()
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('notifications', compact('notifications'));
    }

    /**
     * Get unread notification count
     */
    public function getUnreadCount()
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['count' => 0], 401);
        }

        $count = $user->systemNotifications()
            ->where('is_read', false)
            ->count();

        return response()->json(['count' => $count]);
    }

    /**
     * Get recent notifications for popup (last 5)
     */
    public function getRecent()
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['notifications' => []], 401);
        }

        $notifications = $user->systemNotifications()
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($notification) {
                return [
                    'id' => $notification->id,
                    'message' => $notification->message,
                    'type' => $notification->type,
                    'is_read' => $notification->is_read,
                    'created_at' => $notification->created_at->diffForHumans(),
                ];
            });

        return response()->json(['notifications' => $notifications]);
    }

    /**
     * Mark a notification as read
     */
    public function markAsRead($id)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['success' => false, 'error' => 'Unauthorized'], 401);
        }

        $notification = $user->systemNotifications()
            ->findOrFail($id);

        $notification->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead()
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['success' => false, 'error' => 'Unauthorized'], 401);
        }

        $user->systemNotifications()
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }

    /**
     * Delete a notification
     */
    public function destroy($id)
    {
        $user = auth()->user();
        if (!$user) {
            abort(401, 'Unauthorized');
        }

        $notification = $user->systemNotifications()
            ->findOrFail($id);

        $notification->delete();

        return redirect()->back()->with('success', 'Notification deleted successfully');
    }
}