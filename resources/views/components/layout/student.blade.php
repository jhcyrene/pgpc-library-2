<!DOCTYPE html>
<html lang="en" data-theme="pgpc">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Student Dashboard' }} - PGPC Library System</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link rel="icon" href="{{ Vite::asset('resources/images/webp/hd-pgpc-logo.webp') }}">
    <tallstackui:script /> 
    @livewireStyles
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    @vite(['resources/css/preloader.css', 'resources/css/welcome.css', 'resources/js/app.js', 'resources/js/loader.js'])
    
</head>
<body class="bg-[#102b70] lg:bg-base-200 min-h-dvh flex text-base-content antialiased font-sans overflow-x-hidden">

    <x-preloader />
    
    <div id="portal-content" class="flex-1 flex min-h-dvh overflow-hidden w-full relative">
        <!-- Mobile Sidebar Overlay -->
        <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden transition-opacity opacity-0" aria-hidden="true"></div>

        <!-- Sidebar Wrapper — full width on mobile, auto on desktop -->
        <div id="sidebar-wrapper" class="fixed inset-y-0 left-0 z-50 w-full lg:w-auto transform -translate-x-full lg:relative lg:translate-x-0 transition-transform duration-300 ease-in-out flex">
            <x-student.sidebar />
        </div>

        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col h-dvh w-full lg:w-auto min-w-0 overflow-hidden bg-[#102b70] lg:bg-transparent">
            <x-student.header />
        
            <!-- Content -->
            <main class="portal-main flex-1 min-w-0 w-full overflow-y-auto p-4 pb-24 sm:p-6 lg:p-8 lg:pb-8 bg-slate-50 relative">
                
                <!-- Global Flash Messages -->
                @if(session('success'))
                    <x-alert type="success" message="{{ session('success') }}" class="mb-6" />
                @endif

                @if(session('error'))
                    <x-alert type="error" message="{{ session('error') }}" class="mb-6" />
                @endif

                {{ $slot }}
            </main>
        </div>

        <!-- Mobile Bottom Navigation -->
        <div class="lg:hidden fixed bottom-0 left-0 right-0 bg-[#102b70] border-t border-white/10 z-40 flex items-center justify-around py-3 px-4 shadow-xl pb-safe">
            <a href="{{ route('student.dashboard') }}" class="flex flex-col items-center gap-1 text-[10px] font-bold {{ request()->routeIs('student.dashboard') ? 'text-[#fcc719]' : 'text-white/60 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                Dashboard
            </a>
            <a href="{{ route('student.borrow-transactions.current') }}" class="flex flex-col items-center gap-1 text-[10px] font-bold {{ request()->routeIs('student.borrow-transactions.*') ? 'text-[#fcc719]' : 'text-white/60 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                My Borrows
            </a>
            <a href="{{ route('student.reservations.index') }}" class="flex flex-col items-center gap-1 text-[10px] font-bold {{ request()->routeIs('student.reservations.*') ? 'text-[#fcc719]' : 'text-white/60 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                Reservations
            </a>
            <a href="{{ route('student.profile.show') }}" class="flex flex-col items-center gap-1 text-[10px] font-bold {{ request()->routeIs('student.profile.*') ? 'text-[#fcc719]' : 'text-white/60 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM4 21a8 8 0 0116 0" /></svg>
                Profile
            </a>
        </div>
    </div>
    
    <script>
        // Mobile Sidebar Toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const sidebarWrapper = document.getElementById('sidebar-wrapper');
        const sidebarOverlay = document.getElementById('sidebar-overlay');

        function openSidebar() {
            sidebarWrapper.classList.remove('-translate-x-full');
            sidebarOverlay.classList.remove('hidden');
            setTimeout(() => {
                sidebarOverlay.classList.remove('opacity-0');
            }, 10);
            document.body.classList.add('overflow-hidden');
            if (mobileMenuBtn) {
                mobileMenuBtn.setAttribute('aria-expanded', 'true');
            }
        }

        function closeSidebar() {
            sidebarWrapper.classList.add('-translate-x-full');
            sidebarOverlay.classList.add('opacity-0');
            setTimeout(() => {
                sidebarOverlay.classList.add('hidden');
            }, 300);
            document.body.classList.remove('overflow-hidden');
            if (mobileMenuBtn) {
                mobileMenuBtn.setAttribute('aria-expanded', 'false');
                mobileMenuBtn.focus();
            }
        }

        if (mobileMenuBtn) {
            mobileMenuBtn.addEventListener('click', () => {
                if (sidebarWrapper.classList.contains('-translate-x-full')) {
                    openSidebar();
                } else {
                    closeSidebar();
                }
            });
        }

        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', closeSidebar);
        }

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !sidebarWrapper.classList.contains('-translate-x-full')) {
                closeSidebar();
            }
        });

        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024 && !sidebarWrapper.classList.contains('-translate-x-full')) {
                closeSidebar();
            }
        });

        function toggleStudentNavGroup(groupId) {
            const button = document.querySelector(`button[aria-controls="${groupId}"]`);
            const submenu = document.getElementById(groupId);
            const chevron = document.getElementById(`${groupId}-chevron`);

            if (!button || !submenu) return;

            const expanded = button.getAttribute('aria-expanded') === 'true';
            button.setAttribute('aria-expanded', expanded ? 'false' : 'true');
            submenu.classList.toggle('max-h-0', expanded);
            submenu.classList.toggle('opacity-0', expanded);
            submenu.classList.toggle('max-h-96', !expanded);
            submenu.classList.toggle('opacity-100', !expanded);
            chevron?.classList.toggle('rotate-90', !expanded);
            chevron?.classList.toggle('text-[#fcc719]', !expanded);
        }
    </script>

    @stack('scripts')
</body>
</html>
