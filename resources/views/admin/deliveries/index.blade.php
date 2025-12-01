@extends('layouts.app')

@section('content')
<x-page-header
    title="Delivery tasks management"
    subtitle="Manage and monitor all delivery tasks"
    icon="fa-solid fa-truck"
>
    <x-slot name="action">
        <div class="flex gap-2">
            <form method="get" class="flex gap-2">
                <x-input
                    name="q"
                    type="text"
                    :value="$q"
                    placeholder="Search..."
                    class="w-64"
                />
                <x-button type="submit" variant="primary" size="sm">
                    <i class="fa-solid fa-search mr-1"></i>Search
                </x-button>
            </form>
            <x-button variant="success" size="sm" href="{{ route('admin.deliveries.create') }}">
                <i class="fa-solid fa-plus mr-1"></i>Add task
            </x-button>
        </div>
    </x-slot>
</x-page-header>

@if(session('status'))
    <x-alert variant="success" icon="fa-solid fa-circle-check" class="mb-4">
        {{ session('status') }}
    </x-alert>
@endif

<x-card class="overflow-x-auto">
    <x-ui.table>
        <x-ui.table-header>
            <x-ui.table-row>
                <x-ui.table-head>#</x-ui.table-head>
                <x-ui.table-head>Volunteer</x-ui.table-head>
                <x-ui.table-head>Donation</x-ui.table-head>
                <x-ui.table-head>Pickup</x-ui.table-head>
                <x-ui.table-head>Drop-off</x-ui.table-head>
                <x-ui.table-head>Status</x-ui.table-head>
                <x-ui.table-head>Actions</x-ui.table-head>
            </x-ui.table-row>
        </x-ui.table-header>
        <x-ui.table-body>
            @forelse($deliveries as $delivery)
                <x-ui.table-row>
                    <x-ui.table-cell>{{ $delivery->id }}</x-ui.table-cell>
                    <x-ui.table-cell>{{ optional($delivery->volunteer)->name ?? '-' }}</x-ui.table-cell>
                    <x-ui.table-cell>#{{ optional($delivery->donation)->id }} - {{ optional($delivery->donation)->food_type }}</x-ui.table-cell>
                    <x-ui.table-cell>{{ $delivery->pickup_location }}</x-ui.table-cell>
                    <x-ui.table-cell>{{ $delivery->dropoff_location }}</x-ui.table-cell>
                    <x-ui.table-cell>
                        <x-badge :variant="$delivery->status === 'completed' ? 'success' : ($delivery->status === 'in_transit' ? 'warning' : 'info')">
                            {{ ucfirst(str_replace('_', ' ', $delivery->status)) }}
                        </x-badge>
                    </x-ui.table-cell>
                    <x-ui.table-cell>
                        <div class="flex gap-2">
                            <x-button variant="ghost" size="sm" href="{{ route('admin.deliveries.edit', $delivery) }}">
                                <i class="fa-solid fa-edit"></i>
                            </x-button>
                            <form method="post" action="{{ route('admin.deliveries.destroy', $delivery) }}" onsubmit="return confirm('Delete task?');">
                                @csrf
                                @method('delete')
                                <x-button type="submit" variant="ghost" size="sm" class="text-red-600 hover:text-red-700">
                                    <i class="fa-solid fa-trash"></i>
                                </x-button>
                            </form>
                        </div>
                    </x-ui.table-cell>
                </x-ui.table-row>
            @empty
                <x-ui.table-row>
                    <x-ui.table-cell colspan="7" class="text-center text-gray-500">
                        <i class="fa-solid fa-inbox text-3xl mb-2 block"></i>
                        No delivery tasks found
                    </x-ui.table-cell>
                </x-ui.table-row>
            @endforelse
        </x-ui.table-body>
    </x-ui.table>
</x-card>

<div class="mt-4">
    {{ $deliveries->links() }}
</div>
@endsection


