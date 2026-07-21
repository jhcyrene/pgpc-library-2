@props(['id', 'icon', 'label', 'href', 'active' => false])

<li>
    <div class="flex items-center rounded-lg transition-all duration-200 group relative {{ $active ? 'bg-white/10' : 'hover:bg-white/5' }}">
        @if($active)
            <span class="absolute left-0 top-2 bottom-2 w-1 rounded-r-full bg-[#fcc719]"></span>
        @endif

        <a href="{{ $href }}"
           class="min-w-0 flex-1 flex items-center gap-3 pl-3 pr-1 py-2.5 text-base lg:text-sm {{ $active ? 'text-white font-bold' : 'text-slate-300 group-hover:text-white' }}">
            <svg class="h-5 w-5 shrink-0 {{ $active ? 'text-[#fcc719]' : 'text-slate-400 group-hover:text-slate-200' }} transition-colors"
                 fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                {!! $icon !!}
            </svg>
            <span class="truncate">{{ $label }}</span>
        </a>

        <button type="button"
                class="p-3 text-slate-400 hover:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-inset focus:ring-[#fcc719]/50"
                aria-label="Toggle {{ $label }} links"
                aria-controls="{{ $id }}"
                aria-expanded="{{ $active ? 'true' : 'false' }}"
                onclick="toggleStudentNavGroup('{{ $id }}')">
            <svg id="{{ $id }}-chevron" class="h-4 w-4 transition-transform duration-200 {{ $active ? 'rotate-90 text-[#fcc719]' : '' }}"
                 fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>
    </div>

    <ul id="{{ $id }}"
        class="mt-1 space-y-1 pl-10 pr-1 overflow-hidden transition-all duration-300 {{ $active ? 'max-h-96 opacity-100' : 'max-h-0 opacity-0' }}">
        {{ $slot }}
    </ul>
</li>
