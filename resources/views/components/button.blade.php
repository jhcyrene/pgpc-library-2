@props([
    'variant' => 'primary',
    'size' => 'md',
    'href' => null,
    'type' => 'button',
    'iconOnly' => false
])

@php
    // Map component variants to DaisyUI 5 btn classes
    $variantMap = [
        'primary'             => 'btn-primary',
        'secondary'           => 'btn-accent',
        'outline'             => 'btn-outline',
        'ghost'               => 'btn-ghost',
        'destructive'         => 'btn-error',
        'danger'              => 'btn-error',
        'danger-outline'      => 'btn-outline btn-error',
        'destructive-outline' => 'btn-outline btn-error',
        'icon'                => 'btn-primary btn-square',
    ];

    $sizeMap = [
        'sm' => 'btn-sm',
        'md' => 'btn-md',
        'lg' => 'btn-lg',
    ];

    $classes = 'btn rounded-xl font-bold tracking-wide '
        . ($variantMap[$variant] ?? 'btn-primary') . ' '
        . ($sizeMap[$size] ?? 'btn-md');
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
