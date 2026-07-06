<header class="shrink-0 flex flex-col w-full">
    <!-- 1. Top Utility Bar (White Background) -->
    <div class="h-[60px] bg-white border-b border-gray-200 px-6 grid grid-cols-3 items-center w-full shrink-0">
        
        <!-- Left: Breadcrumbs -->
        <div class="text-sm font-medium text-gray-500">
            <span class="hover:text-gray-800 cursor-pointer transition-colors">Admin</span> 
            <span class="mx-1">&gt;</span> 
            <span class="text-gray-800 font-bold">{{ ucfirst(request()->segment(2) ?? 'Dashboard') }}</span>
        </div>

        <!-- Center: Elongated Search Bar -->
        <div class="relative hidden md:block w-full max-w-4xl mx-auto">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input type="text" class="block w-full pl-9 pr-3 py-2 border border-gray-200 rounded-lg text-sm bg-gray-50 focus:bg-white focus:border-[#1A2B56] focus:ring-1 focus:ring-[#1A2B56] outline-none transition-all shadow-sm" placeholder="Search books, users, borrows...">
        </div>

        <!-- Right: Live Clock & Notifications -->
        <div class="flex items-center justify-end gap-5">
            <!-- Live Time Clock -->
            <div class="hidden sm:flex flex-col items-end border-r border-gray-200 pr-5">
                <span id="live-time" class="text-sm font-bold text-gray-800 leading-tight">00:00:00</span>
                <span id="live-date" class="text-[10px] text-gray-500 font-medium uppercase tracking-wider">Date</span>
            </div>

            <!-- Notification Bell -->
            <button class="relative text-gray-400 hover:text-[#1A2B56] transition-colors p-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full border border-white"></span>
            </button>
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

