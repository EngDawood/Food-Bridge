@props([
    'title',
    'subtitle' => null,
    'icon' => null,
])

<div {{ $attributes->merge(['class' => 'bg-gradient-to-r from-primary-800 to-primary-700 text-white rounded-lg p-6 shadow-lg']) }}>
    <div class="flex items-center gap-3">
        @if($icon)
            <div class="h-12 w-12 rounded-lg bg-white/20 flex items-center justify-center flex-shrink-0">
                <i class="{{ $icon }} text-2xl"></i>
            </div>
        @endif
        <div class="flex-1">
            <h1 class="text-2xl font-bold">{{ $title }}</h1>
            @if($subtitle)
                <p class="text-primary-100 text-sm mt-1">{{ $subtitle }}</p>
            @endif
        </div>
        @if(isset($action))
            <div>{{ $action }}</div>
        @endif
    </div>
</div>
