@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between mb-4">
    <h1 class="text-2xl font-bold"><i class="fa-solid fa-clipboard-check mr-2"></i>My tasks</h1>
    <a href="/volunteer/available" class="px-3 py-2 text-sm rounded bg-primary-700 hover:bg-primary-800 text-white"><i class="fa-solid fa-search mr-1"></i>Browse available tasks</a>
  </div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded p-4 shadow">
        <h2 class="font-semibold mb-1"><i class="fa-solid fa-clock mr-1"></i>Assigned</h2>
        <p class="text-xs text-gray-500 mb-2">assigned</p>
        <ul class="space-y-2">
            @forelse(($grouped['assigned'] ?? []) as $task)
            <li class="border rounded p-2">
                <div class="text-sm">Donation #{{ optional($task->donation)->id ?? '—' }}</div>
                <div class="text-xs text-gray-600">From: {{ $task->pickup_location }} → To: {{ $task->dropoff_location }}</div>
                <div class="mt-2 flex items-center gap-2">
                    <form method="post" action="{{ route('volunteer.tasks.start', ['task' => $task->id]) }}">
                        @csrf
                        <button class="px-2 py-1 text-xs rounded bg-accent-500 hover:brightness-95 text-white"><i class="fa-solid fa-play mr-1"></i>Start</button>
                    </form>
                </div>
            </li>
            @empty
            <li class="text-sm text-gray-500">None</li>
            @endforelse
        </ul>
    </div>
    <div class="bg-white rounded p-4 shadow">
        <h2 class="font-semibold mb-1"><i class="fa-solid fa-spinner mr-1"></i>In progress</h2>
        <p class="text-xs text-gray-500 mb-2">in_progress</p>
        <ul class="space-y-2">
            @forelse(($grouped['in_progress'] ?? []) as $task)
            <li class="border rounded p-2">
                <div class="text-sm">Donation #{{ optional($task->donation)->id ?? '—' }}</div>
                <div class="text-xs text-gray-600">From: {{ $task->pickup_location }} → To: {{ $task->dropoff_location }}</div>
                <div class="mt-2 flex items-center gap-2">
                    <form method="post" action="{{ route('volunteer.tasks.complete', ['task' => $task->id]) }}">
                        @csrf
                        <button class="px-2 py-1 text-xs rounded bg-primary-700 hover:bg-primary-800 text-white"><i class="fa-solid fa-circle-check mr-1"></i>Delivered</button>
                    </form>
                </div>
            </li>
            @empty
            <li class="text-sm text-gray-500">None</li>
            @endforelse
        </ul>
    </div>
    <div class="bg-white rounded p-4 shadow">
        <h2 class="font-semibold mb-1"><i class="fa-solid fa-circle-check mr-1"></i>Completed</h2>
        <p class="text-xs text-gray-500 mb-2">completed</p>
        <ul class="space-y-2">
            @forelse(($grouped['completed'] ?? []) as $task)
            <li class="border rounded p-2">
                <div class="text-sm">Donation #{{ optional($task->donation)->id ?? '—' }}</div>
                <div class="text-xs text-gray-600">From: {{ $task->pickup_location }} → To: {{ $task->dropoff_location }}</div>
                <div class="mt-2 text-xs text-gray-500">Completed</div>
            </li>
            @empty
            <li class="text-sm text-gray-500">None</li>
            @endforelse
        </ul>
    </div>
</div>

<div class="bg-white rounded p-4 shadow">
    <h2 class="font-semibold mb-3">All tasks</h2>
    <table class="w-full text-sm">
        <thead>
            <tr class="text-left border-b">
                <th class="py-2"><i class="fa-solid fa-hand-holding-heart mr-1"></i>Donor</th>
                <th class="py-2"><i class="fa-solid fa-location-dot mr-1"></i>Pickup location</th>
                <th class="py-2"><i class="fa-solid fa-location-dot mr-1"></i>Drop-off location</th>
                <th class="py-2"><i class="fa-solid fa-info-circle mr-1"></i>Status</th>
                <th class="py-2"><i class="fa-solid fa-gear mr-1"></i>Update</th>
            </tr>
        </thead>
        <tbody>
            @forelse(($tasks ?? []) as $task)
            <tr class="border-b">
                <td class="py-2">{{ optional($task->donation)->id ? 'Donation #' . $task->donation->id : '—' }}</td>
                <td class="py-2">{{ $task->pickup_location }}</td>
                <td class="py-2">{{ $task->dropoff_location }}</td>
                <td class="py-2"><span class="px-2 py-1 rounded bg-gray-100">{{ $task->status }}</span></td>
                <td class="py-2">
                    <div class="flex items-center gap-2">
                        @if($task->status === 'assigned')
                        <form method="post" action="{{ route('volunteer.tasks.start', ['task' => $task->id]) }}">
                            @csrf
                            <button class="px-2 py-1 text-xs rounded bg-accent-500 hover:brightness-95 text-white"><i class="fa-solid fa-play mr-1"></i>Start</button>
                        </form>
                        @endif
                        @if($task->status === 'in_progress')
                        <form method="post" action="{{ route('volunteer.tasks.complete', ['task' => $task->id]) }}">
                            @csrf
                            <button class="px-2 py-1 text-xs rounded bg-primary-700 hover:bg-primary-800 text-white"><i class="fa-solid fa-circle-check mr-1"></i>Complete</button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td class="py-4 text-center text-gray-500" colspan="5">No tasks</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection



