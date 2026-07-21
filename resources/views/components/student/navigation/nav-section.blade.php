@props(['title'])

<div>
    <h3 class="px-3 mb-2 text-[10px] font-bold text-slate-500 uppercase tracking-[0.16em]">{{ $title }}</h3>
    <ul class="space-y-1">
        {{ $slot }}
    </ul>
</div>
