@php
    $student = Auth::guard('member')->user()->member;
    $initials = strtoupper(substr($student->first_name ?? 'S', 0, 1) . substr($student->last_name ?? '', 0, 1));
@endphp

<aside id="student-sidebar" class="flex h-screen w-56 shrink-0 flex-col overflow-hidden bg-[#1A2B56]">
    <div class="flex h-[60px] shrink-0 items-center border-b border-white/5 px-4">
        <a href="{{ route('student.dashboard') }}" class="group flex min-w-0 items-center gap-3">
            <div class="flex h-8 w-8 shrink-0 items-center justify-center overflow-hidden rounded-full border border-white/20 bg-white">
                <img src="{{ Vite::asset('resources/images/pgpc-logo.jpg') }}" alt="PGPC Logo" class="h-full w-full object-cover">
            </div>
            <div class="min-w-0">
                <p class="truncate text-sm font-bold leading-tight text-white">PGPC Library</p>
                <p class="mt-0.5 text-[10px] font-semibold uppercase tracking-widest text-white/45">Student Portal</p>
            </div>
        </a>
    </div>

    <nav class="flex-1 overflow-y-auto px-3 py-4" aria-label="Student navigation">
        <ul class="space-y-1">
            <x-student.navigation.nav-item
                href="{{ route('student.dashboard') }}"
                icon="<path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z' />"
                label="Dashboard"
                :active="request()->routeIs('student.dashboard')"
            />

            <x-student.navigation.nav-group
                id="borrows-group"
                icon="<path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253' />"
                label="Borrows"
                href="{{ route('student.borrow-transactions.index') }}"
                :active="request()->routeIs('student.borrow-transactions.*')
                    || request()->routeIs('student.overdue-items.*')
                    || request()->routeIs('student.reservations.*')
                    || request()->routeIs('student.saved-items.*')
                    || request()->routeIs('student.fines.*')"
            >
                <x-student.navigation.nav-subitem href="{{ route('student.borrow-transactions.current') }}" label="Current Borrows" :active="request()->routeIs('student.borrow-transactions.current')" />
                <x-student.navigation.nav-subitem href="{{ route('student.borrow-transactions.history') }}" label="Borrow History" :active="request()->routeIs('student.borrow-transactions.history')" />
                <x-student.navigation.nav-subitem href="{{ route('student.overdue-items.index') }}" label="Overdue Items" :active="request()->routeIs('student.overdue-items.index')" />
                <x-student.navigation.nav-subitem href="{{ route('student.reservations.index') }}" label="Reservations" :active="request()->routeIs('student.reservations.*')" />
                <x-student.navigation.nav-subitem href="{{ route('student.saved-items.index') }}" label="Saved Items" :active="request()->routeIs('student.saved-items.*')" />
                <x-student.navigation.nav-subitem href="{{ route('student.fines.index') }}" label="Fines & Penalties" :active="request()->routeIs('student.fines.*')" />
            </x-student.navigation.nav-group>
        </ul>
    </nav>

    <div class="shrink-0 border-t border-white/5 p-2">
        <div class="flex items-center gap-1">
            <a href="{{ route('student.profile.show') }}"
                class="flex min-w-0 flex-1 items-center gap-2 rounded-xl px-2 py-2 transition-colors hover:bg-white/10 {{ request()->routeIs('student.profile.*') ? 'bg-white/10' : '' }}">
                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full {{ !Auth::guard('member')->user()->profile_image ? 'bg-[#FFC107] text-[#1A2B56]' : '' }} text-sm font-black overflow-hidden">
                    @if(Auth::guard('member')->user()->profile_image)
                        <img src="{{ Auth::guard('member')->user()->profile_image }}" alt="Profile" class="w-full h-full object-cover">
                    @else
                        {{ $initials }}
                    @endif
                </div>
                <div class="min-w-0 flex-1">
                    <p class="truncate text-sm font-bold text-white">{{ $student->first_name }} {{ $student->last_name }}</p>
                    <p class="truncate text-[10px] text-slate-400">View profile</p>
                </div>
            </a>

            <a href="{{ route('student.account-settings.edit') }}"
                class="rounded-lg p-2 text-slate-400 transition-colors hover:bg-white/10 hover:text-white {{ request()->routeIs('student.account-settings.*') ? 'bg-white/10 text-white' : '' }}"
                title="Account settings" aria-label="Account settings">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </a>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="rounded-lg p-2 text-slate-400 transition-colors hover:bg-white/10 hover:text-white" title="Log out" aria-label="Log out">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </button>
            </form>
        </div>
    </div>
</aside>
