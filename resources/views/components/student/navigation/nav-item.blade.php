@props(['href', 'icon', 'label', 'active' => false])

<li>
    <a href="{{ $href }}"
       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-base lg:text-sm transition-all duration-200 group relative
       {{ $active ? 'bg-white/10 text-white font-bold' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
        @if($active)
            <span class="absolute left-0 top-2 bottom-2 w-1 rounded-r-full bg-[#fcc719]"></span>
        @endif
        <svg class="h-5 w-5 shrink-0 {{ $active ? 'text-[#fcc719]' : 'text-slate-400 group-hover:text-slate-200' }} transition-colors"
             fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            {!! $icon !!}
        </svg>
        <span class="truncate">{{ $label }}</span>
        {{ $slot }}
    </a>
</li>
