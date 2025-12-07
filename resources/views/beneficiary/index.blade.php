@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-primary-800 flex items-center gap-2">
                <div class="h-10 w-10 rounded-lg bg-primary-100 flex items-center justify-center">
                    <i class="fa-solid fa-clipboard-list text-primary-700"></i>
                </div>
                My requests
            </h1>
            <p class="text-gray-600 mt-1">Track your food requests and matches</p>
        </div>
        <a href="/requests/create" class="inline-flex items-center justify-center bg-accent-500 hover:brightness-95 text-white px-6 py-3 rounded-lg font-semibold shadow-md hover:shadow-lg transition-all w-full sm:w-auto">
            <i class="fa-solid fa-plus mr-2"></i>Create request
        </a>
    </div>

    <!-- Matching Donations Card -->
    <div class="bg-gradient-to-br from-green-50 to-green-100 border border-green-200 rounded-lg p-5 shadow-md">
        <div class="flex items-start gap-3">
            <div class="h-10 w-10 rounded-lg bg-green-200 flex items-center justify-center flex-shrink-0">
                <i class="fa-solid fa-link text-green-700"></i>
            </div>
            <div>
                <h2 class="font-bold text-green-900 mb-1">Matching donations</h2>
                <p class="text-sm text-green-700">No matches right now. (Accept/confirm actions will be added later)</p>
            </div>
        </div>
    </div>

    <!-- Requests Table Card -->
    <div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h2 class="font-bold text-lg text-primary-800">Requests list</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm min-w-[640px]">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr class="text-left">
                        <th class="py-3 px-4 font-semibold text-gray-700">
                            <i class="fa-solid fa-utensils mr-1 text-primary-700"></i>Food type
                        </th>
                        <th class="py-3 px-4 font-semibold text-gray-700">
                            <i class="fa-solid fa-hashtag mr-1 text-primary-700"></i>Quantity
                        </th>
                        <th class="py-3 px-4 font-semibold text-gray-700">
                            <i class="fa-solid fa-sticky-note mr-1 text-primary-700"></i>Note
                        </th>
                        <th class="py-3 px-4 font-semibold text-gray-700">
                            <i class="fa-solid fa-info-circle mr-1 text-primary-700"></i>Status
                        </th>
                        <th class="py-3 px-4 font-semibold text-gray-700">
                            <i class="fa-solid fa-gear mr-1 text-primary-700"></i>Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($requests as $request)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-3 px-4 font-medium text-gray-900">{{ \App\Helpers\FoodTypes::display($request->food_type) }}</td>
                        <td class="py-3 px-4 text-gray-700">{{ $request->quantity }}</td>
                        <td class="py-3 px-4 text-gray-700">{{ $request->note ?: '—' }}</td>
                        <td class="py-3 px-4">
                            @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                    'matched' => 'bg-green-100 text-green-800 border-green-200',
                                    'fulfilled' => 'bg-blue-100 text-blue-800 border-blue-200',
                                    'cancelled' => 'bg-red-100 text-red-800 border-red-200',
                                ];
                                $colorClass = $statusColors[$request->status] ?? 'bg-gray-100 text-gray-800 border-gray-200';
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $colorClass }}">
                                {{ ucfirst(__($request->status)) }}
                            </span>
                        </td>
                        <td class="py-3 px-4">
                            <div class="flex gap-2 flex-wrap">
                                <a href="{{ route('requests.edit', $request) }}"
                                   class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium transition-colors">
                                    <i class="fa-solid fa-pen-to-square mr-1"></i>
                                    <span class="hidden sm:inline">Edit</span>
                                </a>
                                <form method="POST" action="{{ route('requests.destroy', $request) }}"
                                      onsubmit="return confirm('Delete request?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="inline-flex items-center text-red-600 hover:text-red-800 font-medium transition-colors">
                                        <i class="fa-solid fa-trash mr-1"></i>
                                        <span class="hidden sm:inline">Delete</span>
                                    </button>
                                </form>
                                <a href="{{ route('requests.matches', $request) }}"
                                   class="inline-flex items-center text-primary-700 hover:text-primary-900 font-medium transition-colors">
                                    <i class="fa-solid fa-eye mr-1"></i>
                                    <span class="hidden sm:inline">View matches</span>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-12 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="h-16 w-16 rounded-full bg-gray-100 flex items-center justify-center">
                                    <i class="fa-solid fa-inbox text-gray-400 text-2xl"></i>
                                </div>
                                <p class="text-gray-500 font-medium">No requests yet</p>
                                <a href="/requests/create" class="text-primary-700 hover:text-primary-800 font-semibold hover:underline">
                                    Create your first request
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($requests->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            {{ $requests->links() }}
        </div>
        @endif
    </div>
</div>
@endsection


