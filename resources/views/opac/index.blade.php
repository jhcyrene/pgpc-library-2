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
                            class="btn h-auto min-h-12 w-full rounded-xl border-none bg-gold px-7 py-3 font-bold text-primaryfade transition hover:bg-[#ffd84c] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white sm:w-auto sm:rounded-full">
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
            </div>
        </div>
    </section>

    <x-opac 
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
</x-layout.welcome>
