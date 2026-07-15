<!-- Table -->
<div id="books-table-container" class="bg-white border-x border-b border-gray-200 rounded-b-xl shadow-sm flex flex-col min-h-0 flex-1">
    <div class="overflow-x-auto flex-1">
        <table class="w-full text-left border-collapse">
            <thead
                class="sticky top-0 z-10 bg-gray-50 border-y border-gray-200 text-xs font-bold text-gray-500 uppercase tracking-wider shadow-sm">
                <tr>
                    <th class="px-6 py-3">Book Details</th>
                    <th class="px-6 py-3">Author</th>
                    <th class="px-6 py-3">Category</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($allBooks as $book)
                <!-- Row -->
                <tr class="hover:bg-gray-50 transition-colors group">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-10 h-12 bg-gray-200 rounded border border-gray-300 flex items-center justify-center shrink-0 shadow-sm overflow-hidden text-gray-400 font-bold text-[10px] uppercase text-center leading-tight">
                                {{ strtoupper(substr($book->book_title, 0, 2)) }}<br>
                                {{ $book->bookDetail?->edition ? substr($book->bookDetail->edition, 0, 4) : '' }}
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-800">{{ $book->book_title }}</p>
                                <p class="text-xs text-gray-500 mt-0.5">ISBN: {{ $book->bookDetail?->isbn ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm font-medium text-gray-700">
                        {{ $book->authors->first()?->last_name ?? 'Unknown' }}{{ $book->authors->count() > 1 ? ' et al.' : '' }}
                    </td>
                    <td class="px-6 py-4">
                        <span
                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                            {{ $book->categories->first()?->category_name ?? 'Uncategorized' }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        @if ($book->copies_available > 0)
                            <span
                                class="inline-flex items-center gap-1.5 px-2 py-1 rounded-md text-xs font-bold bg-green-50 text-green-700 border border-green-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> {{ $book->copies_available }} Available
                            </span>
                        @elseif ($book->copies_total > 0)
                            <span
                                class="inline-flex items-center gap-1.5 px-2 py-1 rounded-md text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span> {{ $book->copies_borrowed }} Borrowed
                            </span>
                        @else
                            <span
                                class="inline-flex items-center gap-1.5 px-2 py-1 rounded-md text-xs font-bold bg-red-50 text-red-700 border border-red-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Unavailable
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <!-- View Button -->
                            <a href="{{ route('admin.books.show', $book->book_data_id) }}"
                                class="bg-gray-50 text-gray-500 hover:text-blue-600 hover:bg-blue-50 border border-gray-200 transition-colors px-2 py-1.5 rounded-md flex items-center justify-center shadow-sm"
                                title="View">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>
                            <!-- Edit Button -->
                            <a href="{{ route('admin.books.edit', $book->book_data_id) }}"
                                class="bg-gray-50 text-gray-500 hover:text-[#102b70] hover:bg-gray-100 border border-gray-200 transition-colors px-2 py-1.5 rounded-md flex items-center justify-center shadow-sm"
                                title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </a>
                            <!-- Delete Form -->
                            <form action="{{ route('admin.books.destroy', $book->book_data_id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this book?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="bg-red-50 text-red-500 hover:text-white hover:bg-red-500 border border-red-100 hover:border-red-500 transition-colors px-2 py-1.5 rounded-md flex items-center justify-center shadow-sm"
                                    title="Delete">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        <p class="text-sm">No books available in the catalog.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="ajax-pagination-wrapper px-6 py-4 border-t border-gray-200 bg-gray-50 flex items-center justify-between shrink-0">
        @if(isset($allBooks) && $allBooks instanceof \Illuminate\Pagination\LengthAwarePaginator && $allBooks->hasPages())
            {{ $allBooks->links() }}
        @else
            <span class="text-sm text-gray-500">Showing <span class="font-bold text-gray-800">{{ count($allBooks ?? []) }}</span> books</span>
        @endif
    </div>
</div>
