<!-- Welcome Hero -->
<section class="relative flex min-h-[100dvh] w-full items-center justify-center overflow-hidden bg-[#102b70] pb-16 pt-24 lg:pb-20 lg:pt-28">
    <div
        class="absolute inset-0 bg-cover bg-center"
        style="background-image: url('{{ Vite::asset('resources/images/webp/pgpc-ng.webp') }}')"
        aria-hidden="true"
    ></div>
    <div class="absolute inset-0 bg-gradient-to-br from-[#071943]/95 via-[#102b70]/88 to-[#102b70]/70" aria-hidden="true"></div>
    
    <!-- Decorative Glowing Circles (Matching Login Panel) -->
    <div class="absolute -right-24 -top-20 h-80 w-80 rounded-full border border-white/10 pointer-events-none"></div>
    <div class="absolute -left-12 bottom-12 h-64 w-64 rounded-full border border-[#fcc719]/25 pointer-events-none"></div>
    <div class="absolute -left-20 bottom-8 h-80 w-80 rounded-full border border-white/5 pointer-events-none"></div>

    <div class="container relative z-10 mx-auto px-6 md:px-12">
        <div class="grid min-w-0 items-center gap-12 lg:grid-cols-[minmax(0,1.2fr)_minmax(320px,0.8fr)] lg:gap-16 xl:gap-20">
            <!-- Main system introduction -->
            <div class="min-w-0 w-full max-w-2xl text-center lg:text-left">
                <div class="mb-5 inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/10 px-4 py-2 text-xs font-bold uppercase tracking-[0.18em] text-white backdrop-blur-sm">
                    <svg class="h-5 w-5 text-[#fcc719]" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5A8.5 8.5 0 003 6.253v13A8.5 8.5 0 017.5 18c1.746 0 3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5A8.5 8.5 0 0121 6.253v13A8.5 8.5 0 0016.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    PGPC Library
                </div>

                <h1 class="text-4xl font-bold leading-[1.08] tracking-tight text-white drop-shadow-md sm:text-5xl lg:text-6xl">
                    PGPC Library <span class="text-[#fcc719]">System</span>
                </h1>

                <p class="mx-auto mt-6 max-w-2xl text-base font-medium leading-7 text-blue-50/95 sm:text-lg lg:mx-0">
                    Search the catalog, check book availability, reserve library resources, and keep track of your borrow transactions in one place.
                </p>

                <div class="mt-8 flex w-full flex-col items-stretch justify-center gap-3 sm:w-auto sm:flex-row sm:items-center lg:justify-start">
                    <a
                        href="{{ route('opac.index') }}"
                        class="btn h-auto min-h-12 w-full rounded-full border-none bg-[#fcc719] px-6 py-3 font-bold text-[#102b70] shadow-md transition-all duration-300 hover:-translate-y-0.5 hover:bg-[#ffd84c] sm:w-auto"
                    >
                        <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.25" d="M21 21l-4.35-4.35m1.35-5.65a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Browse Catalog
                    </a>

                    <a
                        href="{{ route('login') }}"
                        class="btn h-auto min-h-12 w-full rounded-full border-2 border-white/70 bg-white/10 px-6 py-3 font-bold text-white backdrop-blur-sm transition-all duration-300 hover:-translate-y-0.5 hover:border-[#fcc719] hover:bg-[#fcc719] hover:text-[#102b70] sm:w-auto"
                    >
                        <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.25" d="M15 8a3 3 0 11-6 0 3 3 0 016 0zm-9 11a6 6 0 0112 0M19 8v6m3-3h-6" />
                        </svg>
                        Student Login
                    </a>
                </div>
            </div>

            <!-- Library Services Information Panel (Matching Login Translucent features theme) -->
            <div id="about" class="min-w-0 scroll-mt-28 lg:w-full lg:justify-self-end">
                <div class="min-w-0 overflow-hidden rounded-2xl border border-white/10 bg-white/10 shadow-xl backdrop-blur-md">
                    <!-- Panel header -->
                    <div class="flex items-center justify-between border-b border-white/10 px-5 py-4 sm:px-6">
                        <h2 class="text-lg font-bold text-white sm:text-xl">Library Services</h2>
                        <span class="rounded-full bg-[#fcc719] px-3 py-1 text-[10px] font-bold uppercase tracking-wider text-[#102b70]">Student Services</span>
                    </div>

                    <!-- Service rows -->
                    <div class="divide-y divide-white/[0.06] px-5 sm:px-6">
                        <!-- Search the catalog -->
                        <div class="flex items-start gap-4 py-4">
                            <span class="mt-0.5 grid h-10 w-10 shrink-0 place-items-center rounded-xl bg-white/10 text-[#fcc719]">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-4.35-4.35m1.35-5.65a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                                </svg>
                            </span>
                            <div class="min-w-0">
                                <h3 class="text-sm font-bold text-white">Search the Catalog</h3>
                                <p class="mt-0.5 text-xs leading-relaxed text-blue-100/70">Find books, journals, and resources by title, author, or subject.</p>
                            </div>
                        </div>

                        <!-- Check availability -->
                        <div class="flex items-start gap-4 py-4">
                            <span class="mt-0.5 grid h-10 w-10 shrink-0 place-items-center rounded-xl bg-white/10 text-[#fcc719]">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </span>
                            <div class="min-w-0">
                                <h3 class="text-sm font-bold text-white">Check Availability</h3>
                                <p class="mt-0.5 text-xs leading-relaxed text-blue-100/70">See which items are available before your visit to the library.</p>
                            </div>
                        </div>

                        <!-- Reserve items -->
                        <div class="flex items-start gap-4 py-4">
                            <span class="mt-0.5 grid h-10 w-10 shrink-0 place-items-center rounded-xl bg-white/10 text-[#fcc719]">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                                </svg>
                            </span>
                            <div class="min-w-0">
                                <h3 class="text-sm font-bold text-white">Reserve Items</h3>
                                <p class="mt-0.5 text-xs leading-relaxed text-blue-100/70">Place holds on books and materials you need for your studies.</p>
                            </div>
                        </div>

                        <!-- View borrowing transactions -->
                        <div class="flex items-start gap-4 py-4">
                            <span class="mt-0.5 grid h-10 w-10 shrink-0 place-items-center rounded-xl bg-white/10 text-[#fcc719]">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                </svg>
                            </span>
                            <div class="min-w-0">
                                <h3 class="text-sm font-bold text-white">View Transactions</h3>
                                <p class="mt-0.5 text-xs leading-relaxed text-blue-100/70">Track your borrowing history, due dates, and return status.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Panel footer action -->
                    <div class="border-t border-white/10 px-5 py-4 sm:px-6">
                        <a
                            href="{{ route('opac.index') }}"
                            class="flex w-full items-center justify-center gap-2 rounded-xl bg-white/10 px-4 py-2.5 text-sm font-bold text-white transition-all duration-300 hover:bg-[#fcc719] hover:text-[#102b70]"
                        >
                            Browse Catalog
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
