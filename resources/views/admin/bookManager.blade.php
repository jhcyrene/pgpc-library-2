<x-layout.admin>

<!-- Main Dashboard Content -->
    <div class="flex-1 flex flex-col min-h-0 h-auto lg:h-full p-6 bg-gray-50/50">
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
                <button onclick="document.getElementById('add_book_modal').showModal()" class="px-4 py-2.5 bg-[#102b70] hover:bg-[#0b225e] text-white font-bold text-sm rounded-xl shadow-xs flex items-center justify-center gap-2 transition-colors w-full sm:w-auto">
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
    <dialog id="add_book_modal" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box w-[calc(100%-1rem)] max-w-none max-h-[calc(100dvh-1rem)] overflow-y-auto sm:w-11/12 sm:max-w-5xl bg-white p-0 rounded-2xl">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50 shrink-0 relative sticky top-0 z-10">
                <div>
                    <h3 class="font-bold text-lg text-gray-900">Add New Book</h3>
                    <p class="text-sm text-gray-500">Register a new book into the library catalog.</p>
                </div>
                <form method="dialog">
                    <button class="btn btn-sm btn-circle btn-ghost text-gray-500 hover:text-gray-900">✕</button>
                </form>
            </div>
            
            <!-- Content -->
            <div class="p-6">
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
        <div class="modal-box w-[calc(100%-1rem)] max-w-none max-h-[calc(100dvh-1rem)] overflow-y-auto sm:w-11/12 sm:max-w-5xl bg-gray-50 p-0 rounded-2xl">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-4 top-4 z-20 text-gray-500 hover:bg-gray-100 bg-white shadow-sm border border-gray-100">✕</button>
            </form>
            <div id="bookDetailModalContent" class="p-6 sm:p-8 transition-opacity duration-300">
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
            const loadPage = (url, triggerBtn = null) => {
                const tableContainer = document.getElementById('books-table-container');
                if (tableContainer) {
                    tableContainer.style.opacity = '0.5';
                    tableContainer.style.pointerEvents = 'none';
                }

                const controller = new AbortController();
                const timeoutId = setTimeout(() => controller.abort(), 10000);

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
                    window.history.pushState(null, '', url);
                })
                .catch(error => {
                    console.error('Error loading data:', error);
                    if (tableContainer) {
                        tableContainer.style.opacity = '1';
                        tableContainer.style.pointerEvents = 'auto';
                        tableContainer.innerHTML = '<div class="p-8 text-center text-red-500 font-bold border rounded-xl bg-white shadow-sm mt-4">Failed to load data. Please refresh the page.</div>';
                    }
                })
                .finally(() => {
                    if (triggerBtn && triggerBtn.dataset.origHtml) {
                        triggerBtn.disabled = false;
                        triggerBtn.innerHTML = triggerBtn.dataset.origHtml;
                    }
                });
            };

            // Intercept Clicks (View Details, Edit, Clear, Pagination)
            container.addEventListener('click', function(e) {
                // 1. View Details Modal Click
                const viewBtn = e.target.closest('a[title="View Details"], a[title="View"]');
                if (viewBtn) {
                    e.preventDefault();
                    if (viewBtn.dataset.loading === 'true') return;
                    viewBtn.dataset.loading = 'true';
                    
                    const origSvg = viewBtn.innerHTML;
                    viewBtn.style.pointerEvents = 'none';
                    viewBtn.innerHTML = `<svg class="animate-spin h-4 w-4 text-blue-600 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>`;

                    window.openDetailModal(viewBtn.href, 'bookDetailModal')
                        .finally(() => {
                            viewBtn.dataset.loading = 'false';
                            viewBtn.style.pointerEvents = 'auto';
                            viewBtn.innerHTML = origSvg;
                        });
                    return;
                }

                // 2. Edit Book Link Click
                const editBtn = e.target.closest('a[title="Edit Book"], a[title="Edit"]');
                if (editBtn) {
                    editBtn.style.pointerEvents = 'none';
                    editBtn.classList.add('opacity-75', 'cursor-wait');
                    editBtn.innerHTML = `<svg class="animate-spin h-4 w-4 text-[#102b70] shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>`;
                    return;
                }

                // 3. Clear Filters Button Click
                const clearBtn = e.target.closest('a[href="{{ route('admin.books.index') }}"]');
                if (clearBtn && searchForm) {
                    e.preventDefault();
                    clearBtn.dataset.origHtml = clearBtn.innerHTML;
                    clearBtn.innerHTML = `<svg class="animate-spin h-3.5 w-3.5 text-slate-500 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg> Clearing...`;
                    
                    searchForm.reset();
                    const inputs = searchForm.querySelectorAll('input, select');
                    inputs.forEach(i => i.value = '');
                    loadPage('{{ route('admin.books.index') }}', clearBtn);
                    return;
                }

                // 4. Pagination Link Click
                const paginationLink = e.target.closest('.ajax-pagination-wrapper a');
                if (paginationLink) {
                    e.preventDefault();
                    loadPage(paginationLink.href);
                }
            });

            // Intercept Form Submissions (Search & Delete)
            container.addEventListener('submit', function(e) {
                const form = e.target.closest('form');
                if (!form) return;

                // Delete Form
                if (form.action.includes('/admin/books/') && form.querySelector('input[name="_method"][value="DELETE"]')) {
                    const deleteBtn = form.querySelector('button[type="submit"]');
                    if (deleteBtn) {
                        deleteBtn.disabled = true;
                        deleteBtn.innerHTML = `<svg class="animate-spin h-4 w-4 text-rose-600 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>`;
                    }
                    return;
                }

                // Search & Filter Form
                if (form === searchForm) {
                    e.preventDefault();
                    const searchBtn = searchForm.querySelector('button[type="submit"]');
                    if (searchBtn) {
                        searchBtn.disabled = true;
                        searchBtn.dataset.origHtml = searchBtn.innerHTML;
                        searchBtn.innerHTML = `<svg class="animate-spin h-3.5 w-3.5 text-white inline shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>`;
                    }

                    const formData = new FormData(searchForm);
                    const params = new URLSearchParams();
                    for (const [key, value] of formData.entries()) {
                        if (value) params.append(key, value);
                    }
                    
                    const url = `${searchForm.action}?${params.toString()}`;
                    loadPage(url, searchBtn);
                }
            });

            // Auto-submit filter selects with loading indicator
            if (searchForm) {
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

