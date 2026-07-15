@props(['href', 'label', 'active' => false])

<li>
    <a href="{{ $href }}"
       class="block py-2 pl-3 pr-2 rounded-lg transition-colors text-xs
       {{ $active ? 'bg-white/10 text-[#fcc719] font-bold' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
        {{ $label }}
    </a>
</li>
