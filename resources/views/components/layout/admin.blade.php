<!DOCTYPE html>
<html lang="en" data-theme="pgpc">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ in_array(strtolower((string) Auth::guard('member')->user()?->account_type), ['administrator', 'admin'], true) ? 'Admin' : 'Librarian' }} Dashboard - PGPC Library System</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link rel="icon" href="{{ Vite::asset('resources/images/hd-pgpc-logo.png') }}">

    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    @vite(['resources/css/preloader.css', 'resources/css/welcome.css', 'resources/js/app.js', 'resources/js/loader.js'])

    

</head>
<body class="bg-base-200 min-h-dvh flex text-base-content antialiased font-sans overflow-x-hidden relative" id="portal-content">

    {{-- <x-preloader /> --}}
    <div id="site-preloader" role="status" aria-label="Loading PGPC Library">
        <div class="pgpc-preloader-ring" aria-hidden="true"></div>
        <img src="{{ Vite::asset('resources/images/hd-pgpc-logo.png') }}" alt="PGPC logo" class="pgpc-preloader-logo">
    </div>

    <!-- Watermark Background -->
    <div class="fixed inset-0 z-0 pointer-events-none flex items-center justify-center overflow-hidden opacity-5">
        <img src="{{ Vite::asset('resources/images/hd-pgpc-logo.png') }}" class="w-full max-w-3xl object-contain grayscale" alt="Watermark">
    </div>
    
    <!-- Mobile Sidebar Overlay -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden transition-opacity opacity-0" aria-hidden="true"></div>

    <!-- Sidebar Wrapper -->
    <div id="sidebar-wrapper" class="fixed inset-y-0 left-0 z-50 transform -translate-x-full lg:relative lg:translate-x-0 transition-transform duration-300 ease-in-out flex">
        <x-admin.sidebar />
    </div>

    <!-- Main Content Wrapper -->
    <div class="flex-1 flex flex-col h-dvh w-full lg:w-auto min-w-0 relative z-10">
        <x-admin.header />
    
        <!-- Content -->
        <main class="portal-main flex-1 min-w-0 w-full overflow-y-auto px-3 py-4 sm:px-5 lg:px-7">
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
            // small delay to allow display:block to apply before animating opacity
            setTimeout(() => {
                sidebarOverlay.classList.remove('opacity-0');
            }, 10);
            document.body.classList.add('overflow-hidden');
            mobileMenuBtn.setAttribute('aria-expanded', 'true');
        }

        function closeSidebar() {
            sidebarWrapper.classList.add('-translate-x-full');
            sidebarOverlay.classList.add('opacity-0');
            setTimeout(() => {
                sidebarOverlay.classList.add('hidden');
            }, 300); // match transition duration
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

        // Close on Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !sidebarWrapper.classList.contains('-translate-x-full')) {
                closeSidebar();
            }
        });

        // Close on window resize if moving to desktop
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024 && !sidebarWrapper.classList.contains('-translate-x-full')) {
                closeSidebar();
            }
        });

        function toggleNavGroup(groupId) {
            const button = document.querySelector(`button[aria-controls="${groupId}"]`);
            if (!button) return;

            const expanded = button.getAttribute('aria-expanded') === 'true';
            button.setAttribute('aria-expanded', !expanded);
            
            const chevron = document.getElementById(`${groupId}-chevron`);
            if (chevron) {
                if (expanded) {
                    chevron.classList.remove('rotate-90');
                } else {
                    chevron.classList.add('rotate-90');
                }
            }
            
            const submenu = document.getElementById(groupId);
            if (submenu) {
                if (expanded) {
                    submenu.classList.remove('max-h-96', 'opacity-100');
                    submenu.classList.add('max-h-0', 'opacity-0');
                } else {
                    submenu.classList.remove('max-h-0', 'opacity-0');
                    submenu.classList.add('max-h-96', 'opacity-100');
                }
            }
        }
    </script>

    @stack('scripts')
</body>
</html>

