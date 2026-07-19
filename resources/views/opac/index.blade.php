<x-layout.welcome title="Online Public Access Catalog | PGPC Library System" active="opac">
    @php
        $memberAccount = Auth::guard('member')->user();
        $isStudentAccount =
            $memberAccount &&
            $memberAccount->member_id &&
            in_array(strtolower((string) $memberAccount->account_type), ['member', 'student'], true);
        $hasFilters = $search !== '' || $selectedCategoryId !== null || $sort !== 'title_asc';
        $selectedCategory =
            $selectedCategoryId !== null ? $categories->firstWhere('category_id', $selectedCategoryId) : null;
    @endphp

    <section class="relative overflow-hidden bg-primaryfade pb-14 pt-28 text-white sm:pb-16 sm:pt-32">
        <div class="absolute inset-0 bg-cover bg-center opacity-[0.08]"
            style="background-image: url('{{ Vite::asset('resources/images/pgpc-ng.png') }}')" aria-hidden="true">
        </div>
        <div class="absolute inset-0 bg-gradient-to-r from-primaryfade" aria-hidden="true"></div>
        <div class="absolute -left-24 top-1/3 h-56 w-56 rounded-full border border-white/10" aria-hidden="true"></div>
        <div class="absolute -right-24 bottom-0 h-64 w-64 rounded-full bg-gold/10 blur-3xl" aria-hidden="true"></div>

        <div class="container relative z-10 mx-auto px-5 sm:px-6 md:px-12">
            <div class="mx-auto max-w-5xl text-center">

                <p class="text-xs font-bold uppercase text-gold">PGPC Library System</p>
                <h1 class="mt-3 whitespace-nowrap text-2xl font-bold leading-tight tracking-tight text-white sm:text-4xl lg:text-6xl">
                        Online Public Access Catalog
                </h1>
                <p class="mx-auto mt-5 max-w-2xl text-base leading-7 text-blue-100 sm:text-lg">
                    Search the library collection by title, author, ISBN, or call number and check each title's
                    availability.
                </p>

                <form action="{{ route('opac.index') }}" method="GET" class="mx-auto mt-8 max-w-3xl">
                    @if ($selectedCategoryId !== null)
                        <input type="hidden" name="category" value="{{ $selectedCategoryId }}">
                    @endif
                    @if ($sort !== 'title_asc')
                        <input type="hidden" name="sort" value="{{ $sort }}">
                    @endif

                    <label for="catalog-search" class="sr-only">Search the library catalog</label>
                    <div
                        class="flex min-w-0 flex-col gap-2 rounded-2xl bg-white p-2 shadow-elegant sm:flex-row sm:items-center sm:rounded-full">
                        <div class="flex min-w-0 flex-1 items-center gap-3 px-3 sm:px-4">
                            <svg class="h-5 w-5 shrink-0 text-slate-400" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m21 21-4.35-4.35m1.35-5.65a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                            </svg>
                            <input id="catalog-search" name="q" type="search" value="{{ $search }}"
                                maxlength="150" placeholder="Title, author, ISBN, or call number"
                                class="min-w-0 flex-1 border-0 bg-transparent py-3 text-base text-slate-800 outline-none placeholder:text-slate-400 focus:ring-0">
                        </div>
                        <button type="submit"
                            class="btn h-auto min-h-12 w-full rounded-xl border-none bg-gold px-7 py-3 font-bold text-primaryfade transition hover:bg-[#ffd84c] focus-visible:outline-offset-2 focus-visible:outline-white sm:w-auto sm:rounded-full">
                            Search Catalog
                        </button>
                    </div>
                </form>

                @guest('member')
                    <p class="mt-5 text-sm text-blue-100">
                        Want to reserve a library title?
                        <a href="{{ route('login') }}"
                            class="font-bold text-gold underline decoration-transparent underline-offset-4 transition hover:decoration-current">
                            Student Login
                        </a>
                    </p>
                @endguest

                <p class="mt-3 text-sm text-blue-100">
                    Need more specific results?
                    <a href="{{ route('opac.search') }}"
                        class="font-bold text-gold underline decoration-transparent underline-offset-4 transition hover:decoration-current">
                        Advanced Search
                    </a>
                </p>
            </div>
        </div>
    </section>

    <x-opac.book-list 
        :categories="$categories"
        :search="$search"
        :selectedCategoryId="$selectedCategoryId"
        :sort="$sort"
        :hasFilters="$hasFilters"
        :sortOptions="$sortOptions"
        :selectedCategory="$selectedCategory"
        :statusOptions="$statusOptions"
        :selectedStatuses="$selectedStatuses"
        :selectedCategoryIds="$selectedCategoryIds"
        :yearFrom="$yearFrom"
        :yearTo="$yearTo"
        :books="$books"
        :isStudentAccount="$isStudentAccount"
        :memberAccount="$memberAccount"
    />

    {{-- AJAX Book Detail Modal --}}
    <dialog id="opac-book-detail-modal" class="modal modal-bottom p-0 sm:modal-middle sm:p-4" aria-labelledby="opac-book-detail-title">
        <div class="modal-box relative max-h-[94dvh] w-full max-w-none overflow-y-auto rounded-t-[1.75rem] bg-white p-0 shadow-2xl sm:w-[min(92vw,52rem)] sm:max-w-[52rem] sm:rounded-[1.75rem]">
            <div class="sticky top-0 z-20 overflow-hidden bg-gradient-to-r from-[#0b225e] to-[#183c82] text-white">
                <div class="absolute inset-x-0 bottom-0 h-px bg-[#fcc719]/80"></div>
                <div class="flex items-center justify-between gap-4 px-5 py-4 sm:px-7 sm:py-5">
                    <div class="min-w-0">
                        <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#fcc719]">Library catalog</p>
                        <h3 id="opac-book-detail-title" class="mt-0.5 text-lg font-bold text-white sm:text-xl">Book Details</h3>
                    </div>
                    <form method="dialog" class="shrink-0">
                        <button type="submit"
                            class="grid h-10 w-10 place-items-center rounded-full border border-white/20 bg-white/10 text-white transition hover:border-white/40 hover:bg-white/20 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#fcc719]"
                            aria-label="Close book details">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

            <div id="opac-modal-body" class="p-5 sm:p-7 lg:p-8">
                {{-- Skeleton loading --}}
                <div id="opac-modal-skeleton" class="animate-pulse">
                    <div class="grid gap-6 sm:grid-cols-[10rem_minmax(0,1fr)] sm:gap-7">
                        <div class="mx-auto aspect-[2/3] w-36 rounded-2xl bg-slate-200 sm:w-40"></div>
                        <div class="min-w-0 space-y-4">
                            <div class="h-5 w-28 rounded-full bg-amber-100"></div>
                            <div class="h-8 w-4/5 rounded-lg bg-slate-200"></div>
                            <div class="h-5 w-1/2 rounded bg-slate-100"></div>
                            <div class="grid grid-cols-2 gap-3 pt-2">
                                <div class="h-20 rounded-xl bg-slate-100"></div>
                                <div class="h-20 rounded-xl bg-slate-100"></div>
                                <div class="h-20 rounded-xl bg-slate-100"></div>
                                <div class="h-20 rounded-xl bg-slate-100"></div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-7 h-20 rounded-2xl bg-slate-100"></div>
                    <div class="mt-5 space-y-2">
                        <div class="h-4 w-1/5 rounded bg-slate-200"></div>
                        <div class="h-3 w-full rounded bg-slate-100"></div>
                        <div class="h-3 w-5/6 rounded bg-slate-100"></div>
                    </div>
                </div>
                {{-- AJAX content injected here --}}
                <div id="opac-modal-content" class="hidden transition-opacity duration-200"></div>
            </div>
        </div>
        <form method="dialog" class="modal-backdrop bg-slate-950/60 backdrop-blur-[2px]"><button aria-label="Close book details">close</button></form>
    </dialog>
</x-layout.welcome>
