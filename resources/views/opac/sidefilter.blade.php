<aside class="min-w-0 font-sans" aria-label="Catalog filters">
    <form action="{{ route('opac.index') }}" method="GET"
        class="rounded-2xl border border-slate-200 bg-white p-5 shadow-xs lg:sticky lg:top-24 space-y-5">
        @if ($search !== '')
            <input type="hidden" name="q" value="{{ $search }}">
        @endif

        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-blue-50 text-brand-navy flex items-center justify-center font-bold shrink-0">
                    <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h18M6 12h12m-9 8h6" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-sm font-extrabold text-slate-900 leading-tight">Filter Catalog</h2>
                </div>
            </div>
            @if ($hasFilters)
                <a href="{{ route('opac.index') }}" class="text-xs font-bold text-blue-600 hover:text-blue-800 transition-colors">
                    Clear all
                </a>
            @endif
        </div>

        {{-- Availability --}}
        <div>
            <span class="mb-2.5 block text-xs font-extrabold uppercase tracking-wider text-slate-400">
                Availability
            </span>
            <div class="space-y-2">
                @foreach ($statusOptions as $value => $label)
                    <label class="flex items-center gap-2.5 text-xs font-semibold text-slate-700 hover:text-slate-900 cursor-pointer">
                        <input type="checkbox" name="status[]" value="{{ $value }}"
                            @checked(in_array($value, $selectedStatuses ?? []))
                            class="h-4 w-4 rounded border-slate-300 text-brand-navy accent-brand-navy focus:ring-brand-navy/20">
                        {{ $label }}
                    </label>
                @endforeach
            </div>
        </div>

        {{-- Category --}}
        <div class="border-t border-slate-100 pt-4">
            <span class="mb-2.5 block text-xs font-extrabold uppercase tracking-wider text-slate-400">
                Category
            </span>
            <div class="max-h-52 space-y-2 overflow-y-auto pr-1">
                @foreach ($categories as $category)
                    <label class="flex items-center gap-2.5 text-xs font-semibold text-slate-700 hover:text-slate-900 cursor-pointer">
                        <input type="checkbox" name="category[]" value="{{ $category->category_id }}"
                            @checked(in_array((string) $category->category_id, $selectedCategoryIds ?? []))
                            class="h-4 w-4 rounded border-slate-300 text-brand-navy accent-brand-navy focus:ring-brand-navy/20">
                        <span class="truncate">{{ $category->category_name }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        {{-- Publication year range --}}
        <div class="border-t border-slate-100 pt-4">
            <span class="mb-2.5 block text-xs font-extrabold uppercase tracking-wider text-slate-400">
                Publication Year
            </span>
            <div class="flex items-center gap-2">
                <input type="number" name="year_from" inputmode="numeric" placeholder="From"
                    value="{{ $yearFrom ?? '' }}" min="1900" max="{{ date('Y') }}"
                    class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-xs font-semibold text-slate-800 outline-none transition focus:bg-white focus:border-brand-navy">
                <span class="text-slate-400 text-xs">–</span>
                <input type="number" name="year_to" inputmode="numeric" placeholder="To"
                    value="{{ $yearTo ?? '' }}" min="1900" max="{{ date('Y') }}"
                    class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-xs font-semibold text-slate-800 outline-none transition focus:bg-white focus:border-brand-navy">
            </div>
        </div>

        {{-- Sort --}}
        <div class="border-t border-slate-100 pt-4">
            <label for="catalog-sort" class="mb-2.5 block text-xs font-extrabold uppercase tracking-wider text-slate-400">
                Sort Results
            </label>
            <div class="relative">
                <select id="catalog-sort" name="sort"
                    class="w-full appearance-none rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-2.5 pr-9 text-xs font-semibold text-slate-800 outline-none transition focus:bg-white focus:border-brand-navy">
                    @foreach ($sortOptions as $value => $label)
                        <option value="{{ $value }}" @selected($sort === $value)>{{ $label }}</option>
                    @endforeach
                </select>
                <svg class="pointer-events-none absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6 9 6 6 6-6" />
                </svg>
            </div>
        </div>

        <div class="pt-2">
            <button type="submit"
                class="w-full py-2.5 bg-brand-navy hover:bg-brand-navy-light text-white font-bold text-xs rounded-xl transition-all shadow-2xs">
                Apply Filters
            </button>
        </div>
    </form>
</aside>

