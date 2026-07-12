@props(['type' => 'success', 'message' => ''])

@php
    $bgClass = 'bg-green-50 border-green-500 text-green-700';
    $iconClass = 'text-green-400';
    $title = 'Success';
    
    if ($type === 'error') {
        $bgClass = 'bg-red-50 border-red-500 text-red-700';
        $iconClass = 'text-red-400';
        $title = 'Error';
    } elseif ($type === 'warning') {
        $bgClass = 'bg-amber-50 border-amber-500 text-amber-700';
        $iconClass = 'text-amber-400';
        $title = 'Warning';
    }
@endphp

<div class="{{ $bgClass }} border-l-4 p-4 mb-6 rounded-md shadow-sm">
    <div class="flex">
        <div class="flex-shrink-0">
            @if ($type === 'success')
                <svg class="h-5 w-5 {{ $iconClass }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            @elseif ($type === 'error')
                <svg class="h-5 w-5 {{ $iconClass }}" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
            @else
                <svg class="h-5 w-5 {{ $iconClass }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            @endif
        </div>
        <div class="ml-3">
            <h3 class="text-sm font-medium">{{ $title }}</h3>
            <div class="mt-2 text-sm">
                <p>{{ $message }}</p>
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
