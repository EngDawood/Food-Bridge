@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between mb-4">
    <h1 class="text-xl font-bold"><i class="fa-solid fa-file-alt mr-2"></i>Reports</h1>
    <a href="{{ route('admin.reports.create') }}" class="bg-[#F89A3C] text-white px-4 py-2 rounded"><i class="fa-solid fa-plus mr-1"></i>Create report</a>
 </div>

@if(session('status'))
    <div class="mb-4 bg-green-100 text-green-800 px-3 py-2 rounded">{{ session('status') }}</div>
@endif

<div class="bg-white rounded shadow overflow-hidden">
    <table class="min-w-full text-sm">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2 text-right"><i class="fa-solid fa-hashtag mr-1"></i>#</th>
                <th class="p-2 text-right"><i class="fa-solid fa-file-alt mr-1"></i>Title</th>
                <th class="p-2 text-right"><i class="fa-solid fa-user-shield mr-1"></i>Admin</th>
                <th class="p-2 text-right"><i class="fa-solid fa-calendar mr-1"></i>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reports as $report)
            <tr class="border-t">
                <td class="p-2">{{ $report->id }}</td>
                <td class="p-2">{{ $report->title }}</td>
                <td class="p-2">{{ optional($report->admin)->name ?? '-' }}</td>
                <td class="p-2">{{ optional($report->created_at)->format('Y-m-d H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $reports->links() }}</div>
<div class="mt-4">
    <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 rounded border"><i class="fa-solid fa-arrow-left mr-1"></i>Back to dashboard</a>
</div>
@endsection


