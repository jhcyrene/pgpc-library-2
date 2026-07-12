@props(['label', 'active' => false])

<div class="nav-group mb-1">
    <button type="button" 
            onclick="toggleNavGroup(this)"
            class="nav-group-btn flex items-center justify-between w-full px-3 py-2.5 rounded-lg transition-all duration-200 group {{ $active ? 'bg-white/10 text-white font-bold shadow-sm' : 'text-gray-300 hover:bg-white/5 hover:text-white font-medium' }}"
            aria-expanded="{{ $active ? 'true' : 'false' }}">
        <div class="flex items-center gap-3">
            <div class="{{ $active ? 'text-white' : 'text-gray-400 group-hover:text-gray-300' }} w-5 h-5 flex-shrink-0 transition-colors">
                @if(isset($icon))
                    {{ $icon }}
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-full w-full" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                    </svg>
                @endif
            </div>
            <span class="text-sm tracking-wide">{{ $label }}</span>
        </div>
        
        <div class="nav-group-chevron transition-transform duration-200 {{ $active ? 'rotate-90 text-white' : 'text-gray-400 group-hover:text-gray-300' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </div>
    </button>
    
    <div class="nav-group-children overflow-hidden transition-all duration-300 {{ $active ? 'max-h-96 opacity-100' : 'max-h-0 opacity-0' }}">
        <div class="pl-8 space-y-1 mt-1 pb-1">
            {{ $slot }}
        </div>
    </div>
</div>
