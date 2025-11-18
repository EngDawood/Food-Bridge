@extends('layouts.app')

@section('content')
<h1 class="text-xl font-semibold mb-4">Edit delivery task #{{ $task->id }}</h1>

<form method="post" action="{{ route('admin.deliveries.update', $task) }}" class="space-y-3 max-w-xl">
    @csrf
    @method('put')

    <div>
        <label class="block text-sm mb-1">Volunteer</label>
        <select name="volunteer_id" class="border rounded w-full px-2 py-1">
            @foreach($volunteers as $v)
                <option value="{{ $v->id }}" @selected(old('volunteer_id', $task->volunteer_id) == $v->id)>{{ $v->name }}</option>
            @endforeach
        </select>
        @error('volunteer_id')<div class="text-red-700 text-sm">{{ $message }}</div>@enderror
    </div>

    <div>
        <label class="block text-sm mb-1">Donation</label>
        <select name="donation_id" class="border rounded w-full px-2 py-1">
            @foreach($donations as $d)
                <option value="{{ $d->id }}" @selected(old('donation_id', $task->donation_id) == $d->id)>#{{ $d->id }} - {{ $d->food_type }}</option>
            @endforeach
        </select>
        @error('donation_id')<div class="text-red-700 text-sm">{{ $message }}</div>@enderror
    </div>

    <div>
        <label class="block text-sm mb-1">Pickup location</label>
        <input name="pickup_location" value="{{ old('pickup_location', $task->pickup_location) }}" class="border rounded w-full px-2 py-1" />
        @error('pickup_location')<div class="text-red-700 text-sm">{{ $message }}</div>@enderror
    </div>

    <div>
        <label class="block text-sm mb-1">Drop-off location</label>
        <input name="dropoff_location" value="{{ old('dropoff_location', $task->dropoff_location) }}" class="border rounded w-full px-2 py-1" />
        @error('dropoff_location')<div class="text-red-700 text-sm">{{ $message }}</div>@enderror
    </div>

    <div>
        <label class="block text-sm mb-1">Status</label>
        <select name="status" class="border rounded w-full px-2 py-1">
            @foreach(['assigned' => 'Assigned', 'in_progress' => 'In progress', 'completed' => 'Completed'] as $val => $label)
                <option value="{{ $val }}" @selected(old('status', $task->status) === $val)>{{ $label }}</option>
            @endforeach
        </select>
        @error('status')<div class="text-red-700 text-sm">{{ $message }}</div>@enderror
    </div>

    <div class="flex gap-2">
        <button class="bg-primary-700 hover:bg-primary-800 text-white px-4 py-2 rounded">Save</button>
        <a class="px-4 py-2 border rounded" href="{{ route('admin.deliveries.index') }}">Back</a>
    </div>
</form>
@endsection


