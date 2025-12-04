@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto">
    <!-- Header Card -->
    <x-card class="bg-gradient-to-r from-primary-800 to-primary-700 text-white text-center mb-6">
        <div class="flex items-center justify-center mb-3">
            <div class="h-16 w-16 rounded-full bg-white/20 flex items-center justify-center">
                <i class="fa-solid fa-right-to-bracket text-white text-2xl"></i>
            </div>
        </div>
        <h1 class="text-2xl font-bold mb-2">Welcome back</h1>
        <p class="text-primary-100">Sign in to your FoodBridge account</p>
    </x-card>

    <!-- Login Card -->
    <x-card>
        @php($chosenRole = $role ?? null)

        <!-- Role Selection -->
        @if(!$chosenRole)
            <div class="mb-6">
                <label class="text-sm font-semibold text-primary-800 mb-3 block"><i class="fa-solid fa-user-tag mr-1"></i>Select your role</label>
                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('login.role', ['role' => 'admin']) }}"
                       class="group flex flex-col items-center justify-center p-5 rounded-lg border-2 transition-all @if(request()->is('login/admin')) border-primary-700 bg-primary-100 @else border-gray-300 hover:border-primary-700 hover:bg-primary-50 @endif">
                        <i class="fa-solid fa-user-shield text-3xl mb-2 @if(request()->is('login/admin')) text-primary-800 @else text-gray-400 group-hover:text-primary-700 @endif"></i>
                        <span class="text-sm font-semibold @if(request()->is('login/admin')) text-primary-800 @else text-gray-700 group-hover:text-primary-800 @endif">Admin</span>
                    </a>
                    <a href="{{ route('login.role', ['role' => 'donor']) }}"
                       class="group flex flex-col items-center justify-center p-5 rounded-lg border-2 transition-all @if(request()->is('login/donor')) border-primary-700 bg-primary-100 @else border-gray-300 hover:border-primary-700 hover:bg-primary-50 @endif">
                        <i class="fa-solid fa-hand-holding-heart text-3xl mb-2 @if(request()->is('login/donor')) text-primary-800 @else text-gray-400 group-hover:text-primary-700 @endif"></i>
                        <span class="text-sm font-semibold @if(request()->is('login/donor')) text-primary-800 @else text-gray-700 group-hover:text-primary-800 @endif">Donor</span>
                    </a>
                    <a href="{{ route('login.role', ['role' => 'beneficiary']) }}"
                       class="group flex flex-col items-center justify-center p-5 rounded-lg border-2 transition-all @if(request()->is('login/beneficiary')) border-primary-700 bg-primary-100 @else border-gray-300 hover:border-primary-700 hover:bg-primary-50 @endif">
                        <i class="fa-solid fa-hands-helping text-3xl mb-2 @if(request()->is('login/beneficiary')) text-primary-800 @else text-gray-400 group-hover:text-primary-700 @endif"></i>
                        <span class="text-sm font-semibold @if(request()->is('login/beneficiary')) text-primary-800 @else text-gray-700 group-hover:text-primary-800 @endif">Beneficiary</span>
                    </a>
                    <a href="{{ route('login.role', ['role' => 'volunteer']) }}"
                       class="group flex flex-col items-center justify-center p-5 rounded-lg border-2 transition-all @if(request()->is('login/volunteer')) border-primary-700 bg-primary-100 @else border-gray-300 hover:border-primary-700 hover:bg-primary-50 @endif">
                        <i class="fa-solid fa-user-check text-3xl mb-2 @if(request()->is('login/volunteer')) text-primary-800 @else text-gray-400 group-hover:text-primary-700 @endif"></i>
                        <span class="text-sm font-semibold @if(request()->is('login/volunteer')) text-primary-800 @else text-gray-700 group-hover:text-primary-800 @endif">Volunteer</span>
                    </a>
                </div>
            </div>
        @else
            <!-- Selected Role Badge -->
            <div class="mb-6 flex items-center justify-between p-4 rounded-lg bg-primary-100 border border-primary-300">
                <div class="flex items-center gap-3">
                    <div class="h-10 w-10 rounded-full bg-primary-700 flex items-center justify-center">
                        <i class="fa-solid fa-user text-white"></i>
                    </div>
                    <div>
                        <p class="text-xs text-primary-700 font-medium">Signing in as</p>
                        <p class="text-base font-bold text-primary-800">{{ ucfirst($chosenRole) }}</p>
                    </div>
                </div>
                <a href="{{ route('login') }}" class="text-sm text-primary-700 hover:text-primary-800 font-semibold hover:underline">
                    Switch
                </a>
            </div>
        @endif

        <!-- Error Messages -->
        @if($chosenRole && $errors->any())
            <x-alert variant="danger" icon="fa-solid fa-circle-exclamation" class="mb-6">
                <x-slot name="title">There were errors with your submission</x-slot>
                <ul class="text-sm space-y-0.5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </x-alert>
        @endif

        <!-- Login Form -->
        <form method="POST" action="{{ $chosenRole ? route('login.role.post', ['role' => $chosenRole]) : route('login.post') }}" @if(!$chosenRole) style="display: none;" @endif>
            @csrf

            <!-- Email Field -->
            <x-input
                label="Email"
                icon="fa-solid fa-envelope"
                name="email"
                type="email"
                placeholder="name@example.com"
                :value="old('email')"
                :error="$errors->first('email')"
                required
                class="mb-4"
            />

            <!-- Password Field -->
            <x-input
                label="Password"
                icon="fa-solid fa-lock"
                name="password"
                type="password"
                placeholder="Enter your password"
                :error="$errors->first('password')"
                required
                class="mb-4"
            >
                <x-slot name="suffix">
                    <button
                        type="button"
                        onclick="togglePassword('password')"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700">
                        <i class="fa-solid fa-eye" id="password-eye"></i>
                    </button>
                </x-slot>
            </x-input>

            <!-- Remember Me -->
            <div class="mb-6 flex items-center gap-2">
                <input
                    id="remember"
                    name="remember"
                    type="checkbox"
                    class="h-4 w-4 rounded border-gray-300 text-primary-700">
                <label for="remember" class="text-sm text-gray-700 cursor-pointer">
                    Remember me
                </label>
            </div>

            <!-- Submit Button -->
            <x-button type="submit" variant="primary" size="lg" class="w-full">
                <i class="fa-solid fa-right-to-bracket mr-2"></i>Sign in
            </x-button>
        </form>

        <!-- Footer Links -->
        <div class="mt-6 text-center text-sm text-gray-600">
            Don't have an account?
            <a href="{{ route('register') }}" class="text-primary-700 hover:text-primary-800 font-semibold hover:underline">Sign up</a>
        </div>
    </x-card>
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


