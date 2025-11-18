@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between mb-4">
    <h1 class="text-2xl font-bold"><i class="fa-solid fa-tasks mr-2"></i>Available delivery tasks</h1>
    <div class="flex items-center gap-2">
        <button class="px-3 py-2 text-sm rounded border"><i class="fa-solid fa-rotate mr-1"></i>Refresh</button>
        <a href="/volunteer/tasks" class="px-3 py-2 text-sm rounded bg-primary-700 hover:bg-primary-800 text-white"><i class="fa-solid fa-clipboard-check mr-1"></i>Go to My Tasks</a>
    </div>
</div>

<div class="bg-white rounded p-4 shadow">
    <div class="flex items-center justify-between mb-3">
        <h2 class="font-semibold">Tasks list</h2>
        <div class="text-sm text-gray-600">View as list / map (later)</div>
    </div>

    <table class="w-full text-sm">
        <thead>
            <tr class="text-left border-b">
                <th class="py-2"><i class="fa-solid fa-hand-holding-heart mr-1"></i>Donation</th>
                <th class="py-2"><i class="fa-solid fa-location-dot mr-1"></i>Pickup location</th>
                <th class="py-2"><i class="fa-solid fa-location-dot mr-1"></i>Drop-off location</th>
                <th class="py-2"><i class="fa-solid fa-info-circle mr-1"></i>Status</th>
                <th class="py-2"><i class="fa-solid fa-hand mr-1"></i>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse(($availableTasks ?? []) as $task)
            <tr class="border-b">
                <td class="py-2">{{ optional($task->donation)->id ? 'Donation #' . $task->donation->id : '—' }}</td>
                <td class="py-2">{{ $task->pickup_location }}</td>
                <td class="py-2">{{ $task->dropoff_location }}</td>
                <td class="py-2"><span class="px-2 py-1 rounded bg-gray-100">{{ $task->status }}</span></td>
                <td class="py-2">
                    <form method="post" action="{{ route('volunteer.tasks.claim', ['task' => $task->id]) }}">
                        @csrf
                        <button type="submit" class="px-3 py-1 rounded bg-accent-500 hover:brightness-95 text-white"><i class="fa-solid fa-hand mr-1"></i>Claim</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td class="py-4 text-center text-gray-500" colspan="5">No tasks available right now</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection



