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
                <button onclick="document.getElementById('add_book_modal').showModal()" class="btn bg-brand-navy hover:bg-brand-navy-light text-white border-none shadow-sm flex items-center gap-2 px-4 min-h-[2.5rem] h-10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Add New Book
                </button>
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

    <!-- Add Book Modal -->
    <dialog id="add_book_modal" class="modal">
        <div class="modal-box w-11/12 max-w-5xl bg-white p-0 overflow-hidden flex flex-col">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50 shrink-0 relative">
                <div>
                    <h3 class="font-bold text-lg text-gray-900">Add New Book</h3>
                    <p class="text-sm text-gray-500">Register a new book into the library catalog.</p>
                </div>
                <form method="dialog">
                    <button class="btn btn-sm btn-circle btn-ghost text-gray-500 hover:text-gray-900">✕</button>
                </form>
            </div>
            
            <!-- Content -->
            <div class="p-6 overflow-y-auto max-h-[75dvh]">
                <x-admin.addBook :categories="$categories ?? []" :publishers="$publishers ?? []" :authors="$authors ?? []" />
            </div>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>

    @if($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('add_book_modal').showModal();
            });
        </script>
    @endif

    <!-- Book Detail Modal -->
    <dialog id="bookDetailModal" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box w-11/12 max-w-5xl bg-gray-50 p-0 sm:p-0 rounded-2xl overflow-hidden flex flex-col max-h-[90dvh]">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-4 top-4 z-20 text-gray-500 hover:bg-gray-100 bg-white shadow-sm border border-gray-100">✕</button>
            </form>
            <div id="bookDetailModalContent" class="p-6 sm:p-8 overflow-y-auto flex-1 transition-opacity duration-300">
                <!-- AJAX Content goes here -->
            </div>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>

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
                    window.openDetailModal(viewBtn.href, 'bookDetailModal');
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

