{{-- shadcn Alert Component for Laravel Blade --}}
@props(['variant' => 'default'])

@php
$baseClasses = 'relative w-full rounded-lg border px-4 py-3 text-sm [&>svg+div]:translate-y-[-3px] [&>svg]:absolute [&>svg]:left-4 [&>svg]:top-4 [&>svg]:text-foreground [&>svg~*]:pl-7';

$variants = [
    'default' => 'bg-background text-foreground',
    'destructive' => 'border-destructive/50 text-destructive dark:border-destructive [&>svg]:text-destructive',
];

$classes = $baseClasses . ' ' . ($variants[$variant] ?? $variants['default']);
@endphp

<div role="alert" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</div>
