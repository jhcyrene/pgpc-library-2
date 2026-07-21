<x-layout.admin>

<!-- DASHBOARD MAIN WRAPPER -->
<div class="w-full mx-auto flex flex-col min-h-full font-sans text-slate-800 pb-6">
    <!-- ROW 1: HERO & DIRECT ACTIONS (Split Layout) -->
    <div class="portal-grid grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-5 shrink-0 mb-4 sm:mb-5">
        
        @include('admin.partials.greetingBanner')

        @include('admin.partials.requireAttentionCard')
        
    </div>

    <!-- ROW 2: 4-COLUMN Stats Cards with Skeletal Shimmers -->
    <div class="portal-grid grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5 shrink-0 mb-4 sm:mb-5">

        <x-admin.totalcard
            title="Total Titles"
            value="<span id='stat-total-titles'><div class='h-8 w-16 bg-slate-200 animate-pulse rounded-lg inline-block'></div></span>"
            description="Unique book records in catalog"
        />

        <x-admin.totalcard
            title="Total Copies"
            value="<span id='stat-total-copies'><div class='h-8 w-16 bg-slate-200 animate-pulse rounded-lg inline-block'></div></span>"
            description="Physical copies across all titles"
        />

        <x-admin.totalcard
            title="Active Members"
            value="<span id='stat-active-members'><div class='h-8 w-16 bg-slate-200 animate-pulse rounded-lg inline-block'></div></span>"
            description="Currently registered students"
        />

        <x-admin.totalcard
            title="Borrowed Items"
            value="<span id='stat-borrowed-items'><div class='h-8 w-16 bg-slate-200 animate-pulse rounded-lg inline-block'></div></span>"
            description="Books currently on loan"
        />

    </div>

    <!-- ROW 3: Current Borrowers Table + Most Borrowed -->
    <div class="portal-grid grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-5">

        {{-- Current Borrowers Table (2/3) --}}
        <div class="lg:col-span-2 bg-white border border-slate-200 rounded-2xl shadow-sm hover:shadow-md transition-shadow flex flex-col">
            <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
                <div>
                    <h3 class="text-base font-extrabold text-slate-900">Current Borrowers</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Students with active book loans</p>
                </div>
                <a href="{{ route('admin.borrows.index') }}" class="text-xs font-bold text-blue-700 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition-colors">
                    View all
                </a>
            </div>
            <div class="overflow-x-auto flex-1">
                <table class="mobile-card-table w-full text-left text-sm text-slate-600 whitespace-nowrap">
                    <thead class="bg-slate-50 text-slate-500 font-bold border-b border-slate-200 uppercase text-xs tracking-wider">
                        <tr>
                            <th class="px-5 py-3.5">Member</th>
                            <th class="px-5 py-3.5">Book</th>
                            <th class="hidden px-5 py-3.5 sm:table-cell">Borrowed</th>
                            <th class="px-5 py-3.5 text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody id="dashboard-borrowers-tbody" class="divide-y divide-slate-100">
                        <tr class="animate-pulse">
                            <td class="px-5 py-4"><div class="h-4 w-32 bg-slate-200 rounded-md"></div></td>
                            <td class="px-5 py-4"><div class="h-4 w-48 bg-slate-200 rounded-md"></div></td>
                            <td class="hidden px-5 py-4 sm:table-cell"><div class="h-4 w-24 bg-slate-200 rounded-md"></div></td>
                            <td class="px-5 py-4 text-right"><div class="h-6 w-16 bg-slate-200 rounded-md ml-auto"></div></td>
                        </tr>
                        <tr class="animate-pulse">
                            <td class="px-5 py-4"><div class="h-4 w-28 bg-slate-200 rounded-md"></div></td>
                            <td class="px-5 py-4"><div class="h-4 w-52 bg-slate-200 rounded-md"></div></td>
                            <td class="hidden px-5 py-4 sm:table-cell"><div class="h-4 w-20 bg-slate-200 rounded-md"></div></td>
                            <td class="px-5 py-4 text-right"><div class="h-6 w-16 bg-slate-200 rounded-md ml-auto"></div></td>
                        </tr>
                        <tr class="animate-pulse">
                            <td class="px-5 py-4"><div class="h-4 w-36 bg-slate-200 rounded-md"></div></td>
                            <td class="px-5 py-4"><div class="h-4 w-44 bg-slate-200 rounded-md"></div></td>
                            <td class="hidden px-5 py-4 sm:table-cell"><div class="h-4 w-24 bg-slate-200 rounded-md"></div></td>
                            <td class="px-5 py-4 text-right"><div class="h-6 w-16 bg-slate-200 rounded-md ml-auto"></div></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Most Borrowed SubCard (1/3) --}}
        <x-admin.sub-card
            title="Most Borrowed Titles"
            description="Top circulation this period"
        />

    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Fetch stats via AJAX
        // Determine the endpoint based on current route prefix
        const endpoint = window.location.pathname.startsWith('/admin') 
            ? '{{ route('admin.dashboard.stats') }}' 
            : '{{ route('librarian.dashboard.stats') }}';

        const controller = new AbortController();
        const timeoutId = setTimeout(() => controller.abort(), 10000); // 10 second timeout

        fetch(endpoint, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            signal: controller.signal
        })
        .then(res => {
            if (!res.ok) throw new Error('Network response was not ok');
            return res.json();
        })
        .then(data => {
            clearTimeout(timeoutId);
            if (data.success && data.stats) {
                const formatter = new Intl.NumberFormat();
                
                // Update total cards
                const updateStat = (id, value) => {
                    const el = document.getElementById(id);
                    if (el) el.textContent = formatter.format(value);
                };
                
                updateStat('stat-total-titles', data.stats.total_titles);
                updateStat('stat-total-copies', data.stats.total_copies);
                updateStat('stat-active-members', data.stats.active_members);
                updateStat('stat-borrowed-items', data.stats.borrowed_items);
                
                // Update require attention cards
                updateStat('stat-overdue-items', data.stats.overdue_items);
                updateStat('stat-pending-reservations', data.stats.pending_reservations);

                // Populate Current Borrowers Table
                const borrowersTbody = document.getElementById('dashboard-borrowers-tbody');
                if (borrowersTbody && data.current_borrowers) {
                    if (data.current_borrowers.length === 0) {
                        borrowersTbody.innerHTML = '<tr><td data-empty colspan="4" class="px-5 py-8 text-center text-slate-500 font-medium">No current borrowers found.</td></tr>';
                    } else {
                        borrowersTbody.innerHTML = data.current_borrowers.map(b => `
                            <tr class="hover:bg-slate-50 transition-colors group">
                                <td data-primary class="px-5 py-4 font-bold text-slate-900 group-hover:text-blue-600 transition-colors">${b.member_name}</td>
                                <td data-label="Book" class="px-5 py-4 font-medium">${b.book_title}</td>
                                <td data-label="Borrowed" class="px-5 py-4 text-slate-500 text-xs">${b.borrow_date}</td>
                                <td data-label="Status" class="px-5 py-4 text-right">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold ${b.status === 'Overdue' ? 'text-red-700 bg-red-100 border-red-200' : 'text-emerald-700 bg-emerald-100 border-emerald-200'} border">
                                        ${b.status}
                                    </span>
                                </td>
                            </tr>
                        `).join('');
                    }
                }

                // Populate Most Borrowed Items
                const mostBorrowedContainer = document.getElementById('dashboard-most-borrowed-container');
                if (mostBorrowedContainer && data.most_borrowed_items) {
                    if (data.most_borrowed_items.length === 0) {
                        mostBorrowedContainer.innerHTML = '<div class="p-4 text-center text-slate-500 font-medium">No items borrowed yet.</div>';
                    } else {
                        mostBorrowedContainer.innerHTML = data.most_borrowed_items.map(i => {
                            const availableClass = i.copies_available > 0 ? 'text-emerald-700 bg-emerald-100 border-emerald-200' : 'text-amber-700 bg-amber-100 border-amber-200';
                            return `
                            <div class="group flex flex-col justify-between p-3 rounded-xl hover:bg-slate-50 border border-transparent hover:border-slate-100 transition-all cursor-default">
                                <div class="flex justify-between items-start mb-1.5">
                                    <p class="text-sm font-bold text-slate-900 group-hover:text-blue-600 transition-colors line-clamp-1" title="${i.book_title}">${i.book_title}</p>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold ${availableClass} border shadow-sm whitespace-nowrap ml-2">
                                        ${i.borrow_count} Borrows
                                    </span>
                                </div>
                                <p class="text-xs font-medium text-slate-500">${i.copies_available} available <span class="mx-1 text-slate-300">|</span> ${i.copies_total} total</p>
                            </div>
                            `;
                        }).join('');
                    }
                }
            } else {
                throw new Error("Invalid data format returned.");
            }
        })
        .catch(err => {
            console.error('Failed to load dashboard stats:', err);
            
            // Revert spinners to show error state
            const statIds = [
                'stat-total-titles', 'stat-total-copies', 'stat-active-members', 
                'stat-borrowed-items', 'stat-overdue-items', 'stat-pending-reservations'
            ];
            statIds.forEach(id => {
                const el = document.getElementById(id);
                if (el) el.innerHTML = '<span class="text-red-500 text-sm font-bold">Error</span>';
            });
            
            const borrowersTbody = document.getElementById('dashboard-borrowers-tbody');
            if (borrowersTbody) borrowersTbody.innerHTML = '<tr><td data-empty colspan="4" class="px-5 py-8 text-center text-red-500 font-medium">Failed to load data.</td></tr>';
            
            const mostBorrowedContainer = document.getElementById('dashboard-most-borrowed-container');
            if (mostBorrowedContainer) mostBorrowedContainer.innerHTML = '<div class="p-4 text-center text-red-500 font-medium">Failed to load data.</div>';
        });
    });
</script>

</x-layout.admin>
