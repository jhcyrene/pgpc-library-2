@props(['active' => ''])
    <style>
        /* Small alpine.js like behavior using simple vanilla js for the scroll effect and mobile menu */
        .scrolled {
            background-color: var(--color-primaryfade) !important;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03) !important;
            padding-top: 0.75rem !important;
            padding-bottom: 0.75rem !important;
        }
        .scrolled .nav-text { color: #ffffff !important; }
        .scrolled .brand-text { color: #ffffff !important; }
        .scrolled .menu-icon { stroke: var(--color-primary) !important; }
    </style>


<header id="main-header" class="fixed w-full z-50 transition-all duration-300 bg-transparent py-5">
        <div class="container mx-auto px-6 md:px-12 flex justify-between items-center">
            <!-- Logo & Wordmark -->
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center overflow-hidden shadow-sm">
                    <img src="/images/pgpc-logo.jpg" alt="PGPC Logo" class="w-full h-full object-cover" onerror="this.src='https://ui-avatars.com/api/?name=PG&background=fcc719&color=212e5e'" />
                </div>
                <span class="brand-text font-bold text-lg hidden sm:block text-white transition-colors">
                    Padre Garcia Polytechnic College
                </span>
            </div>

            <!-- Desktop Nav -->
            <nav class="hidden md:flex items-center gap-8">
                <a href="#" class="nav-text font-medium transition-colors hover:text-accent text-gray-100">Home</a>
                <a href="#categories" class="nav-text font-medium transition-colors hover:text-accent text-gray-100">Categories</a>
                <a href="#about" class="nav-text font-medium transition-colors hover:text-accent text-gray-100">About</a>
                <a href="#contact" class="nav-text font-medium transition-colors hover:text-accent text-gray-100">Contact</a>

                <button class="btn btn-login">
                    Log in
                </button>
            </nav>

            <!-- Mobile Menu Toggle -->
            <button id="mobile-menu-btn" class="md:hidden btn btn-ghost btn-circle">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 menu-icon text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <!-- Mobile Dropdown Panel -->
        <div id="mobile-menu" class="hidden absolute top-full left-0 w-full bg-white shadow-elegant py-4 px-6 flex-col gap-4 md:hidden">
            <a href="/" class="{{ $active === 'home' ? 'text-gray-900' : 'text-gray-400 hover:text-gray-700' }} font-medium py-2 border-b border-gray-100 transition-colors">Home</a>
            <a href="#categories" class="text-gray-800 font-medium py-2 border-b border-gray-100">Categories</a>
            <a href="#about" class="text-gray-800 font-medium py-2 border-b border-gray-100">About</a>
            <a href="#contact" class="text-gray-800 font-medium py-2 border-b border-gray-100">Contact</a>
            <button class="btn btn-login">
                Log in
            </button>
        </div>
    </header>
