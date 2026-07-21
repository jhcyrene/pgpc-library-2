@php
    $section = str_replace('-', ' ', request()->segment(2) ?? 'dashboard');
@endphp

<header class="h-[60px] bg-[#102b70] lg:bg-white border-b border-white/5 lg:border-gray-200 px-4 md:px-6 flex justify-between items-center w-full shrink-0 z-30 relative">
    <!-- Left: Mobile Menu, Logo & Title, Breadcrumbs on Desktop -->
    <div class="flex items-center gap-2.5 text-sm font-medium text-white/70 lg:text-gray-500 min-w-0">

        <!-- Logo & Title for Mobile/Tablet -->
        <div class="flex lg:hidden items-center gap-2">
            <div class="flex h-8 w-8 shrink-0 items-center justify-center overflow-hidden rounded-full border border-white/20 bg-white">
                <img src="{{ Vite::asset('resources/images/webp/hd-pgpc-logo.webp') }}" alt="PGPC Logo" class="h-full w-full object-cover">
            </div>
            <div class="text-left">
                <p class="text-xs font-bold leading-tight text-white">PGPC Library</p>
                <p class="text-[9px] font-semibold uppercase tracking-wider text-white/50 leading-none">Student Portal</p>
            </div>
        </div>

        <!-- Breadcrumbs for Desktop -->
        <div class="hidden lg:block">
            <span class="text-gray-500">Student</span>
            <span class="mx-1 text-gray-400">&gt;</span>
            <span class="text-gray-800 font-bold capitalize">{{ $section }}</span>
        </div>
    </div>

    <!-- Middle: Live Unified Search Bar (Desktop Only) -->
    <div class="hidden lg:block w-full max-w-md mx-4 relative">
        <form action="{{ route('student.search') }}" method="GET" class="relative group w-full" id="student-search-form">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-4 w-4 text-gray-400 group-focus-within:text-[#102b70] transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            
            <input 
                id="student-header-search"
                type="text" 
                name="q" 
                value="{{ request('q') }}"
                autocomplete="off"
                class="block w-full pl-9 pr-20 py-2 border border-gray-200 rounded-lg text-sm bg-gray-50 focus:bg-white focus:border-[#102b70] focus:ring-1 focus:ring-[#102b70] outline-none transition-all shadow-sm placeholder:text-gray-400" 
                placeholder="Search history, reservations, saved items, books..."
            >   

            <button type="submit" class="absolute top-1/2 -translate-y-1/2 right-1.5 px-3 py-1.5 bg-[#102b70] hover:bg-[#0b225e] text-white text-xs font-medium rounded-md transition-colors shadow-sm focus:outline-none">
                Search
            </button>
        </form>

        <!-- Floating Live Search Results Dropdown -->
        <div id="student-search-dropdown" class="hidden absolute top-full left-0 right-0 mt-2 bg-white rounded-2xl shadow-xl border border-gray-100 max-h-[420px] overflow-y-auto z-50 divide-y divide-gray-100 font-sans">
            <!-- Results container injected via JS -->
        </div>
    </div>

    <!-- Right: Live Clock & Notifications -->
    <div class="flex items-center justify-end gap-3 sm:gap-5">
        <!-- Search trigger for mobile view only -->
        <a href="{{ route('student.search') }}" class="lg:hidden p-2 rounded-lg text-white/80 hover:text-white hover:bg-white/10" aria-label="Search catalog">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </a>

        <!-- Live Clock -->
        <div class="hidden lg:flex flex-col items-end leading-tight">
            <span id="student-live-time" class="text-sm font-bold text-gray-800 leading-tight">00:00:00</span>
            <span id="student-live-date" class="text-[10px] text-gray-500 font-medium uppercase tracking-wider">Date</span>
        </div>

        <!-- Overdue items notification bell -->
        <a href="{{ route('student.overdue-items.index') }}" class="relative text-white/80 lg:text-gray-400 hover:text-white lg:hover:text-[#102b70] transition-colors p-1" aria-label="View overdue items">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
        </a>

        <!-- Topbar Profile Button -->
        <a href="{{ route('student.profile.show') }}" class="flex items-center gap-2 pl-2 border-l border-white/10 lg:border-gray-200 group" title="My Profile">
            <div class="w-8 h-8 rounded-full bg-[#102b70] text-[#fcc719] flex items-center justify-center text-xs font-black overflow-hidden border border-white/20 lg:border-gray-200 shadow-2xs group-hover:ring-2 group-hover:ring-[#fcc719] lg:group-hover:ring-[#102b70]/20 transition-all">
                @if(Auth::guard('member')->user()?->profile_image)
                    <img src="{{ Auth::guard('member')->user()->profile_image }}" alt="Profile" class="w-full h-full object-cover">
                @else
                    {{ strtoupper(substr(Auth::guard('member')->user()?->member?->first_name ?? 'S', 0, 1)) }}
                @endif
            </div>
        </a>
    </div>
</header>

<script>
    (() => {
        // Clock
        const updateStudentClock = () => {
            const now = new Date();
            const time = document.getElementById('student-live-time');
            const date = document.getElementById('student-live-date');

            if (time) time.textContent = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', second: '2-digit' });
            if (date) date.textContent = now.toLocaleDateString([], { weekday: 'short', month: 'short', day: 'numeric', year: 'numeric' });
        };

        updateStudentClock();
        window.setInterval(updateStudentClock, 1000);

        // Unified Live Search
        const searchInput = document.getElementById('student-header-search');
        const dropdown = document.getElementById('student-search-dropdown');
        let searchTimeout = null;

        if (searchInput && dropdown) {
            const renderResults = (data, query) => {
                const hasBorrows = data.borrows && data.borrows.length > 0;
                const hasReservations = data.reservations && data.reservations.length > 0;
                const hasSaved = data.saved && data.saved.length > 0;
                const hasCatalog = data.catalog && data.catalog.length > 0;

                if (!hasBorrows && !hasReservations && !hasSaved && !hasCatalog) {
                    dropdown.innerHTML = `
                        <div class="p-4 text-center text-xs text-slate-500">
                            No matching history, reservations, or books found for "<span class="font-bold text-slate-700">${query}</span>".
                        </div>
                    `;
                    dropdown.classList.remove('hidden');
                    return;
                }

                let html = '';

                // 1. Borrow History Section
                if (hasBorrows) {
                    html += `
                        <div class="p-2.5">
                            <div class="px-2 py-1 text-[10px] font-extrabold uppercase tracking-wider text-blue-900 flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                                My Borrow History & Active Borrows
                            </div>
                            <div class="space-y-1 mt-1">
                                ${data.borrows.map(item => `
                                    <a href="${item.url}" class="flex items-center justify-between p-2 rounded-xl hover:bg-slate-50 transition-colors group">
                                        <div class="min-w-0 pr-2">
                                            <p class="text-xs font-bold text-slate-800 group-hover:text-[#102b70] truncate">${item.title}</p>
                                            <p class="text-[10px] text-slate-400 font-medium">${item.subtitle}</p>
                                        </div>
                                        <span class="shrink-0 text-[10px] font-bold px-2 py-0.5 rounded-md bg-blue-50 text-[#102b70]">Borrow</span>
                                    </a>
                                `).join('')}
                            </div>
                        </div>
                    `;
                }

                // 2. Reservations Section
                if (hasReservations) {
                    html += `
                        <div class="p-2.5">
                            <div class="px-2 py-1 text-[10px] font-extrabold uppercase tracking-wider text-amber-900 flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                My Reservations & Requests
                            </div>
                            <div class="space-y-1 mt-1">
                                ${data.reservations.map(item => `
                                    <a href="${item.url}" class="flex items-center justify-between p-2 rounded-xl hover:bg-slate-50 transition-colors group">
                                        <div class="min-w-0 pr-2">
                                            <p class="text-xs font-bold text-slate-800 group-hover:text-[#102b70] truncate">${item.title}</p>
                                            <p class="text-[10px] text-slate-400 font-medium">${item.subtitle}</p>
                                        </div>
                                        <span class="shrink-0 text-[10px] font-bold px-2 py-0.5 rounded-md bg-amber-50 text-amber-700">Reservation</span>
                                    </a>
                                `).join('')}
                            </div>
                        </div>
                    `;
                }

                // 3. Saved Items Section
                if (hasSaved) {
                    html += `
                        <div class="p-2.5">
                            <div class="px-2 py-1 text-[10px] font-extrabold uppercase tracking-wider text-emerald-900 flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" /></svg>
                                My Saved Items
                            </div>
                            <div class="space-y-1 mt-1">
                                ${data.saved.map(item => `
                                    <a href="${item.url}" class="flex items-center justify-between p-2 rounded-xl hover:bg-slate-50 transition-colors group">
                                        <div class="min-w-0 pr-2">
                                            <p class="text-xs font-bold text-slate-800 group-hover:text-[#102b70] truncate">${item.title}</p>
                                            <p class="text-[10px] text-slate-400 font-medium">${item.subtitle}</p>
                                        </div>
                                        <span class="shrink-0 text-[10px] font-bold px-2 py-0.5 rounded-md bg-emerald-50 text-emerald-700">Saved</span>
                                    </a>
                                `).join('')}
                            </div>
                        </div>
                    `;
                }

                // 4. Catalog Section
                if (hasCatalog) {
                    html += `
                        <div class="p-2.5">
                            <div class="px-2 py-1 text-[10px] font-extrabold uppercase tracking-wider text-slate-500 flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                                Library Catalog Books
                            </div>
                            <div class="space-y-1 mt-1">
                                ${data.catalog.map(item => `
                                    <a href="${item.url}" class="flex items-center justify-between p-2 rounded-xl hover:bg-slate-50 transition-colors group">
                                        <div class="min-w-0 pr-2">
                                            <p class="text-xs font-bold text-slate-800 group-hover:text-[#102b70] truncate">${item.title}</p>
                                            <p class="text-[10px] text-slate-400 font-medium">${item.subtitle}</p>
                                        </div>
                                        <span class="shrink-0 text-[10px] font-bold px-2 py-0.5 rounded-md bg-slate-100 text-slate-600">Catalog</span>
                                    </a>
                                `).join('')}
                            </div>
                        </div>
                    `;
                }

                // Bottom Footer Action
                html += `
                    <div class="p-2 bg-slate-50 rounded-b-2xl text-center">
                        <a href="{{ route('student.search') }}?q=${encodeURIComponent(query)}" class="text-xs font-bold text-[#102b70] hover:underline">
                            View all results for "${query}" &rarr;
                        </a>
                    </div>
                `;

                dropdown.innerHTML = html;
                dropdown.classList.remove('hidden');
            };

            const performSearch = () => {
                const query = searchInput.value.trim();
                if (query.length < 1) {
                    dropdown.classList.add('hidden');
                    dropdown.innerHTML = '';
                    return;
                }

                fetch(`{{ route('student.search-unified') }}?q=${encodeURIComponent(query)}`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    renderResults(data, query);
                })
                .catch(err => {
                    console.error('Search error:', err);
                });
            };

            searchInput.addEventListener('input', () => {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(performSearch, 200);
            });

            searchInput.addEventListener('focus', () => {
                if (searchInput.value.trim().length >= 1) {
                    performSearch();
                }
            });

            document.addEventListener('click', (e) => {
                if (!searchInput.contains(e.target) && !dropdown.contains(e.target)) {
                    dropdown.classList.add('hidden');
                }
            });
        }
    })();
</script>
