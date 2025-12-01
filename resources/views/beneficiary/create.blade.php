@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <!-- Header -->
    <x-page-header
        title="Create request"
        subtitle="Request food items you need"
        icon="fa-solid fa-plus"
    />

    <!-- Form Card -->
    <x-card>
        <form method="POST" action="{{ route('requests.store') }}">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Food Type -->
                <x-select
                    label="Food type"
                    icon="fa-solid fa-utensils"
                    name="food_type"
                    :selected="old('food_type')"
                    placeholder="Select food type"
                    :error="$errors->first('food_type')"
                    required
                >
                    @foreach(\App\Helpers\FoodTypes::all() as $value => $label)
                        <option value="{{ $value }}" @selected(old('food_type') === $value)>{{ $label }}</option>
                    @endforeach
                </x-select>

                <!-- Quantity -->
                <x-input
                    label="Quantity"
                    icon="fa-solid fa-hashtag"
                    name="quantity"
                    type="number"
                    :value="old('quantity')"
                    placeholder="e.g., 10"
                    :error="$errors->first('quantity')"
                    min="1"
                    required
                />
            </div>

            <!-- Note -->
            <div class="mt-6">
                <x-textarea
                    label="Note"
                    icon="fa-solid fa-sticky-note"
                    name="note"
                    rows="3"
                    placeholder="Additional details about your request"
                    :value="old('note')"
                    :error="$errors->first('note')"
                />
            </div>

            <!-- Action Buttons -->
            <div class="mt-8 flex flex-col sm:flex-row gap-3">
                <x-button type="submit" variant="primary">
                    <i class="fa-solid fa-paper-plane mr-2"></i>Submit Request
                </x-button>
                <x-button variant="secondary" href="/requests">
                    Cancel
                </x-button>
            </div>
        </form>
    </x-card>

    <!-- Info Card -->
    <x-alert variant="info" title="Request Guidelines">
        <ul class="text-sm space-y-1">
            <li>• Be specific about the quantity you need</li>
            <li>• Provide additional details in the note section</li>
            <li>• You'll be notified when a match is found</li>
        </ul>
    </x-alert>
</div>
@endsection
