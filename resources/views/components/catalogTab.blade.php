@php
    $categories = [
        [
            'name' => 'Computer Science',
            'description' => 'Programming, algorithms, software, and computing resources.',
            'route' => 'Computer Science',
            'icon' => 'computer',
        ],
        [
            'name' => 'Information Technology',
            'description' => 'Networking, systems, databases, and information management.',
            'route' => 'Information Technology',
            'icon' => 'technology',
        ],
        [
            'name' => 'Mathematics',
            'description' => 'Algebra, statistics, calculus, and applied mathematics.',
            'route' => 'Mathematics',
            'icon' => 'math',
        ],
        [
            'name' => 'Science',
            'description' => 'Natural sciences, laboratory references, and scientific studies.',
            'route' => 'Science',
            'icon' => 'science',
        ],
        [
            'name' => 'Literature',
            'description' => 'Fiction, language, literary works, and cultural studies.',
            'route' => 'Literature',
            'icon' => 'literature',
        ],
        [
            'name' => 'Research',
            'description' => 'Theses, academic writing, research methods, and references.',
            'route' => 'Research',
            'icon' => 'research',
        ],
    ];
@endphp

<section
    id="categories"
    aria-labelledby="categories-heading"
    class="relative scroll-mt-20 overflow-hidden border-y border-slate-200/70 bg-[#f7f9fc] py-12 sm:py-14 lg:py-16">
    <div class="pointer-events-none absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-[#fcc719] to-transparent"></div>
    <div class="pointer-events-none absolute -right-24 -top-24 h-72 w-72 rounded-full border border-[#102b70]/5"></div>
    <div class="pointer-events-none absolute -bottom-32 -left-32 h-80 w-80 rounded-full bg-[#102b70]/[0.025]"></div>

    <div class="container relative mx-auto px-6 md:px-12">
        <div
            class="grid gap-6 border-b border-slate-200/80 pb-8 lg:grid-cols-[minmax(0,1fr)_auto] lg:items-end">
            <div class="max-w-2xl">
                <p class="flex items-center gap-3 text-xs font-extrabold uppercase tracking-[0.2em] text-[#b98b00]">
                    <span class="h-0.5 w-8 rounded-full bg-[#fcc719]" aria-hidden="true"></span>
                    About Our Collections
                </p>

                <h2
                    id="categories-heading"
                    class="mt-3 text-3xl font-extrabold tracking-tight text-[#102b70] sm:text-4xl">
                    Explore by Category
                </h2>

                <p class="mt-3 max-w-xl text-sm font-medium leading-6 text-slate-600 sm:text-base">
                    Browse resources by subject, then continue your search
                    through the PGPC Library catalog.
                </p>
            </div>

            <a
                href="{{ route('opac.index') }}"
                class="inline-flex w-fit items-center gap-2 rounded-full border border-[#102b70] bg-[#102b70] px-5 py-2.5 text-sm font-bold text-white shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:bg-[#0b225e] hover:shadow-md focus:outline-none focus:ring-2 focus:ring-[#102b70] focus:ring-offset-2">
                View all resources

                <svg class="h-4 w-4 text-[#fcc719]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        <div class="mt-8 grid auto-rows-fr grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-5 lg:grid-cols-3">
            @foreach ($categories as $category)
                <a href="{{ route('opac.index', ['category' => $category['route']]) }}"
                    class="group relative flex min-h-[13rem] flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:border-[#102b70]/25 hover:shadow-xl hover:shadow-slate-200/70 focus:outline-none focus:ring-2 focus:ring-[#102b70] focus:ring-offset-2 sm:p-6"
                >
                    <div class="absolute inset-x-0 top-0 h-[3px] bg-gradient-to-r from-[#fcc719] via-[#f8d75f] to-[#fcc719] opacity-70 transition-opacity duration-300 group-hover:opacity-100"></div>

                    <div class="flex flex-1 flex-col">
                        <!-- Icon & Title -->
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex min-w-0 items-center gap-4">
                                <div class="grid h-11 w-11 shrink-0 place-items-center rounded-xl border border-[#102b70]/5 bg-[#102b70]/[0.045] text-[#102b70] transition-all duration-300 group-hover:border-[#102b70] group-hover:bg-[#102b70] group-hover:text-[#fcc719]">
                                    @switch($category['icon'])
                                    @case('computer')
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            aria-hidden="true"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="1.5"
                                                d="M9.75 17L9 20l-1 1h8l-1-1-.75-3 M3 13h18 M5 17h14a2 2 0 002-2V5 a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                                            />
                                        </svg>
                                        @break

                                    @case('technology')
                                        <svg
                                            class="h-6 w-6"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            aria-hidden="true"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="1.5"
                                                d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5A2 2 0 0119.172 20H4.828a2 2 0 01-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"
                                            />
                                        </svg>
                                        @break

                                    @case('math')
                                        <svg
                                            class="h-6 w-6"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            aria-hidden="true"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="1.5"
                                                d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"
                                            />
                                        </svg>
                                        @break

                                    @case('science')
                                        <svg
                                            class="h-6 w-6"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            aria-hidden="true"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="1.5"
                                                d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5A2 2 0 0119.172 20H4.828a2 2 0 01-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"
                                            />
                                        </svg>  
                                        @break

                                    @case('literature')
                                        <svg
                                            class="h-6 w-6"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            aria-hidden="true"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="1.5"
                                                d="M12 6.253v13m0-13C10.832 5.477
                                                    9.246 5 7.5 5A8.5 8.5 0 003
                                                    6.253v13A8.5 8.5 0 017.5 18
                                                    c1.746 0 3.332.477 4.5 1.253
                                                    m0-13C13.168 5.477 14.754 5
                                                    16.5 5A8.5 8.5 0 0121 6.253v13
                                                    A8.5 8.5 0 0016.5 18c-1.746 0
                                                    -3.332.477-4.5 1.253"
                                            />
                                        </svg>
                                        @break

                                    @case('research')
                                        <svg
                                            class="h-6 w-6"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            aria-hidden="true"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="1.5"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"
                                            />
                                        </svg>
                                        @break

                                    @default
                                        <svg
                                            class="h-6 w-6"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            aria-hidden="true"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="1.5"
                                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"
                                            />
                                        </svg>
                                    @endswitch
                                </div>
                                <div class="min-w-0">
                                    <h3 class="text-base font-extrabold text-slate-800 transition-colors group-hover:text-[#102b70] leading-snug">
                                        {{ $category['name'] }}
                                    </h3>
                                </div>
                            </div>

                            <span class="pt-1 text-xs font-extrabold tracking-[0.16em] text-slate-300 transition-colors group-hover:text-[#b98b00]">
                                {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                            </span>
                        </div>

                        <!-- Description -->
                        <p class="mt-4 flex-1 text-sm font-medium leading-6 text-slate-500">
                            {{ $category['description'] }}
                        </p>
                    </div>

                    <!-- Bottom Browse Call-to-action -->
                    <div class="mt-5 flex items-center justify-between border-t border-slate-100 pt-4">
                        <span class="text-xs font-bold uppercase tracking-[0.12em] text-slate-400 transition-colors duration-300 group-hover:text-[#102b70]">
                            Browse subject
                        </span>

                        <span class="grid h-8 w-8 place-items-center rounded-full bg-slate-100 text-[#102b70] transition-all duration-300 group-hover:translate-x-0.5 group-hover:bg-[#fcc719]">
                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
