<x-layout.student title="Borrowing History">
    <div class="max-w-[1600px] mx-auto w-full">
        <x-student.page-header 
            title="Borrowing History" 
            subtitle="A complete record of all the books you've read." 
        />

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-4 md:p-5 border-b border-gray-100 bg-gray-50/50 shrink-0">
                <div class="flex flex-col sm:flex-row gap-4 justify-between items-center">
                    <div>
                        <p class="text-sm font-semibold text-gray-600">
                            Showing <span class="text-gray-900 font-bold">{{ $borrows->firstItem() ?? 0 }}</span> to <span class="text-gray-900 font-bold">{{ $borrows->lastItem() ?? 0 }}</span> of <span class="text-gray-900 font-bold">{{ $borrows->total() }}</span> items
                        </p>
                    </div>
                    
                    <div class="w-full sm:w-auto">
                        <form method="GET" action="{{ route('student.borrow-transactions.history') }}" class="flex items-center gap-3 justify-end">
                            <label for="sort" class="text-xs font-bold uppercase tracking-wider text-gray-500 shrink-0">Sort By</label>
                            <select name="sort" id="sort" class="select select-bordered h-10 min-h-10 text-sm shadow-sm bg-white w-full sm:w-60 focus:border-primary focus:ring-primary/20 transition-all rounded-lg" onchange="this.form.submit()">
                                <option value="return_date_desc" {{ request('sort') == 'return_date_desc' ? 'selected' : '' }}>Returned (Newest first)</option>
                                <option value="return_date_asc" {{ request('sort') == 'return_date_asc' ? 'selected' : '' }}>Returned (Oldest first)</option>
                            </select>
                        </form>
                    </div>
                </div>
            </div>

            <div class="responsive-table-scroll">
                <table class="mobile-card-table table w-full">
                    <thead>
                        <tr class="bg-gray-50/50 text-gray-500 uppercase text-xs tracking-wider">
                            <th class="px-6 py-4 font-semibold">Book Details</th>
                            <th class="px-6 py-4 font-semibold">Accession No.</th>
                            <th class="px-6 py-4 font-semibold">Issue Date</th>
                            <th class="px-6 py-4 font-semibold">Return Date</th>
                            <th class="px-6 py-4 font-semibold text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($borrows as $borrow)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td data-primary class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-14 bg-gray-200 rounded shrink-0 overflow-hidden flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-gray-800">{{ $borrow->book->bookData->book_title }}</h4>
                                        </div>
                                    </div>
                                </td>
                                <td data-label="Accession no." class="px-6 py-4 text-sm text-gray-600 font-medium">
                                    {{ $borrow->book->accession_number }}
                                </td>
                                <td data-label="Issue date" class="px-6 py-4 text-sm text-gray-600">
                                    {{ $borrow->issue_date->format('M d, Y') }}
                                </td>
                                <td data-label="Return date" class="px-6 py-4 text-sm text-gray-600">
                                    {{ $borrow->return_date ? $borrow->return_date->format('M d, Y') : 'N/A' }}
                                </td>
                                <td data-label="Status" class="px-6 py-4 text-right">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-success/10 text-success uppercase tracking-wider">
                                        Returned
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td data-empty colspan="5" class="px-6 py-12 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <p class="text-lg font-medium text-gray-800 mb-1">No Borrowing History</p>
                                        <p class="text-sm">You haven't returned any books yet.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($borrows->hasPages())
                <div class="p-4 border-t border-gray-100 flex justify-center bg-gray-50/50">
                    {{ $borrows->links('vendor.pagination.tailwind') }}
                </div>
            @endif
        </div>
    </div>
</x-layout.student>
