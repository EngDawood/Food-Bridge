@props([
    'title' => null,
    'subtitle' => null,
    'variant' => 'default', // default, gradient, bordered
])

@php
    $variantClasses = [
        'default' => 'bg-white shadow-md border border-gray-200',
        'gradient' => 'bg-gradient-to-br from-primary-50 to-primary-100 border border-primary-200 shadow-md',
        'bordered' => 'bg-white border-2 border-gray-200 hover:border-primary-300 transition-colors',
    ];

    $classes = 'rounded-lg overflow-hidden ' . $variantClasses[$variant];
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    @if($title)
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h2 class="font-bold text-lg text-primary-800">{{ $title }}</h2>
            @if($subtitle)
                <p class="text-sm text-gray-600 mt-1">{{ $subtitle }}</p>
            @endif
        </div>
    @endif

    <div class="p-6">
        {{ $slot }}
    </div>
</div>
