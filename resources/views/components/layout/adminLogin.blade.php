@props([
    'title' => 'Staff Login',
    'portal' => 'Staff Portal',
    'eyebrow' => 'PGPC Library System',
    'formSide' => 'right',
    'accessLabel' => 'Authorized personnel access',
    'headline' => 'Manage knowledge.',
    'highlight' => 'Empower learning.',
    'description' => 'A secure workspace for library operations, circulation, cataloging, and member services.',
    'features' => ['Cataloging', 'Members', 'Reports'],
    'formWidth' => 'default',
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="pgpc">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#102b70">

    <title>{{ $title }} | PGPC Library</title>
    <link rel="icon" href="{{ Vite::asset('resources/images/hd-pgpc-logo.png') }}">

    @vite(['resources/css/preloader.css', 'resources/js/app.js', 'resources/css/loginauth.css', 'resources/js/loader.js'])
</head>

<body class="min-h-dvh bg-slate-100 font-sans text-slate-900 antialiased">
    <div id="site-preloader" role="status" aria-label="Loading PGPC Library">
        <div class="pgpc-preloader-ring" aria-hidden="true"></div>
        <img src="{{ Vite::asset('resources/images/hd-pgpc-logo.png') }}" alt="PGPC logo" class="pgpc-preloader-logo">
    </div>

    <main id="portal-content"
        class="relative min-h-dvh overflow-hidden lg:grid {{ $formSide === 'left' ? 'lg:grid-cols-[minmax(440px,0.92fr)_minmax(0,1.08fr)]' : 'lg:grid-cols-[minmax(0,1.08fr)_minmax(440px,0.92fr)]' }}">
        <section
            class="relative hidden min-h-dvh overflow-hidden bg-[#102b70] lg:flex lg:flex-col lg:justify-between lg:p-12 xl:p-16 {{ $formSide === 'left' ? 'lg:order-2' : 'lg:order-1' }}">
            <img src="{{ Vite::asset('resources/images/pgpc-ng.png') }}" alt="PGPC library"
                class="absolute inset-0 h-full w-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-br from-[#071943]/95 via-[#102b70]/88 to-[#102b70]/70"></div>
            <div class="absolute -left-24 bottom-20 h-80 w-80 rounded-full border border-white/10"></div>
            <div class="absolute -left-8 bottom-36 h-48 w-48 rounded-full border border-[#fcc719]/25"></div>

            <a href="{{ route('home') }}" class="relative z-10 inline-flex w-fit items-center gap-3 text-white">
                <span
                    class="grid h-12 w-12 place-items-center overflow-hidden rounded-full bg-white shadow-lg ring-4 ring-white/10">
                    <img src="{{ Vite::asset('resources/images/hd-pgpc-logo.png') }}" alt="PGPC logo"
                        class="h-full w-full object-cover">
                </span>
                <span>
                    <span
                        class="block text-xs font-bold uppercase tracking-[0.18em] text-[#fcc719]">{{ $eyebrow }}</span>
                    <span class="block text-base font-semibold">Padre Garcia Polytechnic College</span>
                </span>
            </a>

            <div class="relative z-10 max-w-2xl pb-8">
                <div
                    class="mb-7 inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/10 px-4 py-2 text-sm font-semibold text-white backdrop-blur-sm">
                    <span class="h-2 w-2 rounded-full bg-[#fcc719]"></span>
                    {{ $accessLabel }}
                </div>
                <h1 class="max-w-xl text-5xl font-bold leading-[1.08] tracking-tight text-white xl:text-6xl">
                    {{ $headline }}<br>
                    <span class="text-[#fcc719]">{{ $highlight }}</span>
                </h1>
                <p class="mt-6 max-w-xl text-lg leading-8 text-blue-100/90">
                    {{ $description }}
                </p>

                <div class="mt-10 grid max-w-xl grid-cols-3 gap-3">
                    <div class="rounded-2xl border border-white/10 bg-white/10 p-4 backdrop-blur-sm">
                        <svg class="mb-3 h-6 w-6 text-[#fcc719]" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5A8.5 8.5 0 003 6.253v13A8.5 8.5 0 017.5 18c1.746 0 3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5A8.5 8.5 0 0121 6.253v13A8.5 8.5 0 0016.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        <p class="text-sm font-semibold text-white">{{ $features[0] ?? 'Cataloging' }}</p>
                    </div>
                    <div class="rounded-2xl border border-white/10 bg-white/10 p-4 backdrop-blur-sm">
                        <svg class="mb-3 h-6 w-6 text-[#fcc719]" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <p class="text-sm font-semibold text-white">{{ $features[1] ?? 'Members' }}</p>
                    </div>
                    <div class="rounded-2xl border border-white/10 bg-white/10 p-4 backdrop-blur-sm">
                        <svg class="mb-3 h-6 w-6 text-[#fcc719]" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l3.414 3.414A1 1 0 0117 7.414V19a2 2 0 01-2 2z" />
                        </svg>
                        <p class="text-sm font-semibold text-white">{{ $features[2] ?? 'Reports' }}</p>
                    </div>
                </div>
            </div>

            <p class="relative z-10 text-xs text-blue-100/65">© {{ date('Y') }} PGPC Library. All rights reserved.
            </p>
        </section>

        <section
            class="relative flex min-h-dvh items-center justify-center bg-slate-50 px-5 py-8 sm:px-8 lg:px-12 {{ $formSide === 'left' ? 'lg:order-1' : 'lg:order-2' }}">
            <div
                class="absolute inset-x-0 top-0 h-1.5 bg-gradient-to-r from-[#102b70] via-[#fcc719] to-[#102b70] lg:hidden">
            </div>
            <div class="absolute right-0 top-0 h-64 w-64 rounded-bl-full bg-blue-50/80"></div>
            <div class="relative z-10 w-full {{ $formWidth === 'wide' ? 'max-w-2xl' : 'max-w-md' }}">
                <div class="mb-8 flex items-center justify-between lg:hidden">
                    <a href="{{ route('home') }}"
                        class="inline-flex items-center gap-2 text-sm font-bold text-[#102b70]">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Home
                    </a>
                    <img src="{{ Vite::asset('resources/images/hd-pgpc-logo.png') }}" alt="PGPC logo"
                        class="h-11 w-11 rounded-full shadow-sm">
                </div>

                {{ $slot }}
            </div>
        </section>
    </main>

    <noscript>
        <style>
            #site-preloader {
                display: none
            }

            #portal-content {
                opacity: 1
            }
        </style>
    </noscript>
</body>

</html>

