@props([
    'variant' => 'primary', // primary, accent, secondary, success, danger, ghost
    'size' => 'md', // sm, md, lg
    'href' => null,
    'type' => 'button',
])

@php
    $baseClasses = 'inline-flex items-center justify-center font-semibold rounded-lg transition-all';

    $variantClasses = [
        'primary' => 'bg-primary-700 hover:bg-primary-800 text-white shadow-md hover:shadow-lg',
        'accent' => 'bg-accent-500 hover:brightness-95 text-white shadow-md hover:shadow-lg',
        'secondary' => 'bg-gray-200 hover:bg-gray-300 text-gray-700',
        'success' => 'bg-green-600 hover:bg-green-700 text-white shadow-md hover:shadow-lg',
        'danger' => 'bg-red-600 hover:bg-red-700 text-white shadow-md hover:shadow-lg',
        'ghost' => 'hover:bg-gray-100 text-gray-700',
        'success' => 'bg-emerald-600 hover:bg-emerald-700 text-white shadow-md hover:shadow-lg',
    ];

    $sizeClasses = [
        'sm' => 'px-4 py-2 text-sm',
        'md' => 'px-6 py-3 text-base',
        'lg' => 'px-8 py-4 text-lg',
    ];

    $classes = $baseClasses . ' ' . $variantClasses[$variant] . ' ' . $sizeClasses[$size];
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
