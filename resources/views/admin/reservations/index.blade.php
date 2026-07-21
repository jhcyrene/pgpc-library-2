<x-layout.admin title="Reservations">
    <div class="flex-1 flex flex-col min-h-0 h-auto lg:h-full p-4 sm:p-6 bg-slate-50/50 font-sans text-slate-800">
        
        <!-- Header -->
        <div class="mb-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 shrink-0">
            <div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Reservations</h1>
                <p class="text-xs sm:text-sm text-slate-500 font-medium mt-0.5">Manage student book reservations and requests.</p>
            </div>
        </div>

        @if(session('success'))
            <x-alert type="success" message="{{ session('success') }}" class="mb-5" />
        @endif
        @if(session('error'))
            <x-alert type="error" message="{{ session('error') }}" class="mb-5" />
        @endif

        <!-- Top 4 Summary Metric Cards -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-5 shrink-0">
            <!-- 1. Pending (Amber) -->
            <div class="bg-white rounded-2xl p-4 shadow-xs border border-slate-200/80 flex items-center justify-between transition-all hover:shadow-md">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0 border border-amber-100 shadow-2xs">
                        <svg class="w-5 h-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <div>
                        <p class="text-xl sm:text-2xl font-black text-slate-900 leading-none">{{ $pendingCount ?? 3 }}</p>
                        <p class="text-[11px] font-extrabold text-slate-400 uppercase tracking-wider mt-1">Pending</p>
                    </div>
                </div>
            </div>

            <!-- 2. Ready for Pickup (Green) -->
            <div class="bg-white rounded-2xl p-4 shadow-xs border border-slate-200/80 flex items-center justify-between transition-all hover:shadow-md">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 border border-emerald-100 shadow-2xs">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <div>
                        <p class="text-xl sm:text-2xl font-black text-slate-900 leading-none">{{ $readyForPickupCount ?? 2 }}</p>
                        <p class="text-[11px] font-extrabold text-slate-400 uppercase tracking-wider mt-1">Ready for Pickup</p>
                    </div>
                </div>
            </div>

            <!-- 3. Approved (Blue) -->
            <div class="bg-white rounded-2xl p-4 shadow-xs border border-slate-200/80 flex items-center justify-between transition-all hover:shadow-md">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0 border border-blue-100 shadow-2xs">
                        <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                    </div>
                    <div>
                        <p class="text-xl sm:text-2xl font-black text-slate-900 leading-none">{{ $approvedCount ?? 1 }}</p>
                        <p class="text-[11px] font-extrabold text-slate-400 uppercase tracking-wider mt-1">Approved</p>
                    </div>
                </div>
            </div>

            <!-- 4. Completed (Slate) -->
            <div class="bg-white rounded-2xl p-4 shadow-xs border border-slate-200/80 flex items-center justify-between transition-all hover:shadow-md">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center shrink-0 border border-slate-200 shadow-2xs">
                        <svg class="w-5 h-5 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" /></svg>
                    </div>
                    <div>
                        <p class="text-xl sm:text-2xl font-black text-slate-900 leading-none">{{ $completedCount ?? 1 }}</p>
                        <p class="text-[11px] font-extrabold text-slate-400 uppercase tracking-wider mt-1">Completed</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Bar Card (Matching Books Page Pattern) -->
        <div class="bg-white rounded-2xl border border-slate-200 p-4 mb-5 shadow-xs shrink-0">
            <div class="flex flex-col lg:flex-row gap-3 justify-between items-stretch lg:items-center">
                
                <!-- Left: Search Input -->
                <div class="relative w-full lg:w-96 shrink-0">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    </div>
                    <input type="text" id="search-reservations" class="w-full pl-10 pr-9 py-2 rounded-xl border border-slate-200 text-xs sm:text-sm text-slate-900 placeholder:text-slate-400 focus:border-[#102b70] focus:ring-2 focus:ring-[#102b70]/20 outline-none transition-colors shadow-2xs bg-white" placeholder="Search by student, book title, or ID..." value="{{ request('search') }}">
                    <button type="button" id="clear-search-btn" onclick="resetFilters()" class="{{ request('search') ? '' : 'hidden' }} absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <!-- Right: Dropdown Filters & Filter Button -->
                <div class="flex flex-wrap items-center gap-2.5 w-full lg:w-auto">
                    <select id="status-filter" class="rounded-xl border border-slate-200 py-2 px-3 text-xs font-bold text-slate-700 shadow-2xs bg-white focus:border-[#102b70] outline-none flex-1 sm:w-36">
                        <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="ready-for-pickup" {{ request('status') == 'ready-for-pickup' ? 'selected' : '' }}>Ready for Pickup</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>

                    <select id="date-filter" class="rounded-xl border border-slate-200 py-2 px-3 text-xs font-bold text-slate-700 shadow-2xs bg-white focus:border-[#102b70] outline-none flex-1 sm:w-40">
                        <option value="all" {{ request('date_filter') == 'all' ? 'selected' : '' }}>Any Request Date</option>
                        <option value="today" {{ request('date_filter') == 'today' ? 'selected' : '' }}>Today</option>
                        <option value="this_week" {{ request('date_filter') == 'this_week' ? 'selected' : '' }}>This Week</option>
                        <option value="this_month" {{ request('date_filter') == 'this_month' ? 'selected' : '' }}>This Month</option>
                    </select>

                    <select id="sort-filter" class="rounded-xl border border-slate-200 py-2 px-3 text-xs font-bold text-slate-700 shadow-2xs bg-white focus:border-[#102b70] outline-none flex-1 sm:w-36">
                        <option value="request_date_desc" {{ request('sort') == 'request_date' && request('dir') == 'desc' ? 'selected' : '' }}>Newest First</option>
                        <option value="request_date_asc" {{ request('sort') == 'request_date' && request('dir') == 'asc' ? 'selected' : '' }}>Oldest First</option>
                        <option value="student_name_asc" {{ request('sort') == 'student_name' && request('dir') == 'asc' ? 'selected' : '' }}>Student A-Z</option>
                    </select>

                    <button type="button" onclick="applyFilters()" class="py-2 px-4 rounded-xl bg-[#0a1b42] hover:bg-[#102b70] text-white text-xs font-extrabold transition-all shadow-2xs flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" /></svg>
                        Filter
                    </button>
                </div>

            </div>
        </div>

        <!-- Table Container Card -->
        <div id="table-container-outer" class="bg-white rounded-2xl shadow-sm border border-slate-200 flex flex-col flex-1 overflow-hidden relative">
            @include('admin.reservations.partials.table')
        </div>
    </div>
    </div>

    <!-- DETAILS MODAL -->
    <dialog id="reservationDetailsModal" class="modal modal-bottom sm:modal-middle font-sans">
        <div class="modal-box w-[calc(100%-1rem)] max-w-4xl bg-white p-0 rounded-3xl overflow-hidden shadow-2xl relative border border-slate-100" id="details-modal-box">
            <!-- Dynamic Content Injected Here -->
            <div class="p-8 text-center" id="details-modal-loading">
                <span class="loading loading-spinner loading-lg text-[#102b70]"></span>
                <p class="text-xs font-bold text-slate-400 mt-2">Loading reservation details...</p>
            </div>
        </div>
        <form method="dialog" class="modal-backdrop bg-slate-950/50 backdrop-blur-[2px]"><button>close</button></form>
    </dialog>

    <!-- CANCEL CONFIRMATION POPUP MODAL (Screen 3 Mockup) -->
    @include('admin.reservations.partials.cancel-modal')

    <script>
        let currentModalUrl = '';

        function openDetailsModal(url) {
            currentModalUrl = url;
            const dialog = document.getElementById('reservationDetailsModal');
            const box = document.getElementById('details-modal-box');
            box.innerHTML = '<div class="p-12 text-center"><span class="loading loading-spinner loading-lg text-[#102b70]"></span><p class="text-xs font-bold text-slate-400 mt-2">Loading reservation details...</p></div>';
            dialog.showModal();

            fetch(url, {
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'text/html' }
            })
            .then(res => res.text())
            .then(html => {
                box.innerHTML = html;
            })
            .catch(err => {
                console.error(err);
                box.innerHTML = '<div class="p-8 text-center text-red-500 font-bold text-sm">Failed to load details. Please try again.</div>';
            });
        }

        function closeDetailsModal() {
            document.getElementById('reservationDetailsModal').close();
        }

        function openCancelModal(actionUrl, reservationId) {
            const form = document.getElementById('cancel-reservation-form');
            form.action = actionUrl;
            document.getElementById('cancelConfirmModal').showModal();
        }

        function closeCancelModal() {
            document.getElementById('cancelConfirmModal').close();
        }

        function applyFilters() {
            const search = document.getElementById('search-reservations').value;
            const status = document.getElementById('status-filter').value;
            const dateFilter = document.getElementById('date-filter').value;
            const sortVal = document.getElementById('sort-filter').value;

            let sort = 'request_date';
            let dir = 'desc';
            if (sortVal === 'request_date_asc') { sort = 'request_date'; dir = 'asc'; }
            if (sortVal === 'student_name_asc') { sort = 'student_name'; dir = 'asc'; }

            const loader = document.getElementById('table-loader');
            if (loader) loader.classList.remove('hidden');

            const params = new URLSearchParams({ search, status, date_filter: dateFilter, sort, dir });

            fetch(`{{ route('admin.reservations.index') }}?${params.toString()}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.text())
            .then(html => {
                document.getElementById('table-container-outer').innerHTML = html;
            })
            .catch(err => console.error(err))
            .finally(() => {
                if (loader) loader.classList.add('hidden');
            });
        }

        function resetFilters() {
            document.getElementById('search-reservations').value = '';
            document.getElementById('status-filter').value = 'all';
            document.getElementById('date-filter').value = 'all';
            document.getElementById('sort-filter').value = 'request_date_desc';
            applyFilters();
        }

        document.addEventListener('DOMContentLoaded', function() {
            let debounceTimer;
            document.getElementById('search-reservations')?.addEventListener('input', function() {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(applyFilters, 400);
            });

            document.addEventListener('submit', function (e) {
                const form = e.target.closest('.ajax-form, .ajax-status-form, #cancel-reservation-form');
                if (!form) return;

                e.preventDefault();

                const confirmMsg = form.getAttribute('data-confirm');
                if (confirmMsg && !confirm(confirmMsg)) return;

                const formData = new FormData(form);
                if (e.submitter && e.submitter.name && e.submitter.value) {
                    formData.set(e.submitter.name, e.submitter.value);
                }

                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || document.querySelector('input[name="_token"]')?.value || ''
                    }
                })
                .then(async res => {
                    const data = await res.json();
                    if (res.ok && data.success) {
                        closeCancelModal();
                        applyFilters();
                        if (data.modal_html) {
                            const box = document.getElementById('details-modal-box');
                            if (box) box.innerHTML = data.modal_html;
                        } else if (currentModalUrl) {
                            openDetailsModal(currentModalUrl);
                        }
                    } else {
                        alert(data.message || 'An error occurred updating the reservation.');
                    }
                })
                .catch(err => {
                    console.error('AJAX form submit error:', err);
                    alert('An unexpected error occurred.');
                });
            });
        });
    </script>
</x-layout.admin>
