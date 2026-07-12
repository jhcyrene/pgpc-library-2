@props(['route', 'label', 'badge' => null, 'badgeColor' => 'bg-[#EF4444]'])

@php
    $path = parse_url($route, PHP_URL_PATH) ?? '';
    $isActive = request()->url() === $route || request()->is(trim($path, '/'));
@endphp

<a href="{{ $route }}" class="flex items-center justify-between px-3 py-2.5 rounded-lg transition-all {{ $isActive ? 'bg-white/10' : 'text-gray-300 hover:text-white hover:bg-white/5' }}">
    <div class="flex items-center gap-3">
        <div class="h-4 w-4 {{ $isActive ? 'text-[#FFC107]' : '' }}">
            {{ $slot }}
        </div>
        <span class="text-sm {{ $isActive ? 'font-semibold text-[#FFC107]' : 'font-medium' }}">{{ $label }}</span>
    </div>
    
    @if($badge || $isActive)
    <div class="flex items-center gap-2">
        @if($badge)
            <span class="{{ $badgeColor }} text-white text-[9px] font-bold px-2 py-0.5 rounded-full leading-none">{{ $badge }}</span>
        @endif
        @if($isActive)
            <span class="w-1.5 h-1.5 rounded-full bg-[#FFC107] shrink-0"></span>
        @endif
    </div>
    @endif
</a>