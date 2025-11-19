@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white p-4 sm:p-6 rounded shadow">
    <h1 class="text-xl font-bold mb-4"><i class="fa-solid fa-user-plus mr-2"></i>Create account</h1>

    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded text-base">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('status'))
        <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded text-base">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('register.post') }}">
        @csrf
        <div class="mb-4">
            <label class="block mb-2 text-base font-medium"><i class="fa-solid fa-user mr-1"></i>Name</label>
            <input name="name" type="text" class="w-full border rounded px-3 py-3 text-base min-h-[48px]" value="{{ old('name') }}" required>
        </div>
        <div class="mb-4">
            <label class="block mb-2 text-base font-medium"><i class="fa-solid fa-envelope mr-1"></i>Email</label>
            <input name="email" type="email" class="w-full border rounded px-3 py-3 text-base min-h-[48px]" value="{{ old('email') }}" required>
        </div>
        <div class="mb-4">
            <label class="block mb-2 text-base font-medium"><i class="fa-solid fa-lock mr-1"></i>Password</label>
            <div class="relative">
                <input id="password" name="password" type="password" class="w-full border rounded px-3 py-3 pr-12 text-base min-h-[48px]" required>
                <button type="button" onclick="togglePassword('password')"
                        class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700 p-2 min-w-[44px] min-h-[44px] flex items-center justify-center" aria-label="Toggle password visibility">
                    <i class="fa-solid fa-eye text-lg" id="password-eye"></i>
                </button>
            </div>
        </div>
        <div class="mb-4">
            <label class="block mb-2 text-base font-medium"><i class="fa-solid fa-user-tag mr-1"></i>Role</label>
            <select name="role" class="w-full border rounded px-3 py-3 text-base min-h-[48px]" required>
                <option value="donor" {{ old('role') === 'donor' ? 'selected' : '' }}>Donor</option>
                <option value="beneficiary" {{ old('role') === 'beneficiary' ? 'selected' : '' }}>Beneficiary</option>
                <option value="volunteer" {{ old('role') === 'volunteer' ? 'selected' : '' }}>Volunteer</option>
            </select>
        </div>
        <div class="mb-4">
            <label class="block mb-2 text-base font-medium"><i class="fa-solid fa-location-dot mr-1"></i>Location (optional)</label>
            <input name="location" type="text" class="w-full border rounded px-3 py-3 text-base min-h-[48px]" value="{{ old('location') }}">
        </div>
        <button class="w-full bg-accent-500 hover:brightness-95 text-white px-6 py-3 rounded-lg min-h-[48px] font-medium text-base"><i class="fa-solid fa-user-plus mr-2"></i>Sign up</button>
    </form>
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


