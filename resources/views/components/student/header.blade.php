@php
    $section = str_replace('-', ' ', request()->segment(2) ?? 'dashboard');
@endphp

<header class="z-30 grid h-[60px] w-full shrink-0 grid-cols-[1fr_auto] items-center border-b border-slate-200 bg-white px-4 sm:px-6 md:grid-cols-[minmax(0,1fr)_minmax(18rem,30rem)_auto] lg:px-8">
    <div class="flex items-center gap-3 text-sm font-medium text-slate-500 min-w-0">
        <button type="button" id="mobile-menu-btn"
                class="lg:hidden p-2 -ml-2 rounded-md hover:bg-slate-100 text-slate-600 focus:outline-none focus:ring-2 focus:ring-[#1A2B56]"
                aria-label="Open student navigation" aria-expanded="false" aria-controls="student-sidebar">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
        <div class="hidden sm:flex items-center min-w-0">
            <span>Student</span>
            <span class="mx-2 text-slate-300">&gt;</span>
            <span class="text-slate-900 font-bold capitalize truncate">{{ $section }}</span>
        </div>
    </div>

    <form action="{{ route('opac.index') }}" method="GET" class="hidden md:block relative w-full max-w-md justify-self-center">
        <label for="student-header-search" class="sr-only">Search the library catalog</label>
        <svg class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
        <input id="student-header-search" name="q" type="search" placeholder="Search the catalog..."
               class="w-full h-9 pl-9 pr-3 rounded-lg border border-slate-200 bg-slate-50 text-sm text-slate-800 placeholder:text-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#1A2B56]/20 focus:border-[#1A2B56]">
    </form>

    <div class="flex items-center justify-end gap-2 sm:gap-4">
        <a href="{{ route('opac.index') }}" class="md:hidden p-2 rounded-lg text-slate-500 hover:text-[#1A2B56] hover:bg-slate-100" aria-label="Search catalog">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </a>

        <div class="hidden xl:block text-right leading-tight">
            <p id="student-live-time" class="text-xs font-bold text-slate-800"></p>
            <p id="student-live-date" class="text-[10px] font-medium text-slate-400"></p>
        </div>

        <a href="{{ route('student.overdue-items.index') }}" class="p-2 rounded-lg text-slate-500 hover:text-[#1A2B56] hover:bg-slate-100" aria-label="View overdue items">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
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

            if (time) time.textContent = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
            if (date) date.textContent = now.toLocaleDateString([], { month: 'short', day: 'numeric', year: 'numeric' });
        };

        updateStudentClock();
        window.setInterval(updateStudentClock, 30000);
    })();
</script>
