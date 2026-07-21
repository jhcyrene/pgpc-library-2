@props(['title', 'value', 'description', 'valueId' => null])

<div class="bg-white border border-slate-200 rounded-2xl p-4 sm:p-6 shadow-sm hover:shadow-md transition-all group cursor-default">
    <p class="text-xs font-bold text-slate-500 mb-1.5 uppercase tracking-wide group-hover:text-blue-600 transition-colors">
        {{ $title ?? 'Default Title' }}
    </p>
    <h4 @if($valueId) id="{{ $valueId }}" @endif class="text-2xl sm:text-3xl font-black text-slate-900 mb-0.5 tracking-tight">{!! $value ?? '0' !!}</h4>
    <p class="text-xs font-medium text-slate-400">{{ $description ?? 'No description' }}</p>
</div>
