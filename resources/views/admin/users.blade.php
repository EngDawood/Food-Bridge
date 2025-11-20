@extends('layouts.app')

@section('content')
<!-- Header Section -->
<div class="mb-8">
    <div class="flex items-center justify-between mb-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 mb-2 flex items-center">
                <i class="fa-solid fa-users text-primary-700 mr-3"></i>
                User Management
            </h1>
            <p class="text-gray-600 text-sm">Manage and monitor all registered users in the system</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.users.create') }}" class="flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-all duration-200 shadow-md hover:shadow-lg">
                <i class="fa-solid fa-plus"></i>
                <span class="hidden sm:inline">Create User</span>
            </a>
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-4 py-2 bg-primary-700 hover:bg-primary-800 text-white rounded-lg transition-all duration-200 shadow-md hover:shadow-lg">
                <i class="fa-solid fa-gauge"></i>
                <span class="hidden sm:inline">Dashboard</span>
            </a>
        </div>
    </div>
</div>

@if(session('status'))
    <div class="mb-6 p-4 rounded-lg bg-green-100 text-green-800 border border-green-200">
        <i class="fa-solid fa-check-circle mr-2"></i>{{ session('status') }}
    </div>
@endif

@if($errors->has('error'))
    <div class="mb-6 p-4 rounded-lg bg-red-100 text-red-800 border border-red-200">
        <i class="fa-solid fa-exclamation-circle mr-2"></i>{{ $errors->first('error') }}
    </div>
@endif

<!-- Search Section -->
<div class="bg-white rounded-xl shadow-lg p-6 mb-6">
    <form method="get" class="flex flex-col sm:flex-row gap-3">
        <div class="flex-1 relative">
            <i class="fa-solid fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            <input 
                type="text" 
                name="q" 
                value="{{ $q }}" 
                placeholder="Search by name, email, or role..." 
                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all"
            />
        </div>
        <button type="submit" class="px-6 py-3 bg-primary-700 hover:bg-primary-800 text-white rounded-lg transition-all duration-200 shadow-md hover:shadow-lg font-medium">
            <i class="fa-solid fa-search mr-2"></i>Search
        </button>
        @if($q)
        <a href="{{ route('admin.users') }}" class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition-all duration-200 font-medium flex items-center justify-center">
            <i class="fa-solid fa-rotate mr-2"></i>Reset
        </a>
        @endif
    </form>
</div>

<!-- Users Table Section -->
<div class="bg-white rounded-xl shadow-lg overflow-hidden">
    <div class="px-6 py-4 bg-gradient-to-r from-primary-900 to-primary-800">
        <h2 class="text-lg font-semibold text-white flex items-center">
            <i class="fa-solid fa-table mr-2"></i>
            Users List
            <span class="ml-3 text-sm font-normal text-primary-100">({{ $users->total() }} total)</span>
        </h2>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        <i class="fa-solid fa-hashtag mr-1"></i>ID
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        <i class="fa-solid fa-user mr-1"></i>Name
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        <i class="fa-solid fa-envelope mr-1"></i>Email
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        <i class="fa-solid fa-user-tag mr-1"></i>Role
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        <i class="fa-solid fa-location-dot mr-1"></i>Location
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        <i class="fa-solid fa-cog mr-1"></i>Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($users as $user)
                <tr class="hover:bg-gray-50 transition-colors duration-150">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        #{{ $user->id }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 font-medium">
                        {{ $user->name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                        {{ $user->email }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @php
                            $roleColors = [
                                'admin' => 'bg-purple-100 text-purple-800 border-purple-200',
                                'donor' => 'bg-blue-100 text-blue-800 border-blue-200',
                                'beneficiary' => 'bg-green-100 text-green-800 border-green-200',
                                'volunteer' => 'bg-orange-100 text-orange-800 border-orange-200'
                            ];
                            $roleColor = $roleColors[$user->role] ?? 'bg-gray-100 text-gray-800 border-gray-200';
                        @endphp
                        <span class="px-3 py-1 text-xs font-semibold rounded-full border {{ $roleColor }} capitalize">
                            {{ $user->role }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                        <i class="fa-solid fa-map-marker-alt mr-1 text-gray-400"></i>
                        {{ $user->location ?? 'N/A' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.users.edit', $user) }}" class="text-blue-600 hover:text-blue-800 transition-colors" title="Edit user">
                                <i class="fa-solid fa-edit"></i>
                            </a>
                            <form method="post" action="{{ route('admin.users.destroy', $user) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                @csrf
                                @method('delete')
                                <button type="submit" class="text-red-600 hover:text-red-800 transition-colors" title="Delete user">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center justify-center text-gray-400">
                            <i class="fa-solid fa-users-slash text-4xl mb-3"></i>
                            <p class="text-lg font-medium text-gray-600">No users found</p>
                            @if($q)
                            <p class="text-sm mt-1">Try adjusting your search criteria</p>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    @if($users->hasPages())
    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
        <div class="flex items-center justify-between">
            <div class="text-sm text-gray-700">
                Showing <span class="font-medium">{{ $users->firstItem() }}</span> to 
                <span class="font-medium">{{ $users->lastItem() }}</span> of 
                <span class="font-medium">{{ $users->total() }}</span> results
            </div>
            <div class="flex items-center gap-2">
                {{ $users->links() }}
            </div>
        </div>
    </div>
    @endif
</div>
@endsection


