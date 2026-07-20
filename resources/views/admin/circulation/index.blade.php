<x-layout.admin title="Circulation Desk">
    <div class="min-h-full flex flex-col bg-slate-50/50 p-4 sm:p-6 lg:p-8">
        <x-admin.page-header 
            title="Circulation Desk" 
            description="Manage checkouts, returns, and track active circulation."
        />

        <!-- Top Navigation Pills (Check Out / Check In) -->
        <div class="mb-6 flex items-center justify-between flex-wrap gap-4 bg-white p-1.5 rounded-xl border border-slate-200 shadow-xs max-w-xs">
            <button type="button" 
                    id="tab-checkout-btn"
                    onclick="switchCirculationTab('checkout')" 
                    class="flex-1 py-2 px-4 rounded-lg font-bold text-xs flex items-center justify-center gap-1.5 transition-all shadow-xs bg-[#102b70] text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                </svg>
                Check Out
            </button>
            <button type="button" 
                    id="tab-checkin-btn"
                    onclick="switchCirculationTab('checkin')" 
                    class="flex-1 py-2 px-4 rounded-lg font-bold text-xs flex items-center justify-center gap-1.5 transition-all text-slate-600 hover:text-slate-900 hover:bg-slate-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                </svg>
                Check In
            </button>
        </div>

        <!-- TAB 1: CHECK OUT PANEL -->
        <div id="checkout-tab-panel" class="grid grid-cols-1 lg:grid-cols-3 gap-6 flex-1 items-start">
            
            <!-- Left Column: Find Member & Checkout Form (2/3 width) -->
            <div class="lg:col-span-2 flex flex-col gap-6">
                
                <!-- Find Member Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5 sm:p-6 flex flex-col relative">
                    <div class="mb-4 flex items-center gap-2.5">
                        <span class="w-5 h-5 rounded-full bg-[#102b70] text-white text-xs font-black flex items-center justify-center">1</span>
                        <div>
                            <h3 class="text-sm sm:text-base font-extrabold text-slate-900 leading-tight">Find Member / Scan ID</h3>
                            <p class="text-xs font-medium text-slate-500 mt-0.5">Search by member ID, name, or email.</p>
                        </div>
                    </div>

                    <!-- Step 1: Search Form -->
                    <div id="checkout-step-1" class="relative">
                        <div class="flex flex-col sm:flex-row gap-3">
                            <form id="member-lookup-form" class="relative flex-1">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                                </div>
                                <input type="text" id="checkout-member-id" class="w-full pl-9 pr-10 py-2.5 text-sm rounded-xl border border-slate-300 focus:border-[#102b70] focus:ring-1 focus:ring-[#102b70]/20 transition-colors shadow-xs outline-none bg-white text-slate-900 placeholder:text-slate-400" placeholder="Enter member ID, name, or email" required autofocus autocomplete="off">
                                <button type="submit" class="absolute right-2 top-2 p-1.5 rounded-lg text-slate-400 hover:text-[#102b70] hover:bg-slate-100 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                                </button>
                            </form>
                            <button type="button" onclick="focusMemberSearch()" class="px-4 py-2.5 border border-slate-200 hover:bg-slate-50 text-slate-600 text-xs font-bold rounded-xl transition-all shadow-xs shrink-0 flex items-center justify-center gap-1.5">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01" /></svg>
                                Scan Member ID
                            </button>
                        </div>
                        <!-- Autocomplete Suggestions -->
                        <ul id="member-autocomplete-results" class="absolute z-50 w-full bg-white shadow-xl rounded-xl mt-1 border border-slate-200 max-h-60 overflow-y-auto hidden">
                        </ul>
                    </div>

                    <!-- Step 2: Member Info Card (Shown after selection) -->
                    <div id="checkout-step-2" class="hidden mt-4 pt-4 border-t border-slate-100">
                        <div class="bg-slate-50 rounded-2xl border border-slate-200 p-4 sm:p-5 flex flex-col sm:flex-row gap-4 sm:gap-6">
                            <div class="flex items-start gap-3.5 flex-1">
                                <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-full bg-[#102b70] text-[#fcc719] flex items-center justify-center shrink-0 shadow-sm border border-slate-200">
                                    <span class="text-xl sm:text-2xl font-black uppercase" id="member-avatar">U</span>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <h3 class="text-base font-bold text-slate-900 leading-tight" id="member-name">User Name</h3>
                                        <span id="member-status-badge" class="inline-flex px-2 py-0.5 rounded-md text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">Active</span>
                                    </div>
                                    <p class="text-xs text-slate-600 mt-1 font-medium" id="member-id">Student ID: 000000</p>
                                    <p class="text-xs text-slate-500 mt-0.5" id="member-course">Program - Year</p>
                                    
                                    <div class="mt-3 flex items-center gap-3">
                                        <a href="javascript:void(0)" id="btn-view-profile" class="text-xs font-bold text-blue-700 hover:text-blue-900 transition-colors uppercase tracking-wider">View Profile</a>
                                        <span class="text-slate-300">•</span>
                                        <button type="button" onclick="resetCheckout()" class="text-xs font-bold text-slate-500 hover:text-[#102b70] transition-colors uppercase tracking-wider flex items-center gap-1">
                                            Change Member
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-2.5 shrink-0 sm:w-64">
                                <div class="bg-white p-3 rounded-xl border border-slate-200 shadow-xs flex flex-col justify-center">
                                    <span class="block text-slate-400 text-[10px] uppercase font-extrabold tracking-wider">Borrowed</span>
                                    <span class="font-black text-slate-900 text-lg leading-none mt-1" id="member-borrowed">0</span>
                                </div>
                                <div class="bg-white p-3 rounded-xl border border-slate-200 shadow-xs flex flex-col justify-center">
                                    <span class="block text-slate-400 text-[10px] uppercase font-extrabold tracking-wider">Available</span>
                                    <span class="font-black text-emerald-600 text-lg leading-none mt-1" id="member-slots">3</span>
                                </div>
                                <div class="bg-white p-3 rounded-xl border border-slate-200 shadow-xs col-span-2 flex justify-between items-center">
                                    <span class="block text-slate-400 text-[10px] uppercase font-extrabold tracking-wider">Fines</span>
                                    <span class="font-extrabold text-slate-900 text-sm" id="member-fines">₱0.00</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Initial Empty State -->
                    <div id="checkout-empty-state" class="py-12 flex flex-col items-center justify-center text-center">
                        <div class="w-16 h-16 sm:w-20 sm:h-20 mb-4 relative">
                            <div class="absolute inset-0 bg-blue-100 rounded-full opacity-40 animate-pulse"></div>
                            <div class="w-full h-full rounded-full bg-blue-50 flex items-center justify-center text-[#102b70] relative z-10 shadow-xs border border-blue-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" /></svg>
                            </div>
                        </div>
                        <h4 class="text-sm font-extrabold text-slate-800 mb-1">Search for a member to begin checkout</h4>
                        <p class="text-xs text-slate-500 max-w-sm">Enter member details above to view their information and scan items.</p>
                    </div>
                </div>

                <!-- Scan Book Card (Shown only when member is loaded) -->
                <div id="checkout-book-card" class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5 sm:p-6 flex flex-col hidden">
                    <div class="mb-4 flex items-center gap-2.5">
                        <span class="w-5 h-5 rounded-full bg-[#102b70] text-white text-xs font-black flex items-center justify-center">2</span>
                        <div>
                            <h3 class="text-sm sm:text-base font-extrabold text-slate-900 leading-tight">Scan Book Barcode / Add Item</h3>
                            <p class="text-xs font-medium text-slate-500 mt-0.5">Scan or enter the book barcode to add to checkout.</p>
                        </div>
                    </div>

                    <div class="relative">
                        <div class="flex flex-col sm:flex-row gap-3">
                            <form id="add-book-form" class="relative flex-1">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" /></svg>
                                </div>
                                <input type="text" id="checkout-book-barcode" class="w-full pl-9 pr-12 py-2.5 text-sm bg-white rounded-xl border border-slate-300 focus:outline-none focus:border-[#102b70] focus:ring-1 focus:ring-[#102b70]/20 shadow-xs text-slate-900 placeholder:text-slate-400" placeholder="Scan book barcode or enter accession no." autocomplete="off">
                            </form>
                            <button type="button" onclick="focusBookScanner()" class="px-4 py-2.5 border border-slate-200 hover:bg-slate-50 text-slate-600 text-xs font-bold rounded-xl transition-all shadow-xs shrink-0 flex items-center justify-center gap-1.5">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01" /></svg>
                                Scan Barcode
                            </button>
                        </div>
                        <!-- Autocomplete Suggestions for Book -->
                        <ul id="book-autocomplete-results" class="absolute z-50 w-full bg-white shadow-xl rounded-xl mt-1 border border-slate-200 max-h-60 overflow-y-auto hidden">
                        </ul>
                    </div>

                    <!-- Book Added Alert Message (Inline CSS) -->
                    <div id="book-added-alert" class="hidden mt-4 p-3 bg-emerald-50 border border-emerald-100 text-emerald-700 text-xs font-bold rounded-xl flex items-center justify-between shadow-xs">
                        <span id="book-added-alert-text">The Midnight Library (ACC-000723) added to cart</span>
                        <span class="px-2 py-0.5 bg-emerald-100 text-emerald-800 rounded font-black text-[10px]">Added</span>
                    </div>
                </div>

                <!-- Checkout Cart Card (Shown only when member is loaded) -->
                <div id="checkout-cart-card" class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5 sm:p-6 flex flex-col hidden">
                    <div class="mb-4 flex items-center justify-between gap-4">
                        <div class="flex items-center gap-2.5">
                            <span class="w-5 h-5 rounded-full bg-[#102b70] text-white text-xs font-black flex items-center justify-center">3</span>
                            <div>
                                <h3 class="text-sm sm:text-base font-extrabold text-slate-900 leading-tight">Checkout Cart</h3>
                                <p class="text-xs font-medium text-slate-500 mt-0.5">Review items before completing checkout.</p>
                            </div>
                        </div>
                        <button type="button" onclick="clearBooks()" class="text-xs font-extrabold text-slate-400 hover:text-slate-600 transition-colors uppercase tracking-wider flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            Clear Cart
                        </button>
                    </div>

                    <div id="empty-books-state" class="border-2 border-dashed border-slate-200 rounded-2xl p-8 flex flex-col items-center justify-center text-center">
                        <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center text-slate-400 mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                        </div>
                        <p class="text-sm font-semibold text-slate-500">Scan a book barcode to add it to the list.</p>
                    </div>

                    <div id="books-list-container" class="hidden">
                        <div class="responsive-table-scroll hidden md:block border border-slate-200 rounded-xl shadow-xs bg-white">
                            <table class="responsive-table w-full text-left text-sm whitespace-nowrap">
                                <thead class="bg-slate-50 text-slate-500 uppercase text-[10px] font-extrabold tracking-wider border-b border-slate-200">
                                    <tr>
                                        <th class="px-4 py-3 w-10"></th>
                                        <th class="px-4 py-3">Book Details</th>
                                        <th class="px-4 py-3">Barcode</th>
                                        <th class="px-4 py-3">Due Date</th>
                                        <th class="px-4 py-3 text-right"></th>
                                    </tr>
                                </thead>
                                <tbody id="books-table-body" class="divide-y divide-slate-100">
                                </tbody>
                            </table>
                        </div>

                        <div id="books-mobile-body" class="md:hidden flex flex-col gap-3">
                        </div>
                    </div>
                </div>

            </div>

            <!-- Right Column: Summary & Quick Actions (1/3 width) -->
            <div class="flex flex-col gap-6">

                <!-- Checkout Summary Card (Sticky/Reactive on Desktop, hidden initially on Mobile) -->
                <div id="checkout-summary-card" class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5 flex flex-col hidden">
                    <h3 class="text-sm sm:text-base font-extrabold text-slate-900 mb-4 uppercase tracking-wider">Checkout Summary</h3>
                    
                    <div class="space-y-4">
                        <!-- Due Date Block -->
                        <div class="bg-slate-50 border border-slate-100 p-4 rounded-xl text-center">
                            <span class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">Due Date (All Items)</span>
                            <span id="summary-due-date" class="text-lg font-black text-slate-800 mt-1 block">Aug 03, 2026</span>
                            <a href="javascript:void(0)" onclick="alert('Change Due Date details')" class="text-xs font-bold text-blue-700 hover:text-blue-900 mt-2 inline-flex items-center gap-1">
                                Change Due Date
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            </a>
                        </div>

                        <!-- Stats details -->
                        <div class="divide-y divide-slate-100 text-xs font-bold">
                            <div class="py-2.5 flex justify-between">
                                <span class="text-slate-400">Borrow Limit</span>
                                <span class="text-slate-800" id="summary-borrow-limit">10 items</span>
                            </div>
                            <div class="py-2.5 flex justify-between">
                                <span class="text-slate-400">Currently Borrowed</span>
                                <span class="text-slate-800" id="summary-currently-borrowed">2 items</span>
                            </div>
                            <div class="py-2.5 flex justify-between">
                                <span class="text-slate-400">Items in Cart</span>
                                <span class="text-slate-800" id="summary-cart-items">0 items</span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="pt-2">
                            <button type="button" onclick="submitCheckout()" id="btn-complete-checkout" class="w-full py-3 bg-[#fcc719] hover:bg-[#FFD54F] text-[#102b70] font-bold text-sm rounded-xl shadow-md shadow-[#fcc719]/10 transition-all flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                                Complete Checkout
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Today's Summary Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5 flex flex-col">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm sm:text-base font-extrabold text-slate-900 uppercase tracking-wider">Today's Summary</h3>
                        <a href="{{ route('admin.circulation.index') }}" class="text-xs font-bold text-blue-600 hover:text-blue-800 transition-colors">View All</a>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div class="p-3.5 bg-blue-50/60 border border-blue-100 rounded-xl flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                            <div>
                                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider leading-none">Checked Out</p>
                                <p class="text-base font-black text-slate-900 mt-1 leading-none" id="stat-checkouts">{{ $todaysCheckouts ?? 0 }}</p>
                            </div>
                        </div>

                        <div class="p-3.5 bg-emerald-50/60 border border-emerald-100 rounded-xl flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" /></svg>
                            </div>
                            <div>
                                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider leading-none">Checked In</p>
                                <p class="text-base font-black text-slate-900 mt-1 leading-none" id="stat-returns">{{ $todaysReturns ?? 0 }}</p>
                            </div>
                        </div>

                        <div class="p-3.5 bg-rose-50/60 border border-rose-100 rounded-xl flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-rose-100 text-rose-600 flex items-center justify-center shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                            <div>
                                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider leading-none">Overdue</p>
                                <p class="text-base font-black text-slate-900 mt-1 leading-none" id="stat-overdue">{{ $overdueBooks ?? 0 }}</p>
                            </div>
                        </div>

                        <div class="p-3.5 bg-purple-50/60 border border-purple-100 rounded-xl flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-purple-100 text-purple-600 flex items-center justify-center shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                            </div>
                            <div>
                                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider leading-none">Active</p>
                                <p class="text-base font-black text-slate-900 mt-1 leading-none" id="stat-active">{{ $activeBorrowsCount ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <!-- TAB 2: CHECK IN PANEL (Hidden initially) -->
        <div id="checkin-tab-panel" class="hidden bg-white rounded-2xl shadow-sm border border-slate-200 flex flex-col overflow-hidden">
            <div class="p-4 sm:p-5 border-b border-slate-100 flex items-center gap-3 shrink-0 bg-slate-50/50">
                <div class="w-9 h-9 rounded-full bg-[#102b70] text-[#fcc719] font-bold flex items-center justify-center shrink-0 shadow-sm border border-slate-200">
                    ✓
                </div>
                <div>
                    <h2 class="text-sm sm:text-base font-extrabold text-slate-900 leading-tight">Check-In Desk</h2>
                    <p class="text-xs font-medium text-slate-500 mt-0.5">Scan or enter books to check them back in.</p>
                </div>
            </div>

            <div class="p-4 sm:p-6 flex-1 overflow-y-auto flex flex-col">
                <!-- Barcode Scan Form -->
                <div class="mb-6 relative">
                    <label class="block text-xs sm:text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Scan Book Barcode</label>
                    <form id="checkin-form" class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" /></svg>
                        </div>
                        <input type="text" id="checkin-book-barcode" class="w-full pl-10 pr-24 py-2.5 rounded-xl border border-slate-300 focus:border-[#102b70] focus:ring-1 focus:ring-[#102b70]/20 transition-colors shadow-xs text-sm text-slate-900 placeholder:text-slate-400 outline-none bg-white" placeholder="Scan book barcode to return..." autocomplete="off">
                        <button type="submit" class="absolute right-2 top-2 px-4 py-1.5 rounded-lg bg-[#102b70] hover:bg-[#0b225e] text-white font-bold text-xs transition-colors shadow-xs">Check In</button>
                    </form>
                    <!-- Autocomplete Suggestions for Checkin -->
                    <ul id="checkin-autocomplete-results" class="absolute z-50 w-full bg-white shadow-xl rounded-xl mt-1 border border-slate-200 max-h-60 overflow-y-auto hidden">
                    </ul>
                </div>

                <!-- Current Session Returns -->
                <div class="flex-1 flex flex-col">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-xs font-extrabold text-slate-400 uppercase tracking-wider">Current Session Returns</h4>
                        <button type="button" onclick="clearCheckinSession()" class="text-xs font-bold text-slate-400 hover:text-slate-700 transition-colors uppercase tracking-wider">Clear List</button>
                    </div>

                    <!-- Session List -->
                    <div id="session-checkins" class="space-y-3 flex-1 overflow-y-auto mb-6">
                    </div>
                    
                    <div id="checkin-empty-state" class="flex-1 flex flex-col items-center justify-center text-center py-8">
                        <div class="w-14 h-14 bg-slate-100 rounded-full flex items-center justify-center text-slate-400 mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h4a1 1 0 010 2H6.414l2.293 2.293a1 1 0 11-1.414 1.414L5 6.414V8a1 1 0 01-2 0V4zm9 1a1 1 0 010-2h4a1 1 0 011 1v4a1 1 0 01-2 0V6.414l-2.293 2.293a1 1 0 11-1.414-1.414L13.586 5H12zM5 13a1 1 0 012 0v1.586l2.293-2.293a1 1 0 111.414 1.414L8.414 16H10a1 1 0 010 2H6a1 1 0 01-1-1v-4zm9-1a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 010-2h1.586l-2.293-2.293a1 1 0 111.414-1.414L15 13.586V12z" /></svg>
                        </div>
                        <p class="text-sm font-semibold text-slate-500">Scan a book barcode to begin check-in.</p>
                    </div>
                    
                    <div id="checkin-count-container" class="hidden text-sm font-semibold text-emerald-700 bg-emerald-50 border border-emerald-100 rounded-xl p-3 flex items-center justify-center gap-2 mb-8">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        <span id="checkin-count">0 books returned this session</span>
                    </div>
                    
                    <!-- Recent Activity -->
                    <div id="recent-activity-container">
                        @include('admin.circulation.partials.recent_checkins', ['recentCheckins' => $recentCheckins])
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
        const MAX_BORROW_LIMIT = 10;

        // Checkin State
        let checkinCount = 0;

        // Tab Switching Function
        function switchCirculationTab(tab) {
            const checkoutBtn = document.getElementById('tab-checkout-btn');
            const checkinBtn = document.getElementById('tab-checkin-btn');
            const checkoutPanel = document.getElementById('checkout-tab-panel');
            const checkinPanel = document.getElementById('checkin-tab-panel');

            if (tab === 'checkout') {
                checkoutBtn.className = 'flex-1 py-2 px-4 rounded-lg font-bold text-xs flex items-center justify-center gap-1.5 transition-all shadow-xs bg-[#102b70] text-white';
                checkinBtn.className = 'flex-1 py-2 px-4 rounded-lg font-bold text-xs flex items-center justify-center gap-1.5 transition-all text-slate-600 hover:text-slate-900 hover:bg-slate-100';
                checkoutPanel.classList.remove('hidden');
                checkinPanel.classList.add('hidden');
            } else {
                checkinBtn.className = 'flex-1 py-2 px-4 rounded-lg font-bold text-xs flex items-center justify-center gap-1.5 transition-all shadow-xs bg-[#102b70] text-white';
                checkoutBtn.className = 'flex-1 py-2 px-4 rounded-lg font-bold text-xs flex items-center justify-center gap-1.5 transition-all text-slate-600 hover:text-slate-900 hover:bg-slate-100';
                checkinPanel.classList.remove('hidden');
                checkoutPanel.classList.add('hidden');
                document.getElementById('checkin-book-barcode')?.focus();
            }
        }

        function focusMemberSearch() {
            switchCirculationTab('checkout');
            const input = document.getElementById('checkout-member-id');
            if (input) {
                input.focus();
                input.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }

        function focusBookScanner() {
            switchCirculationTab('checkout');
            const input = document.getElementById('checkout-book-barcode');
            if (input) {
                input.focus();
                input.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }

        // Utils
        function showAlert(message, type = 'success') {
            const container = document.getElementById('circulation-alert-container');
            const alertDiv = document.createElement('div');
            
            let colorClass, icon;
            if (type === 'success') {
                colorClass = 'bg-white border-l-4 border-emerald-500 text-slate-800';
                icon = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke="currentColor" class="text-emerald-500" />';
            } else if (type === 'warning') {
                colorClass = 'bg-white border-l-4 border-amber-500 text-slate-800';
                icon = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" stroke="currentColor" class="text-amber-500" />';
            } else {
                colorClass = 'bg-white border-l-4 border-rose-500 text-slate-800';
                icon = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke="currentColor" class="text-rose-500" />';
            }

            alertDiv.className = `p-4 rounded-xl shadow-xl border border-slate-200 text-sm font-bold flex items-center gap-3 transition-all duration-300 transform translate-x-full ${colorClass}`;
            alertDiv.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24">
                    ${icon}
                </svg>
                <span>${message}</span>
            `;
            
            container.appendChild(alertDiv);
            
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
                    if (document.getElementById('stat-checkouts')) document.getElementById('stat-checkouts').textContent = data.todaysCheckouts;
                    if (document.getElementById('stat-returns')) document.getElementById('stat-returns').textContent = data.todaysReturns;
                    if (document.getElementById('stat-overdue')) document.getElementById('stat-overdue').textContent = data.overdueBooks;
                    if (document.getElementById('stat-active')) document.getElementById('stat-active').textContent = data.activeBorrows || data.todaysCheckouts;
                    
                    if (data.recentCheckinsHtml && document.getElementById('recent-activity-container')) {
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
        const memberAutocompleteResults = document.getElementById('member-autocomplete-results');
        let memberSearchTimeout = null;

        memberInput.addEventListener('input', function(e) {
            const query = e.target.value.trim();
            clearTimeout(memberSearchTimeout);

            if (query.length < 1) {
                memberAutocompleteResults.classList.add('hidden');
                return;
            }

            memberAutocompleteResults.innerHTML = '<li class="p-4 text-sm text-slate-500 text-center flex justify-center items-center gap-2"><span class="loading loading-spinner loading-xs"></span> Searching...</li>';
            memberAutocompleteResults.classList.remove('hidden');

            memberSearchTimeout = setTimeout(async () => {
                try {
                    const response = await fetch(`{{ route('admin.circulation.member.search') }}?q=${encodeURIComponent(query)}`, {
                        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                    });
                    const data = await response.json();
                    
                    if (data.members && data.members.length > 0) {
                        memberAutocompleteResults.innerHTML = data.members.map(m => `
                            <li class="p-3.5 hover:bg-slate-50 cursor-pointer border-b border-slate-100 last:border-0 flex items-center justify-between group transition-colors" onclick="selectMember('${m.member_db_id || m.id}')">
                                <div>
                                    <p class="text-sm font-bold text-slate-900 group-hover:text-[#102b70] transition-colors">${m.name}</p>
                                    <p class="text-xs text-slate-500">ID: ${m.student_number} | ${m.course}</p>
                                </div>
                                <span class="text-xs font-semibold px-2 py-1 rounded ${m.can_borrow ? 'bg-emerald-50 text-emerald-700' : 'bg-rose-50 text-rose-700'}">${m.status}</span>
                            </li>
                        `).join('');
                    } else {
                        memberAutocompleteResults.innerHTML = '<li class="p-4 text-sm text-slate-500 text-center">No members found</li>';
                    }
                } catch (err) {
                    memberAutocompleteResults.innerHTML = '<li class="p-4 text-sm text-rose-500 text-center">Failed to search members</li>';
                }
            }, 300);
        });

        document.addEventListener('click', function(e) {
            if (!memberInput.contains(e.target) && !memberAutocompleteResults.contains(e.target)) {
                memberAutocompleteResults.classList.add('hidden');
            }
        });

        document.getElementById('member-lookup-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            const query = memberInput.value.trim();
            if (!query) return;

            memberAutocompleteResults.classList.add('hidden');
            
            try {
                const response = await fetch(`{{ route('admin.circulation.member.search') }}?q=${encodeURIComponent(query)}`, {
                    headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                });
                const data = await response.json();
                
                if (data.members && data.members.length === 1) {
                    selectMember(data.members[0].member_db_id || data.members[0].id);
                } else if (data.members && data.members.length > 1) {
                    memberAutocompleteResults.classList.remove('hidden');
                } else {
                    showAlert('Member not found', 'error');
                }
            } catch (err) {
                showAlert('Error looking up member', 'error');
            }
        });

        window.selectMember = async function(memberId) {
            memberAutocompleteResults.classList.add('hidden');
            try {
                const response = await fetch(`{{ route('admin.circulation.member.details', ':id') }}`.replace(':id', encodeURIComponent(memberId)));
                if (!response.ok) {
                    const errData = await response.json().catch(() => ({}));
                    throw new Error(errData.error || 'Failed to load member details');
                }
                const data = await response.json();

                currentStudentId = data.member.id;
                document.getElementById('member-avatar').textContent = data.member.initials;
                document.getElementById('member-name').textContent = data.member.name;
                document.getElementById('member-id').textContent = 'Student ID: ' + data.member.student_number + ' • ' + data.member.email;
                document.getElementById('member-course').textContent = data.member.department + ' • ' + data.member.course;
                document.getElementById('member-borrowed').textContent = data.member.currently_borrowed;
                document.getElementById('member-slots').textContent = data.member.available_slots;
                document.getElementById('member-fines').textContent = '₱' + parseFloat(data.member.fines).toFixed(2);
                
                // Set View Profile link href
                document.getElementById('btn-view-profile').setAttribute('href', `/admin/users?search=${encodeURIComponent(data.member.student_number)}`);

                const statusBadge = document.getElementById('member-status-badge');
                if (data.member.can_borrow) {
                    statusBadge.className = 'inline-flex px-2 py-0.5 rounded-md text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200';
                    statusBadge.textContent = 'Active';
                } else {
                    statusBadge.className = 'inline-flex px-2 py-0.5 rounded-md text-[10px] font-bold bg-rose-100 text-rose-800 border border-rose-200';
                    statusBadge.textContent = data.member.status || 'Restricted';
                    statusBadge.setAttribute('title', data.member.borrow_restriction_reason || '');
                }

                // Update Checkout Summary Card elements
                document.getElementById('summary-borrow-limit').textContent = MAX_BORROW_LIMIT + ' items';
                document.getElementById('summary-currently-borrowed').textContent = data.member.currently_borrowed + ' items';

                document.getElementById('checkout-empty-state').classList.add('hidden');
                document.getElementById('checkout-step-2').classList.remove('hidden');
                document.getElementById('checkout-book-card').classList.remove('hidden');
                document.getElementById('checkout-cart-card').classList.remove('hidden');
                document.getElementById('checkout-summary-card').classList.remove('hidden');
                
                setTimeout(() => bookInput.focus(), 100);
            } catch (err) {
                showAlert('Failed to load member details', 'error');
            }
        };

        window.resetCheckout = function() {
            currentStudentId = null;
            checkoutBooks = [];
            memberInput.value = '';
            bookInput.value = '';
            document.getElementById('checkout-step-2').classList.add('hidden');
            document.getElementById('checkout-book-card').classList.add('hidden');
            document.getElementById('checkout-cart-card').classList.add('hidden');
            document.getElementById('checkout-summary-card').classList.add('hidden');
            document.getElementById('checkout-empty-state').classList.remove('hidden');
            document.getElementById('book-added-alert').classList.add('hidden');
            renderBooksList();
            memberInput.focus();
        };

        // Book Search Autocomplete Logic
        const bookAutocompleteResults = document.getElementById('book-autocomplete-results');
        let bookSearchTimeout = null;

        bookInput.addEventListener('input', function(e) {
            const query = e.target.value.trim();
            clearTimeout(bookSearchTimeout);

            if (query.length < 1) {
                bookAutocompleteResults.classList.add('hidden');
                return;
            }

            bookAutocompleteResults.innerHTML = '<li class="p-4 text-sm text-slate-500 text-center flex justify-center items-center gap-2"><span class="loading loading-spinner loading-xs"></span> Searching...</li>';
            bookAutocompleteResults.classList.remove('hidden');

            bookSearchTimeout = setTimeout(async () => {
                try {
                    const response = await fetch(`{{ route('admin.circulation.books.search') }}?q=${encodeURIComponent(query)}`, {
                        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                    });
                    const data = await response.json();
                    
                    if (data.books && data.books.length > 0) {
                        bookAutocompleteResults.innerHTML = data.books.map(b => `
                            <li class="p-3.5 hover:bg-slate-50 cursor-pointer border-b border-slate-100 last:border-0 flex items-center justify-between group transition-colors" onclick="selectBookSuggestion('${b.barcode}')">
                                <div>
                                    <p class="text-sm font-bold text-slate-900 group-hover:text-[#102b70] transition-colors">${b.title}</p>
                                    <p class="text-xs text-slate-500">Barcode: ${b.barcode} | by ${b.authors}</p>
                                </div>
                                <span class="text-xs font-semibold px-2 py-1 rounded bg-emerald-50 text-emerald-700">${b.status}</span>
                            </li>
                        `).join('');
                    } else {
                        bookAutocompleteResults.innerHTML = '<li class="p-4 text-sm text-slate-500 text-center">No books found</li>';
                    }
                } catch (err) {
                    bookAutocompleteResults.innerHTML = '<li class="p-4 text-sm text-rose-500 text-center">Failed to search books</li>';
                }
            }, 300);
        });

        document.addEventListener('click', function(e) {
            if (!bookInput.contains(e.target) && !bookAutocompleteResults.contains(e.target)) {
                bookAutocompleteResults.classList.add('hidden');
            }
        });

        window.selectBookSuggestion = async function(barcode) {
            bookAutocompleteResults.classList.add('hidden');
            bookInput.value = barcode;
            // Submit form to execute standard lookup
            document.getElementById('add-book-form').dispatchEvent(new Event('submit'));
        };

        document.getElementById('add-book-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            const barcode = bookInput.value.trim();
            if (!barcode || !currentStudentId) return;

            if (checkoutBooks.some(b => (b.barcode && b.barcode === barcode) || (b.accession_number && b.accession_number === barcode))) {
                showAlert('Book already added to list', 'warning');
                bookInput.value = '';
                return;
            }

            bookInput.disabled = true;
            try {
                const response = await fetch(`{{ route('admin.circulation.book.lookup') }}?barcode=${encodeURIComponent(barcode)}&member_id=${currentStudentId}`);
                const data = await response.json();

                if (response.ok && data.success) {
                    checkoutBooks.push({
                        book_id: data.book.id,
                        barcode: data.book.barcode || data.book.accession_number,
                        accession_number: data.book.accession_number,
                        book_data: data.book.book_data,
                        display_due_date: data.due_date
                    });
                    renderBooksList();
                    bookInput.value = '';

                    // Show temporary success banner matching mockup
                    const alertBox = document.getElementById('book-added-alert');
                    const alertText = document.getElementById('book-added-alert-text');
                    alertText.textContent = `${data.book.book_data.book_title} (ACC-${data.book.accession_number}) added to cart`;
                    alertBox.classList.remove('hidden');
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
            const summaryDueDate = document.getElementById('summary-due-date');
            const summaryCartItems = document.getElementById('summary-cart-items');
            const completeBtn = document.getElementById('btn-complete-checkout');

            if (checkoutBooks.length === 0) {
                emptyState.classList.remove('hidden');
                listContainer.classList.add('hidden');
                summaryCartItems.textContent = '0 items';
                if (completeBtn) {
                    completeBtn.disabled = true;
                    completeBtn.classList.add('opacity-50', 'cursor-not-allowed');
                }
                return;
            }

            emptyState.classList.add('hidden');
            listContainer.classList.remove('hidden');
            if (completeBtn) {
                completeBtn.disabled = false;
                completeBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            }

            tableBody.innerHTML = '';
            mobileBody.innerHTML = '';

            let lastDueDate = '';
            summaryCartItems.textContent = `${checkoutBooks.length} items`;

            checkoutBooks.forEach((book, index) => {
                lastDueDate = book.display_due_date;
                
                let authors = 'Unknown Author';
                if (book.book_data && book.book_data.authors && book.book_data.authors.length > 0) {
                    authors = book.book_data.authors.map(a => a.author_name).join(', ');
                }
                const title = book.book_data ? book.book_data.book_title : 'Unknown Title';
                const barcode = book.barcode || book.accession_number;
                
                let imgHtml = `<div class="w-10 h-14 bg-slate-100 rounded border border-slate-200 flex items-center justify-center shrink-0"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg></div>`;
                if (book.book_data && book.book_data.book_detail) {
                    const detail = book.book_data.book_detail;
                    if (detail.image_url) {
                        imgHtml = `<div class="w-10 h-14 bg-slate-100 rounded border border-slate-200 shrink-0 overflow-hidden"><img src="/storage/${detail.image_url}" class="w-full h-full object-cover"></div>`;
                    } else if (detail.cover_image) {
                        const src = detail.cover_image.startsWith('data:image') ? detail.cover_image : '/storage/' + detail.cover_image.replace(/^\/+/, '');
                        imgHtml = `<div class="w-10 h-14 bg-slate-100 rounded border border-slate-200 shrink-0 overflow-hidden"><img src="${src}" class="w-full h-full object-cover"></div>`;
                    }
                }

                // Desktop Row
                const tr = document.createElement('tr');
                tr.className = 'hover:bg-blue-50/40 transition-colors group';
                tr.innerHTML = `
                    <td class="px-4 py-3">${imgHtml}</td>
                    <td class="px-4 py-3">
                        <div class="font-bold text-slate-900 leading-tight max-w-[200px] truncate" title="${title}">${title}</div>
                        <div class="text-xs text-slate-500 max-w-[200px] truncate">${authors}</div>
                    </td>
                    <td class="px-4 py-3 text-slate-700 font-mono text-xs">${barcode}</td>
                    <td class="px-4 py-3 text-slate-700 font-medium">${book.display_due_date}</td>
                    <td class="px-4 py-3 text-right">
                        <button type="button" onclick="removeBook(${index})" class="p-1.5 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                        </button>
                    </td>
                `;
                tableBody.appendChild(tr);

                // Mobile Card
                const card = document.createElement('div');
                card.className = 'bg-slate-50 border border-slate-200 rounded-xl p-3 flex gap-3.5 relative shadow-xs';
                card.innerHTML = `
                    ${imgHtml}
                    <div class="flex-1 min-w-0 pr-8">
                        <div class="font-bold text-slate-900 leading-tight truncate">${title}</div>
                        <div class="text-xs text-slate-500 truncate mb-1">${authors}</div>
                        <div class="flex items-center gap-2 text-xs flex-wrap mt-1">
                            <span class="font-mono text-[10px] text-slate-500 bg-white border border-slate-200 px-1.5 py-0.5 rounded">${barcode}</span>
                            <span class="text-emerald-700 font-extrabold text-[10px] bg-emerald-50 px-1.5 py-0.5 rounded">Ready</span>
                            <span class="text-slate-400 font-semibold">Due: ${book.display_due_date}</span>
                        </div>
                    </div>
                    <button type="button" onclick="removeBook(${index})" class="absolute top-2 right-2 p-1.5 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                `;
                mobileBody.appendChild(card);
            });

            if (summaryDueDate) summaryDueDate.textContent = lastDueDate;
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
            const originalHtml = btn.innerHTML;
            btn.innerHTML = '<span class="loading loading-spinner loading-xs"></span> Processing...';
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
                btn.innerHTML = originalHtml;
                btn.disabled = false;
            }
        };

        // ================= CHECKIN LOGIC =================

        const checkinForm = document.getElementById('checkin-form');
        const checkinInput = document.getElementById('checkin-book-barcode');
        const checkinAutocompleteResults = document.getElementById('checkin-autocomplete-results');
        let checkinSearchTimeout = null;

        checkinInput.addEventListener('input', function(e) {
            const query = e.target.value.trim();
            clearTimeout(checkinSearchTimeout);

            if (query.length < 1) {
                checkinAutocompleteResults.classList.add('hidden');
                return;
            }

            checkinAutocompleteResults.innerHTML = '<li class="p-4 text-sm text-slate-500 text-center flex justify-center items-center gap-2"><span class="loading loading-spinner loading-xs"></span> Searching...</li>';
            checkinAutocompleteResults.classList.remove('hidden');

            checkinSearchTimeout = setTimeout(async () => {
                try {
                    const response = await fetch(`{{ route('admin.circulation.books.search') }}?status=borrowed&q=${encodeURIComponent(query)}`, {
                        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                    });
                    const data = await response.json();
                    
                    if (data.books && data.books.length > 0) {
                        checkinAutocompleteResults.innerHTML = data.books.map(b => `
                            <li class="p-3.5 hover:bg-slate-50 cursor-pointer border-b border-slate-100 last:border-0 flex items-center justify-between group transition-colors" onclick="selectCheckinBookSuggestion('${b.barcode}')">
                                <div>
                                    <p class="text-sm font-bold text-slate-900 group-hover:text-[#102b70] transition-colors">${b.title}</p>
                                    <p class="text-xs text-slate-500">Barcode: ${b.barcode} ${b.borrower ? '| Borrowed by: ' + b.borrower : ''}</p>
                                </div>
                                <span class="text-xs font-semibold px-2 py-1 rounded bg-amber-50 text-amber-700">${b.status}</span>
                            </li>
                        `).join('');
                    } else {
                        checkinAutocompleteResults.innerHTML = '<li class="p-4 text-sm text-slate-500 text-center">No borrowed books found</li>';
                    }
                } catch (err) {
                    checkinAutocompleteResults.innerHTML = '<li class="p-4 text-sm text-rose-500 text-center">Failed to search books</li>';
                }
            }, 300);
        });

        document.addEventListener('click', function(e) {
            if (!checkinInput.contains(e.target) && !checkinAutocompleteResults.contains(e.target)) {
                checkinAutocompleteResults.classList.add('hidden');
            }
        });

        window.selectCheckinBookSuggestion = async function(barcode) {
            checkinAutocompleteResults.classList.add('hidden');
            checkinInput.value = barcode;
            document.getElementById('checkin-form').dispatchEvent(new Event('submit'));
        };

        checkinForm.addEventListener('submit', async function(e) {
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
                    showAlert(data.message, 'success');
                    addCheckinToSessionList(data.borrow);
                    checkinCount++;
                    updateCheckinCount();
                    checkinInput.value = '';
                    refreshCirculationStats();
                } else {
                    showAlert(data.message || 'Check-in failed', 'error');
                }
            } catch (err) {
                showAlert('Network error occurred.', 'error');
            } finally {
                checkinInput.disabled = false;
                checkinInput.focus();
            }
        });

        function addCheckinToSessionList(borrow) {
            document.getElementById('checkin-empty-state').classList.add('hidden');
            const container = document.getElementById('session-checkins');
            
            let fineHtml = '';
            if (borrow.fine_amount > 0) {
                fineHtml = `<span class="text-xs font-bold text-rose-600 bg-rose-50 px-2 py-0.5 rounded border border-rose-100 font-mono">Fine: ₱${parseFloat(borrow.fine_amount).toFixed(2)}</span>`;
            }

            const div = document.createElement('div');
            div.className = 'bg-slate-50 border border-slate-200 rounded-xl p-3.5 flex items-center justify-between gap-4 shadow-xs';
            div.innerHTML = `
                <div class="flex items-center gap-3 min-w-0">
                    <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0 font-bold text-xs">
                        ✓
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-bold text-slate-900 truncate">${borrow.book_title}</p>
                        <p class="text-xs text-slate-500 truncate">Returned by: ${borrow.member_name}</p>
                    </div>
                </div>
                <div class="flex items-center gap-2 shrink-0">
                    ${fineHtml}
                    <span class="text-[10px] font-extrabold text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded uppercase tracking-wider">Returned</span>
                </div>
            `;

            container.prepend(div);
        }

        function updateCheckinCount() {
            const container = document.getElementById('checkin-count-container');
            const countText = document.getElementById('checkin-count');
            if (checkinCount > 0) {
                container.classList.remove('hidden');
                countText.textContent = `${checkinCount} book(s) returned this session`;
            }
        }

        window.clearCheckinSession = function() {
            document.getElementById('session-checkins').innerHTML = '';
            document.getElementById('checkin-empty-state').classList.remove('hidden');
            document.getElementById('checkin-count-container').classList.add('hidden');
            checkinCount = 0;
            checkinInput.focus();
        };
    </script>
</x-layout.admin>
