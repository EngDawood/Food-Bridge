@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <!-- Header -->
    <x-page-header
        title="Create User"
        subtitle="Add a new user to the system"
        icon="fa-solid fa-user-plus"
    />

    <!-- Success Message -->
    @if(session('status'))
        <x-alert variant="success" title="Success!">
            {{ session('status') }}
        </x-alert>
    @endif

    <!-- Form Card -->
    <x-card>
        <form method="post" action="{{ route('admin.users.store') }}">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <x-input
                    label="Name"
                    icon="fa-solid fa-user"
                    name="name"
                    type="text"
                    :value="old('name')"
                    placeholder="Enter full name"
                    :error="$errors->first('name')"
                    required
                />

                <!-- Email -->
                <x-input
                    label="Email"
                    icon="fa-solid fa-envelope"
                    name="email"
                    type="email"
                    :value="old('email')"
                    placeholder="email@example.com"
                    :error="$errors->first('email')"
                    required
                />

                <!-- Password -->
                <div>
                    <label for="password" class="block mb-2 text-sm font-semibold text-gray-700">
                        <i class="fa-solid fa-lock mr-1 text-primary-700"></i>Password
                        <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input
                            id="password"
                            type="password"
                            name="password"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2.5 pr-10 text-base focus:outline-none focus:ring-2 focus:ring-primary-700 focus:border-transparent @error('password') border-red-400 @enderror"
                            required />
                        <button type="button" onclick="togglePassword('password')"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700">
                            <i class="fa-solid fa-eye" id="password-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-600 text-sm mt-1"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Role -->
                <x-select
                    label="Role"
                    icon="fa-solid fa-user-tag"
                    name="role"
                    :selected="old('role')"
                    placeholder="Select role"
                    :options="[
                        'admin' => 'Admin',
                        'donor' => 'Donor',
                        'beneficiary' => 'Beneficiary',
                        'volunteer' => 'Volunteer'
                    ]"
                    :error="$errors->first('role')"
                    required
                />

                <!-- Location -->
                <div class="md:col-span-2">
                    <x-input
                        label="Location"
                        icon="fa-solid fa-location-dot"
                        name="location"
                        type="text"
                        :value="old('location')"
                        placeholder="City, district, or area (optional)"
                        :error="$errors->first('location')"
                    />
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-8 flex flex-col sm:flex-row gap-3">
                <x-button type="submit" variant="primary">
                    <i class="fa-solid fa-user-plus mr-2"></i>Create User
                </x-button>
                <x-button variant="secondary" href="{{ route('admin.users') }}">
                    <i class="fa-solid fa-arrow-left mr-2"></i>Back
                </x-button>
            </div>
        </form>
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
