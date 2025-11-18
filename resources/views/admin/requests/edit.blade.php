@extends('layouts.app')

@section('content')
<h1 class="text-xl font-semibold mb-4">Edit request #{{ $request->id }}</h1>

<form method="post" action="{{ route('admin.requests.update', $request) }}" class="space-y-3 max-w-xl">
    @csrf
    @method('put')

    <div>
        <label class="block text-sm mb-1">Food type</label>
        <select name="food_type" class="border rounded w-full px-2 py-1">
            <option value="">Select food type</option>
            @foreach(\App\Helpers\FoodTypes::all() as $value => $label)
                <option value="{{ $value }}" @selected(old('food_type', $request->food_type) === $value)>{{ $label }}</option>
            @endforeach
        </select>
        @error('food_type')<div class="text-red-700 text-sm">{{ $message }}</div>@enderror
    </div>

    <div>
        <label class="block text-sm mb-1">Quantity</label>
        <input type="number" name="quantity" value="{{ old('quantity', $request->quantity) }}" class="border rounded w-full px-2 py-1" />
        @error('quantity')<div class="text-red-700 text-sm">{{ $message }}</div>@enderror
    </div>

    <div>
        <label class="block text-sm mb-1">Note</label>
        <textarea name="note" class="border rounded w-full px-2 py-1">{{ old('note', $request->note) }}</textarea>
        @error('note')<div class="text-red-700 text-sm">{{ $message }}</div>@enderror
    </div>

    <div>
        <label class="block text-sm mb-1">Status</label>
        <select name="status" class="border rounded w-full px-2 py-1">
            @foreach(['pending' => 'Pending', 'matched' => 'Matched', 'fulfilled' => 'Fulfilled'] as $val => $label)
                <option value="{{ $val }}" @selected(old('status', $request->status) === $val)>{{ $label }}</option>
            @endforeach
        </select>
        @error('status')<div class="text-red-700 text-sm">{{ $message }}</div>@enderror
    </div>

    <div class="flex gap-2">
        <button class="bg-primary-700 hover:bg-primary-800 text-white px-4 py-2 rounded">Save</button>
        <a class="px-4 py-2 border rounded" href="{{ route('admin.requests.index') }}">Back</a>
    </div>
</form>
@endsection


