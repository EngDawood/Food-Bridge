@extends('layouts.app')

@section('content')
<div class="mb-4">
    <a href="{{ route('donations.index') }}" class="text-primary-700 hover:underline"><i class="fa-solid fa-arrow-left mr-1"></i>Back to donations</a>
</div>

<div class="bg-white rounded p-4 shadow mb-4">
    <h1 class="text-2xl font-bold mb-4"><i class="fa-solid fa-link mr-2"></i>Matching requests for donation</h1>
    <div class="border-b pb-3 mb-4">
        <p class="text-sm text-gray-600"><strong>Food type:</strong> {{ \App\Helpers\FoodTypes::display($donation->food_type) }}</p>
        <p class="text-sm text-gray-600"><strong>Quantity:</strong> {{ $donation->quantity }}</p>
        <p class="text-sm text-gray-600"><strong>Remaining:</strong> {{ $donation->remaining_quantity ?? $donation->quantity }}</p>
        @if($donation->expiration_date)
        <p class="text-sm text-gray-600"><strong>Expires:</strong> {{ $donation->expiration_date->format('Y-m-d') }}</p>
        @endif
        <p class="text-sm text-gray-600"><strong>Status:</strong> <span class="px-2 py-1 rounded bg-gray-100">{{ __($donation->status) }}</span></p>
    </div>
</div>

<div class="bg-white rounded p-4 shadow">
    <h2 class="text-xl font-semibold mb-4"><i class="fa-solid fa-list mr-2"></i>Matching requests</h2>
    
    @if($matches->isEmpty())
        <div class="text-center py-8 text-gray-500">
            <i class="fa-solid fa-inbox text-4xl mb-4 block"></i>
            <p>No matching requests found.</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left border-b">
                        <th class="py-2"><i class="fa-solid fa-percent mr-1"></i>Match score</th>
                        <th class="py-2"><i class="fa-solid fa-utensils mr-1"></i>Food type</th>
                        <th class="py-2"><i class="fa-solid fa-hashtag mr-1"></i>Quantity</th>
                        <th class="py-2"><i class="fa-solid fa-sticky-note mr-1"></i>Note</th>
                        <th class="py-2"><i class="fa-solid fa-user mr-1"></i>Beneficiary</th>
                        <th class="py-2"><i class="fa-solid fa-location-dot mr-1"></i>Location</th>
                        <th class="py-2"><i class="fa-solid fa-info-circle mr-1"></i>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($matches as $match)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-2">
                            <span class="px-2 py-1 rounded font-semibold
                                @if($match['score'] >= 80) bg-green-100 text-green-800
                                @elseif($match['score'] >= 50) bg-yellow-100 text-yellow-800
                                @else bg-orange-100 text-orange-800
                                @endif">
                                {{ number_format($match['score'], 1) }}%
                            </span>
                        </td>
                        <td class="py-2">{{ \App\Helpers\FoodTypes::display($match['request']->food_type) }}</td>
                        <td class="py-2">{{ $match['request']->quantity }}</td>
                        <td class="py-2">{{ $match['request']->note ?: '—' }}</td>
                        <td class="py-2">{{ $match['request']->beneficiary->name ?? '—' }}</td>
                        <td class="py-2">{{ $match['request']->beneficiary->location ?? '—' }}</td>
                        <td class="py-2">
                            <span class="px-2 py-1 rounded bg-gray-100">
                                {{ __($match['request']->status) }}
                            </span>
                            @if($match['request']->status === 'matched' && $match['request']->donation_id === $donation->id)
                                <span class="ml-2 text-green-600"><i class="fa-solid fa-check-circle"></i> Matched</span>
                            @endif
                            @if($donation->status === 'pending' && $match['request']->status === 'pending')
                                <form class="inline" method="post" action="{{ route('donations.match.withRequest', ['donation' => $donation->id, 'requestModel' => $match['request']->id]) }}" onsubmit="return confirm('Match this donation with the selected request?');">
                                    @csrf
                                    <button class="ml-2 text-primary-800 underline"><i class="fa-solid fa-link mr-1"></i>Match</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="mt-4 text-sm text-gray-600">
            <p><i class="fa-solid fa-info-circle mr-1"></i>Match score indicates how well the request matches your donation based on food type, quantity, location, and freshness.</p>
        </div>
    @endif
</div>
@endsection

