@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-4 sm:p-6 rounded shadow">
    <h1 class="text-xl font-bold mb-4"><i class="fa-solid fa-plus mr-2"></i>Add donation</h1>
    <form method="POST" action="{{ route('donations.store') }}">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block mb-2 text-base font-medium"><i class="fa-solid fa-utensils mr-1"></i>Food type</label>
                <select name="food_type" class="w-full border rounded px-3 py-3 text-base min-h-[48px]" required>
                    <option value="">Select food type</option>
                    @foreach(\App\Helpers\FoodTypes::all() as $value => $label)
                        <option value="{{ $value }}" @selected(old('food_type') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block mb-2 text-base font-medium"><i class="fa-solid fa-hashtag mr-1"></i>Quantity</label>
                <input name="quantity" type="number" class="w-full border rounded px-3 py-3 text-base min-h-[48px]" min="1" required>
            </div>
            <div>
                <label class="block mb-2 text-base font-medium"><i class="fa-solid fa-calendar mr-1"></i>Expiration date</label>
                <input name="expiration_date" type="date" class="w-full border rounded px-3 py-3 text-base min-h-[48px]">
            </div>
            <div>
                <label class="block mb-2 text-base font-medium"><i class="fa-solid fa-clock mr-1"></i>Pickup time</label>
                <input name="pickup_time" type="datetime-local" class="w-full border rounded px-3 py-3 text-base min-h-[48px]">
            </div>
        </div>
        <div class="mt-6 flex flex-col sm:flex-row gap-3">
            <button class="bg-primary-700 hover:bg-primary-800 text-white px-6 py-3 rounded-lg min-h-[48px] font-medium w-full sm:w-auto"><i class="fa-solid fa-floppy-disk mr-2"></i>Save</button>
            <a href="/donations" class="text-center bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-lg min-h-[48px] flex items-center justify-center font-medium w-full sm:w-auto">Cancel</a>
        </div>
    </form>
</div>
@endsection


