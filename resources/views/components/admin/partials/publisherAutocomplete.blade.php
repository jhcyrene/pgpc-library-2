@props(['value' => ''])

<div class="relative w-full">
    <label class="block text-sm font-semibold text-gray-700 mb-1">Publisher</label>
    <input type="text" id="publisher" name="publisher" autocomplete="off"
           class="block w-full border border-gray-200 rounded-lg text-sm px-3 py-2.5 bg-gray-50 focus:bg-white focus:border-[#102b70] focus:ring-1 focus:ring-[#102b70] outline-none transition-all shadow-sm" 
           placeholder="Type to search or enter a new publisher..." 
           value="{{ $value }}">
    
    <!-- Dropdown list -->
    <ul id="publisher-dropdown" class="absolute z-50 w-full bg-white border border-gray-200 rounded-lg mt-1 shadow-lg max-h-48 overflow-y-auto hidden">
    </ul>
    
    <p class="text-xs text-gray-500 mt-1">If the publisher does not exist, just type the name and it will be created automatically.</p>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const publisherInput = document.getElementById('publisher');
    const publisherDropdown = document.getElementById('publisher-dropdown');
    const publisherSearchUrl = @json(route('admin.api.publishers.search'));
    let debounceTimer;

    if (!publisherInput || !publisherDropdown) return;

    publisherInput.addEventListener('input', function() {
        clearTimeout(debounceTimer);
        const query = this.value.trim();
        
        if (query.length < 2) {
            publisherDropdown.classList.add('hidden');
            return;
        }

        debounceTimer = setTimeout(() => {
            const searchUrl = new URL(publisherSearchUrl);
            searchUrl.searchParams.set('q', query);

            fetch(searchUrl)
                .then(response => response.json())
                .then(data => {
                    publisherDropdown.innerHTML = '';
                    if (data.length > 0) {
                        data.forEach(pub => {
                            const li = document.createElement('li');
                            li.className = 'px-4 py-2 hover:bg-gray-100 cursor-pointer text-sm font-medium text-gray-700';
                            li.textContent = pub.publisher_name;
                            li.addEventListener('click', () => {
                                publisherInput.value = pub.publisher_name;
                                publisherDropdown.classList.add('hidden');
                            });
                            publisherDropdown.appendChild(li);
                        });
                        publisherDropdown.classList.remove('hidden');
                    } else {
                        publisherDropdown.classList.add('hidden');
                    }
                })
                .catch(error => {
                    console.error('Error fetching publishers:', error);
                    publisherDropdown.classList.add('hidden');
                });
        }, 300);
    });

    // Hide dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!publisherInput.contains(e.target) && !publisherDropdown.contains(e.target)) {
            publisherDropdown.classList.add('hidden');
        }
    });
});
</script>
@endpush
