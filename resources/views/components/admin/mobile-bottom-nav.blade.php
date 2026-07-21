@php
    $staffAccountType = strtolower((string) Auth::guard('member')->user()?->account_type);
    $isAdministrator = in_array($staffAccountType, ['administrator', 'admin'], true);
    $dashboardRoute = $isAdministrator ? route('admin.dashboard') : route('librarian.dashboard');
    $usersRoute = $isAdministrator ? route('admin.users.index') : route('librarian.settings.index');
@endphp

<!-- Mobile Bottom Navigation Bar (Visible only on mobile/tablet screens < lg breakpoint) -->
<nav class="lg:hidden fixed bottom-0 inset-x-0 z-40 bg-[#102b70] text-white border-t border-white/10 shadow-2xl flex items-center justify-around h-16 px-1">
    
    <!-- 1. Dashboard -->
    <a href="{{ $dashboardRoute }}" 
       class="flex flex-col items-center justify-center flex-1 py-1.5 transition-colors relative {{ request()->routeIs('admin.dashboard') || request()->routeIs('librarian.dashboard') ? 'text-[#fcc719] font-bold' : 'text-slate-300 hover:text-white' }}">
        @if(request()->routeIs('admin.dashboard') || request()->routeIs('librarian.dashboard'))
            <span class="absolute top-0 w-8 h-0.5 rounded-full bg-[#fcc719]"></span>
        @endif
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mb-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
        </svg>
        <span class="text-[11px] leading-none tracking-tight">Dashboard</span>
    </a>

    <!-- 2. Circulation -->
    <a href="{{ route('admin.circulation.index') }}" 
       class="flex flex-col items-center justify-center flex-1 py-1.5 transition-colors relative {{ request()->routeIs('admin.circulation.*') ? 'text-[#fcc719] font-bold' : 'text-slate-300 hover:text-white' }}">
        @if(request()->routeIs('admin.circulation.*'))
            <span class="absolute top-0 w-8 h-0.5 rounded-full bg-[#fcc719]"></span>
        @endif
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mb-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
        </svg>
        <span class="text-[11px] leading-none tracking-tight">Circulation</span>
    </a>

    <!-- 3. Books -->
    <a href="{{ route('admin.books.index') }}" 
       class="flex flex-col items-center justify-center flex-1 py-1.5 transition-colors relative {{ request()->routeIs('admin.books.*') || request()->routeIs('admin.book-copies.*') ? 'text-[#fcc719] font-bold' : 'text-slate-300 hover:text-white' }}">
        @if(request()->routeIs('admin.books.*') || request()->routeIs('admin.book-copies.*'))
            <span class="absolute top-0 w-8 h-0.5 rounded-full bg-[#fcc719]"></span>
        @endif
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mb-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
        </svg>
        <span class="text-[11px] leading-none tracking-tight">Books</span>
    </a>

    <!-- 4. Users -->
    <a href="{{ $usersRoute }}" 
       class="flex flex-col items-center justify-center flex-1 py-1.5 transition-colors relative {{ request()->routeIs('admin.users.*') || request()->routeIs('admin.members.*') || request()->routeIs('admin.librarians.*') ? 'text-[#fcc719] font-bold' : 'text-slate-300 hover:text-white' }}">
        @if(request()->routeIs('admin.users.*') || request()->routeIs('admin.members.*') || request()->routeIs('admin.librarians.*'))
            <span class="absolute top-0 w-8 h-0.5 rounded-full bg-[#fcc719]"></span>
        @endif
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mb-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
        </svg>
        <span class="text-[11px] leading-none tracking-tight">Users</span>
    </a>

    <!-- 5. More -->
    <button type="button" 
            onclick="openSidebar()" 
            class="flex flex-col items-center justify-center flex-1 py-1.5 text-slate-300 hover:text-white transition-colors focus:outline-none">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mb-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
        </svg>
        <span class="text-[11px] leading-none tracking-tight">More</span>
    </button>
</nav>
