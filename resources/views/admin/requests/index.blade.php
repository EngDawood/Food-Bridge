@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between mb-4">
    <h1 class="text-xl font-semibold">Requests management</h1>
    <form method="get" class="flex gap-2">
        <input type="text" name="q" value="{{ $q }}" placeholder="Search..." class="border rounded px-2 py-1" />
        <button class="bg-primary-700 hover:bg-primary-800 text-white px-3 py-1 rounded">Search</button>
    </form>
</div>

@if(session('status'))
    <div class="mb-3 p-2 rounded bg-green-100 text-green-800">{{ session('status') }}</div>
@endif

<div class="overflow-x-auto">
    <table class="min-w-full bg-white">
        <thead>
            <tr class="text-left border-b">
                <th class="p-2">#</th>
                <th class="p-2">Beneficiary</th>
                <th class="p-2">Type</th>
                <th class="p-2">Quantity</th>
                <th class="p-2">Status</th>
                <th class="p-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($requests as $request)
            <tr class="border-b">
                <td class="p-2">{{ $request->id }}</td>
                <td class="p-2">{{ optional($request->beneficiary)->name ?? '-' }}</td>
                <td class="p-2">{{ $request->food_type }}</td>
                <td class="p-2">{{ $request->quantity }}</td>
                <td class="p-2">{{ $request->status }}</td>
                <td class="p-2 flex gap-2">
                    <a class="text-blue-700" href="{{ route('admin.requests.edit', $request) }}">Edit</a>
                    <form method="post" action="{{ route('admin.requests.destroy', $request) }}" onsubmit="return confirm('Delete request?');">
                        @csrf
                        @method('delete')
                        <button class="text-red-700">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td class="p-3" colspan="6">No records</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="mt-4">{{ $requests->links() }}</div>
</div>
@endsection


