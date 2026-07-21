<x-layout.student title="Borrow Transactions Overview">
    <div class="max-w-[1600px] mx-auto w-full">
        <x-student.page-header 
            title="Borrowing Overview" 
            subtitle="A high-level view of your borrowing activity." 
        />

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <a href="{{ route('student.borrow-transactions.current') }}" class="group bg-white rounded-2xl p-8 border border-gray-100 shadow-sm hover:shadow-elegant transition-all flex items-center justify-between">
                <div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-1 group-hover:text-primary transition-colors">Current Borrows</h3>
                    <p class="text-gray-500 text-sm">View books you currently have checked out.</p>
                </div>
                <div class="w-12 h-12 bg-primary/10 text-primary rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
            </a>

            <a href="{{ route('student.borrow-transactions.history') }}" class="group bg-white rounded-2xl p-8 border border-gray-100 shadow-sm hover:shadow-elegant transition-all flex items-center justify-between">
                <div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-1 group-hover:text-primary transition-colors">Borrowing History</h3>
                    <p class="text-gray-500 text-sm">View all books you have previously read.</p>
                </div>
                <div class="w-12 h-12 bg-gold/10 text-gold rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                    </svg>
                </div>
            </a>
        </div>
        
        <h3 class="text-lg font-bold text-gray-800 mb-4">Recent Activity</h3>
        
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="responsive-table-scroll">
                <table class="mobile-card-table table w-full">
                    <thead>
                        <tr class="bg-gray-50/50 text-gray-500 uppercase text-xs tracking-wider">
                            <th class="px-6 py-4 font-semibold">Book Details</th>
                            <th class="px-6 py-4 font-semibold">Accession No.</th>
                            <th class="px-6 py-4 font-semibold">Date</th>
                            <th class="px-6 py-4 font-semibold text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($currentBorrows as $borrow)
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
                                <td data-label="Date" class="px-6 py-4 text-sm text-gray-600">
                                    {{ $borrow->issue_date->format('M d, Y') }}
                                </td>
                                <td data-label="Status" class="px-6 py-4 text-right">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-primary/10 text-primary uppercase tracking-wider">
                                        Borrowed
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td data-empty colspan="4" class="px-6 py-8 text-center text-gray-500">
                                    No recent borrowing activity.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($currentBorrows->isNotEmpty())
            <div class="p-4 bg-gray-50 border-t border-gray-100 text-center">
                <a href="{{ route('student.borrow-transactions.current') }}" class="text-sm font-bold text-primary hover:text-primaryfade transition-colors">View all current borrows &rarr;</a>
            </div>
            @endif
        </div>
    </div>
</x-layout.student>
