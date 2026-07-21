<!-- Books Table Container -->
<div id="books-table-container" class="bg-white border border-slate-200 rounded-2xl shadow-sm flex flex-col flex-1 overflow-hidden">
    
    <!-- DESKTOP / TABLET TABLE VIEW (Visible on lg screens and up) -->
    <div class="hidden lg:block overflow-x-auto flex-1" tabindex="0" role="region" aria-label="Books table">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50/80 border-b border-slate-200 text-[11px] font-extrabold text-slate-400 uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-4">Book Details</th>
                    <th class="px-6 py-4">Author</th>
                    <th class="px-6 py-4">Category</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($allBooks as $book)
                <tr class="hover:bg-blue-50/30 transition-colors group">
                    <!-- Book Details -->
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3.5">
                            <div class="w-10 h-12 bg-slate-100 rounded-xl border border-slate-200 flex items-center justify-center shrink-0 shadow-xs overflow-hidden text-[#102b70] font-black text-xs uppercase text-center leading-none">
                                {{ strtoupper(substr($book->book_title, 0, 2)) }}
                            </div>
                            <div class="min-w-0 max-w-xs">
                                <p class="text-sm font-extrabold text-slate-900 leading-snug truncate" title="{{ $book->book_title }}">{{ $book->book_title }}</p>
                                <p class="text-xs font-mono text-slate-500 mt-0.5">ISBN: {{ $book->bookDetail?->isbn ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </td>

                    <!-- Author -->
                    <td class="px-6 py-4 text-sm font-semibold text-slate-700">
                        {{ $book->authors->first()?->last_name ?? 'Unknown' }}{{ $book->authors->count() > 1 ? ' et al.' : '' }}
                    </td>

                    <!-- Category -->
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-bold bg-blue-50 text-blue-700 border border-blue-100">
                            {{ $book->categories->first()?->category_name ?? 'Uncategorized' }}
                        </span>
                    </td>

                    <!-- Status -->
                    <td class="px-6 py-4">
                        @if ($book->copies_available > 0)
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> {{ $book->copies_available }} Available
                            </span>
                        @elseif ($book->copies_total > 0)
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span> {{ $book->copies_borrowed }} Borrowed
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md text-xs font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Unavailable
                            </span>
                        @endif
                    </td>

                    <!-- Actions -->
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-1.5">
                            <!-- View Button -->
                            <a href="{{ route('admin.books.show', $book->book_data_id) }}"
                               class="p-2 rounded-lg bg-slate-50 text-slate-500 hover:text-blue-600 hover:bg-blue-50 border border-slate-200 transition-colors shadow-xs"
                               title="View Details">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>

                            <!-- Edit Button -->
                            <a href="{{ route('admin.books.edit', $book->book_data_id) }}"
                               class="p-2 rounded-lg bg-slate-50 text-slate-500 hover:text-[#102b70] hover:bg-slate-100 border border-slate-200 transition-colors shadow-xs"
                               title="Edit Book">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </a>

                            <!-- Delete Button -->
                            <form action="{{ route('admin.books.destroy', $book->book_data_id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this book?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="p-2 rounded-lg bg-rose-50 text-rose-500 hover:text-white hover:bg-rose-600 border border-rose-200 transition-colors shadow-xs"
                                        title="Delete Book">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto text-slate-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        <p class="font-bold text-slate-700 text-base">No books found</p>
                        <p class="text-xs text-slate-400 mt-1">Try adjusting your search terms or filters.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- MOBILE CARDS STACK VIEW (Visible on mobile/tablet < lg screens) -->
    <div class="lg:hidden p-4 space-y-3.5">
        @forelse ($allBooks as $book)
        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs flex flex-col gap-3 relative">
            
            <!-- Book Top Header (Thumbnail + Details) -->
            <div class="flex items-start gap-3.5">
                <div class="w-12 h-14 bg-slate-100 rounded-xl border border-slate-200 flex items-center justify-center shrink-0 text-[#102b70] font-black text-sm uppercase shadow-xs">
                    {{ strtoupper(substr($book->book_title, 0, 2)) }}
                </div>
                <div class="min-w-0 flex-1">
                    <h4 class="font-extrabold text-slate-900 text-base leading-tight truncate" title="{{ $book->book_title }}">
                        {{ $book->book_title }}
                    </h4>
                    <p class="text-xs text-slate-600 font-medium mt-0.5">
                        {{ $book->authors->first()?->last_name ?? 'Unknown' }}{{ $book->authors->count() > 1 ? ' et al.' : '' }}
                    </p>
                    <p class="text-xs font-mono text-slate-400 mt-0.5">
                        ISBN: {{ $book->bookDetail?->isbn ?? 'N/A' }}
                    </p>
                </div>
            </div>

            <!-- Category & Status Badges -->
            <div class="flex items-center justify-between flex-wrap gap-2 pt-1">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-bold bg-blue-50 text-blue-700 border border-blue-100">
                    {{ $book->categories->first()?->category_name ?? 'Uncategorized' }}
                </span>

                @if ($book->copies_available > 0)
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-md text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> {{ $book->copies_available }} Available
                    </span>
                @elseif ($book->copies_total > 0)
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-md text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> {{ $book->copies_borrowed }} Borrowed
                    </span>
                @else
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-md text-xs font-bold bg-rose-50 text-rose-700 border border-rose-200">
                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Unavailable
                    </span>
                @endif
            </div>

            <!-- Mobile Action Buttons (Grouped closely together at bottom right) -->
            <div class="flex items-center justify-end gap-1.5 pt-2.5 border-t border-slate-100">
                <!-- View -->
                <a href="{{ route('admin.books.show', $book->book_data_id) }}"
                   class="p-2 rounded-xl bg-slate-50 text-slate-500 hover:text-blue-600 hover:bg-blue-50 border border-slate-200 transition-colors shadow-xs"
                   title="View Details">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </a>

                <!-- Edit -->
                <a href="{{ route('admin.books.edit', $book->book_data_id) }}"
                   class="p-2 rounded-xl bg-slate-50 text-slate-500 hover:text-[#102b70] hover:bg-slate-100 border border-slate-200 transition-colors shadow-xs"
                   title="Edit Book">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                </a>

                <!-- Delete -->
                <form action="{{ route('admin.books.destroy', $book->book_data_id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this book?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="p-2 rounded-xl bg-rose-50 text-rose-500 hover:text-white hover:bg-rose-600 border border-rose-200 transition-colors shadow-xs"
                            title="Delete Book">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="bg-white border border-slate-200 rounded-2xl p-8 text-center text-slate-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto text-slate-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
            </svg>
            <p class="font-bold text-slate-700">No books found</p>
        </div>
        @endforelse
    </div>

    <!-- PAGINATION FOOTER -->
    <div class="p-4 border-t border-slate-200 bg-slate-50/50 flex flex-col sm:flex-row items-center justify-between gap-4 ajax-pagination-wrapper">
        <p class="text-xs font-semibold text-slate-500">
            Showing <span class="font-bold text-slate-900">{{ $allBooks->firstItem() ?? 0 }}</span> 
            to <span class="font-bold text-slate-900">{{ $allBooks->lastItem() ?? 0 }}</span> 
            of <span class="font-bold text-slate-900">{{ $allBooks->total() }}</span> results
        </p>
        <div>
            {{ $allBooks->links() }}
        </div>
    </div>
</div>
