@props(['title', 'value', 'icon', 'color' => 'primary', 'link' => null, 'description' => null])

@php
    $colorClasses = [
        'primary' => 'bg-primary/10 text-primary',
        'secondary' => 'bg-secondary/10 text-secondary',
        'accent' => 'bg-accent/10 text-accent',
        'info' => 'bg-info/10 text-info',
        'success' => 'bg-success/10 text-success',
        'warning' => 'bg-warning/10 text-warning',
        'error' => 'bg-error/10 text-error',
        'gold' => 'bg-gold/10 text-gold',
    ];
    $iconColor = $colorClasses[$color] ?? $colorClasses['primary'];
@endphp

<div class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition-shadow hover:shadow-md">
    @if($link)
        <a href="{{ $link }}" class="absolute inset-0 z-10"><span class="sr-only">View {{ $title }}</span></a>
    @endif
    
    <div class="mb-2 flex items-start justify-between gap-4">
        <div>
            <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wide group-hover:text-blue-700 transition-colors">{{ $title }}</h3>
            <p class="mt-1.5 text-2xl font-black tracking-tight text-slate-900">{{ $value }}</p>
        </div>
        <div class="flex h-9 w-9 items-center justify-center rounded-xl {{ $iconColor }} transition-transform group-hover:scale-105">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                {!! $icon !!}
            </svg>
        </div>
    </div>
    
    @if($description)
        <p class="text-xs font-medium text-slate-400">{{ $description }}</p>
    @elseif($link)
        <div class="flex items-center text-xs text-blue-700 font-bold">
            View details
            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 ml-1 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </div>
    @endif
</div>
