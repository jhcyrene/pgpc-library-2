@props([
    'title' => 'Complete Your Profile',
    'subtitle' => 'Student Account Onboarding',
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="pgpc">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#071943">

    <title>{{ $title }} | PGPC Library System</title>
    <link rel="icon" href="{{ Vite::asset('resources/images/webp/hd-pgpc-logo.webp') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">

    @vite(['resources/css/preloader.css', 'resources/js/ajax-auth.js', 'resources/css/loginauth.css', 'resources/js/app.js', 'resources/js/loader.js'])
</head>

<body class="min-h-dvh bg-slate-900 font-sans text-slate-800 antialiased flex flex-col justify-between relative overflow-x-hidden selection:bg-[#fcc719] selection:text-[#071943]" id="portal-content">
    
    <!-- Site Preloader -->
    <div id="site-preloader" role="status" aria-label="Loading PGPC Library">
        <div class="pgpc-preloader-ring" aria-hidden="true"></div>
        <img src="{{ Vite::asset('resources/images/webp/hd-pgpc-logo.webp') }}" alt="PGPC logo" class="pgpc-preloader-logo">
    </div>

    <!-- Fullscreen Hero Backdrop Image & Gradient -->
    <div class="fixed inset-0 z-0 bg-cover bg-center bg-fixed opacity-30 pointer-events-none"
         style="background-image: url('{{ Vite::asset('resources/images/webp/pgpc-ng.webp') }}')"></div>
    <div class="fixed inset-0 z-0 bg-gradient-to-br from-[#040d21]/95 via-[#071943]/90 to-[#0a1b42]/95 backdrop-blur-md pointer-events-none"></div>

    <!-- Decorative Glow Orbs -->
    <div class="fixed -top-40 -left-40 w-96 h-96 rounded-full bg-[#102b70]/40 blur-3xl pointer-events-none"></div>
    <div class="fixed -bottom-40 -right-40 w-96 h-96 rounded-full bg-[#fcc719]/10 blur-3xl pointer-events-none"></div>

    <!-- TOP ONBOARDING BAR -->
    <header class="relative z-20 w-full border-b border-white/10 bg-[#071943]/60 backdrop-blur-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            
            <!-- Left: Logo & Portal Badge -->
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <div class="w-9 h-9 rounded-full bg-white p-0.5 shadow-md flex items-center justify-center shrink-0 ring-2 ring-white/20 group-hover:scale-105 transition-transform">
                    <img src="{{ Vite::asset('resources/images/webp/hd-pgpc-logo.webp') }}" alt="PGPC Seal" class="w-full h-full object-contain" />
                </div>
                <div>
                    <span class="block text-xs font-black uppercase tracking-wider text-white leading-none">PGPC LIBRARY SYSTEM</span>
                    <span class="block text-[9px] font-extrabold text-[#fcc719] uppercase tracking-wider mt-0.5 leading-none">{{ $subtitle }}</span>
                </div>
            </a>

            <!-- Right: Action Navigation (Logout / Return to Login) -->
            <div class="flex items-center gap-3">
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl bg-white/10 hover:bg-white/20 border border-white/15 text-xs font-bold text-slate-200 hover:text-white transition-all backdrop-blur-sm">
                        <svg class="w-3.5 h-3.5 text-[#fcc719]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span>Sign Out</span>
                    </button>
                </form>
            </div>

        </div>
    </header>

    <!-- MAIN ONBOARDING WORKSPACE CONTAINER -->
    <main class="relative z-10 flex-1 flex flex-col justify-center py-6 sm:py-10 px-4 sm:px-6 lg:px-8">
        {{ $slot }}
    </main>

    <!-- FOOTER -->
    <footer class="relative z-20 py-4 text-center border-t border-white/10 bg-[#040d21]/40 backdrop-blur-md">
        <p class="text-xs font-semibold text-slate-400">
            &copy; {{ date('Y') }} Padre Garcia Polytechnic College Library System. All rights reserved.
        </p>
    </footer>

    <noscript>
        <style>
            #site-preloader { display: none; }
            #portal-content { opacity: 1; }
        </style>
    </noscript>
</body>

</html>
