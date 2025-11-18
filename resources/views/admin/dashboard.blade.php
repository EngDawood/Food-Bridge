@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-2">Dashboard</h1>
    <p class="text-gray-600 text-sm">Welcome back! Here's an overview of your system.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    <!-- Users Card -->
    <div class="bg-gradient-to-br from-primary-900 to-primary-800 rounded-xl shadow-lg p-6 text-white transform transition-all duration-300 hover:scale-105 hover:shadow-xl">
        <div class="flex items-center justify-between mb-4">
            <div class="bg-white bg-opacity-20 rounded-lg p-3">
                <i class="fa-solid fa-users fa-2x"></i>
            </div>
            <span class="text-primary-100 text-xs font-semibold uppercase tracking-wider">Users</span>
        </div>
        <div class="text-4xl font-bold mb-2">{{ $totalUsers }}</div>
        <div class="text-primary-100 text-sm">Total registered users</div>
    </div>

    <!-- Donations Card -->
    <div class="bg-gradient-to-br from-primary-800 to-primary-700 rounded-xl shadow-lg p-6 text-white transform transition-all duration-300 hover:scale-105 hover:shadow-xl">
        <div class="flex items-center justify-between mb-4">
            <div class="bg-white bg-opacity-20 rounded-lg p-3">
                <i class="fa-solid fa-hand-holding-heart fa-2x"></i>
            </div>
            <span class="text-primary-100 text-xs font-semibold uppercase tracking-wider">Donations</span>
        </div>
        <div class="text-4xl font-bold mb-2">{{ $totalDonations }}</div>
        <div class="text-primary-100 text-sm">
            <span class="font-semibold">{{ $deliveredDonations }}</span> delivered
        </div>
    </div>

    <!-- Requests Card -->
    <div class="bg-gradient-to-br from-primary-700 to-primary-300 rounded-xl shadow-lg p-6 text-white transform transition-all duration-300 hover:scale-105 hover:shadow-xl">
        <div class="flex items-center justify-between mb-4">
            <div class="bg-white bg-opacity-20 rounded-lg p-3">
                <i class="fa-solid fa-clipboard-list fa-2x"></i>
            </div>
            <span class="text-white text-xs font-semibold uppercase tracking-wider">Requests</span>
        </div>
        <div class="text-4xl font-bold mb-2">{{ $totalRequests }}</div>
        <div class="text-white text-sm opacity-90">
            <span class="font-semibold">{{ $fulfilledRequests }}</span> fulfilled
        </div>
    </div>

    <!-- Deliveries Card -->
    <div class="bg-gradient-to-br from-primary-900 to-primary-700 rounded-xl shadow-lg p-6 text-white transform transition-all duration-300 hover:scale-105 hover:shadow-xl">
        <div class="flex items-center justify-between mb-4">
            <div class="bg-white bg-opacity-20 rounded-lg p-3">
                <i class="fa-solid fa-truck fa-2x"></i>
            </div>
            <span class="text-primary-100 text-xs font-semibold uppercase tracking-wider">Deliveries</span>
        </div>
        <div class="text-4xl font-bold mb-2">{{ $completedDeliveries }}</div>
        <div class="text-primary-100 text-sm">Completed tasks</div>
    </div>

    <!-- Food Saved Card -->
    <div class="bg-gradient-to-br from-primary-800 to-primary-300 rounded-xl shadow-lg p-6 text-white transform transition-all duration-300 hover:scale-105 hover:shadow-xl">
        <div class="flex items-center justify-between mb-4">
            <div class="bg-white bg-opacity-20 rounded-lg p-3">
                <i class="fa-solid fa-utensils fa-2x"></i>
            </div>
            <span class="text-white text-xs font-semibold uppercase tracking-wider">Food Saved</span>
        </div>
        <div class="text-4xl font-bold mb-2">{{ $foodSavedQty }}</div>
        <div class="text-white text-sm opacity-90">Total quantity saved</div>
    </div>

    <!-- Beneficiaries Card -->
    <div class="bg-gradient-to-br from-primary-700 to-primary-300 rounded-xl shadow-lg p-6 text-white transform transition-all duration-300 hover:scale-105 hover:shadow-xl">
        <div class="flex items-center justify-between mb-4">
            <div class="bg-white bg-opacity-20 rounded-lg p-3">
                <i class="fa-solid fa-people-group fa-2x"></i>
            </div>
            <span class="text-white text-xs font-semibold uppercase tracking-wider">Beneficiaries</span>
        </div>
        <div class="text-4xl font-bold mb-2">{{ $beneficiariesHelped }}</div>
        <div class="text-white text-sm opacity-90">People served</div>
    </div>
</div>

<!-- Quick Actions Section -->
<div class="bg-white rounded-xl shadow-lg p-6 mb-8">
    <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
        <i class="fa-solid fa-bolt text-accent-500 mr-2"></i>
        Quick Actions
    </h2>
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-3">
        <a href="{{ route('admin.users') }}" class="flex flex-col items-center justify-center p-4 bg-primary-100 hover:bg-primary-300 rounded-lg transition-all duration-200 hover:shadow-md group">
            <div class="bg-primary-700 group-hover:bg-primary-800 rounded-full p-3 mb-2 transition-colors">
                <i class="fa-solid fa-users fa-lg text-white"></i>
            </div>
            <span class="text-sm font-medium text-primary-900 group-hover:text-primary-800">Users</span>
        </a>
        <a href="{{ route('admin.transactions') }}" class="flex flex-col items-center justify-center p-4 bg-primary-100 hover:bg-primary-300 rounded-lg transition-all duration-200 hover:shadow-md group">
            <div class="bg-primary-700 group-hover:bg-primary-800 rounded-full p-3 mb-2 transition-colors">
                <i class="fa-solid fa-exchange-alt fa-lg text-white"></i>
            </div>
            <span class="text-sm font-medium text-primary-900 group-hover:text-primary-800">Transactions</span>
        </a>
        <a href="{{ route('admin.reports.index') }}" class="flex flex-col items-center justify-center p-4 bg-primary-100 hover:bg-primary-300 rounded-lg transition-all duration-200 hover:shadow-md group">
            <div class="bg-primary-700 group-hover:bg-primary-800 rounded-full p-3 mb-2 transition-colors">
                <i class="fa-solid fa-file-alt fa-lg text-white"></i>
            </div>
            <span class="text-sm font-medium text-primary-900 group-hover:text-primary-800">Reports</span>
        </a>
        <a href="{{ route('admin.feedback') }}" class="flex flex-col items-center justify-center p-4 bg-primary-100 hover:bg-primary-300 rounded-lg transition-all duration-200 hover:shadow-md group">
            <div class="bg-primary-700 group-hover:bg-primary-800 rounded-full p-3 mb-2 transition-colors">
                <i class="fa-solid fa-comments fa-lg text-white"></i>
            </div>
            <span class="text-sm font-medium text-primary-900 group-hover:text-primary-800">Feedback</span>
        </a>
        <a href="{{ route('admin.donations.index') }}" class="flex flex-col items-center justify-center p-4 bg-primary-100 hover:bg-primary-300 rounded-lg transition-all duration-200 hover:shadow-md group">
            <div class="bg-primary-700 group-hover:bg-primary-800 rounded-full p-3 mb-2 transition-colors">
                <i class="fa-solid fa-hand-holding-heart fa-lg text-white"></i>
            </div>
            <span class="text-sm font-medium text-primary-900 group-hover:text-primary-800">Donations</span>
        </a>
        <a href="{{ route('admin.requests.index') }}" class="flex flex-col items-center justify-center p-4 bg-primary-100 hover:bg-primary-300 rounded-lg transition-all duration-200 hover:shadow-md group">
            <div class="bg-primary-700 group-hover:bg-primary-800 rounded-full p-3 mb-2 transition-colors">
                <i class="fa-solid fa-clipboard-list fa-lg text-white"></i>
            </div>
            <span class="text-sm font-medium text-primary-900 group-hover:text-primary-800">Requests</span>
        </a>
        <a href="{{ route('admin.deliveries.index') }}" class="flex flex-col items-center justify-center p-4 bg-primary-100 hover:bg-primary-300 rounded-lg transition-all duration-200 hover:shadow-md group">
            <div class="bg-primary-700 group-hover:bg-primary-800 rounded-full p-3 mb-2 transition-colors">
                <i class="fa-solid fa-truck fa-lg text-white"></i>
            </div>
            <span class="text-sm font-medium text-primary-900 group-hover:text-primary-800">Deliveries</span>
        </a>
    </div>
</div>
@endsection


