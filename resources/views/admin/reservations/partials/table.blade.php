<!-- Reservations Table Container -->
<div id="reservations-table-container" class="bg-white border border-slate-200 rounded-2xl shadow-sm flex flex-col flex-1 overflow-hidden font-sans relative">
    
    <!-- Loading Overlay -->
    <div id="table-loader" class="absolute inset-0 bg-white/60 backdrop-blur-[1px] flex items-center justify-center z-50 hidden">
        <span class="loading loading-spinner loading-md text-[#102b70]"></span>
    </div>

    <!-- DESKTOP / TABLET TABLE VIEW (Visible on lg screens and up) -->
    <div class="hidden lg:block overflow-x-auto flex-1" tabindex="0" role="region" aria-label="Reservations table">
        <table class="w-full text-left text-xs sm:text-sm whitespace-nowrap border-collapse">
            <thead class="bg-slate-50/80 sticky top-0 z-10 border-b border-slate-200 text-slate-500 uppercase text-[11px] font-extrabold tracking-wider">
                <tr>
                    <th class="px-5 py-4">Student</th>
                    <th class="px-5 py-4">Book Title</th>
                    <th class="px-5 py-4">Requested</th>
                    <th class="px-5 py-4">Pickup Date</th>
                    <th class="px-5 py-4 text-center">Status</th>
                    <th class="px-5 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 bg-white relative">
                @forelse($reservations as $reservation)
                    @php
                        $bookData = $reservation->bookData;
                        $detail = $bookData?->bookDetail;
                        $statusName = strtolower($reservation->bookRequestStatus->status_name ?? 'pending');
                        
                        $statusBadgeClass = match($statusName) {
                            'pending' => 'bg-amber-100 text-amber-800 border-amber-200',
                            'approved' => 'bg-blue-100 text-blue-800 border-blue-200',
                            'ready for pickup', 'ready' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                            'completed', 'fulfilled' => 'bg-slate-100 text-slate-700 border-slate-200',
                            'cancelled' => 'bg-red-100 text-red-700 border-red-200',
                            'rejected' => 'bg-rose-100 text-rose-800 border-rose-200',
                            'expired' => 'bg-slate-100 text-slate-500 border-slate-200',
                            default => 'bg-slate-100 text-slate-700 border-slate-200'
                        };
                    @endphp
                    <tr class="hover:bg-slate-50/80 cursor-pointer transition-colors group reservation-row" data-url="{{ route('admin.reservations.show', $reservation) }}">
                        <!-- Student Column -->
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-[#0a1b42] text-[#fcc719] font-black text-sm flex items-center justify-center overflow-hidden shrink-0 shadow-xs">
                                    {{ strtoupper(substr($reservation->member->first_name ?? 'S', 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-bold text-slate-900 leading-tight group-hover:text-[#102b70] transition-colors">
                                        {{ $reservation->member->first_name }} {{ $reservation->member->last_name }}
                                    </p>
                                    <p class="text-[11px] text-slate-400 font-medium mt-0.5">ID: {{ $reservation->member->student_number ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </td>

                        <!-- Book Title Column -->
                        <td class="px-5 py-4">
                            <p class="font-bold text-slate-900 truncate max-w-[240px]" title="{{ $bookData?->book_title }}">
                                {{ $bookData?->book_title ?? 'Untitled Book' }}
                            </p>
                            <p class="text-[11px] text-slate-400 font-medium mt-0.5">
                                ISBN: {{ $detail?->isbn ?? 'N/A' }}
                            </p>
                        </td>

                        <!-- Requested Column -->
                        <td class="px-5 py-4">
                            <p class="text-xs font-bold text-slate-800">{{ $reservation->request_date ? $reservation->request_date->format('M d, Y') : 'N/A' }}</p>
                            <p class="text-[11px] text-slate-400 font-medium mt-0.5">{{ $reservation->request_date ? $reservation->request_date->format('h:i A') : '' }}</p>
                        </td>

                        <!-- Pickup Date Column -->
                        <td class="px-5 py-4">
                            @if($reservation->pickup_date)
                                <p class="text-xs font-bold text-slate-800">{{ $reservation->pickup_date->format('M d, Y') }}</p>
                            @else
                                <span class="text-slate-400 font-bold">&mdash;</span>
                            @endif
                        </td>

                        <!-- Status Column -->
                        <td class="px-5 py-4 text-center">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-extrabold border shadow-2xs {{ $statusBadgeClass }}">
                                {{ ucwords(strtolower($reservation->bookRequestStatus->status_name)) }}
                            </span>
                        </td>

                        <!-- Actions Column -->
                        <td class="px-5 py-4 text-right relative z-10 flex justify-end items-center gap-2">
                            @if($statusName === 'pending')
                                <form action="{{ route('admin.reservations.status', $reservation) }}" method="POST" class="inline-block ajax-form" onclick="event.stopPropagation();">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="Approved">
                            <button type="submit"
                                data-loading-text="Approving..."
                                style="background-color: #059669; color: #ffffff;"
                                class="btn-submit-action h-8 px-3.5 rounded-lg hover:opacity-90 active:opacity-100 text-white font-bold text-xs shadow-xs transition-all flex items-center justify-center gap-1.5">
                                <svg class="btn-spinner hidden w-3.5 h-3.5 animate-spin shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                </svg>
                                <span class="btn-label">Approve</span>
                            </button>
                                </form>
                                <button type="button" 
                                        onclick="openCancelModal('{{ route('admin.reservations.status', $reservation) }}', '{{ $reservation->book_request_id }}'); event.stopPropagation();"
                                        class="h-8 px-3 rounded-lg bg-red-50 hover:bg-red-100 text-red-600 font-bold text-xs border border-red-200 transition-colors">
                                    Reject
                                </button>
                            @endif
                            <button type="button" 
                                    onclick="openDetailsModal('{{ route('admin.reservations.show', $reservation) }}'); event.stopPropagation();"
                                    class="h-8 px-3.5 rounded-lg bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-bold text-xs transition-colors shadow-2xs">
                                Details
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center text-slate-500">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-14 h-14 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 mb-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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

    <!-- MOBILE CARDS STACK VIEW (Visible on mobile/tablet < lg screens) -->
    <div class="lg:hidden p-4 space-y-3.5">
        @forelse($reservations as $reservation)
            @php
                $bookData = $reservation->bookData;
                $detail = $bookData?->bookDetail;
                $statusName = strtolower($reservation->bookRequestStatus->status_name ?? 'pending');
                
                $statusBadgeClass = match($statusName) {
                    'pending' => 'bg-amber-100 text-amber-800 border-amber-200',
                    'approved' => 'bg-blue-100 text-blue-800 border-blue-200',
                    'ready for pickup', 'ready' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                    'completed', 'fulfilled' => 'bg-slate-100 text-slate-700 border-slate-200',
                    'cancelled' => 'bg-red-100 text-red-700 border-red-200',
                    'rejected' => 'bg-rose-100 text-rose-800 border-rose-200',
                    'expired' => 'bg-slate-100 text-slate-500 border-slate-200',
                    default => 'bg-slate-100 text-slate-700 border-slate-200'
                };
            @endphp
            <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs flex flex-col gap-3 relative cursor-pointer hover:border-brand-navy/30 transition-all" onclick="openDetailsModal('{{ route('admin.reservations.show', $reservation) }}')">
                <!-- Top Header: Student Avatar & Info + Status Badge -->
                <div class="flex items-start justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-[#0a1b42] text-[#fcc719] font-black text-sm flex items-center justify-center shrink-0 shadow-xs">
                            {{ strtoupper(substr($reservation->member->first_name ?? 'S', 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-extrabold text-slate-900 text-sm leading-tight">
                                {{ $reservation->member->first_name }} {{ $reservation->member->last_name }}
                            </p>
                            <p class="text-[11px] text-slate-400 font-medium mt-0.5">ID: {{ $reservation->member->student_number ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-extrabold border shadow-2xs {{ $statusBadgeClass }} shrink-0">
                        {{ ucwords(strtolower($reservation->bookRequestStatus->status_name)) }}
                    </span>
                </div>

                <!-- Book Info Box -->
                <div class="p-3 bg-slate-50 border border-slate-100 rounded-xl space-y-1">
                    <p class="text-xs font-bold text-slate-900 line-clamp-1" title="{{ $bookData?->book_title }}">
                        {{ $bookData?->book_title ?? 'Untitled Book' }}
                    </p>
                    <p class="text-[11px] font-mono text-slate-500">
                        ISBN: {{ $detail?->isbn ?? 'N/A' }}
                    </p>
                </div>

                <!-- Dates Grid -->
                <div class="grid grid-cols-2 gap-2 text-[11px]">
                    <div>
                        <span class="text-slate-400 font-bold uppercase tracking-wider text-[9px] block">Requested Date</span>
                        <span class="font-bold text-slate-800">{{ $reservation->request_date ? $reservation->request_date->format('M d, Y') : 'N/A' }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 font-bold uppercase tracking-wider text-[9px] block">Preferred Pickup</span>
                        <span class="font-bold text-slate-800">{{ $reservation->pickup_date ? $reservation->pickup_date->format('M d, Y') : 'Not specified' }}</span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end gap-2 pt-2 border-t border-slate-100" onclick="event.stopPropagation()">
                    @if($statusName === 'pending')
                        <form action="{{ route('admin.reservations.status', $reservation) }}" method="POST" class="inline-block ajax-form">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="Approved">
                            <button type="submit"
                                data-loading-text="Approving..."
                                style="background-color: #059669; color: #ffffff;"
                                class="btn-submit-action py-1.5 px-3 rounded-lg hover:opacity-90 active:opacity-100 text-white font-bold text-xs shadow-xs transition-all flex items-center justify-center gap-1.5">
                                <svg class="btn-spinner hidden w-3.5 h-3.5 animate-spin shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                </svg>
                                <span class="btn-label">Approve</span>
                            </button>
                        </form>
                        <button type="button" 
                                onclick="openCancelModal('{{ route('admin.reservations.status', $reservation) }}', '{{ $reservation->book_request_id }}')" 
                                class="py-1.5 px-3 rounded-lg bg-red-50 hover:bg-red-100 text-red-600 font-bold text-xs border border-red-200 transition-colors">
                            Reject
                        </button>
                    @endif
                    <button type="button" 
                            onclick="openDetailsModal('{{ route('admin.reservations.show', $reservation) }}')" 
                            class="py-1.5 px-3 rounded-lg bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-bold text-xs transition-colors shadow-2xs">
                        Details
                    </button>
                </div>
            </div>
        @empty
            <div class="bg-white border border-slate-200 rounded-2xl p-8 text-center text-slate-500">
                <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 mx-auto mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <p class="font-extrabold text-slate-900 text-sm mb-0.5">No Reservations Found</p>
                <p class="text-xs text-slate-500">Try adjusting your filters above.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($reservations->hasPages())
        <div class="p-4 border-t border-slate-100 flex justify-between items-center bg-slate-50/50 shrink-0 text-xs font-semibold text-slate-500">
            <span>Showing {{ $reservations->firstItem() }} to {{ $reservations->lastItem() }} of {{ $reservations->total() }} reservations</span>
            <div class="ajax-pagination-wrapper">
                {{ $reservations->links('vendor.pagination.tailwind') }}
            </div>
        </div>
    @endif
</div>
