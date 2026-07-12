<aside id="admin-sidebar" class="w-64 flex flex-col h-screen shrink-0 overflow-hidden bg-[#1A2B56]">

    <!-- Branding / Logo (Added more spacing/height) -->
    <div class="h-[80px] flex items-center px-6 shrink-0 border-b border-white/5">
        <div class="flex items-center gap-4">
            <div class="w-10 h-10 rounded-full border border-white/20 shrink-0 overflow-hidden flex items-center justify-center bg-white">
                <img src="{{ asset('images/pgpc-logo.jpg') }}" alt="PGPC Logo" class="w-full h-full object-cover">
            </div>
            <div class="flex flex-col justify-center">
                <h2 class="text-base font-bold text-white leading-tight">PGPC Library</h2>
                <p class="text-xs text-gray-400 font-medium leading-tight">Admin Panel</p>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <div class="flex-1 overflow-y-auto py-6 px-4 space-y-8">

        <!-- Main Section -->
        <div>
            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-3 px-2">MAIN</p>
            <nav class="space-y-1">
                <!-- Dashboard -->
                <x-admin.partials.navButton route="{{ route('admin.dashboard') }}" label="Dashboard">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-full w-full" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                </x-admin.partials.navButton>

                <!-- Book Management -->
                <x-admin.navigation.nav-group label="Books" :active="request()->routeIs('admin.books.*')">
                    <x-slot:icon>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-full w-full" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </x-slot:icon>
                    
                    <x-admin.navigation.nav-item label="Book Manager" :href="route('admin.books.index')" :active="request()->routeIs('admin.books.index')" />
                    <x-admin.navigation.nav-item label="Add Book" :href="route('admin.books.create')" :active="request()->routeIs('admin.books.create')" />
                    <x-admin.navigation.nav-item label="Quick Add Book" :href="route('admin.books.quick-create')" :active="request()->routeIs('admin.books.quick-create')" />
                    <x-admin.navigation.nav-item label="Batch Add Books" :href="route('admin.books.batch-create')" :active="request()->routeIs('admin.books.batch-create')" />
                </x-admin.navigation.nav-group>

                <!-- Users -->
                <x-admin.navigation.nav-group label="Users" :active="request()->routeIs('admin.users.*') || request()->routeIs('admin.members.*') || request()->routeIs('admin.librarians.*')">
                    <x-slot:icon>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-full w-full" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </x-slot:icon>

                    <!-- User manager routes will be implemented soon -->
                    <x-admin.navigation.nav-item label="All Users" href="/admin/users" :active="request()->routeIs('admin.users.index')" />
                    <x-admin.navigation.nav-item label="Members" href="/admin/users?type=member" :active="request()->fullUrlIs('*type=member*')" />
                    <x-admin.navigation.nav-item label="Librarians" href="/admin/users?type=librarian" :active="request()->fullUrlIs('*type=librarian*')" />
                    <x-admin.navigation.nav-item label="Add Member" href="/admin/members/create" :active="request()->routeIs('admin.members.create')" />
                    <x-admin.navigation.nav-item label="Add Librarian" href="/admin/librarians/create" :active="request()->routeIs('admin.librarians.create')" />
                </x-admin.navigation.nav-group>

                <!-- Circulation -->
                <x-admin.partials.navButton route="/admin/circulation" label="Circulation">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-full w-full" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                    </svg>
                </x-admin.partials.navButton>

                <!-- Borrows -->
                <x-admin.partials.navButton route="/admin/borrows" label="Borrows" badge="24">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-full w-full" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                    </svg>
                </x-admin.partials.navButton>

                <!-- Reservations -->
                <x-admin.partials.navButton route="/admin/reservations" label="Reservations" badge="5" badgeColor="bg-[#3B82F6]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-full w-full" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </x-admin.partials.navButton>

                <!-- Returns -->
                <x-admin.partials.navButton route="/admin/returns" label="Returns">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-full w-full" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                </x-admin.partials.navButton>
            </nav>
        </div>

        <!-- Configuration Section -->
        <div>
            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-3 px-2">CONFIGURATION</p>
            <nav class="space-y-1">
                <x-admin.partials.navButton route="/admin/categories" label="Categories">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-full w-full" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                </x-admin.partials.navButton>

                <x-admin.partials.navButton route="/admin/settings" label="Settings">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-full w-full" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </x-admin.partials.navButton>

                <x-admin.partials.navButton route="/admin/reports" label="Reports">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-full w-full" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </x-admin.partials.navButton>
            </nav>
        </div>

    </div>

    <!-- Bottom Profile Block -->
    <x-admin.partials.botttomProfileBlock />
</aside>
