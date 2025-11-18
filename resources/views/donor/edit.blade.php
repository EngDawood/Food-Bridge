@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-xl font-bold mb-4"><i class="fa-solid fa-pen-to-square mr-2"></i>Edit donation</h1>
    <form method="POST" action="{{ route('donations.update', $donation) }}">
        @csrf
        @method('PUT')
        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="block mb-1"><i class="fa-solid fa-utensils mr-1"></i>Food type</label>
                <select name="food_type" class="w-full border rounded px-3 py-2" required>
                    <option value="">Select food type</option>
                    @foreach(\App\Helpers\FoodTypes::all() as $value => $label)
                        <option value="{{ $value }}" @selected(old('food_type', $donation->food_type) === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block mb-1"><i class="fa-solid fa-hashtag mr-1"></i>Quantity</label>
                <input name="quantity" value="{{ old('quantity', $donation->quantity) }}" type="number" class="w-full border rounded px-3 py-2" min="1" required>
            </div>
            <div>
                <label class="block mb-1"><i class="fa-solid fa-calendar mr-1"></i>Expiration date</label>
                <input name="expiration_date" value="{{ old('expiration_date', optional($donation->expiration_date)->format('Y-m-d')) }}" type="date" class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block mb-1"><i class="fa-solid fa-clock mr-1"></i>Pickup time</label>
                <input name="pickup_time" value="{{ old('pickup_time', optional($donation->pickup_time)->format('Y-m-d\TH:i')) }}" type="datetime-local" class="w-full border rounded px-3 py-2">
            </div>
        </div>
        <div class="mt-4">
            <button class="bg-primary-700 hover:bg-primary-800 text-white px-4 py-2 rounded"><i class="fa-solid fa-floppy-disk mr-1"></i>Update</button>
            <a href="/donations" class="ml-2 underline">Cancel</a>
        </div>
    </form>
</div>
@endsection


