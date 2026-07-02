<aside id="user-sidebar" class="fixed inset-y-0 left-0 z-40 md:sticky md:top-0 w-full md:w-64 flex flex-col h-[100dvh] shrink-0 overflow-hidden bg-[#1A2B56] transform -translate-x-full md:translate-x-0 transition-transform duration-300">

    <!-- Branding / Logo -->
    <div class="h-[80px] flex items-center justify-between px-6 shrink-0 border-b border-white/5">
        <div class="flex items-center gap-4">
            <div class="w-10 h-10 rounded-full border border-white/20 shrink-0 overflow-hidden flex items-center justify-center bg-white">
                <img src="{{ asset('images/pgpc-logo.jpg') }}" alt="PGPC Logo" class="w-full h-full object-cover">
            </div>
            <div class="flex flex-col justify-center">
                <h2 class="text-base font-bold text-white leading-tight">PGPC Library</h2>
                <p class="text-xs text-gray-400 font-medium leading-tight">Student Portal</p>
            </div>
        </div>
        <button id="mobile-sidebar-close" class="md:hidden text-gray-400 hover:text-white transition-colors focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Navigation -->
    <div class="flex-1 overflow-y-auto py-6 px-4 space-y-8">

        <!-- Main Section -->
        <div>
            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-3 px-2">MAIN</p>
            <nav class="space-y-1">
                <!-- Dashboard -->
                <a href="/users/dashboard" class="flex items-center justify-between px-3 py-2.5 rounded-lg transition-all {{ request()->is('users/dashboard') ? 'bg-white/10' : 'text-gray-300 hover:text-white hover:bg-white/5' }}">
                    <div class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 {{ request()->is('users/dashboard') ? 'text-[#FFC107]' : '' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        <span class="text-sm font-{{ request()->is('users/dashboard') ? 'semibold text-[#FFC107]' : 'medium' }}">Dashboard</span>
                    </div>
                    @if(request()->is('users/dashboard'))
                        <span class="w-1.5 h-1.5 rounded-full bg-[#FFC107] shrink-0"></span>
                    @endif
                </a>

                <!-- Catalog -->
                <a href="/catalog" class="flex items-center justify-between px-3 py-2.5 rounded-lg transition-all {{ request()->is('catalog') ? 'bg-white/10' : 'text-gray-300 hover:text-white hover:bg-white/5' }}">
                    <div class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 {{ request()->is('catalog') ? 'text-[#FFC107]' : '' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <span class="text-sm font-{{ request()->is('catalog') ? 'semibold text-[#FFC107]' : 'medium' }}">Search Catalog</span>
                    </div>
                    @if(request()->is('catalog'))
                        <span class="w-1.5 h-1.5 rounded-full bg-[#FFC107] shrink-0"></span>
                    @endif
                </a>

                <!-- My Borrows -->
                <a href="/users/borrows" class="flex items-center justify-between px-3 py-2.5 rounded-lg transition-all {{ request()->is('users/borrows') ? 'bg-white/10' : 'text-gray-300 hover:text-white hover:bg-white/5' }}">
                    <div class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 {{ request()->is('users/borrows') ? 'text-[#FFC107]' : '' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        <span class="text-sm font-{{ request()->is('users/borrows') ? 'semibold text-[#FFC107]' : 'medium' }}">My Borrows</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="bg-[#FFC107] text-[#1A2B56] text-[9px] font-bold px-2 py-0.5 rounded-full leading-none">2</span>
                        @if(request()->is('users/borrows'))
                            <span class="w-1.5 h-1.5 rounded-full bg-[#FFC107] shrink-0"></span>
                        @endif
                    </div>
                </a>

                <!-- Reservations -->
                <a href="/users/reservations" class="flex items-center justify-between px-3 py-2.5 rounded-lg transition-all {{ request()->is('users/reservations') ? 'bg-white/10' : 'text-gray-300 hover:text-white hover:bg-white/5' }}">
                    <div class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 {{ request()->is('users/reservations') ? 'text-[#FFC107]' : '' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                        </svg>
                        <span class="text-sm font-{{ request()->is('users/reservations') ? 'semibold text-[#FFC107]' : 'medium' }}">Reservations</span>
                    </div>
                </a>
                
                <!-- Saved Lists -->
                <a href="/users/lists" class="flex items-center justify-between px-3 py-2.5 rounded-lg transition-all {{ request()->is('users/lists') ? 'bg-white/10' : 'text-gray-300 hover:text-white hover:bg-white/5' }}">
                    <div class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 {{ request()->is('users/lists') ? 'text-[#FFC107]' : '' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        <span class="text-sm font-{{ request()->is('users/lists') ? 'semibold text-[#FFC107]' : 'medium' }}">Saved Lists</span>
                    </div>
                </a>

                <!-- Reading History -->
                <a href="/users/history" class="flex items-center justify-between px-3 py-2.5 rounded-lg transition-all {{ request()->is('users/history') ? 'bg-white/10' : 'text-gray-300 hover:text-white hover:bg-white/5' }}">
                    <div class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 {{ request()->is('users/history') ? 'text-[#FFC107]' : '' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-sm font-{{ request()->is('users/history') ? 'semibold text-[#FFC107]' : 'medium' }}">Reading History</span>
                    </div>
                </a>

                <!-- Fines & Fees -->
                <a href="/users/fines" class="flex items-center justify-between px-3 py-2.5 rounded-lg transition-all {{ request()->is('users/fines') ? 'bg-white/10' : 'text-gray-300 hover:text-white hover:bg-white/5' }}">
                    <div class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 {{ request()->is('users/fines') ? 'text-[#FFC107]' : '' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-sm font-{{ request()->is('users/fines') ? 'semibold text-[#FFC107]' : 'medium' }}">Fines & Fees</span>
                    </div>
                </a>
            </nav>
        </div>

    </div>

    <!-- Bottom Profile Block -->
    <a href="/users/profile" class="p-4 shrink-0 border-t border-white/5 block hover:bg-white/5 transition-colors {{ request()->is('users/profile') ? 'bg-white/10' : '' }}">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3 overflow-hidden">
                <div class="w-9 h-9 rounded-full flex items-center justify-center shrink-0 text-sm font-bold text-[#1A2B56] bg-blue-100">
                    ST
                </div>
                <div class="overflow-hidden">
                    <p class="text-sm font-bold text-white truncate group-hover:text-[#FFC107] transition-colors">Student User</p>
                    <p class="text-xs text-gray-400 truncate">student@pgpc.edu.ph</p>
                </div>
            </div>
            <span class="text-gray-400 hover:text-white transition-colors p-1" title="Logout">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
            </span>
        </div>
    </a>
</aside>
