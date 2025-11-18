@extends('layouts.app')

@section('content')
<h1 class="text-xl font-semibold mb-4">Edit user #{{ $user->id }}</h1>

@if(session('status'))
    <div class="mb-3 p-2 rounded bg-green-100 text-green-800">{{ session('status') }}</div>
@endif

@if($errors->has('error'))
    <div class="mb-3 p-2 rounded bg-red-100 text-red-800">{{ $errors->first('error') }}</div>
@endif

<form method="post" action="{{ route('admin.users.update', $user) }}" class="space-y-3 max-w-xl">
    @csrf
    @method('put')

    <div>
        <label class="block text-sm mb-1">Name</label>
        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="border rounded w-full px-2 py-1" required />
        @error('name')<div class="text-red-700 text-sm">{{ $message }}</div>@enderror
    </div>

    <div>
        <label class="block text-sm mb-1">Email</label>
        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="border rounded w-full px-2 py-1" required />
        @error('email')<div class="text-red-700 text-sm">{{ $message }}</div>@enderror
    </div>

    <div>
        <label class="block text-sm mb-1">Password <span class="text-gray-500 text-xs">(leave blank to keep current)</span></label>
        <input type="password" name="password" class="border rounded w-full px-2 py-1" />
        @error('password')<div class="text-red-700 text-sm">{{ $message }}</div>@enderror
    </div>

    <div>
        <label class="block text-sm mb-1">Role</label>
        <select name="role" class="border rounded w-full px-2 py-1" required>
            <option value="">Select role</option>
            @foreach(['admin' => 'Admin', 'donor' => 'Donor', 'beneficiary' => 'Beneficiary', 'volunteer' => 'Volunteer'] as $val => $label)
                <option value="{{ $val }}" @selected(old('role', $user->role) === $val)>{{ $label }}</option>
            @endforeach
        </select>
        @error('role')<div class="text-red-700 text-sm">{{ $message }}</div>@enderror
    </div>

    <div>
        <label class="block text-sm mb-1">Location</label>
        <input type="text" name="location" value="{{ old('location', $user->location) }}" class="border rounded w-full px-2 py-1" />
        @error('location')<div class="text-red-700 text-sm">{{ $message }}</div>@enderror
    </div>

    <div class="flex gap-2">
        <button class="bg-primary-700 hover:bg-primary-800 text-white px-4 py-2 rounded">Update</button>
        <a class="px-4 py-2 border rounded" href="{{ route('admin.users') }}">Back</a>
    </div>
</form>
@endsection

