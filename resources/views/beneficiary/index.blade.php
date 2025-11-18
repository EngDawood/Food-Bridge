@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between mb-4">
    <h1 class="text-2xl font-bold"><i class="fa-solid fa-clipboard-list mr-2"></i>My requests</h1>
    <a href="/requests/create" class="bg-accent-500 hover:brightness-95 text-white px-4 py-2 rounded"><i class="fa-solid fa-plus mr-1"></i>Create request</a>
  </div>

<div class="mb-6 bg-white rounded p-4 shadow">
    <h2 class="font-semibold mb-2">Matching donations</h2>
    <p class="text-sm text-gray-600">No matches right now. (Accept/confirm actions will be added later)</p>
  </div>

<div class="bg-white rounded p-4 shadow">
    <h2 class="font-semibold mb-3">Requests list</h2>
    <table class="w-full text-sm">
        <thead>
            <tr class="text-left border-b">
                <th class="py-2"><i class="fa-solid fa-utensils mr-1"></i>Food type</th>
                <th class="py-2"><i class="fa-solid fa-hashtag mr-1"></i>Quantity</th>
                <th class="py-2"><i class="fa-solid fa-sticky-note mr-1"></i>Note</th>
                <th class="py-2"><i class="fa-solid fa-info-circle mr-1"></i>Status</th>
                <th class="py-2"><i class="fa-solid fa-gear mr-1"></i>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($requests as $request)
            <tr class="border-b">
                <td class="py-2">{{ \App\Helpers\FoodTypes::display($request->food_type) }}</td>
                <td class="py-2">{{ $request->quantity }}</td>
                <td class="py-2">{{ $request->note ?: '—' }}</td>
                <td class="py-2"><span class="px-2 py-1 rounded bg-gray-100">{{ __($request->status) }}</span></td>
                <td class="py-2 flex gap-2">
                    <a href="{{ route('requests.edit', $request) }}" class="text-blue-600"><i class="fa-solid fa-pen-to-square mr-1"></i>Edit</a>
                    <form method="POST" action="{{ route('requests.destroy', $request) }}" onsubmit="return confirm('Delete request?');">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-600"><i class="fa-solid fa-trash mr-1"></i>Delete</button>
                    </form>
                    <a href="{{ route('requests.matches', $request) }}" class="text-primary-800"><i class="fa-solid fa-eye mr-1"></i>View matching donations</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="py-6 text-center text-gray-500">No requests yet</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="mt-4">{{ $requests->links() }}</div>
  </div>
@endsection


