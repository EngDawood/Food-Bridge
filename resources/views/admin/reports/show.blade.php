@extends('layouts.app')

@section('title', 'View Report')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ $report->title }}</h1>
            <p class="text-sm text-gray-600 mt-1">
                <span class="px-2 py-1 rounded text-xs
                    {{ $report->type === 'manual' ? 'bg-gray-200 text-gray-800' : '' }}
                    {{ $report->type === 'daily' ? 'bg-blue-200 text-blue-800' : '' }}
                    {{ $report->type === 'weekly' ? 'bg-green-200 text-green-800' : '' }}
                    {{ $report->type === 'monthly' ? 'bg-purple-200 text-purple-800' : '' }}">
                    {{ ucfirst($report->type) }} Report
                </span>
                &middot; Created by {{ $report->admin->name }} on {{ $report->created_at->format('F d, Y \a\t H:i') }}
            </p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.reports.index') }}" class="px-4 py-2 border rounded hover:bg-gray-50">
                <i class="fa-solid fa-arrow-left mr-1"></i>Back
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 bg-green-100 text-green-800 px-4 py-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    <!-- Report Content -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Report Content</h2>
        <div class="prose max-w-none">
            <pre class="whitespace-pre-wrap text-gray-700 font-sans">{{ $report->content }}</pre>
        </div>
    </div>

    <!-- Report Data (for automated reports) -->
    @if($report->data && is_array($report->data))
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Detailed Statistics</h2>

        <!-- Donations Stats -->
        @if(isset($report->data['donations']))
        <div class="mb-6">
            <h3 class="font-medium text-gray-900 mb-3">Donations Overview</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                <div class="bg-blue-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-600">Total Donations</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $report->data['donations']['total'] }}</p>
                </div>
                <div class="bg-green-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-600">Total Quantity</p>
                    <p class="text-2xl font-bold text-green-600">{{ $report->data['donations']['total_quantity'] }}</p>
                </div>
            </div>

            @if(isset($report->data['donations']['by_status']) && count($report->data['donations']['by_status']) > 0)
            <div class="bg-gray-50 p-4 rounded-lg">
                <h4 class="font-medium mb-2">By Status</h4>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                    @foreach($report->data['donations']['by_status'] as $status => $count)
                    <div class="bg-white p-2 rounded text-center">
                        <p class="text-xs text-gray-600">{{ ucfirst($status) }}</p>
                        <p class="text-lg font-semibold">{{ $count }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
        @endif

        <!-- Matching Stats -->
        @if(isset($report->data['matching']))
        <div class="mb-6">
            <h3 class="font-medium text-gray-900 mb-3">Matching Performance</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-purple-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-600">Total Requests</p>
                    <p class="text-2xl font-bold text-purple-600">{{ $report->data['matching']['total_requests'] }}</p>
                </div>
                <div class="bg-green-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-600">Matched</p>
                    <p class="text-2xl font-bold text-green-600">{{ $report->data['matching']['matched'] }}</p>
                </div>
                <div class="bg-red-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-600">Unmatched</p>
                    <p class="text-2xl font-bold text-red-600">{{ $report->data['matching']['unmatched'] }}</p>
                </div>
                <div class="bg-blue-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-600">Success Rate</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $report->data['matching']['success_rate'] }}%</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Delivery Stats -->
        @if(isset($report->data['delivery']))
        <div class="mb-6">
            <h3 class="font-medium text-gray-900 mb-3">Delivery Statistics</h3>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-4">
                <div class="bg-yellow-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-600">Total Deliveries</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ $report->data['delivery']['total'] }}</p>
                </div>
                <div class="bg-green-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-600">Completed</p>
                    <p class="text-2xl font-bold text-green-600">{{ $report->data['delivery']['completed'] }}</p>
                </div>
                <div class="bg-blue-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-600">Completion Rate</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $report->data['delivery']['completion_rate'] }}%</p>
                </div>
            </div>

            @if(isset($report->data['delivery']['by_status']) && count($report->data['delivery']['by_status']) > 0)
            <div class="bg-gray-50 p-4 rounded-lg">
                <h4 class="font-medium mb-2">By Status</h4>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                    @foreach($report->data['delivery']['by_status'] as $status => $count)
                    <div class="bg-white p-2 rounded text-center">
                        <p class="text-xs text-gray-600">{{ ucfirst($status) }}</p>
                        <p class="text-lg font-semibold">{{ $count }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
        @endif

        <!-- Food Types -->
        @if(isset($report->data['food_types']) && count($report->data['food_types']) > 0)
        <div class="mb-6">
            <h3 class="font-medium text-gray-900 mb-3">Food Types Distribution</h3>
            <div class="bg-gray-50 p-4 rounded-lg">
                <table class="w-full text-sm">
                    <thead class="text-left border-b">
                        <tr>
                            <th class="pb-2">Food Type</th>
                            <th class="pb-2">Count</th>
                            <th class="pb-2">Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($report->data['food_types'] as $foodType)
                        <tr class="border-b last:border-0">
                            <td class="py-2">{{ $foodType['food_type'] }}</td>
                            <td class="py-2">{{ $foodType['count'] }}</td>
                            <td class="py-2">{{ $foodType['total_quantity'] }} items</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        <!-- User Stats -->
        @if(isset($report->data['users']))
        <div class="mb-6">
            <h3 class="font-medium text-gray-900 mb-3">User Statistics</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-blue-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-600">Donors</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $report->data['users']['donors'] }}</p>
                </div>
                <div class="bg-green-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-600">Beneficiaries</p>
                    <p class="text-2xl font-bold text-green-600">{{ $report->data['users']['beneficiaries'] }}</p>
                </div>
                <div class="bg-purple-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-600">Volunteers</p>
                    <p class="text-2xl font-bold text-purple-600">{{ $report->data['users']['volunteers'] }}</p>
                </div>
                <div class="bg-yellow-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-600">Total Users</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ $report->data['users']['total'] }}</p>
                </div>
            </div>
        </div>
        @endif
    </div>
    @endif

    <!-- Actions -->
    <div class="flex gap-2 justify-end">
        <form method="POST" action="{{ route('admin.reports.destroy', $report) }}"
              onsubmit="return confirm('Are you sure you want to delete this report?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                <i class="fa-solid fa-trash mr-1"></i>Delete Report
            </button>
        </form>
    </div>
</div>
@endsection
