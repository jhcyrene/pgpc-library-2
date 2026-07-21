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

    <!-- OPAC Hero Banner Section (Matching Mockup) -->
    <section class="relative overflow-hidden bg-brand-navy pb-14 pt-28 text-white sm:pb-16 sm:pt-32 font-sans">
        <div class="absolute inset-0 bg-cover bg-center opacity-10"
            style="background-image: url('{{ Vite::asset('resources/images/webp/pgpc-ng.webp') }}')" aria-hidden="true">
        </div>
        <div class="absolute inset-0 bg-gradient-to-b from-[#111c38]/95 via-brand-navy/90 to-brand-navy" aria-hidden="true"></div>
        
        <!-- Background Seal Watermark (Matching Mockup) -->
        <div class="absolute -right-20 top-1/2 -translate-y-1/2 h-96 w-96 opacity-10 pointer-events-none">
            <img src="{{ Vite::asset('resources/images/webp/hd-pgpc-logo.webp') }}" class="w-full h-full object-contain grayscale" alt="Watermark">
        </div>

        <div class="container relative z-10 mx-auto px-5 sm:px-6 md:px-12">
            <div class="mx-auto max-w-4xl text-center space-y-4">
                <p class="text-xs font-black uppercase tracking-[0.2em] text-brand-gold">PGPC LIBRARY SYSTEM</p>
                <h1 class="text-3xl font-black leading-tight tracking-tight text-white sm:text-5xl lg:text-6xl">
                    Online Public Access Catalog
                </h1>
                <p class="mx-auto max-w-2xl text-sm font-medium leading-relaxed text-blue-100/90 sm:text-base">
                    Search the library collection by title, author, ISBN, or call number and check each title's availability.
                </p>

                <!-- Search Input Bar -->
                <form action="{{ route('opac.index') }}" method="GET" class="mx-auto pt-4 max-w-2xl">
                    @if ($selectedCategoryId !== null)
                        <input type="hidden" name="category" value="{{ $selectedCategoryId }}">
                    @endif
                    @if ($sort !== 'title_asc')
                        <input type="hidden" name="sort" value="{{ $sort }}">
                    @endif

                    <div class="flex min-w-0 flex-col gap-2 rounded-2xl bg-white p-2 shadow-xl sm:flex-row sm:items-center sm:rounded-full">
                        <div class="flex min-w-0 flex-1 items-center gap-3 px-4">
                            <svg class="h-5 w-5 shrink-0 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-4.35-4.35m1.35-5.65a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                            </svg>
                            <input id="catalog-search" name="q" type="search" value="{{ $search }}"
                                placeholder="Title, author, ISBN, or call number"
                                class="w-full border-0 bg-transparent py-2.5 text-sm text-slate-900 placeholder:text-slate-400 outline-none font-medium">
                        </div>
                        <button type="submit"
                            class="px-6 py-3 rounded-xl sm:rounded-full bg-brand-gold hover:bg-[#ffc824] text-brand-navy font-black text-xs uppercase tracking-wider transition-all shadow-sm shrink-0">
                            Search Catalog
                        </button>
                    </div>
                </form>

                <div class="flex flex-wrap items-center justify-center gap-4 text-xs font-semibold text-blue-100/80 pt-2">
                    @guest('member')
                        <p>
                            Want to reserve a library title?
                            <a href="{{ route('login') }}" class="font-bold text-brand-gold hover:underline">Student Login</a>
                        </p>
                        <span class="text-white/20">•</span>
                    @endguest

                    <p>
                        Need more specific results?
                        <a href="{{ route('opac.search') }}" class="font-bold text-brand-gold hover:underline">Advanced Search</a>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Catalog Results Section -->
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

    <!-- AJAX Book Detail Modal -->
    <dialog id="opac-book-detail-modal" class="modal modal-bottom p-0 sm:modal-middle sm:p-4 font-sans" aria-labelledby="opac-book-detail-title">
        <div class="modal-box relative max-h-[94dvh] w-full max-w-none overflow-y-auto rounded-t-2xl bg-white p-0 shadow-2xl sm:w-[min(92vw,52rem)] sm:max-w-[52rem] sm:rounded-2xl border border-slate-200">
            <div class="sticky top-0 z-20 overflow-hidden bg-brand-navy text-white">
                <div class="absolute inset-x-0 bottom-0 h-px bg-brand-gold"></div>
                <div class="flex items-center justify-between gap-4 px-5 py-4 sm:px-7 sm:py-5">
                    <div class="min-w-0">
                        <p class="text-[10px] font-extrabold uppercase tracking-[0.2em] text-brand-gold">Book Details</p>
                        <h3 id="opac-book-detail-title" class="mt-0.5 text-lg font-extrabold text-white sm:text-xl">Title Information</h3>
                    </div>
                    <form method="dialog" class="shrink-0">
                        <button type="submit"
                            class="w-8 h-8 rounded-full border border-white/20 bg-white/10 text-white hover:bg-white/20 flex items-center justify-center transition-colors">
                            ✕
                        </button>
                    </form>
                </div>
            </div>


            <div id="opac-modal-body" class="p-5 sm:p-7 lg:p-8">
                <!-- Skeleton loading -->
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
                </div>
                <!-- AJAX content injected here -->
                <div id="opac-modal-content" class="hidden transition-opacity duration-200"></div>
            </div>
        </div>
        <form method="dialog" class="modal-backdrop bg-slate-950/60 backdrop-blur-[2px]"><button>close</button></form>
    </dialog>
</x-layout.welcome>
