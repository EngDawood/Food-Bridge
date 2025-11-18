@extends('layouts.app')

@section('content')
<h1 class="text-xl font-bold mb-6"><i class="fa-solid fa-exchange-alt mr-2"></i>Transactions</h1>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-white p-4 rounded shadow">
        <h2 class="font-semibold mb-2"><i class="fa-solid fa-hand-holding-heart mr-1"></i>Recent donations</h2>
        <ul class="space-y-2 text-sm">
            @foreach($donations as $d)
            <li class="border-b pb-2">
                <div class="flex justify-between">
                    <span>{{ $d->food_type }} ({{ $d->quantity }})</span>
                    <span class="text-xs">{{ $d->status }}</span>
                </div>
                <div class="text-gray-500 text-xs">#{{ $d->id }} • {{ optional($d->pickup_time)->format('Y-m-d H:i') }}</div>
            </li>
            @endforeach
        </ul>
    </div>

    <div class="bg-white p-4 rounded shadow">
        <h2 class="font-semibold mb-2"><i class="fa-solid fa-clipboard-list mr-1"></i>Recent requests</h2>
        <ul class="space-y-2 text-sm">
            @foreach($requests as $r)
            <li class="border-b pb-2">
                <div class="flex justify-between">
                    <span>{{ $r->food_type }} ({{ $r->quantity }})</span>
                    <span class="text-xs">{{ $r->status }}</span>
                </div>
                <div class="text-gray-500 text-xs">#{{ $r->id }} • Beneficiary: {{ $r->beneficiary_id }}</div>
            </li>
            @endforeach
        </ul>
    </div>

    <div class="bg-white p-4 rounded shadow">
        <h2 class="font-semibold mb-2"><i class="fa-solid fa-truck mr-1"></i>Recent delivery tasks</h2>
        <ul class="space-y-2 text-sm">
            @foreach($deliveries as $t)
            <li class="border-b pb-2">
                <div class="flex justify-between">
                    <span>#{{ $t->id }} • Donation: {{ $t->donation_id }}</span>
                    <span class="text-xs">{{ $t->status }}</span>
                </div>
                <div class="text-gray-500 text-xs">Pickup: {{ $t->pickup_location }} • Drop-off: {{ $t->dropoff_location }}</div>
            </li>
            @endforeach
        </ul>
    </div>
</div>

<div class="mt-6">
    <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 rounded border"><i class="fa-solid fa-arrow-left mr-1"></i>Back to dashboard</a>
</div>
@endsection


