@extends('layouts.app')

@section('content')
<div class="space-y-8">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-primary-800 to-primary-700 text-white rounded-lg p-8 shadow-lg">
        <div class="max-w-3xl mx-auto text-center">
            <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-white/20 mb-4">
                <i class="fa-solid fa-hand-holding-heart text-3xl"></i>
            </div>
            <h1 class="text-4xl font-bold mb-4">Welcome to FoodBridge</h1>
            <p class="text-xl text-primary-100">A simple way to connect donors, beneficiaries, and volunteers to reduce food waste.</p>
        </div>
    </div>

    <!-- How It Works Section -->
    <div class="grid md:grid-cols-3 gap-6">
        <!-- Card 1: How it works -->
        <div class="group bg-white rounded-lg p-6 shadow-md hover:shadow-lg transition-all duration-300 border border-transparent hover:border-primary-300">
            <div class="flex items-center gap-3 mb-4">
                <div class="h-12 w-12 rounded-lg bg-primary-100 flex items-center justify-center group-hover:bg-primary-200 transition-colors">
                    <i class="fa-solid fa-circle-info text-primary-700 text-xl"></i>
                </div>
                <h2 class="text-xl font-bold text-primary-800">How it works</h2>
            </div>
            <div class="space-y-3">
                <div class="flex items-start gap-2">
                    <div class="h-6 w-6 rounded-full bg-primary-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                        <span class="text-primary-700 text-xs font-bold">1</span>
                    </div>
                    <p class="text-gray-700 leading-relaxed">Donors list surplus food</p>
                </div>
                <div class="flex items-start gap-2">
                    <div class="h-6 w-6 rounded-full bg-primary-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                        <span class="text-primary-700 text-xs font-bold">2</span>
                    </div>
                    <p class="text-gray-700 leading-relaxed">Beneficiaries request what they need</p>
                </div>
                <div class="flex items-start gap-2">
                    <div class="h-6 w-6 rounded-full bg-primary-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                        <span class="text-primary-700 text-xs font-bold">3</span>
                    </div>
                    <p class="text-gray-700 leading-relaxed">Volunteers deliver safely</p>
                </div>
            </div>
        </div>

        <!-- Card 2: Our mission -->
        <div class="group bg-white rounded-lg p-6 shadow-md hover:shadow-lg transition-all duration-300 border border-transparent hover:border-accent-300">
            <div class="flex items-center gap-3 mb-4">
                <div class="h-12 w-12 rounded-lg bg-accent-50 flex items-center justify-center group-hover:bg-accent-100 transition-colors">
                    <i class="fa-solid fa-bullseye text-accent-500 text-xl"></i>
                </div>
                <h2 class="text-xl font-bold text-primary-800">Our mission</h2>
            </div>
            <p class="text-gray-700 leading-relaxed">Cut food waste, support families in need, and build a fast, simple community network.</p>
        </div>

        <!-- Card 3: Our values -->
        <div class="group bg-white rounded-lg p-6 shadow-md hover:shadow-lg transition-all duration-300 border border-transparent hover:border-red-300">
            <div class="flex items-center gap-3 mb-4">
                <div class="h-12 w-12 rounded-lg bg-red-50 flex items-center justify-center group-hover:bg-red-100 transition-colors">
                    <i class="fa-solid fa-heart text-red-500 text-xl"></i>
                </div>
                <h2 class="text-xl font-bold text-primary-800">Our values</h2>
            </div>
            <p class="text-gray-700 leading-relaxed">Transparency, safety, and simplicity for everyone.</p>
        </div>
    </div>

    <!-- Call to Action -->
    <div class="bg-gradient-to-br from-primary-50 to-primary-100 rounded-lg p-8 text-center border border-primary-200 shadow-md">
        <h3 class="text-2xl font-bold mb-2 text-primary-800">Get started</h3>
        <p class="mb-6 text-gray-700 text-lg">Create your account in minutes and be part of the solution.</p>
        @guest
            <div class="flex flex-col sm:flex-row gap-3 justify-center items-center">
                <a href="{{ route('register') }}" class="inline-flex items-center justify-center bg-accent-500 hover:brightness-95 text-white px-8 py-3 rounded-lg font-semibold shadow-md hover:shadow-lg transition-all">
                    <i class="fa-solid fa-user-plus mr-2"></i>Sign up
                </a>
                <a href="{{ route('login') }}" class="inline-flex items-center justify-center bg-primary-700 hover:bg-primary-800 text-white px-8 py-3 rounded-lg font-semibold shadow-md hover:shadow-lg transition-all">
                    <i class="fa-solid fa-right-to-bracket mr-2"></i>Log in
                </a>
            </div>
        @endguest
        @auth
            <a href="/profile" class="inline-flex items-center justify-center bg-primary-700 hover:bg-primary-800 text-white px-8 py-3 rounded-lg font-semibold shadow-md hover:shadow-lg transition-all">
                <i class="fa-solid fa-user mr-2"></i>Profile
            </a>
        @endauth
    </div>
</div>
@endsection

