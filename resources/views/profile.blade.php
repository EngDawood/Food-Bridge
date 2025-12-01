@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <!-- Header Card -->
    <div class="bg-gradient-to-r from-primary-800 to-primary-700 text-white rounded-lg p-6 shadow-lg">
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
    </div>

    <!-- Profile Information Card -->
    <div class="bg-white rounded-lg p-6 shadow">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-primary-800">
                <i class="fa-solid fa-id-card mr-2"></i>Profile Information
            </h2>
        </div>

        <!-- Success Message -->
        @if(session('status'))
            <div class="mb-6 rounded-lg bg-green-50 border border-green-300 p-4">
                <div class="flex items-start gap-2">
                    <i class="fa-solid fa-circle-check text-green-600 mt-0.5"></i>
                    <p class="text-sm text-green-700">{{ session('status') }}</p>
                </div>
            </div>
        @endif

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

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf

            <div class="grid md:grid-cols-2 gap-6">
                <!-- Name Field -->
                <div>
                    <label for="name" class="block mb-2 font-semibold text-gray-700">
                        <i class="fa-solid fa-user mr-1"></i>Full Name
                    </label>
                    <input
                        id="name"
                        type="text"
                        name="name"
                        value="{{ old('name', $user->name) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-700 focus:border-transparent @error('name') border-red-400 @enderror"
                        required>
                    @error('name')
                        <p class="text-red-600 text-sm mt-1"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Role Field -->
                <div>
                    <label for="role" class="block mb-2 font-semibold text-gray-700">
                        <i class="fa-solid fa-user-tag mr-1"></i>Role
                    </label>
                    @if($user->role === 'admin')
                        <select
                            id="role"
                            name="role"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-700 focus:border-transparent @error('role') border-red-400 @enderror">
                            <option value="donor" {{ old('role', $user->role) === 'donor' ? 'selected' : '' }}>Donor</option>
                            <option value="beneficiary" {{ old('role', $user->role) === 'beneficiary' ? 'selected' : '' }}>Beneficiary</option>
                            <option value="volunteer" {{ old('role', $user->role) === 'volunteer' ? 'selected' : '' }}>Volunteer</option>
                            <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    @else
                        <div class="px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg text-gray-600">
                            {{ ucfirst($user->role) }}
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Role cannot be changed. Contact admin if needed.</p>
                    @endif
                    @error('role')
                        <p class="text-red-600 text-sm mt-1"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email Field -->
                <div class="md:col-span-2">
                    <label for="email" class="block mb-2 font-semibold text-gray-700">
                        <i class="fa-solid fa-envelope mr-1"></i>Email Address
                    </label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email', $user->email) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-700 focus:border-transparent @error('email') border-red-400 @enderror"
                        required>
                    @error('email')
                        <p class="text-red-600 text-sm mt-1"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Location Field -->
                <div class="md:col-span-2">
                    <label for="location" class="block mb-2 font-semibold text-gray-700">
                        <i class="fa-solid fa-location-dot mr-1"></i>Location
                    </label>
                    <input
                        id="location"
                        type="text"
                        name="location"
                        value="{{ old('location', $user->location) }}"
                        placeholder="City, district, or area"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-700 focus:border-transparent @error('location') border-red-400 @enderror">
                    @error('location')
                        <p class="text-red-600 text-sm mt-1"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Save Button -->
            <div class="mt-6 flex gap-3">
                <button
                    type="submit"
                    class="bg-primary-700 hover:bg-primary-800 text-white font-semibold px-6 py-2.5 rounded-lg transition-colors">
                    <i class="fa-solid fa-floppy-disk mr-2"></i>Save Changes
                </button>
                <a
                    href="{{ url()->previous() }}"
                    class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold px-6 py-2.5 rounded-lg transition-colors">
                    Cancel
                </a>
            </div>
        </form>
    </div>

    <!-- Account Statistics Card (Optional Enhancement) -->
    <div class="bg-white rounded-lg p-6 shadow">
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
    </div>
</div>
@endsection


