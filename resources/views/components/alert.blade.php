@props([
    'variant' => 'info', // info, success, warning, danger
    'icon' => null,
    'title' => null,
])

@php
    $variantClasses = [
        'info' => 'bg-gradient-to-br from-blue-50 to-blue-100 border-blue-200 text-blue-700',
        'success' => 'bg-gradient-to-br from-green-50 to-green-100 border-green-200 text-green-700',
        'warning' => 'bg-gradient-to-br from-yellow-50 to-yellow-100 border-yellow-200 text-yellow-700',
        'danger' => 'bg-gradient-to-br from-red-50 to-red-100 border-red-200 text-red-700',
    ];

    $iconBgClasses = [
        'info' => 'bg-blue-200 text-blue-700',
        'success' => 'bg-green-200 text-green-700',
        'warning' => 'bg-yellow-200 text-yellow-700',
        'danger' => 'bg-red-200 text-red-700',
    ];

    $titleClasses = [
        'info' => 'text-blue-900',
        'success' => 'text-green-900',
        'warning' => 'text-yellow-900',
        'danger' => 'text-red-900',
    ];

    $defaultIcons = [
        'info' => 'fa-solid fa-circle-info',
        'success' => 'fa-solid fa-circle-check',
        'warning' => 'fa-solid fa-triangle-exclamation',
        'danger' => 'fa-solid fa-circle-exclamation',
    ];

    $displayIcon = $icon ?? $defaultIcons[$variant];
@endphp

<div {{ $attributes->merge(['class' => 'border rounded-lg p-5 shadow-md ' . $variantClasses[$variant]]) }}>
    <div class="flex items-start gap-3">
        <div class="h-10 w-10 rounded-lg flex items-center justify-center flex-shrink-0 {{ $iconBgClasses[$variant] }}">
            <i class="{{ $displayIcon }}"></i>
        </div>
        <div class="flex-1">
            @if($title)
                <h3 class="font-bold mb-1 {{ $titleClasses[$variant] }}">{{ $title }}</h3>
            @endif
            <div class="text-sm">{{ $slot }}</div>
        </div>
    </div>
</div>
