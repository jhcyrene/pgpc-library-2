@php
    $staffAccountType = strtolower((string) Auth::guard('member')->user()?->account_type);
    $isAdministrator = in_array($staffAccountType, ['administrator', 'admin'], true);
    $staffDashboardRoute = $isAdministrator ? route('admin.dashboard') : route('librarian.dashboard');
@endphp

<aside id="admin-sidebar" class="w-64 flex flex-col h-screen shrink-0 overflow-hidden bg-[#1A2B56]">

    <!-- Branding / Logo -->
    <div class="h-[60px] flex items-center px-6 shrink-0 border-b border-white/5">
        <a href="{{ $staffDashboardRoute }}" class="flex items-center gap-4">
            <div class="w-8 h-8 rounded-full border border-white/20 shrink-0 overflow-hidden flex items-center justify-center bg-white">
                <img src="{{ Vite::asset('resources/images/pgpc-logo.jpg') }}" alt="PGPC Logo" class="w-full h-full object-cover">
            </div>
            <div class="flex flex-col justify-center">
                <h2 class="text-sm font-bold text-white leading-tight">PGPC Library</h2>
            </div>
        </a>
    </div>

    <!-- Navigation -->
    <div class="flex-1 overflow-y-auto py-4 px-3 space-y-1">

        <x-admin.navigation.nav-item 
            label="Dashboard" 
            :href="$staffDashboardRoute"
            :active="request()->routeIs('admin.dashboard') || request()->routeIs('librarian.dashboard')"
        >
            <x-slot:icon>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-full w-full" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>
            </x-slot:icon>
        </x-admin.navigation.nav-item>

        <x-admin.navigation.nav-section label="Catalog" />

        <x-admin.navigation.nav-group 
            label="Books" 
            :href="route('admin.books.index')"
            :active="request()->routeIs('admin.books.*') || request()->routeIs('admin.book-copies.*')"
            id="nav-group-books"
        >
            <x-slot:icon>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-full w-full" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </x-slot:icon>
            
            <x-admin.navigation.nav-subitem label="Book Manager" :href="route('admin.books.index')" :active="request()->routeIs('admin.books.index')" />
            <x-admin.navigation.nav-subitem label="Add Book" :href="route('admin.books.create')" :active="request()->routeIs('admin.books.create')" />
            <x-admin.navigation.nav-subitem label="Quick Add Book" :href="route('admin.books.quick-create')" :active="request()->routeIs('admin.books.quick-create')" />
            <x-admin.navigation.nav-subitem label="Batch Add Books" :href="route('admin.books.batch-create')" :active="request()->routeIs('admin.books.batch-create')" />
            <x-admin.navigation.nav-subitem label="Import MARC Records" :href="route('admin.books.marc-create')" :active="request()->routeIs('admin.books.marc-*')" />
        </x-admin.navigation.nav-group>

        <!-- Unimplemented Reservations -->
        <x-admin.navigation.nav-item label="Reservations" badge="Coming soon" badgeColor="bg-gray-600" disabled>
            <x-slot:icon>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-full w-full" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </x-slot:icon>
        </x-admin.navigation.nav-item>

        <x-admin.navigation.nav-section label="Circulation" />

        <x-admin.navigation.nav-group 
            label="Circulation" 
            :active="false"
            id="nav-group-circulation"
            disabled
        >
            <x-slot:icon>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-full w-full" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                </svg>
            </x-slot:icon>
            
            <x-admin.navigation.nav-subitem label="Circulation Desk (Coming soon)" disabled />
            <x-admin.navigation.nav-subitem label="Check-out (Coming soon)" disabled />
            <x-admin.navigation.nav-subitem label="Check-in (Coming soon)" disabled />
            <x-admin.navigation.nav-subitem label="Renew (Coming soon)" disabled />
        </x-admin.navigation.nav-group>

        @if($isAdministrator)
        <x-admin.navigation.nav-section label="Users" />

        <x-admin.navigation.nav-group 
            label="Users" 
            :href="route('admin.users.index')"
            :active="request()->routeIs('admin.users.*') || request()->routeIs('admin.members.*') || request()->routeIs('admin.librarians.*')"
            id="nav-group-users"
        >
            <x-slot:icon>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-full w-full" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </x-slot:icon>

            <x-admin.navigation.nav-subitem label="User Management" :href="route('admin.users.index')" :active="request()->routeIs('admin.users.index')" />
            <x-admin.navigation.nav-subitem label="Members" :href="route('admin.users.index', ['type' => 'member'])" :active="request()->fullUrlIs('*type=member*')" />
            <x-admin.navigation.nav-subitem label="Librarians" :href="route('admin.users.index', ['type' => 'librarian'])" :active="request()->fullUrlIs('*type=librarian*')" />
            <x-admin.navigation.nav-subitem label="Add Member" :href="route('admin.members.create')" :active="request()->routeIs('admin.members.create')" />
            <x-admin.navigation.nav-subitem label="Add Librarian" :href="route('admin.librarians.create')" :active="request()->routeIs('admin.librarians.create')" />
        </x-admin.navigation.nav-group>
        @endif

        <x-admin.navigation.nav-section label="System" />
        
        <x-admin.navigation.nav-item label="Reports" badge="Coming soon" badgeColor="bg-gray-600" disabled>
            <x-slot:icon>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-full w-full" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </x-slot:icon>
        </x-admin.navigation.nav-item>

        <x-admin.navigation.nav-item label="Settings" badge="Coming soon" badgeColor="bg-gray-600" disabled>
            <x-slot:icon>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-full w-full" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </x-slot:icon>
        </x-admin.navigation.nav-item>

    </div>

    <!-- Bottom Profile Block -->
    <x-admin.partials.botttomProfileBlock />
</aside>
