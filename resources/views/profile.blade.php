@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <!-- Header Card -->
    <x-card class="bg-gradient-to-r from-primary-800 to-primary-700 text-white">
        <div class="flex items-center gap-4">
            <div class="h-16 w-16 rounded-full bg-white/20 flex items-center justify-center flex-shrink-0">
                <i class="fa-solid fa-user text-white text-2xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold">{{ $user->name }}</h1>
                <p class="text-primary-100 flex items-center gap-2 mt-1">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-white/20">
                        {{ ucfirst($user->role) }}
                    </span>
                    @if($user->location)
                        <span class="text-sm"><i class="fa-solid fa-location-dot mr-1"></i>{{ $user->location }}</span>
                    @endif
                </p>
            </div>
        </div>
    </x-card>

    <!-- Profile Information Card -->
    <x-card>
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-primary-800">
                <i class="fa-solid fa-id-card mr-2"></i>Profile Information
            </h2>
        </div>

        <!-- Success Message -->
        @if(session('status'))
            <x-alert variant="success" icon="fa-solid fa-circle-check" class="mb-6">
                {{ session('status') }}
            </x-alert>
        @endif

        <!-- Error Messages -->
        @if($errors->any())
            <x-alert variant="error" icon="fa-solid fa-circle-exclamation" class="mb-6">
                <x-slot name="title">Please fix the following errors</x-slot>
                <ul class="text-sm space-y-0.5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </x-alert>
        @endif

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf

            <div class="grid md:grid-cols-2 gap-6">
                <!-- Name Field -->
                <x-input
                    label="Full Name"
                    icon="fa-solid fa-user"
                    name="name"
                    type="text"
                    :value="old('name', $user->name)"
                    :error="$errors->first('name')"
                    required
                />

                <!-- Role Field -->
                @if($user->role === 'admin')
                    <x-select
                        label="Role"
                        icon="fa-solid fa-user-tag"
                        name="role"
                        :selected="old('role', $user->role)"
                        :error="$errors->first('role')"
                    >
                        <option value="donor">Donor</option>
                        <option value="beneficiary">Beneficiary</option>
                        <option value="volunteer">Volunteer</option>
                        <option value="admin">Admin</option>
                    </x-select>
                @else
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-gray-700">
                            <i class="fa-solid fa-user-tag mr-1 text-primary-700"></i>Role
                        </label>
                        <div class="px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg text-gray-600">
                            {{ ucfirst($user->role) }}
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Role cannot be changed. Contact admin if needed.</p>
                    </div>
                @endif

                <!-- Email Field -->
                <x-input
                    label="Email Address"
                    icon="fa-solid fa-envelope"
                    name="email"
                    type="email"
                    :value="old('email', $user->email)"
                    :error="$errors->first('email')"
                    required
                    class="md:col-span-2"
                />

                <!-- Location Field -->
                <x-input
                    label="Location"
                    icon="fa-solid fa-location-dot"
                    name="location"
                    type="text"
                    :value="old('location', $user->location)"
                    placeholder="City, district, or area"
                    :error="$errors->first('location')"
                    class="md:col-span-2"
                />
            </div>

            <!-- Save Button -->
            <div class="mt-6 flex gap-3">
                <x-button type="submit" variant="primary">
                    <i class="fa-solid fa-floppy-disk mr-2"></i>Save Changes
                </x-button>
                <x-button variant="secondary" href="{{ url()->previous() }}">
                    Cancel
                </x-button>
            </div>
        </form>
    </x-card>

    <!-- Account Statistics Card (Optional Enhancement) -->
    <x-card>
        <h2 class="text-xl font-bold text-primary-800 mb-4">
            <i class="fa-solid fa-chart-simple mr-2"></i>Account Activity
        </h2>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-primary-50 rounded-lg p-4 border border-primary-200">
                <div class="text-primary-700 text-sm font-medium mb-1">Member Since</div>
                <div class="text-primary-900 text-xl font-bold">{{ $user->created_at->format('M Y') }}</div>
            </div>
            <div class="bg-primary-50 rounded-lg p-4 border border-primary-200">
                <div class="text-primary-700 text-sm font-medium mb-1">Account Status</div>
                <div class="text-primary-900 text-xl font-bold">Active</div>
            </div>
            <div class="bg-primary-50 rounded-lg p-4 border border-primary-200">
                <div class="text-primary-700 text-sm font-medium mb-1">Rating</div>
                <div class="text-primary-900 text-xl font-bold">
                    <i class="fa-solid fa-star text-accent-500"></i> Coming Soon
                </div>
            </div>
        </div>
    </x-card>
</div>
@endsection


