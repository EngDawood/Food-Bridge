@extends('layouts.app')

@section('content')
<h1 class="text-xl font-semibold mb-4">Edit donation #{{ $donation->id }}</h1>

<form method="post" action="{{ route('admin.donations.update', $donation) }}" class="space-y-3 max-w-xl">
    @csrf
    @method('put')

    <div>
        <label class="block text-sm mb-1">Food type</label>
        <select name="food_type" class="border rounded w-full px-2 py-1">
            <option value="">Select food type</option>
            @foreach(\App\Helpers\FoodTypes::all() as $value => $label)
                <option value="{{ $value }}" @selected(old('food_type', $donation->food_type) === $value)>{{ $label }}</option>
            @endforeach
        </select>
        @error('food_type')<div class="text-red-700 text-sm">{{ $message }}</div>@enderror
    </div>

    <div>
        <label class="block text-sm mb-1">Quantity</label>
        <input type="number" name="quantity" value="{{ old('quantity', $donation->quantity) }}" class="border rounded w-full px-2 py-1" />
        @error('quantity')<div class="text-red-700 text-sm">{{ $message }}</div>@enderror
    </div>

    <div>
        <label class="block text-sm mb-1">Expiration date</label>
        <input type="date" name="expiration_date" value="{{ old('expiration_date', optional($donation->expiration_date)->format('Y-m-d')) }}" class="border rounded w-full px-2 py-1" />
        @error('expiration_date')<div class="text-red-700 text-sm">{{ $message }}</div>@enderror
    </div>

    <div>
        <label class="block text-sm mb-1">Pickup time</label>
        <input type="datetime-local" name="pickup_time" value="{{ old('pickup_time', optional($donation->pickup_time)?->format('Y-m-d\TH:i')) }}" class="border rounded w-full px-2 py-1" />
        @error('pickup_time')<div class="text-red-700 text-sm">{{ $message }}</div>@enderror
    </div>

    <div>
        <label class="block text-sm mb-1">Status</label>
        <select name="status" class="border rounded w-full px-2 py-1">
            @foreach(['pending' => 'Pending', 'scheduled' => 'Scheduled', 'delivered' => 'Delivered'] as $val => $label)
                <option value="{{ $val }}" @selected(old('status', $donation->status) === $val)>{{ $label }}</option>
            @endforeach
        </select>
        @error('status')<div class="text-red-700 text-sm">{{ $message }}</div>@enderror
    </div>

    <div class="flex gap-2">
        <button class="bg-primary-700 hover:bg-primary-800 text-white px-4 py-2 rounded">Save</button>
        <a class="px-4 py-2 border rounded" href="{{ route('admin.donations.index') }}">Back</a>
    </div>
</form>
@endsection


