@extends('layouts.app')

@section('content')
<div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-4 gap-3">
    <h1 class="text-xl sm:text-2xl font-bold"><i class="fa-solid fa-hand-holding-heart mr-2"></i>My donations</h1>
    <a href="/donations/create" class="bg-accent-500 hover:brightness-95 text-white px-6 py-3 rounded-lg min-h-[48px] flex items-center justify-center font-medium w-full sm:w-auto"><i class="fa-solid fa-plus mr-2"></i>Add donation</a>
  </div>

<div class="mb-6 bg-white rounded p-4 shadow">
    <h2 class="font-semibold mb-2">Matching alerts</h2>
    <p class="text-sm text-gray-600">No alerts right now.</p>
</div>

<div class="bg-white rounded p-4 shadow">
    <h2 class="font-semibold mb-3">Donations list</h2>
    <div class="overflow-x-auto -mx-4 px-4">
        <table class="w-full text-sm min-w-[640px]">
            <thead>
                <tr class="text-left border-b">
                    <th class="py-2 px-2"><i class="fa-solid fa-utensils mr-1"></i>Food</th>
                    <th class="py-2 px-2"><i class="fa-solid fa-hashtag mr-1"></i>Quantity</th>
                    <th class="py-2 px-2"><i class="fa-solid fa-calendar mr-1"></i>Expires</th>
                    <th class="py-2 px-2"><i class="fa-solid fa-clock mr-1"></i>Pickup time</th>
                    <th class="py-2 px-2"><i class="fa-solid fa-info-circle mr-1"></i>Status</th>
                    <th class="py-2 px-2"><i class="fa-solid fa-gear mr-1"></i>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($donations as $donation)
                <tr class="border-b">
                    <td class="py-2 px-2">{{ \App\Helpers\FoodTypes::display($donation->food_type) }}</td>
                    <td class="py-2 px-2">{{ $donation->quantity }}</td>
                    <td class="py-2 px-2">{{ optional($donation->expiration_date)->format('Y-m-d') ?: '—' }}</td>
                    <td class="py-2 px-2">{{ optional($donation->pickup_time)->format('Y-m-d H:i') ?: '—' }}</td>
                    <td class="py-2 px-2"><span class="px-2 py-1 rounded bg-gray-100 text-xs">{{ __($donation->status) }}</span></td>
                    <td class="py-2 px-2">
                        <div class="flex gap-2 flex-wrap">
                            <a href="{{ route('donations.edit', $donation) }}" class="text-blue-600 whitespace-nowrap min-h-[44px] flex items-center"><i class="fa-solid fa-pen-to-square mr-1"></i><span class="hidden sm:inline">Edit</span><span class="sm:hidden"><i class="fa-solid fa-pen-to-square"></i></span></a>
                            <form method="POST" action="{{ route('donations.destroy', $donation) }}" onsubmit="return confirm('Delete donation?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 whitespace-nowrap min-h-[44px]"><i class="fa-solid fa-trash mr-1"></i><span class="hidden sm:inline">Delete</span><span class="sm:hidden"><i class="fa-solid fa-trash"></i></span></button>
                            </form>
                            <a href="{{ route('donations.matches', $donation) }}" class="text-primary-800 whitespace-nowrap min-h-[44px] flex items-center"><i class="fa-solid fa-link mr-1"></i><span class="hidden sm:inline">Matches</span><span class="sm:hidden"><i class="fa-solid fa-link"></i></span></a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-6 text-center text-gray-500">No donations yet</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $donations->links() }}</div>
  </div>
@endsection


