<x-layout.admin>
    <div class="h-full flex flex-col bg-gray-50/50 p-4 md:p-6 lg:p-8">
                    <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7" /></svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-900 leading-tight">Checkout</h2>
                        <p class="text-xs text-gray-500">Borrow books to a member.</p>
                    </div>
                </div>

                <!-- Content Area -->
                <div class="p-5 md:p-6 flex-1 overflow-y-auto flex flex-col">
                    
                    <!-- Step 1: Member Search -->
                    <div id="checkout-step-1" class="mb-6 shrink-0 relative">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Scan or search member</label>
                        <form id="member-lookup-form" class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" /></svg>
                            </div>
                            <input type="text" id="checkout-member-id" class="input input-bordered w-full pl-10 pr-12 h-12 text-lg focus:border-blue-500 focus:ring-blue-500 transition-colors shadow-sm" placeholder="Member ID, Name or Email" required autofocus autocomplete="off">
                            <button type="submit" class="absolute right-2 top-2 btn btn-sm btn-ghost btn-circle text-gray-400 hover:text-blue-600 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                            </button>
                        </form>
                        <!-- Autocomplete Suggestions -->
                        <ul id="member-autocomplete-results" class="absolute z-50 w-full bg-white shadow-xl rounded-xl mt-1 border border-gray-100 max-h-60 overflow-y-auto hidden">
                        </ul>
                    </div>

                    <!-- Step 2: Checkout details (Hidden initially) -->
                    <div id="checkout-step-2" class="hidden pb-20 flex-1 flex flex-col">
                        <!-- Member Info Card -->
                        <div class="bg-gray-50 rounded-2xl border border-gray-200 p-5 mb-8 flex flex-col md:flex-row gap-6">
                            <div class="flex items-start gap-4 flex-1">
                                <div class="w-14 h-14 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center shrink-0 shadow-sm border border-blue-200">
                                    <span class="text-2xl font-black uppercase" id="member-avatar">U</span>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900 leading-tight" id="member-name">User Name</h3>
                                    <p class="text-sm text-gray-600 mt-1" id="member-id">ID: 000000</p>
                                    <p class="text-sm text-gray-500" id="member-course">Program - Year</p>
                                    
                                    <div class="mt-3 flex items-center gap-3">
                                        <div id="member-status-container">
                                            <!-- Injected by JS -->
                                        </div>
                                        <button type="button" onclick="resetCheckout()" class="text-xs font-bold text-gray-500 hover:text-blue-600 transition-colors uppercase tracking-wider flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                                            Change Member
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-3 shrink-0 md:w-64">
                                <div class="bg-white p-3 rounded-xl border border-gray-100 shadow-sm flex flex-col justify-center">
                                    <span class="block text-gray-400 text-[10px] uppercase font-bold tracking-wider">Currently Borrowed</span>
                                    <span class="font-black text-gray-800 text-lg leading-none mt-1" id="member-borrowed">0</span>
                                </div>
                                <div class="bg-white p-3 rounded-xl border border-gray-100 shadow-sm flex flex-col justify-center">
                                    <span class="block text-gray-400 text-[10px] uppercase font-bold tracking-wider">Available Slots</span>
                                    <span class="font-black text-gray-800 text-lg leading-none mt-1" id="member-slots">3</span>
                                </div>
                                <div class="bg-white p-3 rounded-xl border border-gray-100 shadow-sm col-span-2 flex justify-between items-center">
                                    <span class="block text-gray-400 text-[10px] uppercase font-bold tracking-wider">Outstanding Fine</span>
                                    <span class="font-bold text-gray-800 text-sm" id="member-fines">₱0.00</span>
                                </div>
                            </div>
                        </div>

                        <!-- Book Input -->
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Scan Book Barcode</label>
                            <form id="add-book-form" class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" /></svg>
                                </div>
                                <input type="text" id="checkout-book-barcode" class="input input-bordered w-full pl-10 pr-24 h-12 bg-white focus:outline-none focus:border-blue-500 shadow-sm" placeholder="Scan book barcode..." autocomplete="off">
                                <button type="submit" class="absolute right-2 top-2 btn btn-sm btn-ghost text-blue-600 hover:bg-blue-50 transition-colors">Add</button>
                            </form>
                        </div>

                        <!-- Books List (Desktop Table / Mobile Cards) -->
                        <div>
                            <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Books to Checkout</h4>
                            
                            <!-- Empty State -->
                            <div id="empty-books-state" class="border-2 border-dashed border-gray-200 rounded-xl p-8 flex flex-col items-center justify-center text-center">
                                <div class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center text-gray-300 mb-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                                </div>
                                <p class="text-sm font-medium text-gray-500">Scan a book barcode to add it to the list.</p>
                            </div>

                            <!-- List -->
                            <div id="books-list-container" class="hidden">
                                <!-- Responsive Table/List Container -->
                                <div class="responsive-table-scroll hidden md:block border border-gray-100 rounded-xl shadow-sm bg-white">
                                    <table class="responsive-table w-full text-left text-sm whitespace-nowrap">
                                        <thead class="bg-gray-50/80 text-gray-500 uppercase text-[10px] font-bold tracking-wider">
                                            <tr>
                                                <th class="px-4 py-3 w-10"></th>
                                                <th class="px-4 py-3">Book Details</th>
                                                <th class="px-4 py-3">Barcode</th>
                                                <th class="px-4 py-3">Due Date</th>
                                                <th class="px-4 py-3 text-right"></th>
                                            </tr>
                                        </thead>
                                        <tbody id="books-table-body" class="divide-y divide-gray-100">
                                            <!-- JS injected rows -->
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Mobile Cards -->
                                <div id="books-mobile-body" class="md:hidden flex flex-col gap-3">
                                    <!-- JS injected cards -->
                                </div>

                                <div class="mt-4 p-3 bg-blue-50/50 border border-blue-100 rounded-lg flex items-center gap-3 text-sm text-blue-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    All books will be due on <strong id="global-due-date" class="ml-1">...</strong>.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Empty State Full (Before member search) -->
                    <div id="checkout-empty-state" class="flex-1 flex flex-col items-center justify-center p-8 text-center bg-white">
                        <div class="w-24 h-24 mb-6 relative">
                            <div class="absolute inset-0 bg-blue-100 rounded-full opacity-50 animate-pulse"></div>
                            <div class="w-full h-full rounded-full bg-blue-50 flex items-center justify-center text-blue-400 relative z-10 shadow-sm border border-blue-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" /></svg>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Ready for Checkout</h3>
                        <p class="text-gray-500 max-w-xs">Scan a member's ID card or search by barcode to begin the checkout process.</p>
                    </div>
                </div>

                <!-- Sticky Bottom Action Bar -->
                <div id="checkout-action-bar" class="hidden absolute bottom-0 inset-x-0 p-4 border-t border-gray-200 bg-white shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)] z-20 flex flex-col sm:flex-row justify-between items-center gap-3">
                    <button type="button" onclick="resetCheckout()" class="btn btn-outline border-gray-200 text-gray-600 hover:bg-gray-50 hover:text-gray-900 w-full sm:w-auto font-bold transition-colors">Cancel</button>
                    <div class="flex items-center gap-3 w-full sm:w-auto">
                        <button type="button" onclick="clearBooks()" class="btn btn-ghost text-gray-500 hover:text-error w-full sm:w-auto font-medium transition-colors">Clear List</button>
                        <button type="button" onclick="submitCheckout()" id="btn-complete-checkout" class="btn bg-brand-navy hover:bg-brand-navy-light text-white border-none w-full sm:w-auto font-bold shadow-md shadow-brand-navy/20 transition-all">
                            Complete Checkout
                        </button>
                    </div>
                </div>
            </div>

            <!-- RIGHT PANEL: CHECK-IN -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 flex flex-col h-full overflow-hidden">
                <!-- Section Header -->
                <div class="p-5 border-b border-gray-100 flex items-center gap-4 shrink-0 bg-green-50/30">
                    <div class="w-10 h-10 rounded-full bg-green-100 text-green-600 flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h4a1 1 0 010 2H6.414l2.293 2.293a1 1 0 11-1.414 1.414L5 6.414V8a1 1 0 01-2 0V4zm9 1a1 1 0 010-2h4a1 1 0 011 1v4a1 1 0 01-2 0V6.414l-2.293 2.293a1 1 0 11-1.414-1.414L13.586 5H12zM5 13a1 1 0 012 0v1.586l2.293-2.293a1 1 0 111.414 1.414L8.414 16H10a1 1 0 010 2H6a1 1 0 01-1-1v-4zm9-1a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 010-2h1.586l-2.293-2.293a1 1 0 111.414-1.414L15 13.586V12z" /></svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-900 leading-tight">Check-in</h2>
                        <p class="text-xs text-gray-500">Return borrowed books.</p>
                    </div>
                </div>

                <div class="p-5 md:p-6 flex-1 overflow-y-auto flex flex-col">
                    <!-- Step 1: Scan Barcode -->
                    <div class="mb-8">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Scan book barcode</label>
                        <form id="checkin-form" class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" /></svg>
                            </div>
                            <input type="text" id="checkin-book-barcode" class="input input-bordered w-full pl-10 pr-24 h-12 focus:border-green-500 focus:ring-green-500 transition-colors shadow-sm" placeholder="Scan book to return..." autocomplete="off">
                            <button type="submit" class="absolute right-2 top-2 btn btn-sm bg-green-600 hover:bg-green-700 text-white border-none font-bold shadow-md shadow-green-500/20 transition-all">Check In</button>
                        </form>
                    </div>

                    <!-- Current Session Returns -->
                    <div class="flex-1 flex flex-col">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider">Current Session Returns</h4>
                            <button type="button" onclick="clearCheckinSession()" class="text-xs font-medium text-gray-400 hover:text-gray-700 transition-colors">Clear List</button>
                        </div>

                        <!-- Session List -->
                        <div id="session-checkins" class="space-y-3 flex-1 overflow-y-auto mb-6">
                            <!-- JS injected elements -->
                        </div>
                        
                        <div id="checkin-empty-state" class="flex-1 flex flex-col items-center justify-center text-center pb-8">
                            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center text-gray-300 mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h4a1 1 0 010 2H6.414l2.293 2.293a1 1 0 11-1.414 1.414L5 6.414V8a1 1 0 01-2 0V4zm9 1a1 1 0 010-2h4a1 1 0 011 1v4a1 1 0 01-2 0V6.414l-2.293 2.293a1 1 0 11-1.414-1.414L13.586 5H12zM5 13a1 1 0 012 0v1.586l2.293-2.293a1 1 0 111.414 1.414L8.414 16H10a1 1 0 010 2H6a1 1 0 01-1-1v-4zm9-1a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 010-2h1.586l-2.293-2.293a1 1 0 111.414-1.414L15 13.586V12z" /></svg>
                            </div>
                            <p class="text-sm font-medium text-gray-500">Scan a book barcode to begin check-in.</p>
                        </div>
                        
                        <div id="checkin-count-container" class="hidden text-sm font-semibold text-green-700 bg-green-50 border border-green-100 rounded-lg p-3 flex items-center justify-center gap-2 mb-8">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                            <span id="checkin-count">0 books returned this session</span>
                        </div>
                        
                        <!-- Recent Activity from Database -->
                        <div id="recent-activity-container">
                            @include('admin.circulation.partials.recent_checkins', ['recentCheckins' => $recentCheckins])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Container -->
    <div id="circulation-alert-container" class="fixed top-6 right-6 z-[100] flex flex-col gap-2 pointer-events-none"></div>

    <script>
        const csrfToken = '{{ csrf_token() }}';
        
        // Checkout State
        let currentStudentId = null;
        let checkoutBooks = [];
        const MAX_BORROW_LIMIT = 3;

        // Checkin State
        let checkinCount = 0;

        // Utils
        function showAlert(message, type = 'success') {
            const container = document.getElementById('circulation-alert-container');
            const alertDiv = document.createElement('div');
            
            let colorClass, icon;
            if (type === 'success') {
                colorClass = 'bg-white border-l-4 border-green-500 text-gray-800';
                icon = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke="currentColor" class="text-green-500" />';
            } else if (type === 'warning') {
                colorClass = 'bg-white border-l-4 border-orange-500 text-gray-800';
                icon = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" stroke="currentColor" class="text-orange-500" />';
            } else {
                colorClass = 'bg-white border-l-4 border-red-500 text-gray-800';
                icon = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke="currentColor" class="text-red-500" />';
            }

            alertDiv.className = `p-4 rounded-lg shadow-xl border-y border-r border-gray-100 text-sm font-medium flex items-center gap-3 transition-all duration-300 transform translate-x-full ${colorClass}`;
            alertDiv.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24">
                    ${icon}
                </svg>
                <span>${message}</span>
            `;
            
            container.appendChild(alertDiv);
            
            // Trigger animation
            setTimeout(() => {
                alertDiv.classList.remove('translate-x-full');
            }, 10);
            
            setTimeout(() => {
                alertDiv.classList.add('opacity-0', 'translate-x-full');
                setTimeout(() => alertDiv.remove(), 300);
            }, 4000);
        }

        async function refreshCirculationStats() {
            try {
                const response = await fetch('{{ route('admin.circulation.stats') }}');
                if (response.ok) {
                    const data = await response.json();
                    document.getElementById('stat-checkouts').textContent = data.todaysCheckouts;
                    document.getElementById('stat-returns').textContent = data.todaysReturns;
                    document.getElementById('stat-overdue').textContent = data.overdueBooks;
                    document.getElementById('stat-fines').textContent = '₱' + parseFloat(data.outstandingFines).toFixed(2);
                    
                    if (data.recentCheckinsHtml) {
                        document.getElementById('recent-activity-container').innerHTML = data.recentCheckinsHtml;
                    }
                }
            } catch (err) {
                console.error('Failed to refresh stats:', err);
            }
        }

        // ================= CHECKOUT LOGIC =================

        const memberInput = document.getElementById('checkout-member-id');
        const bookInput = document.getElementById('checkout-book-barcode');

        // ==== Autocomplete Logic ====
        const memberAutocompleteResults = document.getElementById('member-autocomplete-results');
        let memberSearchTimeout = null;

        memberInput.addEventListener('input', function(e) {
            const query = e.target.value.trim();
            clearTimeout(memberSearchTimeout);

            if (query.length < 1) {
                memberAutocompleteResults.classList.add('hidden');
                return;
            }

            // Immediately show loading state
            memberAutocompleteResults.innerHTML = '<li class="p-4 text-sm text-gray-500 text-center flex justify-center items-center gap-2"><span class="loading loading-spinner loading-xs"></span> Searching...</li>';
            memberAutocompleteResults.classList.remove('hidden');

            memberSearchTimeout = setTimeout(async () => {
                try {
                    const response = await fetch(`{{ route('admin.circulation.member.search') }}?q=${encodeURIComponent(query)}`, {
                        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                    });
                    const members = await response.json();
                    
                    if (members.length > 0) {
                        memberAutocompleteResults.innerHTML = members.map(m => `
                            <li class="p-3 hover:bg-blue-50 cursor-pointer border-b border-gray-50 last:border-0 transition-colors flex flex-col gap-1" onclick="selectMember('${m.student_id_number}')">
                                <div class="font-bold text-gray-900">${m.first_name} ${m.last_name}</div>
                                <div class="text-xs text-gray-500 flex justify-between items-center">
                                    <span class="font-mono bg-gray-100 px-1 rounded text-[10px]">ID: ${m.student_id_number}</span>
                                    <span>${m.program || ''} ${m.year_level || ''}</span>
                                </div>
                            </li>
                        `).join('');
                        memberAutocompleteResults.classList.remove('hidden');
                    } else {
                        memberAutocompleteResults.innerHTML = '<li class="p-4 text-sm text-gray-500 text-center">No members found matching your search.</li>';
                        memberAutocompleteResults.classList.remove('hidden');
                    }
                } catch (err) {
                    console.error('Autocomplete error:', err);
                }
            }, 300);
        });

        // Hide autocomplete when clicking outside
        document.addEventListener('click', function(e) {
            if (!memberInput.contains(e.target) && !memberAutocompleteResults.contains(e.target)) {
                memberAutocompleteResults.classList.add('hidden');
            }
        });

        window.selectMember = function(identifier) {
            memberInput.value = identifier;
            memberAutocompleteResults.classList.add('hidden');
            // Trigger the form submission automatically to load the member
            document.getElementById('member-lookup-form').dispatchEvent(new Event('submit', { cancelable: true, bubbles: true }));
        };
        // ============================

        document.getElementById('member-lookup-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            const identifier = memberInput.value.trim();
            if (!identifier) return;

            memberInput.disabled = true;
            document.querySelector('#member-lookup-form button').innerHTML = '<span class="loading loading-spinner loading-xs text-blue-500"></span>';
            
            try {
                const baseUrl = `{{ route('admin.circulation.member', ['identifier' => 'MEMBER_ID']) }}`;
                const fetchUrl = baseUrl.replace('MEMBER_ID', encodeURIComponent(identifier));

                const response = await fetch(fetchUrl, {
                    headers: { 'Accept': 'application/json' }
                });
                const data = await response.json();
                
                if (response.ok) {
                    setupCheckoutView(data);
                } else {
                    showAlert(data.error || 'Member not found', 'error');
                }
            } catch (err) {
                showAlert('Network error occurred.', 'error');
            } finally {
                memberInput.disabled = false;
                document.querySelector('#member-lookup-form button').innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>';
            }
        });

        function setupCheckoutView(data) {
            currentStudentId = data.member.student_id_number;
            
            // Set Data
            document.getElementById('member-name').textContent = `${data.member.first_name} ${data.member.last_name}`;
            document.getElementById('member-id').textContent = `ID: ${currentStudentId}`;
            document.getElementById('member-avatar').textContent = data.member.first_name.charAt(0);
            document.getElementById('member-course').textContent = `${data.member.program || 'N/A'} - ${data.member.year_level || 'N/A'}`;
            
            const borrowedCount = data.active_borrows.length;
            const availableSlots = Math.max(0, MAX_BORROW_LIMIT - borrowedCount);
            const totalFines = parseFloat(data.total_fines || 0);
            
            document.getElementById('member-borrowed').textContent = borrowedCount;
            document.getElementById('member-slots').textContent = availableSlots;
            document.getElementById('member-fines').textContent = '₱' + totalFines.toFixed(2);
            
            // Status Badge
            const statusContainer = document.getElementById('member-status-container');
            let statusHtml = '';
            
            if (availableSlots <= 0) {
                statusHtml = `<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-red-100 text-red-700 border border-red-200">Borrowing Restricted</span>`;
            } else if (totalFines > 0) {
                statusHtml = `<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-orange-100 text-orange-700 border border-orange-200">Has Fine</span>`;
            } else {
                statusHtml = `<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-green-100 text-green-700 border border-green-200">Good Standing</span>`;
            }
            statusContainer.innerHTML = statusHtml;

            // UI Transitions
            document.getElementById('checkout-empty-state').classList.add('hidden');
            document.getElementById('checkout-step-1').classList.add('hidden');
            document.getElementById('checkout-step-2').classList.remove('hidden');
            document.getElementById('checkout-action-bar').classList.remove('hidden');
            document.getElementById('checkout-action-bar').classList.add('flex');
            
            // Auto focus next step
            bookInput.focus();
        }

        function resetCheckout() {
            currentStudentId = null;
            clearBooks();
            
            document.getElementById('checkout-step-2').classList.add('hidden');
            document.getElementById('checkout-action-bar').classList.add('hidden');
            document.getElementById('checkout-action-bar').classList.remove('flex');
            
            document.getElementById('checkout-step-1').classList.remove('hidden');
            document.getElementById('checkout-empty-state').classList.remove('hidden');
            
            memberInput.value = '';
            memberInput.focus();
        }

        document.getElementById('add-book-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            const identifier = bookInput.value.trim();
            if (!identifier) return;

            // Check duplicate
            if (checkoutBooks.some(b => b.barcode === identifier || b.accession_number === identifier)) {
                showAlert('Book already in checkout list.', 'warning');
                bookInput.value = '';
                return;
            }

            // Check slots limit
            const currentSlots = parseInt(document.getElementById('member-slots').textContent);
            if (checkoutBooks.length >= currentSlots) {
                showAlert(`Cannot exceed borrow limit of ${MAX_BORROW_LIMIT} books.`, 'error');
                bookInput.value = '';
                return;
            }

            bookInput.disabled = true;

            try {
                const baseUrl = `{{ route('admin.circulation.book', 'BOOK_ID') }}`;
                const fetchUrl = baseUrl.replace('BOOK_ID', encodeURIComponent(identifier));

                const response = await fetch(fetchUrl, {
                    headers: { 'Accept': 'application/json' }
                });
                const data = await response.json();
                
                if (response.ok) {
                    checkoutBooks.push({
                        ...data.book,
                        display_due_date: data.due_date
                    });
                    renderBooksList();
                    bookInput.value = '';
                } else {
                    showAlert(data.error || 'Book not found', 'error');
                }
            } catch (err) {
                showAlert('Network error occurred.', 'error');
            } finally {
                bookInput.disabled = false;
                bookInput.focus();
            }
        });

        function renderBooksList() {
            const emptyState = document.getElementById('empty-books-state');
            const listContainer = document.getElementById('books-list-container');
            const tableBody = document.getElementById('books-table-body');
            const mobileBody = document.getElementById('books-mobile-body');
            const dueDateText = document.getElementById('global-due-date');
            const completeBtn = document.getElementById('btn-complete-checkout');

            if (checkoutBooks.length === 0) {
                emptyState.classList.remove('hidden');
                listContainer.classList.add('hidden');
                completeBtn.disabled = true;
                completeBtn.classList.add('opacity-50', 'cursor-not-allowed');
                return;
            }

            emptyState.classList.add('hidden');
            listContainer.classList.remove('hidden');
            completeBtn.disabled = false;
            completeBtn.classList.remove('opacity-50', 'cursor-not-allowed');

            tableBody.innerHTML = '';
            mobileBody.innerHTML = '';

            let lastDueDate = '';

            checkoutBooks.forEach((book, index) => {
                lastDueDate = book.display_due_date;
                
                let authors = 'Unknown Author';
                if (book.book_data && book.book_data.authors && book.book_data.authors.length > 0) {
                    authors = book.book_data.authors.map(a => a.author_name).join(', ');
                }
                const title = book.book_data ? book.book_data.book_title : 'Unknown Title';
                const barcode = book.barcode || book.accession_number;
                
                // Image
                let imgHtml = `<div class="w-10 h-14 bg-gray-100 rounded border border-gray-200 flex items-center justify-center shrink-0"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg></div>`;
                if (book.book_data && book.book_data.book_detail) {
                    const detail = book.book_data.book_detail;
                    if (detail.image_url) {
                        imgHtml = `<div class="w-10 h-14 bg-gray-100 rounded border border-gray-200 shrink-0 overflow-hidden"><img src="/storage/${detail.image_url}" class="w-full h-full object-cover"></div>`;
                    } else if (detail.cover_image) {
                        const src = detail.cover_image.startsWith('data:image') ? detail.cover_image : '/storage/' + detail.cover_image.replace(/^\/+/, '');
                        imgHtml = `<div class="w-10 h-14 bg-gray-100 rounded border border-gray-200 shrink-0 overflow-hidden"><img src="${src}" class="w-full h-full object-cover"></div>`;
                    }
                }

                // Desktop Row
                const tr = document.createElement('tr');
                tr.className = 'hover:bg-blue-50/30 transition-colors group';
                tr.innerHTML = `
                    <td class="px-4 py-3">${imgHtml}</td>
                    <td class="px-4 py-3">
                        <div class="font-bold text-gray-900 leading-tight max-w-[200px] truncate" title="${title}">${title}</div>
                        <div class="text-xs text-gray-500 max-w-[200px] truncate" title="${authors}">${authors}</div>
                    </td>
                    <td class="px-4 py-3 text-gray-700 font-mono text-xs">${barcode}</td>
                    <td class="px-4 py-3 text-gray-700 font-medium">${book.display_due_date}</td>
                    <td class="px-4 py-3 text-right">
                        <button onclick="removeBook(${index})" class="btn btn-sm btn-ghost btn-circle text-gray-400 hover:text-red-500 hover:bg-red-50 opacity-0 group-hover:opacity-100 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                        </button>
                    </td>
                `;
                tableBody.appendChild(tr);

                // Mobile Card
                const card = document.createElement('div');
                card.className = 'bg-white border border-gray-200 rounded-xl p-3 flex gap-4 relative shadow-sm';
                card.innerHTML = `
                    ${imgHtml}
                    <div class="flex-1 min-w-0 pr-8">
                        <div class="font-bold text-gray-900 leading-tight truncate">${title}</div>
                        <div class="text-xs text-gray-500 truncate mb-1">${authors}</div>
                        <div class="flex items-center gap-2 text-xs">
                            <span class="font-mono text-gray-600 bg-gray-100 px-1.5 py-0.5 rounded">${barcode}</span>
                            <span class="text-blue-600 font-medium">Due: ${book.display_due_date}</span>
                        </div>
                    </div>
                    <button onclick="removeBook(${index})" class="absolute top-2 right-2 btn btn-xs btn-ghost btn-circle text-red-400 hover:text-red-600 hover:bg-red-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                `;
                mobileBody.appendChild(card);
            });

            dueDateText.textContent = lastDueDate;
        }

        window.removeBook = function(index) {
            checkoutBooks.splice(index, 1);
            renderBooksList();
            bookInput.focus();
        };

        window.clearBooks = function() {
            checkoutBooks = [];
            renderBooksList();
            bookInput.focus();
        };

        window.submitCheckout = async function() {
            if (checkoutBooks.length === 0 || !currentStudentId) return;

            const btn = document.getElementById('btn-complete-checkout');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<span class="loading loading-spinner loading-sm"></span> Processing...';
            btn.disabled = true;

            const identifiers = checkoutBooks.map(b => b.barcode || b.accession_number);

            try {
                const response = await fetch(`{{ route('admin.circulation.checkout') }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        student_id: currentStudentId,
                        book_identifiers: identifiers
                    })
                });
                
                const data = await response.json();
                
                if (response.ok && data.success) {
                    showAlert(data.message, 'success');
                    resetCheckout();
                    refreshCirculationStats();
                } else {
                    showAlert(data.message || 'Check-out failed', 'error');
                }
            } catch (err) {
                showAlert('Network error occurred.', 'error');
            } finally {
                btn.innerHTML = originalText;
                btn.disabled = false;
            }
        };


        // ================= CHECKIN LOGIC =================

        const checkinInput = document.getElementById('checkin-book-barcode');

        document.getElementById('checkin-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            const barcode = checkinInput.value.trim();
            if (!barcode) return;

            checkinInput.disabled = true;

            try {
                const response = await fetch(`{{ route('admin.circulation.checkin') }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ book_identifier: barcode })
                });
                
                const data = await response.json();
                
                if (response.ok && data.success) {
                    showAlert(data.message, data.fine ? 'warning' : 'success');
                    addSessionCheckin(barcode, data.fine);
                    refreshCirculationStats();
                } else {
                    showAlert(data.message || 'Check-in failed', 'error');
                }
            } catch (err) {
                showAlert('Network error occurred.', 'error');
            } finally {
                checkinInput.value = '';
                checkinInput.disabled = false;
                checkinInput.focus();
            }
        });

        function addSessionCheckin(barcode, fine) {
            const emptyState = document.getElementById('checkin-empty-state');
            const listContainer = document.getElementById('session-checkins');
            const countContainer = document.getElementById('checkin-count-container');
            const countText = document.getElementById('checkin-count');

            emptyState.classList.add('hidden');
            countContainer.classList.remove('hidden');
            countContainer.classList.add('flex');

            checkinCount++;
            countText.textContent = `${checkinCount} book${checkinCount > 1 ? 's' : ''} returned this session`;

            const card = document.createElement('div');
            let colorClass = fine ? 'bg-orange-50/50 border-orange-200' : 'bg-green-50/30 border-green-200';
            let badgeClass = fine ? 'bg-orange-100 text-orange-700 border-orange-200' : 'bg-green-100 text-green-700 border-green-200';
            
            card.className = `p-3 rounded-xl border flex items-center gap-4 transition-all shadow-sm ${colorClass}`;
            
            const timeStr = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

            card.innerHTML = `
                <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center shrink-0 border border-gray-100 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="font-bold text-gray-900 truncate">Scanned: ${barcode}</div>
                    <div class="flex items-center gap-2 mt-1">
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider border ${badgeClass}">
                            Returned
                        </span>
                        <span class="text-[10px] text-gray-400 uppercase tracking-wider">${timeStr}</span>
                    </div>
                </div>
                ${fine ? `<div class="text-right shrink-0"><span class="block text-[10px] uppercase font-bold text-orange-500">Fine Assessed</span><span class="font-black text-orange-700">₱${parseFloat(fine).toFixed(2)}</span></div>` : ''}
            `;
            
            listContainer.prepend(card);
        }

        window.clearCheckinSession = function() {
            checkinCount = 0;
            document.getElementById('session-checkins').innerHTML = '';
            document.getElementById('checkin-empty-state').classList.remove('hidden');
            
            const countContainer = document.getElementById('checkin-count-container');
            countContainer.classList.add('hidden');
            countContainer.classList.remove('flex');
            
            checkinInput.focus();
        };

    </script>
</x-layout.admin>
