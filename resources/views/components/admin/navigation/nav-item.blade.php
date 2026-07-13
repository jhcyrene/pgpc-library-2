@props(['label', 'href' => null, 'active' => false, 'badge' => null, 'badgeColor' => 'bg-red-500', 'disabled' => false])

@php
    $classes = 'flex items-center justify-between px-3 py-1.5 rounded-lg transition-all duration-200 group ' .
        ($disabled
            ? 'text-gray-500 cursor-not-allowed'
            : ($active ? 'bg-white/10 text-white font-bold' : 'text-gray-300 hover:bg-white/5 hover:text-white font-medium'));
@endphp

@if($disabled)
    <div class="{{ $classes }}" aria-disabled="true">
        <div class="flex items-center gap-3">
            @if(isset($icon))
                <div class="text-gray-600 w-4 h-4 flex-shrink-0">{{ $icon }}</div>
            @endif
            <span class="text-sm tracking-wide">{{ $label }}</span>
        </div>
        @if($badge)
            <span class="{{ $badgeColor }} text-white text-[10px] font-extrabold px-2 py-0.5 rounded-full shadow-sm">{{ $badge }}</span>
        @endif
    </div>
@else
    <a href="{{ $href }}" class="{{ $classes }}">
        <div class="flex items-center gap-3">
            @if(isset($icon))
                <div class="{{ $active ? 'text-white' : 'text-gray-400 group-hover:text-gray-300' }} w-4 h-4 flex-shrink-0 transition-colors">{{ $icon }}</div>
            @endif
            <span class="text-sm tracking-wide">{{ $label }}</span>
        </div>
        @if($badge)
            <span class="{{ $badgeColor }} text-white text-[10px] font-extrabold px-2 py-0.5 rounded-full shadow-sm">{{ $badge }}</span>
        @endif
    </a>
@endif
