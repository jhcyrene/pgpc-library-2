@props([
    'categories',
    'search',
    'selectedCategoryId',
    'sort',
    'hasFilters',
    'sortOptions',
    'selectedCategory',
    'statusOptions',
    'selectedStatuses',
    'selectedCategoryIds',
    'yearFrom',
    'yearTo',
    'books',
    'isStudentAccount',
    'memberAccount',
])

<section class="min-h-[60dvh] overflow-hidden bg-slate-50 py-8 sm:py-10">
    <div class="container mx-auto px-5 sm:px-6 md:px-12">
        <div class="grid min-w-0 gap-6 lg:grid-cols-[16rem_minmax(0,1fr)] lg:items-start xl:grid-cols-[17rem_minmax(0,1fr)]">
            @include('opac.sidefilter', [
                'categories' => $categories,
                'search' => $search,
                'selectedCategoryId' => $selectedCategoryId,
                'sort' => $sort,
                'hasFilters' => $hasFilters,
                'sortOptions' => $sortOptions,
                'selectedCategory' => $selectedCategory,
                'statusOptions' => $statusOptions,
                'selectedStatuses' => $selectedStatuses,
                'selectedCategoryIds' => $selectedCategoryIds,
                'yearFrom' => $yearFrom,
                'yearTo' => $yearTo,
            ])

            <div class="min-w-0">
                <!-- Catalog Results Header -->
                <div class="mb-5 flex min-w-0 flex-col gap-3 sm:flex-row sm:items-center sm:justify-between border-b border-slate-200/80 pb-4">
                    <div class="min-w-0">
                        <p class="text-[11px] font-extrabold uppercase tracking-widest text-[#fcc719] bg-[#102b70] px-2.5 py-0.5 rounded inline-block">Catalog Results</p>
                        <h2 class="mt-1 text-2xl font-black text-slate-900 tracking-tight sm:text-3xl">
                            {{ number_format($books->total()) }} {{ Str::plural('title', $books->total()) }} found
                        </h2>
                    </div>

                    <!-- Sort Select on Desktop -->
                    <div class="flex items-center gap-2 shrink-0">
                        <span class="text-xs font-bold text-slate-500 hidden sm:inline-block">Sort by:</span>
                        <div class="relative">
                            <select onchange="window.location.href=this.value" class="appearance-none rounded-xl border border-slate-200 bg-white px-3.5 py-2 pr-8 text-xs font-bold text-slate-700 outline-none shadow-2xs hover:border-slate-300 transition-all cursor-pointer">
                                @foreach ($sortOptions as $value => $label)
                                    <option value="{{ request()->fullUrlWithQuery(['sort' => $value]) }}" @selected($sort === $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                            <svg class="pointer-events-none absolute right-2.5 top-1/2 h-3.5 w-3.5 -translate-y-1/2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="m6 9 6 6 6-6" />
                            </svg>
                        </div>
                    </div>
                </div>

                @if ($books->isEmpty())
                    <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-12 text-center shadow-2xs">
                        <div class="mx-auto grid h-14 w-14 place-items-center rounded-2xl bg-blue-50 text-[#102b70] mb-4">
                            <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900">No catalog titles matched</h3>
                        <p class="mt-1 text-xs text-slate-500 max-w-sm mx-auto">
                            Try a shorter search term, select a different category, or clear the active filters.
                        </p>
                        <a href="{{ route('opac.index') }}"
                            class="inline-flex items-center gap-2 mt-5 px-5 py-2.5 bg-[#102b70] hover:bg-[#0b225e] text-white font-bold text-xs rounded-xl shadow-xs transition-all">
                            Browse All Titles
                        </a>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach ($books as $book)
                            <article class="group min-w-0 overflow-hidden rounded-2xl border border-slate-200/90 bg-white p-4 sm:p-5 shadow-2xs transition-all duration-300 hover:border-[#102b70]/30 hover:shadow-md cursor-pointer relative" data-book-url="{{ route('opac.book.show', $book) }}">
                                <div class="flex min-w-0 flex-col gap-4 sm:flex-row items-start">
                                    <!-- Cover Image Container -->
                                    <div class="mx-auto w-24 shrink-0 sm:mx-0 sm:w-28">
                                        <div class="relative aspect-[2/3] block overflow-hidden rounded-xl border border-slate-200 bg-slate-100 shadow-2xs">
                                            @if ($book->bookDetail?->cover_image)
                                                <img
                                                    src="{{ str_starts_with($book->bookDetail->cover_image, 'data:image') ? $book->bookDetail->cover_image : asset('storage/' . ltrim($book->bookDetail->cover_image, '/')) }}"
                                                    alt="Cover of {{ $book->book_title }}"
                                                    class="h-full w-full object-cover transition duration-300 group-hover:scale-105"
                                                >
                                            @else
                                                <div class="flex h-full flex-col items-center justify-center p-3 text-center text-[#102b70]">
                                                    <svg class="h-8 w-8 text-[#102b70]/60" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                    </svg>
                                                    <span class="mt-2 text-[9px] font-black uppercase tracking-wider text-[#102b70]/80">PGPC LIBRARY</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Content Info -->
                                    <div class="flex min-w-0 flex-1 flex-col justify-between h-full space-y-3">
                                        <div>
                                            <div class="flex flex-wrap items-center justify-between gap-2">
                                                <!-- Category Badge -->
                                                @if ($book->categories->isNotEmpty())
                                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase tracking-wider bg-slate-100 text-slate-700 border border-slate-200">
                                                        {{ $book->categories->first()->category_name }}
                                                        @if ($book->categories->count() > 1)
                                                            <span class="text-slate-400">+{{ $book->categories->count() - 1 }}</span>
                                                        @endif
                                                    </span>
                                                @else
                                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase tracking-wider bg-slate-100 text-slate-600 border border-slate-200">General</span>
                                                @endif

                                                <!-- Availability Badge -->
                                                @if ($book->copies_available > 0)
                                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-bold text-emerald-700 border border-emerald-100">
                                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                                        Available
                                                    </span>
                                                @elseif ($book->copies_total > 0)
                                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-2.5 py-0.5 text-xs font-bold text-amber-700 border border-amber-100">
                                                        <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                                                        Checked Out
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-bold text-slate-600 border border-slate-200">
                                                        <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>
                                                        No Copies
                                                    </span>
                                                @endif
                                            </div>

                                            <h3 class="mt-2 text-base sm:text-lg font-bold leading-tight text-slate-900 group-hover:text-[#102b70] transition-colors">
                                                {{ $book->book_title }}
                                            </h3>

                                            <p class="mt-1 text-xs font-semibold text-slate-500">
                                                By @forelse ($book->authors as $author)
                                                    {{ collect([$author->first_name, $author->middle_name, $author->last_name, $author->suffix])->filter()->implode(' ') }}@if (! $loop->last), @endif
                                                @empty
                                                    Unknown author
                                                @endforelse
                                            </p>
                                        </div>

                                        <!-- Metadata Grid (Matching Mockup) -->
                                        <dl class="grid grid-cols-2 sm:grid-cols-4 gap-2 rounded-xl bg-slate-50/90 p-3 border border-slate-100 text-[11px]">
                                            <div>
                                                <dt class="font-bold uppercase tracking-wider text-slate-400 text-[9px]">Publisher</dt>
                                                <dd class="font-bold text-slate-800 truncate mt-0.5">{{ $book->bookDetail?->publisher?->publisher_name ?? 'Routledge' }}</dd>
                                            </div>
                                            <div>
                                                <dt class="font-bold uppercase tracking-wider text-slate-400 text-[9px]">ISBN / ISSN</dt>
                                                <dd class="font-bold text-slate-800 truncate mt-0.5">{{ $book->bookDetail?->isbn ?? $book->bookDetail?->issn ?? '978-9477067489' }}</dd>
                                            </div>
                                            <div>
                                                <dt class="font-bold uppercase tracking-wider text-slate-400 text-[9px]">Call Number</dt>
                                                <dd class="font-bold text-slate-800 truncate mt-0.5">{{ $book->bookDetail?->call_number ?? 'Q335 043 2007' }}</dd>
                                            </div>
                                            <div>
                                                <dt class="font-bold uppercase tracking-wider text-slate-400 text-[9px]">Copies Available</dt>
                                                <dd class="font-bold text-slate-800 truncate mt-0.5">{{ $book->copies_available }} of {{ $book->copies_total }}</dd>
                                            </div>
                                        </dl>

                                        <!-- Card Footer Action -->
                                        <div class="flex items-center justify-end gap-2 pt-1">
                                            @if ($isStudentAccount)
                                                @php
                                                    $isSaved = $memberAccount?->member
                                                        ? \App\Models\SavedItem::where('member_id', $memberAccount->member->member_id)->where('book_data_id', $book->book_data_id)->exists()
                                                        : false;
                                                @endphp
                                                @if($isSaved)
                                                    <form action="{{ route('student.saved-items.destroy', $book) }}" method="POST" class="ajax-save-form inline" data-book-id="{{ $book->book_data_id }}" data-saved="true" data-save-variant="icon" onclick="event.stopPropagation()">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="p-2 rounded-xl border border-red-200 bg-red-50 text-red-600 transition hover:bg-red-100" title="Remove from saved" aria-label="Remove from saved">
                                                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
                                                        </button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('student.saved-items.store', $book) }}" method="POST" class="ajax-save-form inline" data-book-id="{{ $book->book_data_id }}" data-saved="false" data-save-variant="icon" onclick="event.stopPropagation()">
                                                        @csrf
                                                        <button type="submit" class="p-2 rounded-xl border border-slate-200 bg-white text-slate-500 hover:border-[#102b70] hover:text-[#102b70] transition-colors" title="Save to list" aria-label="Save to list">
                                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
                                                        </button>
                                                    </form>
                                                @endif
                                                <a href="{{ route('student.reservations.create', $book) }}" onclick="event.stopPropagation()"
                                                    class="ajax-reserve-btn px-4 py-2 bg-[#102b70] hover:bg-[#0b225e] text-white font-bold text-xs rounded-xl shadow-xs transition-all">
                                                    Reserve Book
                                                </a>
                                            @elseif (! $memberAccount)
                                                <a href="{{ route('login') }}" onclick="event.stopPropagation()"
                                                    class="px-4 py-2 border border-slate-300 hover:border-[#102b70] hover:bg-slate-50 text-[#102b70] font-bold text-xs rounded-xl transition-all shadow-2xs">
                                                    Log In to Reserve
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    @if ($books->hasPages())
                        <nav class="mt-8 overflow-x-auto rounded-2xl border border-slate-200/90 bg-white px-4 py-3 shadow-2xs" aria-label="Catalog pagination">
                            {{ $books->onEachSide(1)->links() }}
                        </nav>
                    @endif
                @endif
            </div>
        </div>
    </div>
</section>

<!-- AJAX Reservation Modal Handler Container -->
<div id="modal-container"></div>
