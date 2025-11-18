@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-xl font-bold mb-4"><i class="fa-solid fa-user-plus mr-2"></i>Create account</h1>
    
    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    @if (session('status'))
        <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('status') }}
        </div>
    @endif
    
    <form method="POST" action="{{ route('register.post') }}">
        @csrf
        <div class="mb-4">
            <label class="block mb-1"><i class="fa-solid fa-user mr-1"></i>Name</label>
            <input name="name" type="text" class="w-full border rounded px-3 py-2" value="{{ old('name') }}" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1"><i class="fa-solid fa-envelope mr-1"></i>Email</label>
            <input name="email" type="email" class="w-full border rounded px-3 py-2" value="{{ old('email') }}" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1"><i class="fa-solid fa-lock mr-1"></i>Password</label>
            <input name="password" type="password" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1"><i class="fa-solid fa-user-tag mr-1"></i>Role</label>
            <select name="role" class="w-full border rounded px-3 py-2" required>
                <option value="donor" {{ old('role') === 'donor' ? 'selected' : '' }}>Donor</option>
                <option value="beneficiary" {{ old('role') === 'beneficiary' ? 'selected' : '' }}>Beneficiary</option>
                <option value="volunteer" {{ old('role') === 'volunteer' ? 'selected' : '' }}>Volunteer</option>
            </select>
        </div>
        <div class="mb-4">
            <label class="block mb-1"><i class="fa-solid fa-location-dot mr-1"></i>Location (optional)</label>
            <input name="location" type="text" class="w-full border rounded px-3 py-2" value="{{ old('location') }}">
        </div>
        <button class="bg-accent-500 hover:brightness-95 text-white px-4 py-2 rounded"><i class="fa-solid fa-user-plus mr-1"></i>Sign up</button>
    </form>
</div>
@endsection


