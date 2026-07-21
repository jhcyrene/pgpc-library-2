<x-layout.student title="Fines & Penalties">
    <div class="max-w-[1600px] mx-auto w-full">
        <x-student.page-header 
            title="Fines & Penalties" 
            subtitle="View your outstanding balances and payment history." 
        />

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                <h3 class="font-bold text-gray-800">Showing {{ $fines->firstItem() ?? 0 }} to {{ $fines->lastItem() ?? 0 }} of {{ $fines->total() }} items</h3>
            </div>

            <div class="responsive-table-scroll">
                <table class="mobile-card-table table w-full">
                    <thead>
                        <tr class="bg-gray-50/50 text-gray-500 uppercase text-xs tracking-wider">
                            <th class="px-6 py-4 font-semibold">Book Details</th>
                            <th class="px-6 py-4 font-semibold">Fine Date</th>
                            <th class="px-6 py-4 font-semibold text-right">Amount</th>
                            <th class="px-6 py-4 font-semibold text-right">Balance</th>
                            <th class="px-6 py-4 font-semibold text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($fines as $fine)
                            @php
                                $totalPaid = $fine->finePayments->sum('payment_amount');
                                $balance = $fine->fine_total - $totalPaid;
                                $isPaid = $balance <= 0;
                            @endphp
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td data-primary class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <h4 class="font-bold text-gray-800 text-sm">{{ $fine->bookBorrow->book->bookData->book_title }}</h4>
                                        <span class="text-xs text-gray-500">Acc. No: {{ $fine->bookBorrow->book->accession_number }}</span>
                                    </div>
                                </td>
                                <td data-label="Fine date" class="px-6 py-4 text-sm text-gray-600">
                                    {{ $fine->fine_date->format('M d, Y') }}
                                </td>
                                <td data-label="Amount" class="px-6 py-4 text-sm font-medium text-gray-800 text-right">
                                    ₱{{ number_format($fine->fine_total, 2) }}
                                </td>
                                <td data-label="Balance" class="px-6 py-4 text-sm font-bold {{ $isPaid ? 'text-success' : 'text-error' }} text-right">
                                    ₱{{ number_format($balance, 2) }}
                                </td>
                                <td data-label="Status" class="px-6 py-4 text-right">
                                    @if($isPaid)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-success/10 text-success uppercase tracking-wider">
                                            Paid
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-error/10 text-error uppercase tracking-wider">
                                            Unpaid
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td data-empty colspan="5" class="px-6 py-12 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-success/50 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <p class="text-lg font-medium text-gray-800 mb-1">No Fines</p>
                                        <p class="text-sm">You do not have any fine records.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($fines->hasPages())
                <div class="p-4 border-t border-gray-100 flex justify-center bg-gray-50/50">
                    {{ $fines->links('vendor.pagination.tailwind') }}
                </div>
            @endif
        </div>
    </div>
</x-layout.student>
