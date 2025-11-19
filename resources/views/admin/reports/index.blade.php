@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between mb-4">
    <h1 class="text-xl font-bold"><i class="fa-solid fa-file-alt mr-2"></i>Reports</h1>
    <div class="flex gap-2">
        <a href="{{ route('admin.reports.analytics') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            <i class="fa-solid fa-chart-line mr-1"></i>Analytics Dashboard
        </a>
        <a href="{{ route('admin.reports.create') }}" class="bg-[#F89A3C] text-white px-4 py-2 rounded hover:bg-orange-600">
            <i class="fa-solid fa-plus mr-1"></i>Create Manual Report
        </a>
    </div>
</div>

@if(session('success'))
    <div class="mb-4 bg-green-100 text-green-800 px-3 py-2 rounded">{{ session('success') }}</div>
@endif

<!-- Automated Report Generation -->
<div class="bg-white rounded shadow p-4 mb-6">
    <h2 class="text-lg font-semibold mb-3"><i class="fa-solid fa-magic mr-2"></i>Generate Automated Report</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <form method="POST" action="{{ route('admin.reports.generate.daily') }}" class="border rounded p-4">
            @csrf
            <h3 class="font-medium mb-2">Daily Report</h3>
            <input type="date" name="date" value="{{ date('Y-m-d') }}" class="w-full border rounded px-2 py-1 mb-2">
            <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Generate Daily
            </button>
        </form>

        <form method="POST" action="{{ route('admin.reports.generate.weekly') }}" class="border rounded p-4">
            @csrf
            <h3 class="font-medium mb-2">Weekly Report</h3>
            <input type="date" name="start_date" value="{{ date('Y-m-d', strtotime('monday this week')) }}" class="w-full border rounded px-2 py-1 mb-2">
            <button type="submit" class="w-full bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                Generate Weekly
            </button>
        </form>

        <form method="POST" action="{{ route('admin.reports.generate.monthly') }}" class="border rounded p-4">
            @csrf
            <h3 class="font-medium mb-2">Monthly Report</h3>
            <input type="month" name="month" value="{{ date('Y-m') }}" class="w-full border rounded px-2 py-1 mb-2">
            <button type="submit" class="w-full bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700">
                Generate Monthly
            </button>
        </form>
    </div>
</div>

<!-- Filters -->
<div class="bg-white rounded shadow p-4 mb-4">
    <form method="GET" action="{{ route('admin.reports.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label class="block text-sm font-medium mb-1">Report Type</label>
            <select name="type" class="w-full border rounded px-2 py-1">
                <option value="">All Types</option>
                <option value="manual" {{ request('type') === 'manual' ? 'selected' : '' }}>Manual</option>
                <option value="daily" {{ request('type') === 'daily' ? 'selected' : '' }}>Daily</option>
                <option value="weekly" {{ request('type') === 'weekly' ? 'selected' : '' }}>Weekly</option>
                <option value="monthly" {{ request('type') === 'monthly' ? 'selected' : '' }}>Monthly</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Start Date</label>
            <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full border rounded px-2 py-1">
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">End Date</label>
            <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full border rounded px-2 py-1">
        </div>
        <div class="flex items-end">
            <button type="submit" class="w-full bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
                Apply Filters
            </button>
        </div>
    </form>
</div>

<div class="bg-white rounded shadow overflow-hidden">
    <table class="min-w-full text-sm">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2 text-left"><i class="fa-solid fa-hashtag mr-1"></i>#</th>
                <th class="p-2 text-left"><i class="fa-solid fa-tag mr-1"></i>Type</th>
                <th class="p-2 text-left"><i class="fa-solid fa-file-alt mr-1"></i>Title</th>
                <th class="p-2 text-left"><i class="fa-solid fa-user-shield mr-1"></i>Admin</th>
                <th class="p-2 text-left"><i class="fa-solid fa-calendar mr-1"></i>Date</th>
                <th class="p-2 text-left"><i class="fa-solid fa-cog mr-1"></i>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reports as $report)
            <tr class="border-t hover:bg-gray-50">
                <td class="p-2">{{ $report->id }}</td>
                <td class="p-2">
                    <span class="px-2 py-1 text-xs rounded
                        {{ $report->type === 'manual' ? 'bg-gray-200 text-gray-800' : '' }}
                        {{ $report->type === 'daily' ? 'bg-blue-200 text-blue-800' : '' }}
                        {{ $report->type === 'weekly' ? 'bg-green-200 text-green-800' : '' }}
                        {{ $report->type === 'monthly' ? 'bg-purple-200 text-purple-800' : '' }}">
                        {{ ucfirst($report->type) }}
                    </span>
                </td>
                <td class="p-2">{{ $report->title }}</td>
                <td class="p-2">{{ optional($report->admin)->name ?? '-' }}</td>
                <td class="p-2">{{ optional($report->created_at)->format('Y-m-d H:i') }}</td>
                <td class="p-2">
                    <div class="flex gap-2">
                        <a href="{{ route('admin.reports.show', $report) }}" class="text-blue-600 hover:text-blue-800" title="View">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.reports.destroy', $report) }}"
                              onsubmit="return confirm('Are you sure you want to delete this report?')" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800" title="Delete">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="p-4 text-center text-gray-500">No reports found</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $reports->links() }}</div>
<div class="mt-4">
    <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 rounded border"><i class="fa-solid fa-arrow-left mr-1"></i>Back to dashboard</a>
</div>
@endsection


