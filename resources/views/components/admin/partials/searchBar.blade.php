@props([
    'action', 
    'placeholder' => 'Search...', 
    'name' => 'search'
])

<!-- Wrapped the div in a form and applied your Tailwind classes to the form -->
<form action="{{ $action }}" method="GET" {{ $attributes->merge(['class' => 'relative group w-full']) }}>
    
    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
        <svg class="h-4 w-4 text-gray-400 group-focus-within:text-[#1A2B56] transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
    </div>
    
    <input 
        type="text" 
        name="{{ $name }}" 
        value="{{ request($name) }}"
        class="block w-full pl-9 pr-20 py-2 border border-gray-200 rounded-lg text-sm bg-gray-50 focus:bg-white focus:border-[#1A2B56] focus:ring-1 focus:ring-[#1A2B56] outline-none transition-all shadow-sm" 
        placeholder="{{ $placeholder }}"
    >   

    <button type="submit" class="absolute top-1/2 -translate-y-1/2 right-1.5 px-3 py-1.5 bg-[#1A2B56] hover:bg-[#243B73] text-white text-xs font-medium rounded-md transition-colors shadow-sm focus:outline-none">
        Search
    </button>
</form>