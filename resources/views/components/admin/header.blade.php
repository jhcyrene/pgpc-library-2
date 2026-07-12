<header class="shrink-0 flex flex-col w-full">
    <!-- 1. Top Utility Bar (White Background) -->
    <div class="h-[60px] bg-white border-b border-gray-200 px-6 grid grid-cols-3 items-center w-full shrink-0">
        
        <!-- Left: Breadcrumbs -->
        <div class="text-sm font-medium text-gray-500">
            <span class="hover:text-gray-800 cursor-pointer transition-colors">Admin</span> 
            <span class="mx-1">&gt;</span> 
            <span class="text-gray-800 font-bold">{{ ucfirst(request()->segment(2) ?? 'Dashboard') }}</span>
        </div>

        <div class="hidden md:block">
            <x-admin.partials.searchBar 
                action="{{ route('admin.bookManager') }}" 
                placeholder="Search books, students, or IDs..." 
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

