@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between mb-4">
    <h1 class="text-xl font-bold"><i class="fa-solid fa-chart-bar mr-2"></i>Statistics Dashboard</h1>
    <a href="{{ route('admin.reports.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded"><i class="fa-solid fa-arrow-left mr-1"></i>Back to Reports</a>
</div>

<!-- All Time Statistics -->
<div class="mb-6">
    <h2 class="text-lg font-semibold mb-3"><i class="fa-solid fa-infinity mr-2"></i>All Time Statistics</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Donations -->
        <div class="bg-white rounded shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Total Donations</p>
                    <p class="text-3xl font-bold text-[#F89A3C]">{{ $totalDonations }}</p>
                </div>
                <div class="bg-orange-100 p-3 rounded-full">
                    <i class="fa-solid fa-hand-holding-heart text-2xl text-[#F89A3C]"></i>
                </div>
            </div>
        </div>

        <!-- Total Requests -->
        <div class="bg-white rounded shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Total Requests</p>
                    <p class="text-3xl font-bold text-blue-600">{{ $totalRequests }}</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <i class="fa-solid fa-clipboard-list text-2xl text-blue-600"></i>
                </div>
            </div>
        </div>

        <!-- Total Matches -->
        <div class="bg-white rounded shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Total Matches</p>
                    <p class="text-3xl font-bold text-green-600">{{ $totalMatches }}</p>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <i class="fa-solid fa-check-circle text-2xl text-green-600"></i>
                </div>
            </div>
        </div>

        <!-- Completed Deliveries -->
        <div class="bg-white rounded shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Completed Deliveries</p>
                    <p class="text-3xl font-bold text-purple-600">{{ $totalDeliveries }}</p>
                </div>
                <div class="bg-purple-100 p-3 rounded-full">
                    <i class="fa-solid fa-truck text-2xl text-purple-600"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- User Statistics -->
<div class="mb-6">
    <h2 class="text-lg font-semibold mb-3"><i class="fa-solid fa-users mr-2"></i>Users by Role</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Donors -->
        <div class="bg-white rounded shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Total Donors</p>
                    <p class="text-3xl font-bold text-[#F89A3C]">{{ $totalDonors }}</p>
                </div>
                <div class="bg-orange-100 p-3 rounded-full">
                    <i class="fa-solid fa-user-tie text-2xl text-[#F89A3C]"></i>
                </div>
            </div>
        </div>

        <!-- Total Beneficiaries -->
        <div class="bg-white rounded shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Total Beneficiaries</p>
                    <p class="text-3xl font-bold text-blue-600">{{ $totalBeneficiaries }}</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <i class="fa-solid fa-user-friends text-2xl text-blue-600"></i>
                </div>
            </div>
        </div>

        <!-- Total Volunteers -->
        <div class="bg-white rounded shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Total Volunteers</p>
                    <p class="text-3xl font-bold text-green-600">{{ $totalVolunteers }}</p>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <i class="fa-solid fa-hands-helping text-2xl text-green-600"></i>
                </div>
            </div>
        </div>

        <!-- Total Admins -->
        <div class="bg-white rounded shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Total Admins</p>
                    <p class="text-3xl font-bold text-purple-600">{{ $totalAdmins }}</p>
                </div>
                <div class="bg-purple-100 p-3 rounded-full">
                    <i class="fa-solid fa-user-shield text-2xl text-purple-600"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- This Month Statistics -->
<div class="mb-6">
    <h2 class="text-lg font-semibold mb-3"><i class="fa-solid fa-calendar-alt mr-2"></i>This Month ({{ now()->format('F Y') }})</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Donations This Month -->
        <div class="bg-white rounded shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Donations This Month</p>
                    <p class="text-3xl font-bold text-[#F89A3C]">{{ $donationsThisMonth }}</p>
                </div>
                <div class="bg-orange-100 p-3 rounded-full">
                    <i class="fa-solid fa-gift text-2xl text-[#F89A3C]"></i>
                </div>
            </div>
        </div>

        <!-- Requests This Month -->
        <div class="bg-white rounded shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Requests This Month</p>
                    <p class="text-3xl font-bold text-blue-600">{{ $requestsThisMonth }}</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <i class="fa-solid fa-envelope-open-text text-2xl text-blue-600"></i>
                </div>
            </div>
        </div>

        <!-- Matches This Month -->
        <div class="bg-white rounded shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Matches This Month</p>
                    <p class="text-3xl font-bold text-green-600">{{ $matchesThisMonth }}</p>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <i class="fa-solid fa-link text-2xl text-green-600"></i>
                </div>
            </div>
        </div>

        <!-- Active Volunteers -->
        <div class="bg-white rounded shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Active Volunteers</p>
                    <p class="text-3xl font-bold text-purple-600">{{ $activeVolunteers }}</p>
                </div>
                <div class="bg-purple-100 p-3 rounded-full">
                    <i class="fa-solid fa-running text-2xl text-purple-600"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mt-6">
    <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 rounded border"><i class="fa-solid fa-arrow-left mr-1"></i>Back to Dashboard</a>
</div>
@endsection