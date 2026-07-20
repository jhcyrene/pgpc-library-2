@php
    $section = str_replace('-', ' ', request()->segment(2) ?? 'dashboard');
@endphp

<header class="h-[60px] bg-[#102b70] lg:bg-white border-b border-white/5 lg:border-gray-200 px-4 md:px-6 flex justify-between items-center w-full shrink-0 z-30">
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

    <!-- Middle: Search Bar (Desktop Only) -->
    <div class="hidden lg:block w-full max-w-md mx-4">
        <form action="{{ route('opac.index') }}" method="GET" class="relative group w-full">
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
                class="block w-full pl-9 pr-20 py-2 border border-gray-200 rounded-lg text-sm bg-gray-50 focus:bg-white focus:border-[#102b70] focus:ring-1 focus:ring-[#102b70] outline-none transition-all shadow-sm" 
                placeholder="Search the catalog..."
            >   

            <button type="submit" class="absolute top-1/2 -translate-y-1/2 right-1.5 px-3 py-1.5 bg-[#102b70] hover:bg-[#0b225e] text-white text-xs font-medium rounded-md transition-colors shadow-sm focus:outline-none">
                Search
            </button>
        </form>
    </div>

    <!-- Right: Live Clock & Notifications -->
    <div class="flex items-center justify-end gap-3 sm:gap-5">
        <!-- Search trigger for mobile view only -->
        <a href="{{ route('opac.index') }}" class="lg:hidden p-2 rounded-lg text-white/80 hover:text-white hover:bg-white/10" aria-label="Search catalog">
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
    </div>
</header>

<script>
    (() => {
        const updateStudentClock = () => {
            const now = new Date();
            const time = document.getElementById('student-live-time');
            const date = document.getElementById('student-live-date');

            if (time) time.textContent = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', second: '2-digit' });
            if (date) date.textContent = now.toLocaleDateString([], { weekday: 'short', month: 'short', day: 'numeric', year: 'numeric' });
        };

        updateStudentClock();
        window.setInterval(updateStudentClock, 1000);
    })();
</script>
