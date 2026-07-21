@props(['status'])

@php
    $colors = [
        'Active' => 'bg-green-100 text-green-800 border-green-200',
        'Inactive' => 'bg-gray-100 text-gray-800 border-gray-200',
        'Suspended' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
        'Locked' => 'bg-red-100 text-red-800 border-red-200',
    ];
    $colorClass = $colors[$status] ?? 'bg-gray-100 text-gray-800 border-gray-200';
@endphp

<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $colorClass }}">
    {{ $status ?? 'Unknown' }}
</span>
