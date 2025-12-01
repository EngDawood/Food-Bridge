@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <x-page-header
        title="Available delivery tasks"
        subtitle="Browse and claim delivery tasks"
        icon="fa-solid fa-tasks"
    >
        <x-slot name="action">
            <div class="flex items-center gap-2">
                <x-button variant="secondary" size="sm" onclick="window.location.reload()">
                    <i class="fa-solid fa-rotate mr-1"></i>Refresh
                </x-button>
                <x-button variant="primary" size="sm" href="/volunteer/tasks">
                    <i class="fa-solid fa-clipboard-check mr-1"></i>My Tasks
                </x-button>
            </div>
        </x-slot>
    </x-page-header>

    <!-- Tasks Table Card -->
    <x-card title="Tasks list">
        <x-ui.table>
            <x-ui.table-header>
                <x-ui.table-row>
                    <x-ui.table-head>
                        <i class="fa-solid fa-hand-holding-heart mr-1"></i>Donation
                    </x-ui.table-head>
                    <x-ui.table-head>
                        <i class="fa-solid fa-location-dot mr-1"></i>Pickup location
                    </x-ui.table-head>
                    <x-ui.table-head>
                        <i class="fa-solid fa-location-dot mr-1"></i>Drop-off location
                    </x-ui.table-head>
                    <x-ui.table-head>
                        <i class="fa-solid fa-info-circle mr-1"></i>Status
                    </x-ui.table-head>
                    <x-ui.table-head>
                        <i class="fa-solid fa-hand mr-1"></i>Action
                    </x-ui.table-head>
                </x-ui.table-row>
            </x-ui.table-header>

            <x-ui.table-body>
                @forelse(($availableTasks ?? []) as $task)
                    <x-ui.table-row>
                        <x-ui.table-cell>
                            {{ optional($task->donation)->id ? 'Donation #' . $task->donation->id : '—' }}
                        </x-ui.table-cell>
                        <x-ui.table-cell>
                            {{ $task->pickup_location }}
                        </x-ui.table-cell>
                        <x-ui.table-cell>
                            {{ $task->dropoff_location }}
                        </x-ui.table-cell>
                        <x-ui.table-cell>
                            <x-badge variant="pending">
                                {{ $task->status }}
                            </x-badge>
                        </x-ui.table-cell>
                        <x-ui.table-cell>
                            <form method="post" action="{{ route('volunteer.tasks.claim', ['task' => $task->id]) }}">
                                @csrf
                                <x-button type="submit" variant="accent" size="sm">
                                    <i class="fa-solid fa-hand mr-1"></i>Claim
                                </x-button>
                            </form>
                        </x-ui.table-cell>
                    </x-ui.table-row>
                @empty
                    <x-ui.table-row>
                        <x-ui.table-cell colspan="5" class="text-center py-8">
                            <div class="flex flex-col items-center justify-center text-gray-400">
                                <i class="fa-solid fa-inbox text-4xl mb-3"></i>
                                <p class="text-lg font-medium text-gray-600">No tasks available right now</p>
                                <p class="text-sm text-gray-500 mt-1">Check back later for new delivery tasks</p>
                            </div>
                        </x-ui.table-cell>
                    </x-ui.table-row>
                @endforelse
            </x-ui.table-body>
        </x-ui.table>
    </x-card>
</div>
@endsection
