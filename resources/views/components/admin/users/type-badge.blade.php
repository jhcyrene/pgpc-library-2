@props(['type'])

@php
    $colors = [
        'Member' => 'bg-blue-100 text-blue-800 border-blue-200',
        'Librarian' => 'bg-purple-100 text-purple-800 border-purple-200',
        'Administrator' => 'bg-indigo-100 text-indigo-800 border-indigo-200',
    ];
    $colorClass = $colors[$type] ?? 'bg-gray-100 text-gray-800 border-gray-200';
@endphp

<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $colorClass }}">
    {{ $type ?? 'Unknown' }}
</span>
