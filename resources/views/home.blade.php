<x-layout.welcome>
    <x-frontsection />

    <!-- Consolidated catalog exploration section -->
    <section id="categories" class="scroll-mt-20 overflow-hidden bg-gray-50 py-16 sm:py-20 lg:py-24">
        <div class="container mx-auto px-5 sm:px-6 md:px-12">
            <div class="mb-10 max-w-2xl sm:mb-12">
                <div class="max-w-2xl">
                    <p class="text-xs font-bold uppercase tracking-[0.18em] text-primary">Catalog collections</p>
                    <h2 class="mt-2 text-3xl font-bold text-primaryfade sm:text-4xl">Explore by Category</h2>
                    <p class="mt-4 leading-7 text-gray-600">
                        Browse the library catalog by field of study and continue your search in the OPAC.
                    </p>
                </div>

            </div>

            <div class="grid min-w-0 grid-cols-2 gap-4 sm:gap-5 lg:grid-cols-3 xl:grid-cols-6">
                <a
                    href="{{ route('opac.index', ['category' => 'Computer Science']) }}"
                    class="group min-w-0 rounded-2xl border border-gray-100 bg-white p-4 text-center shadow-sm transition duration-300 hover:-translate-y-1 hover:border-primaryfade/30 hover:shadow-elegant sm:p-5"
                >
                    <span class="mx-auto grid h-12 w-12 place-items-center rounded-xl bg-primaryfade text-gold shadow-soft transition-transform duration-300 group-hover:scale-105">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </span>
                    <h3 class="mt-4 break-words text-sm font-bold leading-5 text-gray-800 sm:text-base">Computer Science</h3>
                </a>

                <a
                    href="{{ route('opac.index', ['category' => 'Information Technology']) }}"
                    class="group min-w-0 rounded-2xl border border-gray-100 bg-white p-4 text-center shadow-sm transition duration-300 hover:-translate-y-1 hover:border-primaryfade/30 hover:shadow-elegant sm:p-5"
                >
                    <span class="mx-auto grid h-12 w-12 place-items-center rounded-xl bg-primaryfade text-gold shadow-soft transition-transform duration-300 group-hover:scale-105">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m-8 6l4 4 4-4M5 12h14" />
                        </svg>
                    </span>
                    <h3 class="mt-4 break-words text-sm font-bold leading-5 text-gray-800 sm:text-base">Information Technology</h3>
                </a>

                <a
                    href="{{ route('opac.index', ['category' => 'Mathematics']) }}"
                    class="group min-w-0 rounded-2xl border border-gray-100 bg-white p-4 text-center shadow-sm transition duration-300 hover:-translate-y-1 hover:border-primaryfade/30 hover:shadow-elegant sm:p-5"
                >
                    <span class="mx-auto grid h-12 w-12 place-items-center rounded-xl bg-primaryfade text-gold shadow-soft transition-transform duration-300 group-hover:scale-105">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h4m-2-2v4m5-2h3m-10 9h4m3-2l3 3m0-3l-3 3" />
                        </svg>
                    </span>
                    <h3 class="mt-4 break-words text-sm font-bold leading-5 text-gray-800 sm:text-base">Mathematics</h3>
                </a>

                <a
                    href="{{ route('opac.index', ['category' => 'Science']) }}"
                    class="group min-w-0 rounded-2xl border border-gray-100 bg-white p-4 text-center shadow-sm transition duration-300 hover:-translate-y-1 hover:border-primaryfade/30 hover:shadow-elegant sm:p-5"
                >
                    <span class="mx-auto grid h-12 w-12 place-items-center rounded-xl bg-primaryfade text-gold shadow-soft transition-transform duration-300 group-hover:scale-105">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5A2 2 0 0119.172 20H4.828a2 2 0 01-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                        </svg>
                    </span>
                    <h3 class="mt-4 break-words text-sm font-bold leading-5 text-gray-800 sm:text-base">Science</h3>
                </a>

                <a
                    href="{{ route('opac.index', ['category' => 'Literature']) }}"
                    class="group min-w-0 rounded-2xl border border-gray-100 bg-white p-4 text-center shadow-sm transition duration-300 hover:-translate-y-1 hover:border-primaryfade/30 hover:shadow-elegant sm:p-5"
                >
                    <span class="mx-auto grid h-12 w-12 place-items-center rounded-xl bg-primaryfade text-gold shadow-soft transition-transform duration-300 group-hover:scale-105">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5A8.5 8.5 0 003 6.253v13A8.5 8.5 0 017.5 18c1.746 0 3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5A8.5 8.5 0 0121 6.253v13A8.5 8.5 0 0016.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </span>
                    <h3 class="mt-4 break-words text-sm font-bold leading-5 text-gray-800 sm:text-base">Literature</h3>
                </a>

                <a
                    href="{{ route('opac.index', ['category' => 'Research']) }}"
                    class="group min-w-0 rounded-2xl border border-gray-100 bg-white p-4 text-center shadow-sm transition duration-300 hover:-translate-y-1 hover:border-primaryfade/30 hover:shadow-elegant sm:p-5"
                >
                    <span class="mx-auto grid h-12 w-12 place-items-center rounded-xl bg-primaryfade text-gold shadow-soft transition-transform duration-300 group-hover:scale-105">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h3m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l3.414 3.414A1 1 0 0117 7.414V21z" />
                        </svg>
                    </span>
                    <h3 class="mt-4 break-words text-sm font-bold leading-5 text-gray-800 sm:text-base">Research</h3>
                </a>
            </div>
        </div>
    </section>
</x-layout.welcome>
