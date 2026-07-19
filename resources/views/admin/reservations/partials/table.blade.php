<div id="reservations-table-container" class="overflow-hidden flex flex-col h-full relative">
    
    <!-- Loading Overlay -->
    <div id="table-loader" class="absolute inset-0 bg-white/60 backdrop-blur-[1px] flex items-center justify-center z-50 hidden">
        <span class="loading loading-spinner loading-md text-primary"></span>
    </div>

    <!-- Removed Tabs -->

    <!-- Table -->
    <div class="responsive-table-scroll flex-1 min-h-[300px]" tabindex="0" role="region" aria-label="Reservations table">
        <table class="responsive-table w-full min-w-[700px] text-left text-sm whitespace-nowrap">
            <thead class="bg-white sticky top-0 z-10 shadow-sm ring-1 ring-gray-100 text-gray-500 uppercase text-[10px] font-bold tracking-wider">
                <tr>
                    <th class="px-6 py-4">Student</th>
                    <th class="px-6 py-4">Book Title</th>
                    <th class="px-6 py-4">Date Requested</th>
                    <th class="px-6 py-4 text-center">Status</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white relative">
                @forelse($reservations as $reservation)
                    <tr class="hover:bg-gray-50/50 cursor-pointer transition-colors group reservation-row" data-url="{{ route('admin.reservations.show', $reservation) }}">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-gray-100 border border-gray-200 flex items-center justify-center text-gray-600 font-bold overflow-hidden shrink-0">
                                    {{ substr($reservation->member->first_name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900 leading-tight">{{ $reservation->member->first_name }} {{ $reservation->member->last_name }}</p>
                                    <p class="text-xs text-gray-500">ID: {{ $reservation->member->student_number }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="font-medium text-gray-900 truncate max-w-[200px]" title="{{ $reservation->bookData->book_title }}">
                                {{ $reservation->bookData->book_title }}
                            </p>
                            @if($reservation->book)
                                <p class="text-xs text-gray-500">Copy ID: {{ $reservation->book->book_id }}</p>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm font-medium text-gray-900">{{ $reservation->request_date->format('M d, Y') }}</p>
                            <p class="text-xs text-gray-500">{{ $reservation->request_date->format('h:i A') }}</p>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @php
                                $statusName = strtolower($reservation->bookRequestStatus->status_name);
                                $badgeStyle = match($statusName) {
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'approved' => 'bg-blue-100 text-blue-800',
                                    'ready for pickup' => 'bg-green-100 text-green-800',
                                    'completed', 'fulfilled' => 'bg-gray-100 text-gray-800',
                                    'cancelled', 'rejected' => 'bg-red-100 text-red-800',
                                    'expired' => 'bg-gray-100 text-gray-600',
                                    default => 'bg-gray-100 text-gray-700'
                                };
                            @endphp
                            <span class="px-2.5 py-1 rounded-md text-[11px] font-bold {{ $badgeStyle }}">
                                {{ ucwords(strtolower($reservation->bookRequestStatus->status_name)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right relative z-10 flex justify-end items-center gap-2">
                            @if(strtolower($reservation->bookRequestStatus->status_name) === 'pending')
                                <button type="button" class="btn btn-sm bg-green-50 text-green-700 hover:bg-green-100 border-none px-3" 
                                        onclick="window.confirmApprove('{{ route('admin.reservations.status', $reservation) }}'); event.stopPropagation();">
                                    Approve
                                </button>
                                <button type="button" class="btn btn-sm bg-red-50 text-red-700 hover:bg-red-100 border-none px-3" 
                                        onclick="window.confirmReject('{{ route('admin.reservations.status', $reservation) }}'); event.stopPropagation();">
                                    Reject
                                </button>
                            @endif
                            <button type="button" class="btn btn-sm btn-ghost text-gray-500 hover:text-brand-navy hover:bg-brand-navy/10 px-3">
                                View Details
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <p class="text-lg font-medium text-gray-800 mb-1">No Reservations Found</p>
                                <p class="text-sm">There are no reservations matching this status.</p>
                            </div>
                        </td>
                    </tr>
                @endempty
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($reservations->hasPages())
        <div class="p-4 border-t border-gray-100 flex justify-center bg-gray-50/50 shrink-0 ajax-pagination-wrapper">
            {{ $reservations->links('vendor.pagination.tailwind') }}
        </div>
    @endif
</div>
