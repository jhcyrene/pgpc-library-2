@props([
    'name',
    'label' => 'Cover Image',
    'required' => false,
    'accept' => 'image/*'
])

<div class="flex flex-col gap-1.5" x-data="imagePreview()">
    @if($label)
        <label for="{{ $name }}" class="text-sm font-semibold text-gray-700">
            {{ $label }} @if($required) <span class="text-red-500">*</span> @endif
        </label>
    @endif
    
    <div class="relative w-full h-48 rounded-xl border-2 border-dashed border-gray-300 bg-gray-50 hover:bg-gray-100 transition-colors flex flex-col items-center justify-center cursor-pointer overflow-hidden group">
        <input 
            type="file" 
            id="{{ $name }}" 
            name="{{ $name }}" 
            accept="{{ $accept }}"
            {{ $required ? 'required' : '' }}
            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
            @change="previewImage($event)"
        >
        
        <!-- Placeholder / Icon -->
        <div x-show="!imageUrl" class="flex flex-col items-center justify-center text-gray-400 group-hover:text-[#1A2B56] transition-colors p-4 text-center">
            <svg class="w-10 h-10 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
            </svg>
            <span class="text-sm font-medium">Click to upload or drag & drop</span>
            <span class="text-xs mt-1 text-gray-400">PNG, JPG, JPEG up to 2MB</span>
        </div>

        <!-- Image Preview -->
        <img x-show="imageUrl" :src="imageUrl" class="absolute inset-0 w-full h-full object-cover" alt="Image Preview" style="display: none;">
    </div>

    @error($name)
        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
    @enderror
</div>

<!-- Simple vanilla JS fallback if Alpine isn't used, but wrapped nicely -->
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('imagePreview', () => ({
            imageUrl: null,
            previewImage(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.imageUrl = e.target.result;
                    };
                    reader.readAsDataURL(file);
                } else {
                    this.imageUrl = null;
                }
            }
        }))
    })

    // Vanilla JS fallback just in case Alpine.js isn't loaded
    window.addEventListener('DOMContentLoaded', () => {
        if (typeof Alpine === 'undefined') {
            const input = document.getElementById('{{ $name }}');
            if(input) {
                input.addEventListener('change', function(event) {
                    const file = event.target.files[0];
                    const container = this.parentElement;
                    const img = container.querySelector('img');
                    const placeholder = container.querySelector('div.flex-col');
                    
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            img.src = e.target.result;
                            img.style.display = 'block';
                            if(placeholder) placeholder.style.display = 'none';
                        }
                        reader.readAsDataURL(file);
                    } else {
                        img.src = '';
                        img.style.display = 'none';
                        if(placeholder) placeholder.style.display = 'flex';
                    }
                });
            }
        }
    });
</script>
