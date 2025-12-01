@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <!-- Header -->
    <x-page-header
        title="Edit donation"
        subtitle="Update your donation details"
        icon="fa-solid fa-pen-to-square"
    />

    <!-- Form Card -->
    <x-card>
        <form method="POST" action="{{ route('donations.update', $donation) }}">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Food Type -->
                <x-select
                    label="Food type"
                    icon="fa-solid fa-utensils"
                    name="food_type"
                    :selected="old('food_type', $donation->food_type)"
                    placeholder="Select food type"
                    :error="$errors->first('food_type')"
                    required
                >
                    @foreach(\App\Helpers\FoodTypes::all() as $value => $label)
                        <option value="{{ $value }}" @selected(old('food_type', $donation->food_type) === $value)>{{ $label }}</option>
                    @endforeach
                </x-select>

                <!-- Quantity -->
                <x-input
                    label="Quantity"
                    icon="fa-solid fa-hashtag"
                    name="quantity"
                    type="number"
                    :value="old('quantity', $donation->quantity)"
                    placeholder="e.g., 10"
                    :error="$errors->first('quantity')"
                    min="1"
                    required
                />

                <!-- Expiration Date -->
                <x-input
                    label="Expiration date"
                    icon="fa-solid fa-calendar"
                    name="expiration_date"
                    type="date"
                    :value="old('expiration_date', optional($donation->expiration_date)->format('Y-m-d'))"
                    :error="$errors->first('expiration_date')"
                />

                <!-- Pickup Time -->
                <x-input
                    label="Pickup time"
                    icon="fa-solid fa-clock"
                    name="pickup_time"
                    type="datetime-local"
                    :value="old('pickup_time', optional($donation->pickup_time)->format('Y-m-d\TH:i'))"
                    :error="$errors->first('pickup_time')"
                />
            </div>

            <!-- Action Buttons -->
            <div class="mt-8 flex flex-col sm:flex-row gap-3">
                <x-button type="submit" variant="primary">
                    <i class="fa-solid fa-floppy-disk mr-2"></i>Update
                </x-button>
                <x-button variant="secondary" href="/donations">
                    Cancel
                </x-button>
            </div>
        </form>
    </x-card>
</div>
@endsection
