@props([
    'label' => null,
    'icon' => null,
    'name' => '',
    'rows' => 4,
    'placeholder' => '',
    'required' => false,
    'error' => null,
    'value' => '',
])

<div>
    @if($label)
        <label for="{{ $name }}" class="block mb-2 text-sm font-semibold text-gray-700">
            @if($icon)
                <i class="{{ $icon }} mr-1 text-primary-700"></i>
            @endif
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <textarea
        id="{{ $name }}"
        name="{{ $name }}"
        rows="{{ $rows }}"
        placeholder="{{ $placeholder }}"
        {{ $attributes->merge(['class' => 'w-full border border-gray-300 rounded-lg px-3 py-2.5 text-base focus:outline-none focus:ring-2 focus:ring-primary-700 focus:border-transparent transition-colors resize-y ' . ($error ? 'border-red-400' : '')]) }}
        @if($required) required @endif
    >{{ old($name, $value) }}</textarea>

    @if($error)
        <p class="text-red-600 text-sm mt-1">
            <i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $error }}
        </p>
    @endif
</div>
