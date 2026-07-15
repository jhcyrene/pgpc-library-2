<x-layout.student title="Overdue Items">
    <div class="max-w-[1600px] mx-auto w-full">
        <x-student.page-header 
            title="Overdue Items" 
            subtitle="Books that are past their due date and need to be returned immediately." 
        />

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            @if($overdueBorrows->isEmpty())
                <div class="p-12 text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-success/10 text-success mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 mb-1">No Overdue Items!</h3>
                    <p class="text-gray-500 max-w-md mx-auto">Great job! You have returned all your borrowed books on time. There are currently no overdue items on your account.</p>
                </div>
            @else
                <div class="p-4 border-b border-error/20 bg-error/5 flex items-center justify-between">
                    <div class="flex items-center gap-2 text-error font-bold">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <span>You have {{ $overdueBorrows->total() }} overdue item(s)</span>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="table w-full">
                        <thead>
                            <tr class="bg-gray-50/50 text-gray-500 uppercase text-xs tracking-wider">
                                <th class="px-6 py-4 font-semibold">Book Details</th>
                                <th class="px-6 py-4 font-semibold">Accession No.</th>
                                <th class="px-6 py-4 font-semibold">Due Date</th>
                                <th class="px-6 py-4 font-semibold">Days Overdue</th>
                                <th class="px-6 py-4 font-semibold text-right">Fine Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($overdueBorrows as $borrow)
                                @php
                                    $daysOverdue = now()->diffInDays($borrow->due_date);
                                @endphp
                                <tr class="hover:bg-gray-50 transition-colors">
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
                                    <td class="px-6 py-4 text-sm text-error font-bold">
                                        {{ $borrow->due_date->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-error font-bold">
                                        {{ $daysOverdue }} days
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        @if($borrow->fineDue)
                                            <a href="{{ route('student.fines.index') }}" class="text-sm font-bold text-primary hover:underline">
                                                ₱{{ number_format($borrow->fineDue->fine_total, 2) }}
                                            </a>
                                        @else
                                            <span class="text-sm text-gray-500 italic">Pending computation</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($overdueBorrows->hasPages())
                    <div class="p-4 border-t border-gray-100 flex justify-center bg-gray-50/50">
                        {{ $overdueBorrows->links('vendor.pagination.tailwind') }}
                    </div>
                @endif
            @endif
        </div>
    </div>
</x-layout.student>
