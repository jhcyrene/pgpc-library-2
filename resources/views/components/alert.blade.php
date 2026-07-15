@props(['type' => 'info', 'message' => null])

@php
    $bgClass = 'bg-blue-50 border-blue-500 text-blue-800';
    $iconClass = 'text-blue-500';
    $title = 'Information';
    $iconPath = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />';
    
    if ($type === 'success') {
        $bgClass = 'bg-emerald-50 border-emerald-500 text-emerald-800';
        $iconClass = 'text-emerald-500';
        $title = 'Success';
        $iconPath = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />';
    } elseif ($type === 'error') {
        $bgClass = 'bg-red-50 border-red-500 text-red-800';
        $iconClass = 'text-red-500';
        $title = 'Error';
        $iconPath = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />';
    } elseif ($type === 'warning') {
        $bgClass = 'bg-amber-50 border-amber-500 text-amber-800';
        $iconClass = 'text-amber-500';
        $title = 'Warning';
        $iconPath = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />';
    }
@endphp

<div {{ $attributes->merge(['class' => "{$bgClass} border-l-4 p-4 rounded-xl shadow-sm"]) }} role="alert">
    <div class="flex items-start">
        <div class="flex-shrink-0">
            <svg class="h-5 w-5 {{ $iconClass }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                {!! $iconPath !!}
            </svg>
        </div>
        <div class="ml-3">
            @if ($message)
                <p class="text-sm font-medium">{{ $message }}</p>
            @endif
            @if ($slot->isNotEmpty())
                <div class="mt-2 text-sm">
                    {{ $slot }}
                </div>
            @endif
        </div>
    </div>
</div>
