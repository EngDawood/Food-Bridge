{{-- shadcn Table Component for Laravel Blade --}}
@props(['caption' => null])

<div class="relative w-full overflow-auto">
    <table {{ $attributes->merge(['class' => 'w-full caption-bottom text-sm']) }}>
        @if($caption)
            <caption class="mt-4 text-sm text-muted-foreground">{{ $caption }}</caption>
        @endif
        {{ $slot }}
    </table>
</div>
