@props([
    'label' => null,
    'icon' => null,
    'error' => null,
    'type' => 'text',
    'required' => false,
])

@php
    $inputClasses = 'w-full border border-gray-300 rounded-lg px-3 py-2.5 text-base focus:outline-none focus:ring-2 focus:ring-primary-700 focus:border-transparent';

    if($error) {
        $inputClasses .= ' border-red-400';
    }
@endphp

<div {{ $attributes->only('class') }}>
    @if($label)
        <label {{ $attributes->only(['for', 'id'])->merge(['class' => 'block mb-2 text-sm font-semibold text-gray-700']) }}>
            @if($icon)
                <i class="{{ $icon }} mr-1 text-primary-700"></i>
            @endif
            {{ $label }}
            @if($required)
                <span class="text-red-600">*</span>
            @endif
        </label>
    @endif

    <input
        type="{{ $type }}"
        {{ $attributes->except(['class', 'label', 'icon', 'error'])->merge(['class' => $inputClasses]) }}>

    @if($error)
        <p class="text-red-600 text-sm mt-1">
            <i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $error }}
        </p>
    @endif
</div>
