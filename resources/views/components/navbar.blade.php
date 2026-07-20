@props(['active' => ''])
@php
    $signedInUser = Auth::guard('member')->user();
    $accountType = strtolower((string) ($signedInUser?->account_type ?? ''));
    $dashboardUrl = match (true) {
        in_array($accountType, ['member', 'student'], true) => route('student.dashboard'),
        $accountType === 'librarian' => route('librarian.dashboard'),
        default => route('admin.dashboard'),
    };
@endphp
<style>
    /* Small alpine.js like behavior using simple vanilla js for the scroll effect and mobile menu */
    .scrolled {
        background-color: #102b70 !important;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03) !important;
        padding-top: 0.75rem !important;
        padding-bottom: 0.75rem !important;
    }

    .scrolled .nav-text {
        color: #ffffff !important;
    }

    .scrolled .brand-text {
        color: #ffffff !important;
    }

    .scrolled .menu-icon {
        stroke: #ffffff !important;
    }
</style>

<!-- Interactive Scripts for Navbar -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const header = document.getElementById('main-header');
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');

        // Scroll effect
        window.addEventListener('scroll', () => {
            if (!header) return;

            if (window.scrollY > 20) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });

        // Mobile menu toggle
        if (mobileMenuBtn && mobileMenu) {
            mobileMenuBtn.addEventListener('click', (e) => {
                e.stopPropagation(); // Prevent immediate document click
                mobileMenu.classList.toggle('opacity-0');
                mobileMenu.classList.toggle('scale-y-0');
                mobileMenu.classList.toggle('pointer-events-none');
                mobileMenu.classList.toggle('opacity-100');
                mobileMenu.classList.toggle('scale-y-100');
                mobileMenu.classList.toggle('pointer-events-auto');
            });

            // Close when clicking outside
            document.addEventListener('click', (e) => {
                if (!mobileMenu.contains(e.target) && !mobileMenuBtn.contains(e.target)) {
                    // Check if it's currently open
                    if (!mobileMenu.classList.contains('opacity-0')) {
                        mobileMenu.classList.add('opacity-0', 'scale-y-0', 'pointer-events-none');
                        mobileMenu.classList.remove('opacity-100', 'scale-y-100',
                            'pointer-events-auto');
                    }
                }
            });
        }
    });
</script>


<header id="main-header" class="fixed w-full z-50 transition-all duration-300 {{ $active === 'home' ? 'bg-transparent py-5' : 'bg-[#102b70] py-3 shadow-md' }}">
    <div class="container mx-auto px-6 md:px-12 flex justify-between items-center">
        <!-- Logo & Wordmark -->
        <a href="{{ route('home') }}" class="flex items-center gap-3" aria-label="PGPC Library home">
            <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center overflow-hidden shadow-sm">
                <img src="{{ Vite::asset('resources/images/webp/hd-pgpc-logo.webp') }}" alt="PGPC Logo" class="w-full h-full object-cover"
                    onerror="this.src='https://ui-avatars.com/api/?name=PG&background=fcc719&color=212e5e'" />
            </div>
            <span class="brand-text font-bold text-lg hidden sm:block text-white transition-colors">
                Padre Garcia Polytechnic College
            </span>
        </a>

        <!-- Desktop Nav (Aligned with Login design style buttons) -->
        <nav class="hidden md:flex items-center gap-8">
            <a href="{{ route('home') }}" class="nav-text font-medium transition-colors hover:text-gold {{ $active === 'home' ? 'text-gold' : 'text-gray-100' }}">Home</a>
            <a href="{{ route('opac.index') }}" class="nav-text font-medium transition-colors hover:text-gold {{ $active === 'opac' ? 'text-gold' : 'text-gray-100' }}">OPAC</a>
            <a href="{{ route('home') }}#contact" class="nav-text font-medium transition-colors hover:text-gold text-gray-100">Contact</a>

            <div class="flex items-center gap-3">
                @if($signedInUser)
                    <a href="{{ $dashboardUrl }}" class="px-5 py-2.5 rounded-full bg-[#fcc719] text-[#102b70] font-bold hover:bg-[#ffd84c] hover:shadow-md transition-all duration-300">Dashboard</a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="px-5 py-2.5 rounded-full border border-white/20 text-white font-semibold hover:bg-white hover:text-[#102b70] hover:border-white transition-all duration-300 cursor-pointer">Log out</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="px-5 py-2.5 rounded-full border border-white/20 text-white font-semibold hover:bg-white hover:text-[#102b70] hover:border-white transition-all duration-300">Log in</a>
                    <a href="{{ route('register') }}" class="px-5 py-2.5 rounded-full bg-[#fcc719] text-[#102b70] font-bold hover:bg-[#ffd84c] hover:shadow-md transition-all duration-300">Register</a>
                @endif
            </div>
        </nav>

        <!-- Mobile Menu Toggle -->
        <button id="mobile-menu-btn" class="md:hidden btn btn-ghost btn-circle">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 menu-icon text-white transition-colors"
                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>

    <!-- Mobile Dropdown Panel -->
    <div id="mobile-menu"
        class="absolute top-full left-0 w-full bg-[#102b70]/95 backdrop-blur-md shadow-elegant py-4 px-6 flex flex-col gap-4 md:hidden transition-all duration-300 transform origin-top opacity-0 scale-y-0 pointer-events-none">
        <a href="{{ route('home') }}"
            class="{{ $active === 'home' ? 'text-white font-bold' : 'text-gray-300 hover:text-gold' }} font-medium py-2 border-b border-white/10 transition-colors">Home</a>
        <a href="{{ route('opac.index') }}"
            class="{{ $active === 'opac' ? 'text-white font-bold' : 'text-gray-300 hover:text-gold' }} font-medium py-2 border-b border-white/10 transition-colors">OPAC</a>
        <a href="{{ route('home') }}#categories"
            class="text-gray-300 hover:text-gold font-medium py-2 border-b border-white/10 transition-colors">Categories</a>
        <a href="{{ route('home') }}#about"
            class="text-gray-300 hover:text-gold font-medium py-2 border-b border-white/10 transition-colors">About</a>
        <a href="{{ route('home') }}#contact"
            class="text-gray-300 hover:text-gold font-medium py-2 border-b border-white/10 transition-colors">Contact</a>
        <div class="flex flex-col gap-3 mt-4">
            @if($signedInUser)
                <a href="{{ $dashboardUrl }}" class="px-5 py-3 rounded-xl bg-[#fcc719] text-[#102b70] font-bold text-center hover:bg-[#ffd84c] transition-all duration-300">Dashboard</a>
                <form action="{{ route('logout') }}" method="POST" class="w-full">
                    @csrf
                    <button type="submit" class="w-full px-5 py-3 rounded-xl border border-white/20 text-white font-semibold hover:bg-white hover:text-[#102b70] hover:border-white transition-all duration-300">Log out</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="px-5 py-3 rounded-xl border border-white/20 text-white font-semibold text-center hover:bg-white hover:text-[#102b70] hover:border-white transition-all duration-300">Log in</a>
                <a href="{{ route('register') }}" class="px-5 py-3 rounded-xl bg-[#fcc719] text-[#102b70] font-bold text-center hover:bg-[#ffd84c] hover:shadow-md transition-all duration-300">Register</a>
            @endif
        </div>
    </div>
</header>
