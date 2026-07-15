<x-layout.welcome title="Advanced Search | PGPC Library System" active="opac">
    <!-- Hero Section -->
    <section class="relative overflow-hidden bg-primaryfade pb-28 pt-32 sm:pb-36 sm:pt-40">
        <div class="absolute inset-0 bg-cover bg-center opacity-[0.05]"
            style="background-image: url('{{ Vite::asset('resources/images/pgpc-ng.png') }}')" aria-hidden="true">
        </div>
        <div class="absolute inset-0 bg-gradient-to-r from-primaryfade" aria-hidden="true"></div>
        <div class="container relative z-10 mx-auto px-5 sm:px-6 md:px-12">
            <div class="mx-auto max-w-4xl text-center">
                <p class="text-xs font-bold uppercase tracking-[0.2em] text-gold">Advanced Search</p>
                <h1 class="mt-3 text-3xl font-bold leading-tight tracking-tight text-white sm:text-5xl">
                    Find Specific Resources
                </h1>
                <p class="mx-auto mt-5 max-w-2xl text-base leading-7 text-blue-100 sm:text-lg">
                    Use the fields below to perform a highly targeted search across the PGPC Library catalog.
                </p>
            </div>
        </div>
    </section>

    <!-- Form Section -->
    <section class="relative z-20 -mt-20 pb-20">
        <div class="container mx-auto px-5 sm:px-6 md:px-12">
            <div class="mx-auto w-full rounded-3xl border border-slate-100 bg-white p-6 shadow-elegant sm:p-10">
                <form action="{{ route('opac.index') }}" method="GET">
                    
                    <!-- Search Actions & Limit (Top) -->
                    <div class="sticky top-[64px] z-30 bg-white border-b border-slate-100 -mx-6 px-6 sm:-mx-10 sm:px-10 pt-2 pb-4 sm:pb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex flex-wrap items-center gap-2">
                            <button type="submit" class="inline-flex min-h-10 items-center justify-center rounded-xl bg-primaryfade px-5 py-2 text-sm font-bold text-white transition hover:bg-primary">
                                Submit Search
                            </button>
                            <button type="reset" class="inline-flex min-h-10 items-center justify-center rounded-xl border border-slate-200 bg-slate-50 px-5 py-2 text-sm font-bold text-slate-600 transition hover:bg-slate-100 hover:text-slate-900">
                                Clear
                            </button>
                            <a href="{{ route('opac.index') }}" class="inline-flex min-h-10 items-center justify-center rounded-xl border border-slate-200 bg-white px-5 py-2 text-sm font-bold text-slate-600 transition hover:bg-slate-50">
                                Exit Catalog
                            </a>
                        </div>
                        
                        <div class="flex items-center gap-3">
                            <label for="limit" class="text-xs font-bold uppercase tracking-wider text-slate-500">Max Records to Display</label>
                            <div class="relative">
                                <select id="limit" name="limit" class="appearance-none rounded-xl border border-slate-200 bg-slate-50 py-2 pl-4 pr-10 text-sm font-semibold text-slate-700 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="50" selected>50</option>
                                    <option value="100">100</option>
                                </select>
                                <svg class="pointer-events-none absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6 9 6 6 6-6" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Search Fields Container -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-8 gap-y-5 mt-6">
                        
                        <!-- Key Words (Full Width) -->
                        <div class="lg:col-span-2 space-y-1.5">
                            <label for="keywords" class="block text-sm font-bold text-slate-700">Key Words</label>
                            <input type="text" id="keywords" name="q" class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-800 placeholder-slate-400 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20" placeholder="Enter keywords...">
                            <div>
                                <label class="inline-flex items-center gap-2 cursor-pointer group">
                                    <input type="checkbox" name="use_operators" class="h-4 w-4 rounded border-slate-300 text-primary accent-primary focus:ring-primary/25 transition"> 
                                    <span class="text-xs font-semibold text-slate-500 group-hover:text-slate-700 transition">Use my search operators</span>
                                </label>
                            </div>
                        </div>

                        <!-- Separator -->
                        <div class="lg:col-span-2 h-px w-full bg-gradient-to-r from-transparent via-slate-100 to-transparent my-1"></div>

                        <!-- Title -->
                        <div class="space-y-1.5">
                            <label for="title" class="block text-sm font-bold text-slate-700">Title</label>
                            <div class="flex gap-2">
                                <input type="text" id="title" name="title" class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-800 placeholder-slate-400 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20" placeholder="Search by title...">
                                <button type="button" class="inline-flex shrink-0 items-center justify-center rounded-xl bg-slate-100 px-4 text-xs font-bold text-slate-600 hover:bg-slate-200 transition">Titles</button>
                            </div>
                            <div>
                                <label class="inline-flex items-center gap-2 cursor-pointer group">
                                    <input type="checkbox" name="title_exact" class="h-4 w-4 rounded border-slate-300 text-primary accent-primary focus:ring-primary/25 transition"> 
                                    <span class="text-xs font-semibold text-slate-500 group-hover:text-slate-700 transition">Match exactly as pasted/entered</span>
                                </label>
                            </div>
                        </div>

                        <!-- Author -->
                        <div class="space-y-1.5">
                            <label for="author" class="block text-sm font-bold text-slate-700">Personal or Corporate Author</label>
                            <div class="flex gap-2">
                                <input type="text" id="author" name="author" class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-800 placeholder-slate-400 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20" placeholder="Search by author...">
                                <button type="button" class="inline-flex shrink-0 items-center justify-center rounded-xl bg-slate-100 px-4 text-xs font-bold text-slate-600 hover:bg-slate-200 transition">Names</button>
                            </div>
                            <div>
                                <label class="inline-flex items-center gap-2 cursor-pointer group">
                                    <input type="checkbox" name="author_exact" class="h-4 w-4 rounded border-slate-300 text-primary accent-primary focus:ring-primary/25 transition"> 
                                    <span class="text-xs font-semibold text-slate-500 group-hover:text-slate-700 transition">Match exactly as pasted/entered</span>
                                </label>
                            </div>
                        </div>

                        <!-- Subjects -->
                        <div class="space-y-1.5">
                            <label for="subject" class="block text-sm font-bold text-slate-700">Subjects</label>
                            <div class="flex gap-2">
                                <input type="text" id="subject" name="subject" class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-800 placeholder-slate-400 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20" placeholder="Search by subject...">
                                <button type="button" class="inline-flex shrink-0 items-center justify-center rounded-xl bg-slate-100 px-4 text-xs font-bold text-slate-600 hover:bg-slate-200 transition">Subjects</button>
                            </div>
                            <div>
                                <label class="inline-flex items-center gap-2 cursor-pointer group">
                                    <input type="checkbox" name="subject_exact" class="h-4 w-4 rounded border-slate-300 text-primary accent-primary focus:ring-primary/25 transition"> 
                                    <span class="text-xs font-semibold text-slate-500 group-hover:text-slate-700 transition">Match exactly as pasted/entered</span>
                                </label>
                            </div>
                        </div>

                        <!-- Call Number -->
                        <div class="space-y-1.5">
                            <label for="call_number" class="block text-sm font-bold text-slate-700">Call Number(s)</label>
                            <div class="flex gap-2">
                                <input type="text" id="call_number" name="call_number" class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-800 placeholder-slate-400 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20" placeholder="Search by call number...">
                                <button type="button" class="inline-flex shrink-0 items-center justify-center rounded-xl bg-slate-100 px-4 text-xs font-bold text-slate-600 hover:bg-slate-200 transition">Call Nos.</button>
                            </div>
                            <div>
                                <label class="inline-flex items-center gap-2 cursor-pointer group">
                                    <input type="checkbox" name="call_number_exact" class="h-4 w-4 rounded border-slate-300 text-primary accent-primary focus:ring-primary/25 transition"> 
                                    <span class="text-xs font-semibold text-slate-500 group-hover:text-slate-700 transition">Match exactly as pasted/entered</span>
                                </label>
                            </div>
                        </div>

                        <!-- Separator -->
                        <div class="lg:col-span-2 h-px w-full bg-gradient-to-r from-transparent via-slate-100 to-transparent my-1"></div>

                        <!-- Format -->
                        <div class="space-y-1.5">
                            <label for="format" class="block text-sm font-bold text-slate-700">Format</label>
                            <div class="flex gap-2">
                                <div class="relative w-full">
                                    <select id="format" name="format" class="appearance-none w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-4 pr-10 text-sm font-medium text-slate-800 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">
                                        <option value="">All Formats</option>
                                        <option value="book">Book</option>
                                        <option value="journal">Journal</option>
                                        <option value="dvd">DVD / CD</option>
                                        <option value="map">Map</option>
                                    </select>
                                    <svg class="pointer-events-none absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6 9 6 6 6-6" />
                                    </svg>
                                </div>
                                <button type="button" class="inline-flex shrink-0 items-center justify-center rounded-xl bg-slate-100 px-4 text-xs font-bold text-slate-600 hover:bg-slate-200 transition">Formats</button>
                            </div>
                        </div>

                        <!-- Publication Year -->
                        <div class="space-y-1.5">
                            <label class="block text-sm font-bold text-slate-700">Publication Year</label>
                            <div class="flex items-center gap-3">
                                <input type="number" name="year_from" placeholder="From (e.g. 1990)" class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-800 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">
                                <span class="text-sm font-bold text-slate-400">to</span>
                                <input type="number" name="year_to" placeholder="To (e.g. 2024)" class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-800 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">
                            </div>
                        </div>

                        <!-- Checkboxes bottom (Full Width) -->
                        <div class="lg:col-span-2 pt-2">
                            <label class="inline-flex items-center gap-2 cursor-pointer group">
                                <input type="checkbox" name="exclude_on_order" class="h-4 w-4 rounded border-slate-300 text-primary accent-primary focus:ring-primary/25 transition"> 
                                    <span class="text-xs font-semibold text-slate-500 group-hover:text-slate-700 transition">Exclude titles on order</span>
                            </label>
                        </div>

                    </div>

                    <!-- Actions (Bottom) -->
                    <div class="mt-8 flex flex-wrap justify-center sm:justify-start items-center gap-3 border-t border-slate-100 pt-6">
                        <button type="submit" class="inline-flex min-h-11 items-center justify-center rounded-xl bg-gold px-8 py-2 text-sm font-bold text-primaryfade transition hover:bg-[#ffd84c]">
                            Submit Search
                        </button>
                        <button type="reset" class="inline-flex min-h-11 items-center justify-center rounded-xl border border-slate-200 bg-slate-50 px-6 py-2 text-sm font-bold text-slate-600 transition hover:bg-slate-100 hover:text-slate-900">
                            Clear
                        </button>
                        <a href="{{ route('opac.index') }}" class="inline-flex min-h-11 items-center justify-center rounded-xl border border-slate-200 bg-white px-6 py-2 text-sm font-bold text-slate-600 transition hover:bg-slate-50">
                            Exit Catalog
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</x-layout.welcome>
