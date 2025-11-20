@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between mb-4">
    <h1 class="text-2xl font-bold"><i class="fa-solid fa-hand-holding-heart mr-2"></i>My donations</h1>
    <a href="/donations/create" class="bg-accent-500 hover:brightness-95 text-white px-4 py-2 rounded"><i class="fa-solid fa-plus mr-1"></i>Add donation</a>
  </div>

<div class="mb-6 bg-white rounded p-4 shadow">
    <h2 class="font-semibold mb-2">Matching alerts</h2>
    <p class="text-sm text-gray-600">No alerts right now.</p>
</div>

<div class="bg-white rounded p-4 shadow">
    <h2 class="font-semibold mb-3">Donations list</h2>
    <table class="w-full text-sm">
        <thead>
            <tr class="text-left border-b">
                <th class="py-2"><i class="fa-solid fa-utensils mr-1"></i>Food</th>
                <th class="py-2"><i class="fa-solid fa-hashtag mr-1"></i>Quantity</th>
                <th class="py-2"><i class="fa-solid fa-calendar mr-1"></i>Expires</th>
                <th class="py-2"><i class="fa-solid fa-clock mr-1"></i>Pickup time</th>
                <th class="py-2"><i class="fa-solid fa-info-circle mr-1"></i>Status</th>
                <th class="py-2"><i class="fa-solid fa-gear mr-1"></i>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($donations as $donation)
            <tr class="border-b">
                <td class="py-2">{{ \App\Helpers\FoodTypes::display($donation->food_type) }}</td>
                <td class="py-2">{{ $donation->quantity }}</td>
                <td class="py-2">{{ optional($donation->expiration_date)->format('Y-m-d') ?: '—' }}</td>
                <td class="py-2">{{ optional($donation->pickup_time)->format('Y-m-d H:i') ?: '—' }}</td>
                <td class="py-2"><span class="px-2 py-1 rounded bg-gray-100">{{ __($donation->status) }}</span></td>
                <td class="py-2 flex gap-2">
                    <a href="{{ route('donations.edit', $donation) }}" class="text-blue-600"><i class="fa-solid fa-pen-to-square mr-1"></i>Edit</a>
                    <form method="POST" action="{{ route('donations.destroy', $donation) }}" onsubmit="return confirm('Delete donation?');">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-600"><i class="fa-solid fa-trash mr-1"></i>Delete</button>
                    </form>
                    <a href="{{ route('donations.matches', $donation) }}" class="text-primary-800"><i class="fa-solid fa-link mr-1"></i>Matches</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="py-6 text-center text-gray-500">No donations yet</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="mt-4">{{ $donations->links() }}</div>
  </div>
@endsection


