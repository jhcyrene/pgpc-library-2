@props(['title', 'value', 'icon', 'color' => 'primary', 'link' => null, 'description' => null])

@php
    $colorClasses = [
        'primary' => 'bg-blue-50 text-blue-600',
        'secondary' => 'bg-slate-50 text-slate-600',
        'accent' => 'bg-amber-50 text-amber-600',
        'info' => 'bg-purple-50 text-purple-600',
        'success' => 'bg-green-50 text-green-600',
        'warning' => 'bg-orange-50 text-orange-600',
        'error' => 'bg-red-50 text-red-600',
        'gold' => 'bg-amber-50 text-amber-600',
    ];
    $iconColor = $colorClasses[$color] ?? $colorClasses['primary'];
@endphp

<div class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-3 sm:p-5 shadow-sm transition-all hover:shadow-md flex items-center gap-2.5 sm:gap-4">
    @if($link)
        <a href="{{ $link }}" class="absolute inset-0 z-10"><span class="sr-only">View {{ $title }}</span></a>
    @endif
    
    <div class="flex h-9 w-9 sm:h-11 sm:w-11 shrink-0 items-center justify-center rounded-xl {{ $iconColor }} transition-transform group-hover:scale-105">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            {!! $icon !!}
        </svg>
    </div>

    <div class="min-w-0 flex-1">
        <h3 class="text-[9px] sm:text-[10px] font-extrabold text-slate-400 uppercase tracking-wider sm:tracking-widest group-hover:text-blue-700 transition-colors truncate">{{ $title }}</h3>
        <p class="mt-0.5 text-lg sm:text-2xl font-black tracking-tight text-slate-900 leading-none">{{ $value }}</p>
        @if($description)
            <p class="mt-1 text-[9px] sm:text-xs font-semibold text-slate-400 truncate leading-normal">{{ $description }}</p>
        @endif
    </div>
</div>
