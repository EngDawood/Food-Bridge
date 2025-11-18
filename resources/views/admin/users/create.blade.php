@extends('layouts.app')

@section('content')
<h1 class="text-xl font-semibold mb-4">Create user</h1>

@if(session('status'))
    <div class="mb-3 p-2 rounded bg-green-100 text-green-800">{{ session('status') }}</div>
@endif

<form method="post" action="{{ route('admin.users.store') }}" class="space-y-3 max-w-xl">
    @csrf

    <div>
        <label class="block text-sm mb-1">Name</label>
        <input type="text" name="name" value="{{ old('name') }}" class="border rounded w-full px-2 py-1" required />
        @error('name')<div class="text-red-700 text-sm">{{ $message }}</div>@enderror
    </div>

    <div>
        <label class="block text-sm mb-1">Email</label>
        <input type="email" name="email" value="{{ old('email') }}" class="border rounded w-full px-2 py-1" required />
        @error('email')<div class="text-red-700 text-sm">{{ $message }}</div>@enderror
    </div>

    <div>
        <label class="block text-sm mb-1">Password</label>
        <input type="password" name="password" class="border rounded w-full px-2 py-1" required />
        @error('password')<div class="text-red-700 text-sm">{{ $message }}</div>@enderror
    </div>

    <div>
        <label class="block text-sm mb-1">Role</label>
        <select name="role" class="border rounded w-full px-2 py-1" required>
            <option value="">Select role</option>
            @foreach(['admin' => 'Admin', 'donor' => 'Donor', 'beneficiary' => 'Beneficiary', 'volunteer' => 'Volunteer'] as $val => $label)
                <option value="{{ $val }}" @selected(old('role') === $val)>{{ $label }}</option>
            @endforeach
        </select>
        @error('role')<div class="text-red-700 text-sm">{{ $message }}</div>@enderror
    </div>

    <div>
        <label class="block text-sm mb-1">Location</label>
        <input type="text" name="location" value="{{ old('location') }}" class="border rounded w-full px-2 py-1" />
        @error('location')<div class="text-red-700 text-sm">{{ $message }}</div>@enderror
    </div>

    <div class="flex gap-2">
        <button class="bg-primary-700 hover:bg-primary-800 text-white px-4 py-2 rounded">Create</button>
        <a class="px-4 py-2 border rounded" href="{{ route('admin.users') }}">Back</a>
    </div>
</form>
@endsection

