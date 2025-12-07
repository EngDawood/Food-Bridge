@props([
    'variant' => 'default', // default, success, warning, danger, info
])

@php
    $variantClasses = [
        'default' => 'bg-gray-100 text-gray-800 border-gray-200',
        'success' => 'bg-green-100 text-green-800 border-green-200',
        'warning' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
        'danger' => 'bg-red-100 text-red-800 border-red-200',
        'info' => 'bg-blue-100 text-blue-800 border-blue-200',
        'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
        'scheduled' => 'bg-blue-100 text-blue-800 border-blue-200',
        'delivered' => 'bg-green-100 text-green-800 border-green-200',
        'cancelled' => 'bg-red-100 text-red-800 border-red-200',
    ];

    $classes = 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border ' . $variantClasses[$variant];
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</span>
