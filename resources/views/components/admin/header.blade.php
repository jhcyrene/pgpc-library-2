@php
    $staffRole = in_array(strtolower((string) Auth::guard('member')->user()?->account_type), ['administrator', 'admin'], true)
        ? 'Admin'
        : 'Librarian';
@endphp

<header class="shrink-0 flex flex-col w-full">
    <!-- 1. Top Utility Bar (White Background) -->
    <div class="h-[60px] bg-white border-b border-gray-200 px-4 md:px-6 flex justify-between md:grid md:grid-cols-3 items-center w-full shrink-0">
        
        <!-- Left: Breadcrumbs & Mobile Menu -->
        <div class="flex items-center gap-4 text-sm font-medium text-gray-500">
            <!-- Mobile Menu Button -->
            <button type="button" id="mobile-menu-btn" class="lg:hidden p-2 -ml-2 rounded-md hover:bg-gray-100 text-gray-600 focus:outline-none focus:ring-2 focus:ring-[#102b70]" aria-label="Open sidebar">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
            
            <div class="hidden sm:block">
                <span class="text-gray-500">{{ $staffRole }}</span>
                <span class="mx-1">&gt;</span> 
                <span class="text-gray-800 font-bold">{{ ucfirst(request()->segment(2) ?? 'Dashboard') }}</span>
            </div>
        </div>

        <div class="hidden md:block">
            <x-admin.partials.searchBar 
                action="{{ route('admin.books.index') }}" 
                placeholder="Search for books" 
                name="search"
            />
        </div>

        <!-- Right: Live Clock & Notifications -->
        <div class="flex items-center justify-end gap-5">
            <!-- Live Time Clock -->
            <x-admin.partials.clockLive />

            <!-- Notification Bell -->
            <x-admin.partials.notifBellButton />
        </div>
    </div>

    

</header>

<script>
    function updateLiveClock() {
        const now = new Date();
        const timeString = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', second: '2-digit' });
        const dateString = now.toLocaleDateString([], { weekday: 'short', month: 'short', day: 'numeric', year: 'numeric' });
        
        const timeEl = document.getElementById('live-time');
        const dateEl = document.getElementById('live-date');
        
        if (timeEl) timeEl.textContent = timeString;
        if (dateEl) dateEl.textContent = dateString;
    }
    
    // Update immediately, then every second
    updateLiveClock();
    setInterval(updateLiveClock, 1000);
</script>
