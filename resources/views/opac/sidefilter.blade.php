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

        {{-- Availability --}}
        <div class="mt-4 border-t border-slate-100 pt-4">
            <span class="mb-2 block text-xs font-bold uppercase tracking-[0.12em] text-slate-500">
                Availability
            </span>
            <div class="space-y-2">
                @foreach ($statusOptions as $value => $label)
                    <label class="flex items-center gap-2.5 text-sm font-medium text-slate-700">
                        <input type="checkbox" name="status[]" value="{{ $value }}"
                            @checked(in_array($value, $selectedStatuses ?? []))
                            class="h-4 w-4 rounded border-slate-300 text-primary accent-primary focus:ring-primary/25">
                        {{ $label }}
                    </label>
                @endforeach
            </div>
        </div>

        {{-- Category (multi-select: a title can belong to more than one) --}}
        <div class="mt-4 border-t border-slate-100 pt-4">
            <span class="mb-2 block text-xs font-bold uppercase tracking-[0.12em] text-slate-500">
                Category
            </span>
            <div class="max-h-48 space-y-2 overflow-y-auto pr-1">
                @foreach ($categories as $category)
                    <label class="flex items-center gap-2.5 text-sm font-medium text-slate-700">
                        <input type="checkbox" name="category[]" value="{{ $category->category_id }}"
                            @checked(in_array((string) $category->category_id, $selectedCategoryIds ?? []))
                            class="h-4 w-4 rounded border-slate-300 text-primary accent-primary focus:ring-primary/25">
                        {{ $category->category_name }}
                    </label>
                @endforeach
            </div>
        </div>

        {{-- Publication year range --}}
        <div class="mt-4 border-t border-slate-100 pt-4">
            <span class="mb-2 block text-xs font-bold uppercase tracking-[0.12em] text-slate-500">
                Publication Year
            </span>
            <div class="flex items-center gap-2">
                <input type="number" name="year_from" inputmode="numeric" placeholder="From"
                    value="{{ $yearFrom ?? '' }}" min="1900" max="{{ date('Y') }}"
                    class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm font-semibold text-slate-700 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/15">
                <span class="text-slate-400">–</span>
                <input type="number" name="year_to" inputmode="numeric" placeholder="To"
                    value="{{ $yearTo ?? '' }}" min="1900" max="{{ date('Y') }}"
                    class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm font-semibold text-slate-700 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/15">
            </div>
        </div>

        {{-- Sort --}}
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