@extends('layouts.app')

@section('content')
<div class="space-y-8">
    <div class="bg-gradient-to-r from-primary-800 to-primary-700 text-white rounded-lg p-8 shadow-lg text-center">
        <h1 class="text-3xl font-bold mb-3">Welcome to FoodBridge</h1>
        <p class="text-lg">A simple way to connect donors, beneficiaries, and volunteers to reduce food waste.</p>
    </div>

    <div class="grid md:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg p-6 shadow">
            <h2 class="text-xl font-semibold mb-2 text-primary-800"><i class="fa-solid fa-circle-info mr-2"></i>How it works</h2>
            <p class="text-gray-700 leading-relaxed">
                - Donors list surplus food.
                <br>
                - Beneficiaries request what they need.
                <br>
                - Volunteers deliver safely.
            </p>
        </div>
        <div class="bg-white rounded-lg p-6 shadow">
            <h2 class="text-xl font-semibold mb-2 text-primary-800"><i class="fa-solid fa-bullseye mr-2"></i>Our mission</h2>
            <p class="text-gray-700 leading-relaxed">Cut food waste, support families in need, and build a fast, simple community network.</p>
        </div>
        <div class="bg-white rounded-lg p-6 shadow">
            <h2 class="text-xl font-semibold mb-2 text-primary-800"><i class="fa-solid fa-heart mr-2"></i>Our values</h2>
            <p class="text-gray-700 leading-relaxed">Transparency, safety, and simplicity for everyone.</p>
        </div>
    </div>

    <div class="bg-primary-100 rounded-lg p-6 text-center">
        <h3 class="text-xl font-semibold mb-2 text-primary-800">Get started</h3>
        <p class="mb-4 text-gray-700">Create your account in minutes and be part of the solution.</p>
        @guest
            <div class="space-x-3 space-x-reverse">
                <a href="{{ route('register') }}" class="inline-block bg-accent-500 hover:brightness-95 text-white px-6 py-2 rounded-lg"><i class="fa-solid fa-user-plus mr-2"></i>Sign up</a>
                <a href="{{ route('login') }}" class="inline-block bg-primary-700 hover:bg-primary-800 text-white px-6 py-2 rounded-lg"><i class="fa-solid fa-right-to-bracket mr-2"></i>Log in</a>
            </div>
        @endguest
        @auth
            <a href="/profile" class="inline-block bg-primary-700 hover:bg-primary-800 text-white px-6 py-2 rounded-lg"><i class="fa-solid fa-user mr-2"></i>Profile</a>
        @endauth
    </div>
</div>
@endsection

