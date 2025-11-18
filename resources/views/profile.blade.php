@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-xl font-bold mb-4"><i class="fa-solid fa-user mr-2"></i>Profile</h1>
    
    @if(session('status'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
            {{ session('status') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="block mb-1"><i class="fa-solid fa-user mr-1"></i>Name</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full border rounded px-3 py-2 @error('name') border-red-500 @enderror" required>
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block mb-1"><i class="fa-solid fa-user-tag mr-1"></i>Role</label>
                @if($user->role === 'admin')
                    <select name="role" class="w-full border rounded px-3 py-2 @error('role') border-red-500 @enderror">
                        <option value="donor" {{ old('role', $user->role) === 'donor' ? 'selected' : '' }}>Donor</option>
                        <option value="beneficiary" {{ old('role', $user->role) === 'beneficiary' ? 'selected' : '' }}>Beneficiary</option>
                        <option value="volunteer" {{ old('role', $user->role) === 'volunteer' ? 'selected' : '' }}>Volunteer</option>
                        <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                @else
                    <input type="text" value="{{ ucfirst($user->role) }}" class="w-full border rounded px-3 py-2 bg-gray-100" readonly>
                @endif
                @error('role')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="md:col-span-2">
                <label class="block mb-1"><i class="fa-solid fa-envelope mr-1"></i>Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full border rounded px-3 py-2 @error('email') border-red-500 @enderror" required>
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="md:col-span-2">
                <label class="block mb-1"><i class="fa-solid fa-location-dot mr-1"></i>Location</label>
                <input type="text" name="location" value="{{ old('location', $user->location) }}" class="w-full border rounded px-3 py-2 @error('location') border-red-500 @enderror" placeholder="City, district">
                @error('location')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <button type="submit" class="mt-4 bg-[#2F7D32] text-white px-4 py-2 rounded hover:bg-[#1B5E20] transition"><i class="fa-solid fa-floppy-disk mr-1"></i>Save</button>
    </form>
    <hr class="my-6">
    <h2 class="font-semibold mb-2"><i class="fa-solid fa-star mr-1"></i>Ratings</h2>
    <p class="text-sm text-gray-600">Coming soon...</p>
@endsection


