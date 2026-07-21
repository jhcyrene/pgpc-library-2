@props([
    'type' => 'info',
    'title' => null,
    'message' => null,
    'dismissible' => true,
])

@php
    $type = strtolower((string) $type);

    $config = match ($type) {
        'success' => [
            'border' => 'border-emerald-100',
            'iconBg' => 'bg-emerald-100 text-emerald-600',
            'progressBg' => 'bg-emerald-500',
            'titleColor' => 'text-slate-900',
            'defaultTitle' => 'Success',
            'iconHtml' => '<svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>',
        ],
        'error', 'danger' => [
            'border' => 'border-red-100',
            'iconBg' => 'bg-red-100 text-red-600',
            'progressBg' => 'bg-red-500',
            'titleColor' => 'text-slate-900',
            'defaultTitle' => 'Action failed',
            'iconHtml' => '<svg class="w-5 h-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" /></svg>',
        ],
        'warning' => [
            'border' => 'border-amber-100',
            'iconBg' => 'bg-amber-100 text-amber-600',
            'progressBg' => 'bg-amber-500',
            'titleColor' => 'text-slate-900',
            'defaultTitle' => 'Attention required',
            'iconHtml' => '<svg class="w-5 h-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>',
        ],
        default => [
            'border' => 'border-blue-100',
            'iconBg' => 'bg-blue-100 text-blue-600',
            'progressBg' => 'bg-blue-500',
            'titleColor' => 'text-slate-900',
            'defaultTitle' => 'Information',
            'iconHtml' => '<svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>',
        ],
    };

    $displayTitle = $title ?? $config['defaultTitle'];
@endphp

<div {{ $attributes->merge(['class' => "relative overflow-hidden rounded-2xl border {$config['border']} bg-white p-4 shadow-lg transition-all duration-300"]) }} role="alert">
    <div class="flex items-start justify-between gap-3.5">
        <!-- Variant Circle Icon -->
        <div class="{{ $config['iconBg'] }} grid h-10 w-10 shrink-0 place-items-center rounded-full shadow-2xs">
            {!! $config['iconHtml'] !!}
        </div>

        <!-- Notification Content -->
        <div class="min-w-0 flex-1 pt-0.5">
            <h4 class="text-sm font-extrabold {{ $config['titleColor'] }} leading-tight">
                {{ $displayTitle }}
            </h4>
            @if ($message)
                <p class="mt-0.5 text-xs sm:text-sm font-medium text-slate-500 leading-relaxed">
                    {{ $message }}
                </p>
            @endif
            @if ($slot->isNotEmpty())
                <div class="mt-1 text-xs sm:text-sm font-medium text-slate-600">
                    {{ $slot }}
                </div>
            @endif
        </div>

        <!-- Optional Dismiss X Button -->
        @if($dismissible)
            <button type="button" onclick="this.closest('[role=alert]').remove()" class="grid h-7 w-7 shrink-0 place-items-center rounded-lg text-slate-400 transition hover:bg-slate-100 hover:text-slate-700" aria-label="Dismiss notification">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        @endif
    </div>

    <!-- Bottom Progress Indicator Bar -->
    <div class="absolute inset-x-0 bottom-0 h-1 {{ $config['progressBg'] }} rounded-b-2xl opacity-90"></div>
</div>
