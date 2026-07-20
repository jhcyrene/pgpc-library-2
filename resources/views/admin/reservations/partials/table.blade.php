<div id="reservations-table-container" class="overflow-hidden flex flex-col h-full relative">
    
    <!-- Loading Overlay -->
    <div id="table-loader" class="absolute inset-0 bg-white/60 backdrop-blur-[1px] flex items-center justify-center z-50 hidden">
        <span class="loading loading-spinner loading-md text-primary"></span>
    </div>

    <!-- Table Container -->
    <div class="responsive-table-scroll flex-1 min-h-[300px]" tabindex="0" role="region" aria-label="Reservations table">
        <table class="mobile-card-table responsive-table w-full text-left text-sm whitespace-nowrap">
            <thead class="bg-slate-50 sticky top-0 z-10 border-b border-slate-200 text-slate-500 uppercase text-[11px] font-extrabold tracking-wider">
                <tr>
                    <th class="px-6 py-4">Student</th>
                    <th class="px-6 py-4">Book Title</th>
                    <th class="px-6 py-4">Date Requested</th>
                    <th class="px-6 py-4 text-center">Status</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 bg-white relative">
                @forelse($reservations as $reservation)
                    <tr class="hover:bg-slate-50/80 cursor-pointer transition-colors group reservation-row" data-url="{{ route('admin.reservations.show', $reservation) }}">
                        <td data-primary class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-[#102b70] text-[#fcc719] font-black flex items-center justify-center overflow-hidden shrink-0 shadow-sm">
                                    {{ strtoupper(substr($reservation->member->first_name ?? 'S', 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-bold text-slate-900 leading-tight group-hover:text-[#102b70] transition-colors">{{ $reservation->member->first_name }} {{ $reservation->member->last_name }}</p>
                                    <p class="text-xs text-slate-500 mt-0.5">ID: {{ $reservation->member->student_number }}</p>
                                </div>
                            </div>
                        </td>
                        <td data-label="Book" class="px-6 py-4">
                            <p class="font-bold text-slate-900 truncate max-w-[240px]" title="{{ $reservation->bookData->book_title }}">
                                {{ $reservation->bookData->book_title }}
                            </p>
                            @if($reservation->book)
                                <p class="text-xs text-slate-500 mt-0.5">Copy ID: {{ $reservation->book->book_id }}</p>
                            @endif
                        </td>
                        <td data-label="Requested" class="px-6 py-4">
                            <p class="text-sm font-semibold text-slate-800">{{ $reservation->request_date->format('M d, Y') }}</p>
                            <p class="text-xs text-slate-400 mt-0.5">{{ $reservation->request_date->format('h:i A') }}</p>
                        </td>
                        <td data-label="Status" class="px-6 py-4 text-center">
                            @php
                                $statusName = strtolower($reservation->bookRequestStatus->status_name);
                                $badgeStyle = match($statusName) {
                                    'pending' => 'bg-amber-50 text-amber-700 border-amber-200',
                                    'approved' => 'bg-blue-50 text-blue-700 border-blue-200',
                                    'ready for pickup' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                    'completed', 'fulfilled' => 'bg-slate-100 text-slate-700 border-slate-200',
                                    'cancelled', 'rejected' => 'bg-rose-50 text-rose-700 border-rose-200',
                                    'expired' => 'bg-slate-100 text-slate-500 border-slate-200',
                                    default => 'bg-slate-100 text-slate-700 border-slate-200'
                                };
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold border shadow-xs {{ $badgeStyle }}">
                                {{ ucwords(strtolower($reservation->bookRequestStatus->status_name)) }}
                            </span>
                        </td>
                        <td data-label="Actions" class="px-6 py-4 text-right relative z-10 flex justify-end items-center gap-2">
                            @if(strtolower($reservation->bookRequestStatus->status_name) === 'pending')
                                <button type="button" class="btn btn-sm bg-emerald-600 hover:bg-emerald-700 text-white font-bold border-none px-3.5 shadow-xs transition-transform active:scale-95" 
                                        onclick="window.confirmApprove('{{ route('admin.reservations.status', $reservation) }}'); event.stopPropagation();">
                                    Approve
                                </button>
                                <button type="button" class="btn btn-sm bg-rose-50 text-rose-700 hover:bg-rose-100 border border-rose-200 font-bold px-3.5 transition-colors" 
                                        onclick="window.confirmReject('{{ route('admin.reservations.status', $reservation) }}'); event.stopPropagation();">
                                    Reject
                                </button>
                            @endif
                            <button type="button" class="btn btn-sm bg-slate-100 text-slate-700 hover:bg-[#102b70] hover:text-white border-none font-bold px-3.5 transition-colors">
                                Details
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td data-empty colspan="5" class="px-6 py-16 text-center text-slate-500">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 mb-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <p class="text-base font-extrabold text-slate-900 mb-1">No Reservations Found</p>
                                <p class="text-xs text-slate-500 max-w-sm">No reservations match your current search or status filter. Try resetting the filters above.</p>
                            </div>
                        </td>
                    </tr>
                @endempty
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($reservations->hasPages())
        <div class="p-4 border-t border-slate-100 flex justify-center bg-slate-50/50 shrink-0 ajax-pagination-wrapper">
            {{ $reservations->links('vendor.pagination.tailwind') }}
        </div>
    @endif
</div>
