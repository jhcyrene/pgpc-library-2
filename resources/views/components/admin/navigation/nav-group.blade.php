@props([
    'label', 
    'href' => null,
    'active' => false, 
    'expanded' => false,
    'id' => null,
    'disabled' => false,
])

@php
    $groupId = $id ?? 'nav-group-' . Str::slug($label);
    // Determine if we should start expanded
    $isExpanded = $active || $expanded;
@endphp

<div class="nav-group mb-1">
    <div class="flex items-stretch rounded-lg transition-all duration-200 group {{ $active ? 'bg-white/10 shadow-sm' : 'hover:bg-white/5' }}">
        
        <!-- The Main Parent Link -->
        @if($disabled)
        <div class="flex-1 flex items-center gap-3 px-3 py-2.5 rounded-l-lg text-gray-500 cursor-not-allowed" aria-disabled="true">
        @else
        <a href="{{ $href }}" class="flex-1 flex items-center gap-3 px-3 py-2.5 rounded-l-lg outline-none focus:ring-2 focus:ring-inset focus:ring-[#fcc719] {{ $active ? 'text-white font-bold' : 'text-gray-300 hover:text-white font-medium' }}">
        @endif
            <div class="{{ $active ? 'text-white' : 'text-gray-400 group-hover:text-gray-300' }} w-5 h-5 flex-shrink-0 transition-colors">
                @if(isset($icon))
                    {{ $icon }}
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-full w-full" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                    </svg>
                @endif
            </div>
            <span class="text-sm tracking-wide truncate">{{ $label }}</span>
        @if($disabled)
        </div>
        @else
        </a>
        @endif

        <!-- The Dropdown Toggle Button -->
        <button 
            type="button" 
            onclick="toggleNavGroup('{{ $groupId }}')"
            aria-label="Toggle {{ $label }} submenu"
            aria-expanded="{{ $isExpanded ? 'true' : 'false' }}"
            aria-controls="{{ $groupId }}"
            class="flex items-center justify-center px-3 rounded-r-lg outline-none focus:ring-2 focus:ring-inset focus:ring-[#fcc719] {{ $active ? 'text-white hover:bg-white/10' : 'text-gray-400 hover:text-white hover:bg-white/5' }}"
        >
            <svg id="{{ $groupId }}-chevron" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-200 {{ $isExpanded ? 'rotate-90' : '' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>

    </div>
    
    <!-- Submenu -->
    <div id="{{ $groupId }}" class="nav-group-submenu overflow-hidden transition-all duration-300 {{ $isExpanded ? 'max-h-96 opacity-100' : 'max-h-0 opacity-0' }}">
        <div class="pl-8 space-y-1 mt-1 pb-1">
            {{ $slot }}
        </div>
    </div>
</div>
