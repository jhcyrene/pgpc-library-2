<!-- Welcome Hero -->
<section class="relative overflow-hidden bg-primaryfade pb-20 pt-32 sm:pb-24 sm:pt-36 lg:py-32">
    <div
        class="absolute inset-0 bg-cover bg-center opacity-[0.12]"
        style="background-image: url('{{ Vite::asset('resources/images/school-img.jpg') }}')"
        aria-hidden="true"
    ></div>
    <div class="absolute inset-0 bg-gradient-to-r from-primaryfade via-primaryfade/95 to-primary/90" aria-hidden="true"></div>
    <div class="relative z-10 mx-auto w-full max-w-7xl px-5 sm:px-6 md:px-12">
        <div class="grid min-w-0 items-center gap-12 lg:grid-cols-[minmax(0,1.3fr)_minmax(340px,0.7fr)] lg:gap-16 xl:gap-20">
            <!-- Main system introduction -->
            <div class="min-w-0 text-center lg:text-left">
                <div class="mb-5 inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-4 py-2 text-xs font-bold uppercase tracking-[0.18em] text-white backdrop-blur-sm">
                    <svg class="h-5 w-5 text-gold" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5A8.5 8.5 0 003 6.253v13A8.5 8.5 0 017.5 18c1.746 0 3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5A8.5 8.5 0 0121 6.253v13A8.5 8.5 0 0016.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    PGPC Library
                </div>

                <h1 class="text-4xl font-bold leading-[1.08] tracking-tight text-white drop-shadow-md sm:text-5xl lg:text-6xl">
                    PGPC Library System
                </h1>

                <p class="mx-auto mt-6 max-w-2xl text-base font-medium leading-7 text-blue-50/95 sm:text-lg lg:mx-0">
                    Search the catalog, check book availability, reserve library resources, and keep track of your borrow transactions in one place.
                </p>

                <div class="mt-8 flex w-full flex-col items-stretch justify-center gap-3 sm:w-auto sm:flex-row sm:items-center lg:justify-start">
                    <a
                        href="{{ route('opac.index') }}"
                        class="btn h-auto min-h-12 w-full rounded-full border-none bg-gold px-6 py-3 font-bold text-primaryfade shadow-elegant transition hover:-translate-y-0.5 hover:bg-[#ffd84c] sm:w-auto"
                    >
                        <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.25" d="M21 21l-4.35-4.35m1.35-5.65a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Browse Catalog
                    </a>

                    <a
                        href="{{ route('login') }}"
                        class="btn h-auto min-h-12 w-full rounded-full border-2 border-white/70 bg-white/10 px-6 py-3 font-bold text-white backdrop-blur-sm transition hover:-translate-y-0.5 hover:border-white hover:bg-white hover:text-primaryfade sm:w-auto"
                    >
                        <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.25" d="M15 8a3 3 0 11-6 0 3 3 0 016 0zm-9 11a6 6 0 0112 0M19 8v6m3-3h-6" />
                        </svg>
                        Student Login
                    </a>
                </div>
            </div>

            <!-- Static OPAC preview -->
            <div id="about" class="min-w-0 scroll-mt-28 lg:w-full lg:max-w-md lg:justify-self-end">
                <div class="mb-5 text-center lg:text-left">
                    <h2 class="text-2xl font-bold text-white sm:text-3xl">Find your next resource</h2>
                    <p class="mt-2 text-sm leading-6 text-blue-100 sm:text-base">
                        Search the PGPC catalog and check availability before visiting the library.
                    </p>
                </div>

                <div class="min-w-0 rounded-3xl border border-white/25 bg-white/95 p-4 shadow-elegant backdrop-blur-sm sm:p-5">
                    <div class="flex min-w-0 items-center gap-2 rounded-xl border border-slate-200 bg-slate-50 p-2" aria-label="Catalog search preview">
                        <svg class="h-5 w-5 shrink-0 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-4.35-4.35m1.35-5.65a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                        </svg>
                        <input
                            type="text"
                            placeholder="Search title, author, or ISBN"
                            readonly
                            tabindex="-1"
                            aria-label="Search title, author, or ISBN"
                            class="min-w-0 flex-1 border-0 bg-transparent p-0 text-xs text-slate-700 outline-none placeholder:text-slate-400 focus:ring-0 sm:text-sm"
                        >
                        <span class="shrink-0 rounded-lg bg-primaryfade px-3 py-2 text-xs font-bold text-white">Search</span>
                    </div>

                    <div class="mt-4 grid min-w-0 gap-3" aria-label="Sample catalog results">
                        <div class="flex min-w-0 gap-3 rounded-2xl border border-slate-100 bg-white p-3 shadow-soft">
                            <div class="grid h-14 w-11 shrink-0 place-items-center rounded-lg bg-primaryfade text-gold">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20M4 19.5A2.5 2.5 0 0 0 6.5 22H20V2H6.5A2.5 2.5 0 0 0 4 4.5v15Z" />
                                </svg>
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="flex min-w-0 flex-wrap items-start justify-between gap-2">
                                    <div class="min-w-0">
                                        <h3 class="truncate text-sm font-bold text-slate-800">Introduction to Computing</h3>
                                        <p class="mt-0.5 text-xs text-slate-500">Library collection</p>
                                    </div>
                                    <span class="shrink-0 rounded-full bg-emerald-50 px-2 py-1 text-[10px] font-bold uppercase tracking-wide text-emerald-700">Available</span>
                                </div>
                                <div class="mt-2 flex flex-wrap items-center gap-3 text-[11px] font-bold">
                                    <span class="text-primaryfade">View Details</span>
                                    <span class="text-amber-600">Reserve</span>
                                </div>
                            </div>
                        </div>

                        <div class="flex min-w-0 gap-3 rounded-2xl border border-slate-100 bg-white p-3 shadow-soft">
                            <div class="grid h-14 w-11 shrink-0 place-items-center rounded-lg bg-slate-200 text-primaryfade">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20M4 19.5A2.5 2.5 0 0 0 6.5 22H20V2H6.5A2.5 2.5 0 0 0 4 4.5v15Z" />
                                </svg>
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="flex min-w-0 flex-wrap items-start justify-between gap-2">
                                    <div class="min-w-0">
                                        <h3 class="truncate text-sm font-bold text-slate-800">Research Methods</h3>
                                        <p class="mt-0.5 text-xs text-slate-500">Library collection</p>
                                    </div>
                                    <span class="shrink-0 rounded-full bg-amber-50 px-2 py-1 text-[10px] font-bold uppercase tracking-wide text-amber-700">Borrowed</span>
                                </div>
                                <div class="mt-2 text-[11px] font-bold text-primaryfade">View Details</div>
                            </div>
                        </div>
                    </div>

                    <p class="mt-4 border-t border-slate-100 pt-3 text-center text-xs font-semibold text-slate-400">
                        Catalog preview
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
