@props([
    'type' => 'button',
    'variant' => 'primary',
    'icon' => null,
    'iconPosition' => 'left',
])

@php
    $baseClasses = match($variant) {
        'primary' => 'bg-blue-600 hover:bg-blue-700 text-white',
        'secondary' => 'bg-gray-200 hover:bg-gray-300 text-gray-800',
        'danger' => 'bg-red-600 hover:bg-red-700 text-white',
        default => 'bg-blue-600 hover:bg-blue-700 text-white'
    };
@endphp

<button
    type="{{ $type }}"
    {{ $attributes->class([
        "w-full px-4 py-3 rounded-lg font-medium flex items-center justify-center gap-3 transition $baseClasses"
    ]) }}
>
    @if($icon && $iconPosition === 'left')
        <i class="{{ $icon }}"></i>
    @endif

    {{ $slot }}

    @if($icon && $iconPosition === 'right')
        <i class="{{ $icon }}"></i>
    @endif
</button>
