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
    class="scroll-mt-20 overflow-hidden bg-slate-50 py-14 sm:py-16 lg:py-20">
    {{-- Use the same width and padding as the navbar and hero --}}
    <div class="container mx-auto px-6 md:px-12">
        <div
            class="flex flex-col gap-5 border-b border-slate-200 pb-8 sm:flex-row sm:items-end sm:justify-between">
            <div class="max-w-2xl">
                <p
                    class="text-xs font-bold uppercase tracking-[0.2em] text-gold">
                    About Our Collections
                </p>

                <h2
                    class="mt-2 text-3xl font-bold tracking-tight text-primaryfade sm:text-4xl">
                    Explore by Category
                </h2>

                <p class="mt-3 max-w-xl leading-7 text-slate-600">
                    Browse resources by subject, then continue your search
                    through the PGPC Library catalog.
                </p>
            </div>

            <a
                href="{{ route('opac.index') }}"
                class="inline-flex w-fit items-center gap-2 rounded-full border border-primaryfade/20 bg-white px-5 py-2.5 text-sm font-semibold text-primaryfade shadow-sm transition hover:border-primaryfade/40 hover:bg-primaryfade hover:text-white focus:outline-none focus:ring-2 focus:ring-primaryfade focus:ring-offset-2">
                View all resources

                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($categories as $category)
                <a href="{{ route('opac.index', ['category' => $category['route']]) }}"
                    class="group flex min-w-0 items-start gap-4
                            rounded-2xl border border-slate-200 bg-white
                            p-5 shadow-sm transition duration-300
                            hover:-translate-y-1
                            hover:border-primaryfade/30
                            hover:shadow-lg
                            focus:outline-none focus:ring-2
                            focus:ring-primaryfade focus:ring-offset-2"
                >
                    <span class="grid h-14 w-14 shrink-0 place-items-center rounded-xl bg-primaryfade text-gold shadow-sm transition duration-300 group-hover:scale-105">
                        @switch($category['icon'])
                            @case('computer')
                                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"
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
                                    class="h-8 w-8"
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
                                    class="h-8 w-8"
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
                                    class="h-8 w-8"
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
                                    class="h-8 w-8"
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
                                    class="h-8 w-8"
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
                                    class="h-8 w-8"
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
                    </span>

                    <span class="min-w-0 flex-1">
                        <span
                            class="flex items-start justify-between gap-3"
                        >
                            <span
                                class="text-base font-bold leading-6
                                        text-slate-900 transition
                                        group-hover:text-primaryfade"
                            >
                                {{ $category['name'] }}
                            </span>

                            <svg
                                class="mt-1 h-4 w-4 shrink-0 text-slate-400
                                        transition group-hover:translate-x-1
                                        group-hover:text-primaryfade"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 5l7 7-7 7"
                                />
                            </svg>
                        </span>

                        <span
                            class="mt-1.5 block text-sm leading-6
                                    text-slate-500"
                        >
                            {{ $category['description'] }}
                        </span>
                    </span>
                </a>
            @endforeach
        </div>
    </div>
</section>