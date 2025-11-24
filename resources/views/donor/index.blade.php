@extends('layouts.app')

@section('content')
<div class="container mx-auto space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold tracking-tight">My Donations</h1>
            <p class="text-muted-foreground">Manage and track your food donations</p>
        </div>
        <x-ui.button href="/donations/create">
            <i class="fa-solid fa-plus"></i>
            Add Donation
        </x-ui.button>
    </div>

    {{-- Matching Alerts --}}
    <x-ui.alert>
        <i class="fa-solid fa-bell"></i>
        <x-ui.alert-title>Matching Alerts</x-ui.alert-title>
        <x-ui.alert-description>
            No alerts right now. We'll notify you when your donations match with requests.
        </x-ui.alert-description>
    </x-ui.alert>

    {{-- Donations Table --}}
    <x-ui.card>
        <x-ui.card-header>
            <x-ui.card-title>Donations List</x-ui.card-title>
            <x-ui.card-description>A list of all your food donations.</x-ui.card-description>
        </x-ui.card-header>
        <x-ui.card-content>
            <x-ui.table>
                <x-ui.table-header>
                    <x-ui.table-row>
                        <x-ui.table-head>Food Type</x-ui.table-head>
                        <x-ui.table-head>Quantity</x-ui.table-head>
                        <x-ui.table-head>Expires</x-ui.table-head>
                        <x-ui.table-head>Pickup Time</x-ui.table-head>
                        <x-ui.table-head>Status</x-ui.table-head>
                        <x-ui.table-head class="text-right">Actions</x-ui.table-head>
                    </x-ui.table-row>
                </x-ui.table-header>
                <x-ui.table-body>
                    @forelse($donations as $donation)
                        <x-ui.table-row>
                            <x-ui.table-cell class="font-medium">
                                {{ \App\Helpers\FoodTypes::display($donation->food_type) }}
                            </x-ui.table-cell>
                            <x-ui.table-cell>{{ $donation->quantity }}</x-ui.table-cell>
                            <x-ui.table-cell>
                                {{ optional($donation->expiration_date)->format('Y-m-d') ?: '—' }}
                            </x-ui.table-cell>
                            <x-ui.table-cell>
                                {{ optional($donation->pickup_time)->format('Y-m-d H:i') ?: '—' }}
                            </x-ui.table-cell>
                            <x-ui.table-cell>
                                @php
                                    $statusVariants = [
                                        'pending' => 'secondary',
                                        'scheduled' => 'default',
                                        'delivered' => 'default',
                                        'cancelled' => 'destructive',
                                    ];
                                    $variant = $statusVariants[$donation->status] ?? 'outline';
                                @endphp
                                <x-ui.badge :variant="$variant">
                                    {{ ucfirst($donation->status) }}
                                </x-ui.badge>
                            </x-ui.table-cell>
                            <x-ui.table-cell class="text-right">
                                <div class="flex justify-end gap-2">
                                    <x-ui.button variant="ghost" size="sm" href="{{ route('donations.edit', $donation) }}">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                        Edit
                                    </x-ui.button>
                                    <form method="POST" action="{{ route('donations.destroy', $donation) }}"
                                          onsubmit="return confirm('Delete this donation?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <x-ui.button variant="ghost" size="sm" type="submit">
                                            <i class="fa-solid fa-trash"></i>
                                            Delete
                                        </x-ui.button>
                                    </form>
                                    <x-ui.button variant="outline" size="sm" href="{{ route('donations.matches', $donation) }}">
                                        <i class="fa-solid fa-link"></i>
                                        Matches
                                    </x-ui.button>
                                </div>
                            </x-ui.table-cell>
                        </x-ui.table-row>
                    @empty
                        <x-ui.table-row>
                            <x-ui.table-cell colspan="6" class="h-24 text-center">
                                <div class="flex flex-col items-center gap-2">
                                    <i class="fa-solid fa-box-open text-muted-foreground text-4xl mb-2"></i>
                                    <p class="text-muted-foreground font-medium">No donations yet</p>
                                    <x-ui.button variant="link" href="/donations/create">
                                        Create your first donation
                                    </x-ui.button>
                                </div>
                            </x-ui.table-cell>
                        </x-ui.table-row>
                    @endforelse
                </x-ui.table-body>
            </x-ui.table>
        </x-ui.card-content>
        @if($donations->hasPages())
            <x-ui.card-footer>
                {{ $donations->links() }}
            </x-ui.card-footer>
        @endif
    </x-ui.card>
</div>
@endsection


