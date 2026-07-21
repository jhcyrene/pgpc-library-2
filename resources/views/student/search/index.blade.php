<x-layout.student title="Dashboard Search">
    <div class="mx-auto w-full max-w-[1600px] space-y-6">
        <!-- Search Header Banner -->
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-[#102b70] to-[#1e46a3] p-6 text-white shadow-md sm:p-8">
            <div class="relative z-10 space-y-4">
                <div>
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-white/10 px-3 py-1 text-xs font-bold uppercase tracking-wider text-[#fcc719] backdrop-blur-sm">
                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Dashboard Search
                    </span>
                    <h1 class="mt-2 text-2xl sm:text-3xl font-extrabold tracking-tight">
                        @if(!empty($q))
                            Results for "<span class="text-[#fcc719]">{{ $q }}</span>"
                        @else
                            Search Your Student Account & Library
                        @endif
                    </h1>
                    <p class="mt-1 text-xs sm:text-sm text-slate-200 max-w-2xl">
                        Search across your personal borrow history, reservations, saved books, and the library catalog.
                    </p>
                </div>

                <!-- Embedded Search Form -->
                <form action="{{ route('student.search') }}" method="GET" class="flex items-center gap-2 max-w-xl">
                    <div class="relative flex-1">
                        <svg class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input
                            type="search"
                            name="q"
                            value="{{ $q }}"
                            placeholder="Search title, author, reservation, or borrow record..."
                            class="w-full rounded-xl border border-white/20 bg-white/10 pl-10 pr-4 py-2.5 text-sm text-white placeholder:text-slate-300 outline-none backdrop-blur-sm focus:border-white focus:bg-white/20 focus:ring-2 focus:ring-white/20 transition-all"
                        >
                    </div>
                    <button type="submit" class="rounded-xl bg-[#fcc719] hover:bg-[#e0af10] text-[#102b70] font-bold px-5 py-2.5 text-sm shadow-md transition-all shrink-0">
                        Search
                    </button>
                </form>

                <!-- Quick Summary Stats Pill Badges -->
                @if(!empty($q))
                    <div class="flex flex-wrap gap-2 pt-2">
                        <span class="rounded-lg bg-white/10 px-3 py-1 text-xs font-semibold backdrop-blur-sm">
                            📘 {{ $borrows->count() }} Borrow Records
                        </span>
                        <span class="rounded-lg bg-white/10 px-3 py-1 text-xs font-semibold backdrop-blur-sm">
                            📑 {{ $reservations->count() }} Reservations
                        </span>
                        <span class="rounded-lg bg-white/10 px-3 py-1 text-xs font-semibold backdrop-blur-sm">
                            🔖 {{ $savedItems->count() }} Saved Items
                        </span>
                        <span class="rounded-lg bg-white/10 px-3 py-1 text-xs font-semibold backdrop-blur-sm">
                            📚 {{ $catalogBooks->count() }} Catalog Matches
                        </span>
                    </div>
                @endif
            </div>
        </div>

        @if(empty($q))
            <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <h3 class="mt-4 text-base font-bold text-slate-800">Enter a search keyword</h3>
                <p class="mt-1 text-xs text-slate-500">Type a book title, author name, or keyword above to search your student record and library catalog.</p>
            </div>
        @else

            <!-- 1. Borrow History & Active Borrows Section -->
            <section class="rounded-2xl border border-slate-200 bg-white p-5 sm:p-6 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <div class="flex items-center gap-2.5">
                        <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-50 text-[#102b70]">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-base font-bold text-slate-900">Borrow History & Active Borrows</h2>
                            <p class="text-xs text-slate-500">Your borrowed books matching "{{ $q }}"</p>
                        </div>
                    </div>
                    <a href="{{ route('student.borrow-transactions.index') }}" class="text-xs font-bold text-[#102b70] hover:underline">
                        View All Borrows &rarr;
                    </a>
                </div>

                @if($borrows->isEmpty())
                    <p class="text-xs text-slate-500 py-3 italic">No borrow records found matching "{{ $q }}".</p>
                @else
                    <div class="divide-y divide-slate-100">
                        @foreach($borrows as $borrow)
                            @php
                                $bookData = $borrow->book?->bookData;
                            @endphp
                            <div class="flex items-center justify-between py-3 hover:bg-slate-50 px-2 rounded-xl transition-colors">
                                <div class="space-y-0.5">
                                    <h4 class="text-sm font-bold text-slate-900">{{ $bookData?->book_title ?? 'Borrowed Item' }}</h4>
                                    <p class="text-xs text-slate-500">
                                        Borrowed: {{ $borrow->issue_date ? $borrow->issue_date->format('M d, Y') : 'N/A' }}
                                        @if($borrow->due_date)
                                            &bull; Due: <span class="font-semibold text-slate-700">{{ $borrow->due_date->format('M d, Y') }}</span>
                                        @endif
                                    </p>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-bold capitalize 
                                        {{ strtolower($borrow->status) === 'returned' ? 'bg-emerald-50 text-emerald-700' : 'bg-blue-50 text-[#102b70]' }}">
                                        {{ $borrow->status }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>

            <!-- 2. Reservations & Requests Section -->
            <section class="rounded-2xl border border-slate-200 bg-white p-5 sm:p-6 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <div class="flex items-center gap-2.5">
                        <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-amber-50 text-amber-700">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-base font-bold text-slate-900">Reservations & Requests</h2>
                            <p class="text-xs text-slate-500">Your book reservations matching "{{ $q }}"</p>
                        </div>
                    </div>
                    <a href="{{ route('student.reservations.index') }}" class="text-xs font-bold text-[#102b70] hover:underline">
                        View All Reservations &rarr;
                    </a>
                </div>

                @if($reservations->isEmpty())
                    <p class="text-xs text-slate-500 py-3 italic">No reservation requests found matching "{{ $q }}".</p>
                @else
                    <div class="divide-y divide-slate-100">
                        @foreach($reservations as $req)
                            @php
                                $bookData = $req->bookData;
                                $statusName = $req->bookRequestStatus?->status_name ?? 'Pending';
                            @endphp
                            <div class="flex items-center justify-between py-3 hover:bg-slate-50 px-2 rounded-xl transition-colors">
                                <div class="space-y-0.5">
                                    <h4 class="text-sm font-bold text-slate-900">{{ $bookData?->book_title ?? 'Reserved Item' }}</h4>
                                    <p class="text-xs text-slate-500">
                                        Requested: {{ $req->request_date ? $req->request_date->format('M d, Y') : 'N/A' }}
                                    </p>
                                </div>
                                <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-bold bg-amber-50 text-amber-800">
                                    {{ $statusName }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>

            <!-- 3. Saved Items Section -->
            <section class="rounded-2xl border border-slate-200 bg-white p-5 sm:p-6 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <div class="flex items-center gap-2.5">
                        <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-base font-bold text-slate-900">Saved Items</h2>
                            <p class="text-xs text-slate-500">Books saved in your account matching "{{ $q }}"</p>
                        </div>
                    </div>
                    <a href="{{ route('student.saved-items.index') }}" class="text-xs font-bold text-[#102b70] hover:underline">
                        View Saved Items &rarr;
                    </a>
                </div>

                @if($savedItems->isEmpty())
                    <p class="text-xs text-slate-500 py-3 italic">No saved items found matching "{{ $q }}".</p>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($savedItems as $item)
                            @php
                                $bookData = $item->bookData;
                                $detail = $bookData?->bookDetail;
                            @endphp
                            <div class="flex items-center gap-3 p-3 rounded-xl border border-slate-200/80 bg-slate-50/50 hover:bg-white hover:border-[#102b70]/30 transition-all shadow-2xs">
                                <div class="h-12 w-10 shrink-0 rounded-lg bg-slate-200 overflow-hidden shadow-xs">
                                    @if($detail?->cover_image)
                                        <img src="{{ asset('storage/' . $detail->cover_image) }}" alt="{{ $bookData?->book_title }}" class="h-full w-full object-cover">
                                    @else
                                        <div class="h-full w-full flex items-center justify-center bg-slate-300 text-slate-500 font-bold text-xs">Book</div>
                                    @endif
                                </div>
                                <div class="min-w-0 flex-1">
                                    <h4 class="text-xs font-bold text-slate-900 truncate">{{ $bookData?->book_title ?? 'Saved Book' }}</h4>
                                    <p class="text-[10px] text-slate-500 truncate">ISBN: {{ $detail?->isbn ?? 'N/A' }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>

            <!-- 4. Library Catalog Books Section -->
            <section class="rounded-2xl border border-slate-200 bg-white p-5 sm:p-6 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <div class="flex items-center gap-2.5">
                        <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-slate-100 text-slate-700">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-base font-bold text-slate-900">Library Catalog Books</h2>
                            <p class="text-xs text-slate-500">Books in the PGPC Library collection matching "{{ $q }}"</p>
                        </div>
                    </div>
                    <a href="{{ route('opac.index') }}?q={{ urlencode($q) }}" class="text-xs font-bold text-[#102b70] hover:underline">
                        Open Full Catalog &rarr;
                    </a>
                </div>

                @if($catalogBooks->isEmpty())
                    <p class="text-xs text-slate-500 py-3 italic">No catalog books found matching "{{ $q }}".</p>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach($catalogBooks as $book)
                            @php
                                $detail = $book->bookDetail;
                            @endphp
                            <div class="flex flex-col justify-between p-4 rounded-2xl border border-slate-200 bg-white hover:shadow-md transition-all group">
                                <div class="space-y-3">
                                    <div class="h-40 w-full rounded-xl bg-slate-100 overflow-hidden flex items-center justify-center">
                                        @if($detail?->cover_image)
                                            <img src="{{ asset('storage/' . $detail->cover_image) }}" alt="{{ $book->book_title }}" class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-300">
                                        @else
                                            <svg class="h-12 w-12 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                            </svg>
                                        @endif
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-bold text-slate-900 group-hover:text-[#102b70] line-clamp-2 transition-colors">{{ $book->book_title }}</h3>
                                        @if($book->authors && $book->authors->count())
                                            <p class="text-xs font-medium text-slate-500 mt-1 truncate">By {{ $book->authors->pluck('first_name')->join(', ') }}</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                                    <span class="text-[10px] font-bold text-slate-500">
                                        ISBN: {{ $detail?->isbn ?? 'N/A' }}
                                    </span>
                                    <a href="{{ route('student.reservations.create', $book->book_data_id) }}" class="inline-flex items-center gap-1 text-xs font-bold text-[#102b70] hover:underline">
                                        Reserve
                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>

        @endif
    </div>
</x-layout.student>
