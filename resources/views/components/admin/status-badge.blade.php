@props(['status', 'label' => null])

@php
    $types = [
        'success' => 'bg-green-100 text-green-800',
        'error' => 'bg-red-100 text-red-800',
        'danger' => 'bg-red-100 text-red-800',
        'warning' => 'bg-yellow-100 text-yellow-800',
        'info' => 'bg-blue-100 text-blue-800',
        'neutral' => 'bg-gray-100 text-gray-800',
    ];

    // Standardize some common statuses
    $normalizedStatus = strtolower($status);
    if (in_array($normalizedStatus, ['active', 'available', 'approved', 'returned'])) {
        $type = 'success';
    } elseif (in_array($normalizedStatus, ['inactive', 'unavailable', 'rejected', 'overdue', 'lost'])) {
        $type = 'error';
    } elseif (in_array($normalizedStatus, ['pending', 'borrowed', 'reserved'])) {
        $type = 'warning';
    } else {
        $type = $types[$normalizedStatus] ?? 'neutral';
    }
    
    // If not matching direct type, use normalized logic above
    $class = $types[$type] ?? $types['neutral'];
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium capitalize {$class}"]) }}>
    {{ $label ?? $status }}
</span>
