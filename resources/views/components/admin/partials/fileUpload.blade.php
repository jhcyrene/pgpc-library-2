@props([
    'name',
    'label' => 'Cover Image',
    'required' => false,
    'accept' => 'image/*',
    'currentImage' => null,
])

<div class="flex flex-col gap-1.5" data-image-preview>
    @if($label)
        <label for="{{ $name }}" class="text-sm font-semibold text-gray-700">
            {{ $label }} @if($required) <span class="text-red-500">*</span> @endif
        </label>
    @endif

    <input type="hidden" name="{{ $name }}_base64" id="{{ $name }}_base64" value="{{ old($name.'_base64') }}">
    
    <div class="relative w-full h-48 rounded-xl border-2 border-dashed border-gray-300 bg-gray-50 hover:bg-gray-100 transition-colors flex flex-col items-center justify-center cursor-pointer overflow-hidden group">
        <input 
            type="file" 
            id="{{ $name }}" 
            name="{{ $name }}" 
            accept="{{ $accept }}"
            {{ $required ? 'required' : '' }}
            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
        >
        
        <!-- Placeholder / Icon -->
        <div data-image-preview-placeholder class="flex flex-col items-center justify-center text-gray-400 group-hover:text-[#102b70] transition-colors p-4 text-center" @if($currentImage) style="display: none;" @endif>
            <svg class="w-10 h-10 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
            </svg>
            <span class="text-sm font-medium">Click to upload or drag & drop</span>
            <span class="text-xs mt-1 text-gray-400">PNG, JPG, JPEG up to 2MB</span>
        </div>

        <!-- Image Preview -->
        <img data-image-preview-image src="{{ $currentImage ?? '' }}" class="absolute inset-0 w-full h-full object-cover" alt="Image Preview" @if(!$currentImage) style="display: none;" @endif>
    </div>

    @error($name)
        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
    @enderror
</div>

<script>
    function initFileUploads() {
        document.querySelectorAll('[data-image-preview]').forEach((component) => {
            const input = component.querySelector('input[type="file"]');
            const hiddenBase64 = component.querySelector('input[type="hidden"]');
            const image = component.querySelector('[data-image-preview-image]');
            const placeholder = component.querySelector('[data-image-preview-placeholder]');

            if (!input || !image || !placeholder || input.dataset.previewBound) {
                return;
            }

            input.dataset.previewBound = 'true';
            const currentImage = image.getAttribute('src') || '';

            input.addEventListener('change', (event) => {
                const file = event.target.files[0];

                if (!file) {
                    image.src = currentImage;
                    if (hiddenBase64) hiddenBase64.value = '';
                    image.style.display = currentImage ? 'block' : 'none';
                    placeholder.style.display = currentImage ? 'none' : 'flex';
                    return;
                }

                if (file.size > 5 * 1024 * 1024) {
                    alert('Image file size must be 5MB or smaller.');
                    input.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.addEventListener('load', (loadEvent) => {
                    const base64Data = loadEvent.target.result;
                    image.src = base64Data;
                    if (hiddenBase64) {
                        hiddenBase64.value = base64Data;
                    }
                    image.style.display = 'block';
                    placeholder.style.display = 'none';
                });
                reader.readAsDataURL(file);
            });
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initFileUploads);
    } else {
        initFileUploads();
    }
</script>
