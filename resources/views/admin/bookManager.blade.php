<x-layout.admin>

<!-- Main Dashboard Content -->
    <div class="flex-1 flex flex-col min-h-0 h-full p-6 bg-gray-50/50">
        <x-admin.page-header 
            title="Book Management" 
            description="Manage the library's entire catalog of books and resources."
            :breadcrumbs="[
                [
                    'label' => 'Dashboard',
                    'url' => strtolower((string) auth('member')->user()?->account_type) === 'librarian'
                        ? route('librarian.dashboard')
                        : route('admin.dashboard'),
                ],
                ['label' => 'Books']
            ]"
        >
            <x-slot:actions>
                <x-admin.button href="{{ route('admin.books.create') }}" variant="primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Add New Book
                </x-admin.button>
            </x-slot:actions>
        </x-admin.page-header>

        @if(session('success'))
            <x-alert type="success" message="{{ session('success') }}" class="mb-6" />
        @endif
        @if(session('error'))
            <x-alert type="error" message="{{ session('error') }}" class="mb-6" />
        @endif

        <!-- Filters & Search -->
        <x-admin.partials.mainTable :allBooks="$allBooks" :categories="$categories ?? []" :publishers="$publishers ?? []" />

    </div>

    <!-- AJAX Loading JS -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const container = document.querySelector('.flex-1.flex.flex-col.min-h-0.h-full.p-6');
            const searchForm = container.querySelector('form');

            // Generic fetch and replace function
            const loadPage = (url) => {
                const tableContainer = document.getElementById('books-table-container');
                if (tableContainer) {
                    tableContainer.style.opacity = '0.5';
                    tableContainer.style.pointerEvents = 'none';
                }

                const controller = new AbortController();
                const timeoutId = setTimeout(() => controller.abort(), 10000); // 10 second timeout

                fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'text/html'
                    },
                    signal: controller.signal
                })
                .then(response => {
                    clearTimeout(timeoutId);
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.text();
                })
                .then(html => {
                    if (tableContainer) {
                        tableContainer.outerHTML = html;
                    }
                    // Update URL without reloading
                    window.history.pushState(null, '', url);
                })
                .catch(error => {
                    console.error('Error loading data:', error);
                    if (tableContainer) {
                        tableContainer.style.opacity = '1';
                        tableContainer.style.pointerEvents = 'auto';
                        tableContainer.innerHTML = '<div class="p-8 text-center text-red-500 font-bold border rounded-xl bg-white shadow-sm mt-4">Failed to load data. Please refresh the page.</div>';
                    }
                });
            };

            // Intercept Pagination Clicks
            container.addEventListener('click', function(e) {
                const viewBtn = e.target.closest('a[title="View"]');
                if (viewBtn) {
                    e.preventDefault();
                    
                    const btnHtml = viewBtn.innerHTML;
                    viewBtn.innerHTML = '<span class="loading loading-spinner loading-xs"></span>';
                    
                    fetch(viewBtn.href, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'text/html'
                        }
                    })
                    .then(response => response.text())
                    .then(html => {
                        viewBtn.innerHTML = btnHtml;
                        const oldModal = document.getElementById('admin-book-details-modal');
                        if (oldModal) oldModal.remove();
                        
                        document.body.insertAdjacentHTML('beforeend', html);
                        document.getElementById('admin-book-details-modal').showModal();
                    })
                    .catch(() => {
                        viewBtn.innerHTML = btnHtml;
                        alert('Failed to load book details.');
                    });
                    
                    return;
                }

                const paginationLink = e.target.closest('.ajax-pagination-wrapper a');
                if (paginationLink) {
                    e.preventDefault();
                    loadPage(paginationLink.href);
                }
            });

            // Intercept Search and Filter Form Submission
            if (searchForm) {
                searchForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const formData = new FormData(searchForm);
                    
                    // Filter out empty values
                    const params = new URLSearchParams();
                    for (const [key, value] of formData.entries()) {
                        if (value) params.append(key, value);
                    }
                    
                    const url = `${searchForm.action}?${params.toString()}`;
                    loadPage(url);
                });
                
                // Intercept Select change events to auto-submit
                const selects = searchForm.querySelectorAll('select');
                selects.forEach(select => {
                    select.addEventListener('change', () => {
                        searchForm.dispatchEvent(new Event('submit', { cancelable: true }));
                    });
                });
            }

            // Handle browser back/forward buttons
            window.addEventListener('popstate', function() {
                loadPage(window.location.href);
            });
        });
    </script>
</x-layout.admin>
