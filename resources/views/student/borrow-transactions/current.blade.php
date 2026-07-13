<x-layout.student title="Current Borrows">
    <div class="max-w-7xl mx-auto">
        <x-student.page-header 
            title="Current Borrows" 
            subtitle="Books you are currently borrowing from the library." 
        />

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                <h3 class="font-bold text-gray-800">Showing {{ $borrows->firstItem() ?? 0 }} to {{ $borrows->lastItem() ?? 0 }} of {{ $borrows->total() }} items</h3>
                
                <form method="GET" action="{{ route('student.borrow-transactions.current') }}" class="flex items-center gap-2 text-sm">
                    <label for="sort" class="text-gray-600 font-medium hidden sm:block">Sort by:</label>
                    <select name="sort" id="sort" class="select select-sm select-bordered w-full max-w-xs focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all rounded-lg" onchange="this.form.submit()">
                        <option value="due_date_asc" {{ request('sort') == 'due_date_asc' ? 'selected' : '' }}>Due Date (Earliest first)</option>
                        <option value="due_date_desc" {{ request('sort') == 'due_date_desc' ? 'selected' : '' }}>Due Date (Latest first)</option>
                        <option value="issue_date_desc" {{ request('sort') == 'issue_date_desc' ? 'selected' : '' }}>Issue Date (Newest first)</option>
                    </select>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="table w-full">
                    <thead>
                        <tr class="bg-gray-50/50 text-gray-500 uppercase text-xs tracking-wider">
                            <th class="px-6 py-4 font-semibold">Book Details</th>
                            <th class="px-6 py-4 font-semibold">Accession No.</th>
                            <th class="px-6 py-4 font-semibold">Issue Date</th>
                            <th class="px-6 py-4 font-semibold">Due Date</th>
                            <th class="px-6 py-4 font-semibold text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($borrows as $borrow)
                            @php
                                $isOverdue = $borrow->due_date < now();
                            @endphp
                            <tr class="hover:bg-gray-50 transition-colors {{ $isOverdue ? 'bg-error/5' : '' }}">
                                <td class="px-6 py-4">
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
                                <td class="px-6 py-4 text-sm text-gray-600 font-medium">
                                    {{ $borrow->book->accession_number }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $borrow->issue_date->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 text-sm {{ $isOverdue ? 'text-error font-bold' : 'text-gray-600' }}">
                                    {{ $borrow->due_date->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    @if($isOverdue)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-error/10 text-error uppercase tracking-wider">
                                            Overdue
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-primary/10 text-primary uppercase tracking-wider">
                                            Borrowed
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                        <p class="text-lg font-medium text-gray-800 mb-1">No Current Borrows</p>
                                        <p class="text-sm">You do not have any books checked out right now.</p>
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
