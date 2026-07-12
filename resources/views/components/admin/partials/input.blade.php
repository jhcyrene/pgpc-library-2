@props([
    'name',
    'label' => '',
    'type' => 'text',
    'placeholder' => '',
    'required' => false,
    'value' => old($name) ?? ''
])

<div class="flex flex-col gap-1.5">
    @if($label)
        <label for="{{ $name }}" class="text-sm font-semibold text-gray-700">
            {{ $label }} @if($required) <span class="text-red-500">*</span> @endif
        </label>
    @endif
    <input 
        type="{{ $type }}" 
        id="{{ $name }}" 
        name="{{ $name }}" 
        value="{{ $value }}" 
        placeholder="{{ $placeholder }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes->merge(['class' => 'w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-800 placeholder-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#1A2B56]/20 focus:border-[#1A2B56] transition-all shadow-sm']) }}
    >
    @error($name)
        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
    @enderror
</div>
