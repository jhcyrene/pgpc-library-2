<!DOCTYPE html>
<html lang="en" data-theme="pgpc">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Student Dashboard' }} - PGPC Library System</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link rel="icon" href="{{ Vite::asset('resources/images/hd-pgpc-logo.png') }}">

    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    @vite(['resources/css/welcome.css', 'resources/js/app.js'])
    
</head>
<body class="bg-base-200 min-h-screen flex text-base-content antialiased font-sans overflow-x-hidden">
    
    <!-- Mobile Sidebar Overlay -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden transition-opacity opacity-0" aria-hidden="true"></div>

    <!-- Sidebar Wrapper -->
    <div id="sidebar-wrapper" class="fixed inset-y-0 left-0 z-50 transform -translate-x-full lg:relative lg:translate-x-0 transition-transform duration-300 ease-in-out flex">
        <x-student.sidebar />
    </div>

    <!-- Main Content Wrapper -->
    <div class="flex-1 flex flex-col h-screen w-full lg:w-auto min-w-0 overflow-hidden">
        <x-student.header />
    
        <!-- Content -->
        <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 bg-slate-50 relative">
            
            <!-- Global Flash Messages -->
            @if(session('success'))
            <div class="mb-6 bg-emerald-50 border border-emerald-200 rounded-xl p-4 shadow-sm flex items-start gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6 text-green-700" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <div>
                    <h3 class="font-bold text-green-800">Success!</h3>
                    <div class="text-sm text-green-700">{{ session('success') }}</div>
                </div>
            </div>
            @endif

            @if(session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 rounded-xl p-4 shadow-sm flex items-start gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6 text-red-700" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <div>
                    <h3 class="font-bold text-red-800">Error!</h3>
                    <div class="text-sm text-red-700">{{ session('error') }}</div>
                </div>
            </div>
            @endif

            {{ $slot }}
        </main>
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
            chevron?.classList.toggle('text-[#FFC107]', !expanded);
        }
    </script>

    @stack('scripts')
</body>
</html>
