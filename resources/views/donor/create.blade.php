@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <!-- Header Card -->
    <div class="bg-gradient-to-r from-primary-800 to-primary-700 text-white rounded-lg p-6 shadow-lg">
        <div class="flex items-center gap-3">
            <div class="h-12 w-12 rounded-lg bg-white/20 flex items-center justify-center">
                <i class="fa-solid fa-plus text-2xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold">Add donation</h1>
                <p class="text-primary-100 text-sm">Share your surplus food with those in need</p>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-lg p-6 shadow-md border border-gray-200">
        <!-- Error Messages -->
        @if($errors->any())
            <div class="mb-6 rounded-lg bg-red-50 border border-red-300 p-4">
                <div class="flex items-start gap-2">
                    <i class="fa-solid fa-circle-exclamation text-red-600 mt-0.5"></i>
                    <div>
                        <h3 class="text-sm font-semibold text-red-800 mb-1">Please fix the following errors</h3>
                        <ul class="text-sm text-red-700 space-y-0.5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('donations.store') }}">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Food Type -->
                <div>
                    <label for="food_type" class="block mb-2 text-sm font-semibold text-gray-700">
                        <i class="fa-solid fa-utensils mr-1 text-primary-700"></i>Food type
                    </label>
                    <select
                        id="food_type"
                        name="food_type"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-base focus:outline-none focus:ring-2 focus:ring-primary-700 focus:border-transparent @error('food_type') border-red-400 @enderror"
                        required>
                        <option value="">Select food type</option>
                        @foreach(\App\Helpers\FoodTypes::all() as $value => $label)
                            <option value="{{ $value }}" @selected(old('food_type') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('food_type')
                        <p class="text-red-600 text-sm mt-1"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Quantity -->
                <div>
                    <label for="quantity" class="block mb-2 text-sm font-semibold text-gray-700">
                        <i class="fa-solid fa-hashtag mr-1 text-primary-700"></i>Quantity
                    </label>
                    <input
                        id="quantity"
                        name="quantity"
                        type="number"
                        value="{{ old('quantity') }}"
                        placeholder="e.g., 10"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-base focus:outline-none focus:ring-2 focus:ring-primary-700 focus:border-transparent @error('quantity') border-red-400 @enderror"
                        min="1"
                        required>
                    @error('quantity')
                        <p class="text-red-600 text-sm mt-1"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Expiration Date -->
                <div>
                    <label for="expiration_date" class="block mb-2 text-sm font-semibold text-gray-700">
                        <i class="fa-solid fa-calendar mr-1 text-primary-700"></i>Expiration date
                        <span class="text-gray-500 font-normal text-xs">(optional)</span>
                    </label>
                    <input
                        id="expiration_date"
                        name="expiration_date"
                        type="date"
                        value="{{ old('expiration_date') }}"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-base focus:outline-none focus:ring-2 focus:ring-primary-700 focus:border-transparent @error('expiration_date') border-red-400 @enderror">
                    @error('expiration_date')
                        <p class="text-red-600 text-sm mt-1"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Pickup Time -->
                <div>
                    <label for="pickup_time" class="block mb-2 text-sm font-semibold text-gray-700">
                        <i class="fa-solid fa-clock mr-1 text-primary-700"></i>Pickup time
                        <span class="text-gray-500 font-normal text-xs">(optional)</span>
                    </label>
                    <input
                        id="pickup_time"
                        name="pickup_time"
                        type="datetime-local"
                        value="{{ old('pickup_time') }}"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-base focus:outline-none focus:ring-2 focus:ring-primary-700 focus:border-transparent @error('pickup_time') border-red-400 @enderror">
                    @error('pickup_time')
                        <p class="text-red-600 text-sm mt-1"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-8 flex flex-col sm:flex-row gap-3">
                <button
                    type="submit"
                    class="inline-flex items-center justify-center bg-primary-700 hover:bg-primary-800 text-white px-8 py-3 rounded-lg font-semibold shadow-md hover:shadow-lg transition-all w-full sm:w-auto">
                    <i class="fa-solid fa-floppy-disk mr-2"></i>Save donation
                </button>
                <a
                    href="/donations"
                    class="inline-flex items-center justify-center bg-gray-200 hover:bg-gray-300 text-gray-700 px-8 py-3 rounded-lg font-semibold transition-colors w-full sm:w-auto">
                    Cancel
                </a>
            </div>
        </form>
    </div>

    <!-- Info Card -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-5">
        <div class="flex items-start gap-3">
            <div class="h-8 w-8 rounded-lg bg-blue-200 flex items-center justify-center flex-shrink-0">
                <i class="fa-solid fa-lightbulb text-blue-700"></i>
            </div>
            <div>
                <h3 class="font-bold text-blue-900 mb-1">Tips for donating</h3>
                <ul class="text-sm text-blue-700 space-y-1">
                    <li>• Ensure food is fresh and properly stored</li>
                    <li>• Provide accurate expiration dates when available</li>
                    <li>• Specify pickup times for better coordination</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection


