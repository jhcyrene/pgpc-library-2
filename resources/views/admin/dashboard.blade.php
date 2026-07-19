<x-layout.admin>

<!-- DASHBOARD MAIN WRAPPER -->
<div class="w-full mx-auto flex flex-col h-auto lg:h-[calc(100dvh-6rem)] max-h-full font-sans text-slate-800">

    <!-- ========================================== -->
    <!-- ROW 1: HERO & DIRECT ACTIONS (Split Layout) -->
    <!-- ========================================== -->
    <div class="portal-grid grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-5 shrink-0 mb-4 sm:mb-5">
        
        @include('admin.partials.greetingBanner')

        @include('admin.partials.requireAttentionCard')
        
    </div>

    <!-- ROW 2: 4-COLUMN Card -->
    <div class="portal-grid grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5 shrink-0 mb-4 sm:mb-5">
        <x-admin.totalcard 
            title="Total Book Titles" 
            valueId="stat-total-titles"
            value='<span class="loading loading-spinner loading-md"></span>'
            description="Unique books in catalog" 
        />
        <x-admin.totalcard 
            title="Total Physical Copies" 
            valueId="stat-total-copies"
            value='<span class="loading loading-spinner loading-md"></span>'
            description="Physical items in library" 
        />
        <x-admin.totalcard 
            title="Active Members" 
            valueId="stat-active-members"
            value='<span class="loading loading-spinner loading-md"></span>'
            description="Users with active accounts" 
        />
        <x-admin.totalcard 
            title="Currently Borrowed" 
            valueId="stat-borrowed-items"
            value='<span class="loading loading-spinner loading-md"></span>'
            description="Items checked out right now" 
        />

    </div>

    <!-- ROW 3: DECISION-MAKING DATA SPLIT -->    
    <div class="portal-grid grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-5 flex-1 min-h-0">
        
        <x-admin.fronttable />
        <!-- Right: Most Borrowed Items (1/3 Width) -->
        <x-admin.subCard 
            title="Most Borrowed Items"
            description="Items that are frequently borrowed by users"
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

