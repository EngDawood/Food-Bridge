@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-900">
                <i class="fa-solid fa-bell mr-2 text-primary-600"></i>Notifications
            </h1>
            @if($notifications->where('is_read', false)->count() > 0)
                <form action="{{ route('notifications.markAllRead') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-sm text-primary-600 hover:text-primary-700 font-medium">
                        Mark all as read
                    </button>
                </form>
            @endif
        </div>

        @if($notifications->isEmpty())
            <div class="text-center py-12">
                <i class="fa-solid fa-bell-slash text-gray-300 text-5xl mb-4"></i>
                <p class="text-gray-500 text-lg">No notifications yet</p>
                <p class="text-gray-400 text-sm mt-2">You'll see notifications here when you have updates</p>
            </div>
        @else
            <div class="space-y-3">
                @foreach($notifications as $notification)
                    @php
                        // Determine action URL based on notification type and user role
                        $actionUrl = null;
                        if ($notification->type === 'match') {
                            if (auth()->user()->role === 'donor') {
                                $actionUrl = route('donations.index');
                            } elseif (auth()->user()->role === 'beneficiary') {
                                $actionUrl = route('requests.index');
                            }
                        } elseif ($notification->type === 'alert' && auth()->user()->role === 'volunteer') {
                            $actionUrl = route('volunteer.tasks');
                        } elseif ($notification->type === 'new_delivery_task' && auth()->user()->role === 'volunteer') {
                            $actionUrl = route('volunteer.tasks');
                        } elseif ($notification->type === 'new_donation' && auth()->user()->role === 'beneficiary') {
                            $actionUrl = route('requests.index');
                        } elseif ($notification->type === 'new_request') {
                            if (auth()->user()->role === 'donor') {
                                $actionUrl = route('donations.index');
                            } elseif (auth()->user()->role === 'volunteer') {
                                $actionUrl = route('volunteer.tasks');
                            }
                        } elseif ($notification->type === 'update' || $notification->type === 'delivery') {
                            if (auth()->user()->role === 'donor') {
                                $actionUrl = route('donations.index');
                            } elseif (auth()->user()->role === 'beneficiary') {
                                $actionUrl = route('requests.index');
                            } elseif (auth()->user()->role === 'volunteer') {
                                $actionUrl = route('volunteer.tasks');
                            }
                        }
                    @endphp

                    <div class="border rounded-lg p-4 transition-colors {{ $notification->is_read ? 'bg-white' : 'bg-blue-50 border-blue-200' }} {{ $actionUrl ? 'hover:shadow-md cursor-pointer' : '' }}"
                         @if($actionUrl) onclick="window.location.href='{{ $actionUrl }}'" @endif>
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex items-start gap-3 flex-1">
                                <div class="mt-1">
                                    @if($notification->type === 'match')
                                        <i class="fa-solid fa-handshake text-green-500 text-xl"></i>
                                    @elseif($notification->type === 'update')
                                        <i class="fa-solid fa-sync text-blue-500 text-xl"></i>
                                    @elseif($notification->type === 'alert')
                                        <i class="fa-solid fa-exclamation-triangle text-yellow-500 text-xl"></i>
                                    @elseif($notification->type === 'delivery')
                                        <i class="fa-solid fa-truck text-purple-500 text-xl"></i>
                                    @elseif($notification->type === 'new_donation')
                                        <i class="fa-solid fa-gift text-emerald-500 text-xl"></i>
                                    @elseif($notification->type === 'new_request')
                                        <i class="fa-solid fa-hand-holding-heart text-pink-500 text-xl"></i>
                                    @elseif($notification->type === 'new_delivery_task')
                                        <i class="fa-solid fa-truck-fast text-indigo-500 text-xl"></i>
                                    @else
                                        <i class="fa-solid fa-info-circle text-gray-500 text-xl"></i>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <p class="text-gray-800">{{ $notification->message }}</p>
                                    <p class="text-xs text-gray-500 mt-1">
                                        {{ $notification->created_at->locale('en')->diffForHumans() }}
                                    </p>
                                    @if($actionUrl)
                                        <p class="text-xs text-primary-600 mt-1 font-medium">
                                            <i class="fa-solid fa-arrow-right mr-1"></i>Click to view
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <div class="flex items-center gap-2" onclick="event.stopPropagation()">
                                @if(!$notification->is_read)
                                    <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                                @endif
                                <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-gray-400 hover:text-red-500 transition-colors" onclick="return confirm('Delete this notification?')">
                                        <i class="fa-solid fa-trash text-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>
</div>
@endsection


