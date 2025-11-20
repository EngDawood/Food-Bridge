@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-xl font-bold mb-4"><i class="fa-solid fa-right-to-bracket mr-2"></i>Log in</h1>
    @php($chosenRole = $role ?? null)
    @if(!$chosenRole)
        <div class="mb-4 flex gap-2 text-sm">
            <a class="px-3 py-1 rounded border @if(request()->is('login/admin')) bg-gray-100 @endif" href="{{ route('login.role', ['role' => 'admin']) }}">Admin</a>
            <a class="px-3 py-1 rounded border @if(request()->is('login/donor')) bg-gray-100 @endif" href="{{ route('login.role', ['role' => 'donor']) }}">Donor</a>
            <a class="px-3 py-1 rounded border @if(request()->is('login/beneficiary')) bg-gray-100 @endif" href="{{ route('login.role', ['role' => 'beneficiary']) }}">Beneficiary</a>
            <a class="px-3 py-1 rounded border @if(request()->is('login/volunteer')) bg-gray-100 @endif" href="{{ route('login.role', ['role' => 'volunteer']) }}">Volunteer</a>
        </div>
    @else
        <div class="mb-4 text-sm">
            <span class="px-2 py-1 rounded bg-primary-100">Logging in as <strong>{{ ucfirst($chosenRole) }}</strong></span>
            <a class="ml-2 underline" href="{{ route('login') }}">Switch role</a>
        </div>
    @endif
    @if($chosenRole && $errors->any())
        <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-3 py-2 rounded">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="{{ $chosenRole ? route('login.role.post', ['role' => $chosenRole]) : route('login.post') }}" @if(!$chosenRole) style="display: none;" @endif>
        @csrf
        <div class="mb-4">
            <label class="block mb-1"><i class="fa-solid fa-envelope mr-1"></i>Email</label>
            <input name="email" type="email" value="{{ old('email') }}" class="w-full border rounded px-3 py-2" required>
            @error('email')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1"><i class="fa-solid fa-lock mr-1"></i>Password</label>
            <input name="password" type="password" class="w-full border rounded px-3 py-2" required>
            @error('password')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4 flex items-center gap-2">
            <input id="remember" name="remember" type="checkbox" class="rounded">
            <label for="remember">Remember me</label>
        </div>
        <button class="bg-primary-700 hover:bg-primary-800 text-white px-4 py-2 rounded"><i class="fa-solid fa-right-to-bracket mr-1"></i>Sign in</button>
    </form>
</div>
@endsection


