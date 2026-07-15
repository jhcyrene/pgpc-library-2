<x-layout.admin title="Reservations">
    <div class="flex-1 flex flex-col min-h-0 h-full p-6 bg-gray-50/50">
        <x-admin.page-header 
            title="Reservations" 
            description="Manage student book reservations and requests."
        />

        @if(session('success'))
            <x-alert type="success" message="{{ session('success') }}" class="mb-6" />
        @endif
        @if(session('error'))
            <x-alert type="error" message="{{ session('error') }}" class="mb-6" />
        @endif

        <!-- Statistics Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 flex items-center gap-4 transition-shadow hover:shadow-md">
                <div class="w-12 h-12 rounded-full bg-yellow-50 text-yellow-600 flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <div>
                    <p class="text-2xl font-black text-gray-900 leading-none">{{ $pendingCount ?? 0 }}</p>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mt-1">Pending</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 flex items-center gap-4 transition-shadow hover:shadow-md">
                <div class="w-12 h-12 rounded-full bg-green-50 text-green-600 flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <div>
                    <p class="text-2xl font-black text-gray-900 leading-none">{{ $readyForPickupCount ?? 0 }}</p>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mt-1">Ready for Pickup</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 flex items-center gap-4 transition-shadow hover:shadow-md">
                <div class="w-12 h-12 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                </div>
                <div>
                    <p class="text-2xl font-black text-gray-900 leading-none">{{ $approvedCount ?? 0 }}</p>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mt-1">Approved</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 flex items-center gap-4 transition-shadow hover:shadow-md">
                <div class="w-12 h-12 rounded-full bg-gray-50 text-brand-navy flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                </div>
                <div>
                    <p class="text-2xl font-black text-gray-900 leading-none">{{ $completedCount ?? 0 }}</p>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mt-1">Completed</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 flex flex-col flex-1 overflow-hidden relative">
            <!-- Filter Bar -->
            <div class="p-4 md:p-5 border-b border-gray-100 bg-gray-50/50 shrink-0">
                <div class="flex flex-col lg:flex-row gap-4 justify-between items-start">
                    <!-- Search -->
                    <div class="relative w-full lg:w-96 shrink-0">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        </div>
                        <input type="text" id="search-reservations" class="input input-bordered w-full pl-10 h-10 text-sm focus:border-blue-500 focus:ring-blue-500 transition-colors shadow-sm bg-white" placeholder="Search by student, book, ID..." value="{{ request('search') }}">
                    </div>

                    <!-- Filters -->
                    <div class="flex flex-wrap items-center gap-3 w-full lg:w-auto justify-start lg:justify-end">
                        <select id="status-filter" class="select select-bordered h-10 min-h-10 text-sm shadow-sm bg-white w-full sm:w-36">
                            <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="ready-for-pickup" {{ request('status') == 'ready-for-pickup' ? 'selected' : '' }}>Ready for Pickup</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>

                        <select id="date-filter" class="select select-bordered h-10 min-h-10 text-sm shadow-sm bg-white w-full sm:w-40">
                            <option value="all" {{ request('date_filter') == 'all' ? 'selected' : '' }}>Any Request Date</option>
                            <option value="today" {{ request('date_filter') == 'today' ? 'selected' : '' }}>Today</option>
                            <option value="this_week" {{ request('date_filter') == 'this_week' ? 'selected' : '' }}>This Week</option>
                            <option value="this_month" {{ request('date_filter') == 'this_month' ? 'selected' : '' }}>This Month</option>
                        </select>

                        <select id="sort-filter" class="select select-bordered h-10 min-h-10 text-sm shadow-sm bg-white w-full sm:w-40">
                            <option value="request_date_desc" {{ request('sort') == 'request_date' && request('dir') == 'desc' ? 'selected' : '' }}>Newest First</option>
                            <option value="request_date_asc" {{ request('sort') == 'request_date' && request('dir') == 'asc' ? 'selected' : '' }}>Oldest First</option>
                            <option value="student_name_asc" {{ request('sort') == 'student_name' && request('dir') == 'asc' ? 'selected' : '' }}>Student A-Z</option>
                        </select>

                        <button type="button" onclick="resetFilters()" class="btn btn-ghost btn-sm text-gray-500 hover:text-gray-900 w-full sm:w-auto">Reset</button>
                    </div>
                </div>
            </div>

            @include('admin.reservations.partials.table')
        </div>
    </div>

    <dialog id="reservationDetailModal" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box w-[calc(100%-1rem)] max-w-none max-h-[calc(100dvh-1rem)] overflow-y-auto sm:w-11/12 sm:max-w-5xl bg-gray-50 p-0 rounded-2xl">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-4 top-4 z-20 text-gray-500 hover:bg-gray-100 bg-white shadow-sm border border-gray-100">✕</button>
            </form>
            <div id="reservationDetailModalContent" class="p-6 sm:p-8 transition-opacity duration-300">
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

            // Generic fetch and replace function
            const loadPage = (url) => {
                const tableContainer = document.getElementById('reservations-table-container');
                const loader = document.getElementById('table-loader');
                
                if (loader) loader.classList.remove('hidden');

                fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'text/html'
                    }
                })
                .then(response => {
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
                    if (loader) loader.classList.add('hidden');
                    alert('Failed to load data. Please refresh the page.');
                });
            };

            // Intercept Clicks for Tabs, Pagination, and View
            container.addEventListener('click', function(e) {
                // View Details Intercept
                const viewRow = e.target.closest('.reservation-row');
                const isActionButton = e.target.closest('button:not(.btn-ghost), a');
                
                if (viewRow && !isActionButton) {
                    e.preventDefault();
                    window.openDetailModal(viewRow.dataset.url, 'reservationDetailModal');
                    return;
                }

                // Pagination Intercept
                const paginationLink = e.target.closest('.ajax-pagination-wrapper a');
                if (paginationLink) {
                    e.preventDefault();
                    loadPage(paginationLink.href);
                    return;
                }

                // Tabs Intercept
                const tabLink = e.target.closest('.ajax-tabs a');
                if (tabLink) {
                    e.preventDefault();
                    loadPage(tabLink.href);
                    return;
                }
            });

            // Handle browser back/forward buttons
            window.addEventListener('popstate', function() {
                loadPage(window.location.href);
            });
            
            // Global alert function for the modal actions
            window.showAlert = function(message, type = 'success') {
                let container = document.getElementById('ajax-alert-container');
                if (!container) {
                    container = document.createElement('div');
                    container.id = 'ajax-alert-container';
                    container.className = 'fixed top-6 right-6 z-[100] flex flex-col gap-2';
                    document.body.appendChild(container);
                }
                const alertDiv = document.createElement('div');
                alertDiv.className = `p-4 rounded-lg shadow-lg border text-sm font-medium flex items-center gap-3 transition-opacity duration-300 ${
                    type === 'success' 
                        ? 'bg-success/10 border-success text-success' 
                        : 'bg-error/10 border-error text-error'
                }`;
                alertDiv.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        ${type === 'success' 
                            ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />'
                            : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />'
                        }
                    </svg>
                    <span>${message}</span>
                `;
                container.appendChild(alertDiv);
                
                setTimeout(() => {
                    alertDiv.style.opacity = '0';
                    setTimeout(() => alertDiv.remove(), 300);
                }, 4000);
            };

            // Global submit interceptor for status forms (so it works inside the modal and reloads the table)
            document.addEventListener('submit', async function(e) {
                if (e.target && e.target.classList.contains('ajax-form')) {
                    e.preventDefault();
                    
                    const form = e.target;
                    const confirmMsg = form.getAttribute('data-confirm');
                    if (confirmMsg && !confirm(confirmMsg)) {
                        return;
                    }

                    const loader = document.getElementById('status-card-loader');
                    if (loader) loader.classList.remove('hidden');

                    try {
                        const formData = new FormData(form);
                        const response = await fetch(form.action, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]')?.value
                            }
                        });

                        const result = await response.json();

                        if (response.ok) {
                            if (result.html) {
                                document.getElementById('status-card-container').innerHTML = result.html;
                            }
                            window.showAlert(result.message || 'Updated successfully', 'success');
                            
                            // Reload the main table behind the modal
                            const activeTab = document.querySelector('.ajax-tabs a.bg-primary');
                            if (activeTab) {
                                loadPage(activeTab.href);
                            } else {
                                loadPage(window.location.href);
                            }
                        } else {
                            window.showAlert(result.message || 'An error occurred', 'error');
                        }
                    } catch (error) {
                        window.showAlert('A network error occurred.', 'error');
                    } finally {
                        const newLoader = document.getElementById('status-card-loader');
                        if (newLoader) newLoader.classList.add('hidden');
                    }
                }
            });
            // Filter handling
            const searchInput = document.getElementById('search-reservations');
            const statusFilter = document.getElementById('status-filter');
            const dateFilter = document.getElementById('date-filter');
            const sortFilter = document.getElementById('sort-filter');

            const buildFilterUrl = () => {
                const url = new URL(window.location.href);
                url.searchParams.set('search', searchInput.value);
                url.searchParams.set('status', statusFilter.value);
                url.searchParams.set('date_filter', dateFilter.value);
                
                const sortValue = sortFilter.value;
                if (sortValue.endsWith('_desc')) {
                    url.searchParams.set('sort', sortValue.replace('_desc', ''));
                    url.searchParams.set('dir', 'desc');
                } else if (sortValue.endsWith('_asc')) {
                    url.searchParams.set('sort', sortValue.replace('_asc', ''));
                    url.searchParams.set('dir', 'asc');
                }
                
                url.searchParams.set('page', 1);
                return url.toString();
            };

            const handleFilterChange = () => {
                loadPage(buildFilterUrl());
            };

            let searchTimeout;
            searchInput.addEventListener('input', () => {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(handleFilterChange, 300);
            });

            statusFilter.addEventListener('change', handleFilterChange);
            dateFilter.addEventListener('change', handleFilterChange);
            sortFilter.addEventListener('change', handleFilterChange);

            window.resetFilters = () => {
                searchInput.value = '';
                statusFilter.value = 'all';
                dateFilter.value = 'all';
                sortFilter.value = 'request_date_desc';
                handleFilterChange();
            };

            // Inline Approve / Reject
            window.confirmApprove = async (url) => {
                if (!confirm('Are you sure you want to approve this reservation?')) return;
                await inlineUpdateStatus(url, 'Approved');
            };

            window.confirmReject = async (url) => {
                if (!confirm('Are you sure you want to reject this reservation?')) return;
                await inlineUpdateStatus(url, 'Rejected');
            };

            const inlineUpdateStatus = async (url, status) => {
                const loader = document.getElementById('table-loader');
                if (loader) loader.classList.remove('hidden');

                try {
                    const formData = new FormData();
                    formData.append('status', status);
                    formData.append('_method', 'PATCH');
                    // Get CSRF token
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content 
                        || document.querySelector('input[name="_token"]')?.value;

                    const response = await fetch(url, {
                        method: 'POST', // Form spoofing via _method
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        }
                    });

                    const result = await response.json();

                    if (response.ok) {
                        window.showAlert(result.message || 'Updated successfully', 'success');
                        loadPage(window.location.href);
                    } else {
                        window.showAlert(result.message || 'An error occurred', 'error');
                        if (loader) loader.classList.add('hidden');
                    }
                } catch (error) {
                    window.showAlert('A network error occurred.', 'error');
                    if (loader) loader.classList.add('hidden');
                }
            };
        });
    </script>
    </div>
</x-layout.admin>

