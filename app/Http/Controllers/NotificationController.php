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
        $notifications = auth()->user()
            ->systemNotifications()
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('notifications', compact('notifications'));
    }

    /**
     * Get unread notification count
     */
    public function getUnreadCount()
    {
        $count = auth()->user()
            ->systemNotifications()
            ->where('is_read', false)
            ->count();

        return response()->json(['count' => $count]);
    }

    /**
     * Get recent notifications for popup (last 5)
     */
    public function getRecent()
    {
        $notifications = auth()->user()
            ->systemNotifications()
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
        $notification = auth()->user()
            ->systemNotifications()
            ->findOrFail($id);

        $notification->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead()
    {
        auth()->user()
            ->systemNotifications()
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }

    /**
     * Delete a notification
     */
    public function destroy($id)
    {
        $notification = auth()->user()
            ->systemNotifications()
            ->findOrFail($id);

        $notification->delete();

        return redirect()->back()->with('success', 'Notification deleted successfully');
    }
}