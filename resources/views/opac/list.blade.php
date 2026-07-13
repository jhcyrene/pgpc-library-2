<section class="min-h-[55vh] overflow-hidden bg-slate-50 py-8 sm:py-10">
    <div class="container mx-auto px-5 sm:px-6 md:px-12">
        <div class="grid min-w-0 gap-5 lg:grid-cols-[15rem_minmax(0,1fr)] lg:items-start xl:grid-cols-[16rem_minmax(0,1fr)]">
            <aside class="min-w-0" aria-label="Catalog filters">
                <form action="{{ route('opac.index') }}" method="GET"
                    class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm lg:sticky lg:top-24">
                    @if ($search !== '')
                        <input type="hidden" name="q" value="{{ $search }}">
                    @endif

                    <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
                        <span class="grid h-10 w-10 shrink-0 place-items-center rounded-xl bg-primaryfade text-gold">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h18M6 12h12m-9 8h6" />
                            </svg>
                        </span>
                        <div>
                            <h2 class="font-bold text-primaryfade">Filter Catalog</h2>
                            <p class="mt-0.5 text-xs text-slate-500">Refine the current results</p>
                        </div>
                    </div>

                    <div class="mt-4">
                        <label for="catalog-category" class="mb-2 block text-xs font-bold uppercase tracking-[0.12em] text-slate-500">
                            Category
                        </label>
                        <div class="relative">
                            <select id="catalog-category" name="category"
                                class="w-full appearance-none rounded-xl border border-slate-300 bg-white px-4 py-3 pr-10 text-sm font-semibold text-slate-700 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/15">
                                <option value="">All categories</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->category_id }}" @selected((string) $selectedCategoryId === (string) $category->category_id)>
                                        {{ $category->category_name }}
                                    </option>
                                @endforeach
                            </select>
                            <svg class="pointer-events-none absolute right-3 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6 9 6 6 6-6" />
                            </svg>
                        </div>
                    </div>

                    <div class="mt-4 border-t border-slate-100 pt-4">
                        <label for="catalog-sort" class="mb-2 block text-xs font-bold uppercase tracking-[0.12em] text-slate-500">
                            Sort Results
                        </label>
                        <div class="relative">
                            <select id="catalog-sort" name="sort"
                                class="w-full appearance-none rounded-xl border border-slate-300 bg-white px-4 py-3 pr-10 text-sm font-semibold text-slate-700 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/15">
                                @foreach ($sortOptions as $value => $label)
                                    <option value="{{ $value }}" @selected($sort === $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                            <svg class="pointer-events-none absolute right-3 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6 9 6 6 6-6" />
                            </svg>
                        </div>
                    </div>

                    <div class="mt-5 grid gap-2">
                        <button type="submit"
                            class="btn h-auto min-h-11 w-full rounded-xl border-none bg-primaryfade px-5 py-3 font-bold text-white transition hover:bg-primary focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gold">
                            Apply Filters
                        </button>
                        @if ($hasFilters)
                            <a href="{{ route('opac.index') }}"
                                class="btn h-auto min-h-11 w-full rounded-xl border border-slate-300 bg-white px-5 py-3 font-bold text-slate-700 transition hover:border-slate-400 hover:bg-slate-50">
                                Clear Filters
                            </a>
                        @endif
                    </div>
                </form>
            </aside>

            <div class="min-w-0">
                <div class="mb-4 flex min-w-0 flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                    <div class="min-w-0">
                        <p class="text-xs font-bold uppercase tracking-[0.18em] text-primary">Catalog Results</p>
                        <h2 class="mt-1 text-2xl font-bold text-primaryfade sm:text-3xl">
                            {{ number_format($books->total()) }} {{ Str::plural('title', $books->total()) }} found
                        </h2>
                    </div>

                    @if ($search !== '' || $selectedCategory)
                        <p class="min-w-0 text-sm leading-6 text-slate-500 sm:max-w-sm sm:text-right">
                            @if ($search !== '')
                                Results for <span class="break-words font-bold text-slate-700">“{{ $search }}”</span>
                            @endif
                            @if ($search !== '' && $selectedCategory)
                                <span class="mx-1 text-slate-300" aria-hidden="true">•</span>
                            @endif
                            @if ($selectedCategory)
                                Category: <span class="font-bold text-slate-700">{{ $selectedCategory->category_name }}</span>
                            @endif
                        </p>
                    @endif
                </div>

                @if ($books->isEmpty())
                    <div class="rounded-3xl border border-dashed border-slate-300 bg-white px-6 py-16 text-center shadow-sm">
                        <div class="mx-auto grid h-16 w-16 place-items-center rounded-full bg-primaryfade/10 text-primaryfade">
                            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20M4 19.5A2.5 2.5 0 0 0 6.5 22H20V2H6.5A2.5 2.5 0 0 0 4 4.5v15Z" />
                            </svg>
                        </div>
                        <h3 class="mt-5 text-xl font-bold text-slate-900">No catalog titles matched</h3>
                        <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500">
                            Try a shorter search, choose a different category, or clear the filters to browse the collection.
                        </p>
                        <a href="{{ route('opac.index') }}"
                            class="btn mt-6 h-auto min-h-11 rounded-xl border-none bg-primaryfade px-6 py-3 font-bold text-white transition hover:bg-primary">
                            Browse All Titles
                        </a>
                    </div>
                @else
                    <div class="grid min-w-0 gap-3">
                        @foreach ($books as $book)
                            <article class="group min-w-0 overflow-hidden rounded-2xl border border-slate-200 bg-white p-3 shadow-sm transition duration-300 hover:border-primary/20 hover:shadow-elegant sm:p-4">
                                <div class="flex min-w-0 flex-col gap-4 sm:flex-row">
                                    <div class="mx-auto w-24 shrink-0 sm:mx-0 sm:w-28">
                                        <div class="relative aspect-[2/3] overflow-hidden rounded-xl border border-slate-200 bg-gradient-to-br from-slate-100 to-slate-200 shadow-soft">
                                            @if ($book->bookDetail?->cover_image)
                                                <img
                                                    src="{{ asset('storage/' . ltrim($book->bookDetail->cover_image, '/')) }}"
                                                    alt="Cover of {{ $book->book_title }}"
                                                    class="h-full w-full object-cover transition duration-300 group-hover:scale-105"
                                                >
                                            @else
                                                <div class="flex h-full flex-col items-center justify-center px-3 text-center text-primaryfade">
                                                    <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20M4 19.5A2.5 2.5 0 0 0 6.5 22H20V2H6.5A2.5 2.5 0 0 0 4 4.5v15Z" />
                                                    </svg>
                                                    <span class="mt-2 text-[10px] font-bold uppercase tracking-wider">PGPC Library</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="flex min-w-0 flex-1 flex-col">
                                        <div class="flex min-w-0 flex-col gap-3 md:flex-row md:items-start md:justify-between">
                                            <div class="min-w-0">
                                                @if ($book->categories->isNotEmpty())
                                                    <p class="text-[11px] font-bold uppercase tracking-[0.12em] text-primary">
                                                        {{ $book->categories->first()->category_name }}
                                                        @if ($book->categories->count() > 1)
                                                            <span class="text-slate-400">+{{ $book->categories->count() - 1 }}</span>
                                                        @endif
                                                    </p>
                                                @else
                                                    <p class="text-[11px] font-bold uppercase tracking-[0.12em] text-slate-400">General Collection</p>
                                                @endif

                                                <h3 class="mt-1 break-words text-lg font-bold leading-snug text-slate-900 sm:text-xl">
                                                    {{ $book->book_title }}
                                                </h3>
                                                @if ($book->subtitle)
                                                    <p class="mt-0.5 break-words text-sm font-medium leading-5 text-slate-500">
                                                        {{ $book->subtitle }}
                                                    </p>
                                                @endif

                                                <p class="mt-2 break-words text-sm leading-5 text-slate-600">
                                                    <span class="font-semibold text-slate-500">By</span>
                                                    @forelse ($book->authors as $author)
                                                        {{ collect([$author->first_name, $author->middle_name, $author->last_name, $author->suffix])->filter()->implode(' ') }}@if (! $loop->last), @endif
                                                    @empty
                                                        Unknown author
                                                    @endforelse
                                                </p>
                                            </div>

                                            <div class="shrink-0">
                                                @if ($book->copies_available > 0)
                                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-bold text-emerald-700">
                                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500" aria-hidden="true"></span>
                                                        Available
                                                    </span>
                                                @elseif ($book->copies_total > 0)
                                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-2.5 py-1 text-xs font-bold text-amber-700">
                                                        <span class="h-1.5 w-1.5 rounded-full bg-amber-500" aria-hidden="true"></span>
                                                        Checked Out
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-2.5 py-1 text-xs font-bold text-slate-600">
                                                        <span class="h-1.5 w-1.5 rounded-full bg-slate-400" aria-hidden="true"></span>
                                                        No Copies
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <dl class="mt-3 grid min-w-0 gap-3 rounded-xl border border-slate-100 bg-slate-50 p-3 text-xs sm:grid-cols-2 xl:grid-cols-3">
                                            <div class="min-w-0">
                                                <dt class="font-semibold uppercase tracking-wide text-slate-400">Publisher</dt>
                                                <dd class="mt-1 break-words font-bold leading-5 text-slate-700">
                                                    {{ $book->bookDetail?->publisher?->publisher_name ?? 'Not listed' }}
                                                </dd>
                                            </div>
                                            <div class="min-w-0">
                                                <dt class="font-semibold uppercase tracking-wide text-slate-400">ISBN / ISSN</dt>
                                                <dd class="mt-1 break-words font-bold leading-5 text-slate-700">
                                                    {{ $book->bookDetail?->isbn ?? $book->bookDetail?->issn ?? 'Not listed' }}
                                                </dd>
                                            </div>
                                            <div class="min-w-0">
                                                <dt class="font-semibold uppercase tracking-wide text-slate-400">Call Number</dt>
                                                <dd class="mt-1 break-words font-bold leading-5 text-slate-700">
                                                    {{ $book->bookDetail?->call_number ?? 'Not assigned' }}
                                                </dd>
                                            </div>
                                        </dl>

                                        <div class="mt-3 flex flex-col gap-3 border-t border-slate-100 pt-3 sm:flex-row sm:items-center sm:justify-between">
                                            <p class="text-sm font-semibold text-slate-600">
                                                {{ $book->copies_available }} of {{ $book->copies_total }} available
                                            </p>

                                            <div class="w-full sm:w-auto">
                                                @if ($isStudentAccount)
                                                    <a href="{{ route('student.reservations.create', $book) }}"
                                                        class="btn h-auto min-h-10 w-full rounded-xl border-none bg-primaryfade px-5 py-2 font-bold text-white transition hover:bg-primary focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gold sm:w-auto">
                                                        Reserve This Title
                                                    </a>
                                                @elseif (! $memberAccount)
                                                    <a href="{{ route('student.reservations.create', $book) }}"
                                                        class="btn h-auto min-h-10 w-full rounded-xl border border-primaryfade bg-white px-5 py-2 font-bold text-primaryfade transition hover:border-primary hover:bg-blue-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gold sm:w-auto">
                                                        Log In to Reserve
                                                    </a>
                                                @else
                                                    <p class="rounded-xl bg-slate-100 px-4 py-3 text-center text-xs font-semibold leading-5 text-slate-500">
                                                        Reservations require a student account.
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    @if ($books->hasPages())
                        <nav class="mt-10 overflow-x-auto rounded-2xl border border-slate-200 bg-white px-4 py-3 shadow-sm" aria-label="Catalog pagination">
                            {{ $books->onEachSide(1)->links() }}
                        </nav>
                    @endif
                @endif
            </div>
        </div>
    </div>
</section>
