@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-xl font-bold mb-4"><i class="fa-solid fa-pen-to-square mr-2"></i>Edit request</h1>
    <form method="POST" action="{{ route('requests.update', $request) }}">
        @csrf
        @method('PUT')
        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="block mb-1"><i class="fa-solid fa-utensils mr-1"></i>Food type</label>
                <select name="food_type" class="w-full border rounded px-3 py-2" required>
                    <option value="">Select food type</option>
                    @foreach(\App\Helpers\FoodTypes::all() as $value => $label)
                        <option value="{{ $value }}" @selected(old('food_type', $request->food_type) === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block mb-1"><i class="fa-solid fa-hashtag mr-1"></i>Quantity</label>
                <input name="quantity" value="{{ old('quantity', $request->quantity) }}" type="number" class="w-full border rounded px-3 py-2" min="1" required>
            </div>
            <div class="md:col-span-2">
                <label class="block mb-1"><i class="fa-solid fa-sticky-note mr-1"></i>Note</label>
                <textarea name="note" class="w-full border rounded px-3 py-2" rows="3">{{ old('note', $request->note) }}</textarea>
            </div>
        </div>
        <div class="mt-4">
            <button class="bg-primary-700 hover:bg-primary-800 text-white px-4 py-2 rounded"><i class="fa-solid fa-paper-plane mr-1"></i>Update</button>
            <a href="/requests" class="ml-2 underline">Cancel</a>
        </div>
    </form>
</div>
@endsection


