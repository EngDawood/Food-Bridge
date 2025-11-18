@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between mb-4">
    <h1 class="text-xl font-semibold">Delivery tasks management</h1>
    <div class="flex gap-2">
        <form method="get" class="flex gap-2">
            <input type="text" name="q" value="{{ $q }}" placeholder="Search..." class="border rounded px-2 py-1" />
            <button class="bg-primary-700 hover:bg-primary-800 text-white px-3 py-1 rounded">Search</button>
        </form>
        <a href="{{ route('admin.deliveries.create') }}" class="bg-green-700 hover:bg-green-800 text-white px-3 py-1 rounded">Add task</a>
    </div>
    
</div>

@if(session('status'))
    <div class="mb-3 p-2 rounded bg-green-100 text-green-800">{{ session('status') }}</div>
@endif

<div class="overflow-x-auto">
    <table class="min-w-full bg-white">
        <thead>
            <tr class="text-left border-b">
                <th class="p-2">#</th>
                <th class="p-2">Volunteer</th>
                <th class="p-2">Donation</th>
                <th class="p-2">Pickup</th>
                <th class="p-2">Drop-off</th>
                <th class="p-2">Status</th>
                <th class="p-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($deliveries as $delivery)
            <tr class="border-b">
                <td class="p-2">{{ $delivery->id }}</td>
                <td class="p-2">{{ optional($delivery->volunteer)->name ?? '-' }}</td>
                <td class="p-2">#{{ optional($delivery->donation)->id }} - {{ optional($delivery->donation)->food_type }}</td>
                <td class="p-2">{{ $delivery->pickup_location }}</td>
                <td class="p-2">{{ $delivery->dropoff_location }}</td>
                <td class="p-2">{{ $delivery->status }}</td>
                <td class="p-2 flex gap-2">
                    <a class="text-blue-700" href="{{ route('admin.deliveries.edit', $delivery) }}">Edit</a>
                    <form method="post" action="{{ route('admin.deliveries.destroy', $delivery) }}" onsubmit="return confirm('Delete task?');">
                        @csrf
                        @method('delete')
                        <button class="text-red-700">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td class="p-3" colspan="7">No records</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="mt-4">{{ $deliveries->links() }}</div>
@endsection


