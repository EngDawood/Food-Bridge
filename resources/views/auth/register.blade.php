@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <!-- Header Card -->
    <div class="bg-gradient-to-r from-primary-800 to-primary-700 text-white rounded-lg p-6 shadow-lg text-center mb-6">
        <div class="flex items-center justify-center mb-3">
            <div class="h-16 w-16 rounded-full bg-white/20 flex items-center justify-center">
                <i class="fa-solid fa-user-plus text-white text-2xl"></i>
            </div>
        </div>
        <h1 class="text-2xl font-bold mb-2">Join FoodBridge</h1>
        <p class="text-primary-100">Create your account and start making a difference</p>
    </div>

    <!-- Register Card -->
    <div class="bg-white rounded-lg p-6 shadow">
        <!-- Success Message -->
        @if (session('status'))
            <div class="mb-6 rounded-lg bg-green-50 border border-green-300 p-4">
                <div class="flex items-start gap-2">
                    <i class="fa-solid fa-circle-check text-green-600 mt-0.5"></i>
                    <p class="text-sm text-green-700">{{ session('status') }}</p>
                </div>
            </div>
        @endif

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="mb-6 rounded-lg bg-red-50 border border-red-300 p-4">
                <div class="flex items-start gap-2">
                    <i class="fa-solid fa-circle-exclamation text-red-600 mt-0.5"></i>
                    <div>
                        <h3 class="text-sm font-semibold text-red-800 mb-1">Please fix the following errors</h3>
                        <ul class="text-sm text-red-700 space-y-0.5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('register.post') }}">
            @csrf

            <!-- Name Field -->
            <div class="mb-4">
                <label for="name" class="block mb-2 font-semibold text-gray-700">
                    <i class="fa-solid fa-user mr-1"></i>Full Name
                </label>
                <input
                    id="name"
                    name="name"
                    type="text"
                    value="{{ old('name') }}"
                    placeholder="Enter your full name"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-700 focus:border-transparent @error('name') border-red-400 @enderror"
                    required>
                @error('name')
                    <p class="text-red-600 text-sm mt-1"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                @enderror
            </div>

            <!-- Email Field -->
            <div class="mb-4">
                <label for="email" class="block mb-2 font-semibold text-gray-700">
                    <i class="fa-solid fa-envelope mr-1"></i>Email Address
                </label>
                <input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email') }}"
                    placeholder="name@example.com"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-700 focus:border-transparent @error('email') border-red-400 @enderror"
                    required>
                @error('email')
                    <p class="text-red-600 text-sm mt-1"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                @enderror
            </div>

            <!-- Password Field -->
            <div class="mb-4">
                <label for="password" class="block mb-2 font-semibold text-gray-700">
                    <i class="fa-solid fa-lock mr-1"></i>Password
                </label>
                <div class="relative">
                    <input
                        id="password"
                        name="password"
                        type="password"
                        placeholder="Create a strong password"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg pr-10 focus:outline-none focus:ring-2 focus:ring-primary-700 focus:border-transparent @error('password') border-red-400 @enderror"
                        required>
                    <button
                        type="button"
                        onclick="togglePassword('password')"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700">
                        <i class="fa-solid fa-eye" id="password-eye"></i>
                    </button>
                </div>
                @error('password')
                    <p class="text-red-600 text-sm mt-1"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                @enderror
            </div>

            <!-- Role Selection -->
            <div class="mb-4">
                <label class="block mb-3 font-semibold text-gray-700">
                    <i class="fa-solid fa-user-tag mr-1"></i>Select Your Role
                </label>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5">
                    <label class="relative flex flex-col items-center justify-center p-3 rounded-lg border-2 cursor-pointer transition-all @if(old('role') === 'donor') border-primary-700 bg-primary-100 @else border-gray-300 hover:border-primary-700 hover:bg-primary-50 @endif">
                        <input type="radio" name="role" value="donor" class="sr-only peer" {{ old('role', 'donor') === 'donor' ? 'checked' : '' }} required>
                        <i class="fa-solid fa-hand-holding-heart text-2xl mb-1.5 @if(old('role') === 'donor') text-primary-800 @else text-gray-400 peer-checked:text-primary-800 @endif"></i>
                        <span class="text-sm font-semibold @if(old('role') === 'donor') text-primary-800 @else text-gray-700 peer-checked:text-primary-800 @endif">Donor</span>
                        <span class="text-xs text-gray-500 text-center mt-0.5">Share surplus food</span>
                    </label>
                    <label class="relative flex flex-col items-center justify-center p-3 rounded-lg border-2 cursor-pointer transition-all @if(old('role') === 'beneficiary') border-primary-700 bg-primary-100 @else border-gray-300 hover:border-primary-700 hover:bg-primary-50 @endif">
                        <input type="radio" name="role" value="beneficiary" class="sr-only peer" {{ old('role') === 'beneficiary' ? 'checked' : '' }}>
                        <i class="fa-solid fa-hands-helping text-2xl mb-1.5 @if(old('role') === 'beneficiary') text-primary-800 @else text-gray-400 peer-checked:text-primary-800 @endif"></i>
                        <span class="text-sm font-semibold @if(old('role') === 'beneficiary') text-primary-800 @else text-gray-700 peer-checked:text-primary-800 @endif">Beneficiary</span>
                        <span class="text-xs text-gray-500 text-center mt-0.5">Request food</span>
                    </label>
                    <label class="relative flex flex-col items-center justify-center p-3 rounded-lg border-2 cursor-pointer transition-all @if(old('role') === 'volunteer') border-primary-700 bg-primary-100 @else border-gray-300 hover:border-primary-700 hover:bg-primary-50 @endif">
                        <input type="radio" name="role" value="volunteer" class="sr-only peer" {{ old('role') === 'volunteer' ? 'checked' : '' }}>
                        <i class="fa-solid fa-user-check text-2xl mb-1.5 @if(old('role') === 'volunteer') text-primary-800 @else text-gray-400 peer-checked:text-primary-800 @endif"></i>
                        <span class="text-sm font-semibold @if(old('role') === 'volunteer') text-primary-800 @else text-gray-700 peer-checked:text-primary-800 @endif">Volunteer</span>
                        <span class="text-xs text-gray-500 text-center mt-0.5">Help deliver</span>
                    </label>
                </div>
                @error('role')
                    <p class="text-red-600 text-sm mt-1"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                @enderror
            </div>

            <!-- Location Field -->
            <div class="mb-6">
                <label for="location" class="block mb-2 font-semibold text-gray-700">
                    <i class="fa-solid fa-location-dot mr-1"></i>Location <span class="text-gray-500 font-normal text-sm">(optional)</span>
                </label>
                <input
                    id="location"
                    name="location"
                    type="text"
                    value="{{ old('location') }}"
                    placeholder="City, district, or area"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-700 focus:border-transparent @error('location') border-red-400 @enderror">
                @error('location')
                    <p class="text-red-600 text-sm mt-1"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <button
                type="submit"
                class="w-full bg-accent-500 hover:brightness-95 text-white font-semibold px-4 py-3 rounded-lg transition-all">
                <i class="fa-solid fa-user-plus mr-2"></i>Create Account
            </button>
        </form>

        <!-- Footer Links -->
        <div class="mt-6 text-center text-sm text-gray-600">
            Already have an account?
            <a href="{{ route('login') }}" class="text-primary-700 hover:text-primary-800 font-semibold hover:underline">Sign in</a>
        </div>
    </div>
</div>

<script>
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const eye = document.getElementById(fieldId + '-eye');

    if (field.type === 'password') {
        field.type = 'text';
        eye.classList.remove('fa-eye');
        eye.classList.add('fa-eye-slash');
    } else {
        field.type = 'password';
        eye.classList.remove('fa-eye-slash');
        eye.classList.add('fa-eye');
    }
}
</script>
@endsection


