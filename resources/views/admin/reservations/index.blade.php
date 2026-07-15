<x-layout.admin title="Reservations">
    <div class="flex-1 flex flex-col min-h-0 h-full p-6 bg-gray-50/50">
        <x-admin.page-header 
            title="Reservations" 
            description="Manage student book reservations and requests."
            :breadcrumbs="[
                [
                    'label' => 'Dashboard',
                    'url' => strtolower((string) auth('member')->user()?->account_type) === 'librarian'
                        ? route('librarian.dashboard')
                        : route('admin.dashboard'),
                ],
                ['label' => 'Reservations']
            ]"
        />

        @if(session('success'))
            <x-alert type="success" message="{{ session('success') }}" class="mb-6" />
        @endif
        @if(session('error'))
            <x-alert type="error" message="{{ session('error') }}" class="mb-6" />
        @endif

        @include('admin.reservations.partials.table')
    </div>

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
                // View Button Intercept
                const viewBtn = e.target.closest('a[title="View Reservation"]');
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
                        const oldModal = document.getElementById('admin-reservation-details-modal');
                        if (oldModal) oldModal.remove();
                        
                        document.body.insertAdjacentHTML('beforeend', html);
                        document.getElementById('admin-reservation-details-modal').showModal();
                    })
                    .catch(() => {
                        viewBtn.innerHTML = btnHtml;
                        alert('Failed to load reservation details.');
                    });
                    
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
        });
    </script>
    </div>
</x-layout.admin>
