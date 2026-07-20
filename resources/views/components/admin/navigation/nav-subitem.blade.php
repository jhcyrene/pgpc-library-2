@props(['label', 'href' => null, 'active' => false, 'disabled' => false])

@if($disabled)
    <div class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-600 cursor-not-allowed" aria-disabled="true">
        <div class="w-1.5 h-1.5 rounded-full bg-gray-700 ml-1.5"></div>
        <span class="text-base lg:text-sm">{{ $label }}</span>
    </div>
@else
    <a href="{{ $href }}" class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ $active ? 'bg-white/10 text-white font-semibold' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
        @if(isset($icon))
            <div class="w-4 h-4 flex-shrink-0 {{ $active ? 'text-white' : 'text-gray-500' }}">{{ $icon }}</div>
        @else
            <div class="w-1.5 h-1.5 rounded-full {{ $active ? 'bg-[#fcc719]' : 'bg-gray-600' }} ml-1.5"></div>
        @endif
        <span class="text-base lg:text-sm">{{ $label }}</span>
    </a>
@endif
