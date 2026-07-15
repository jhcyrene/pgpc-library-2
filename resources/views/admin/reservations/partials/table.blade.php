<div id="reservations-table-container" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col h-full relative">
    
    <!-- Loading Overlay -->
    <div id="table-loader" class="absolute inset-0 bg-white/60 backdrop-blur-[1px] flex items-center justify-center z-50 hidden">
        <span class="loading loading-spinner loading-md text-primary"></span>
    </div>

    <!-- Tabs -->
    <div class="p-4 border-b border-gray-100 flex items-center gap-4 bg-gray-50/50 overflow-x-auto shrink-0 ajax-tabs">
        <a href="{{ route('admin.reservations.index', ['status' => 'all']) }}" 
           class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ $status === 'all' ? 'bg-primary text-white' : 'text-gray-600 hover:bg-gray-100' }}">
            All
        </a>
        <a href="{{ route('admin.reservations.index', ['status' => 'pending']) }}" 
           class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ $status === 'pending' ? 'bg-primary text-white' : 'text-gray-600 hover:bg-gray-100' }}">
            Pending
        </a>
        <a href="{{ route('admin.reservations.index', ['status' => 'approved']) }}" 
           class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ $status === 'approved' ? 'bg-primary text-white' : 'text-gray-600 hover:bg-gray-100' }}">
            Approved
        </a>
        <a href="{{ route('admin.reservations.index', ['status' => 'ready-for-pickup']) }}" 
           class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ $status === 'ready-for-pickup' ? 'bg-primary text-white' : 'text-gray-600 hover:bg-gray-100' }}">
            Ready for Pickup
        </a>
        <a href="{{ route('admin.reservations.index', ['status' => 'completed']) }}" 
           class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ $status === 'completed' ? 'bg-primary text-white' : 'text-gray-600 hover:bg-gray-100' }}">
            Completed
        </a>
        <a href="{{ route('admin.reservations.index', ['status' => 'cancelled']) }}" 
           class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ $status === 'cancelled' ? 'bg-primary text-white' : 'text-gray-600 hover:bg-gray-100' }}">
            Cancelled
        </a>
    </div>

    <!-- Table -->
    <div class="flex-1 overflow-auto min-h-[300px]">
        <table class="w-full text-left border-collapse">
            <thead class="sticky top-0 bg-white shadow-sm z-10">
                <tr class="text-xs uppercase tracking-wider text-gray-500 border-b border-gray-100">
                    <th class="px-6 py-4 font-semibold">Student</th>
                    <th class="px-6 py-4 font-semibold">Book Title</th>
                    <th class="px-6 py-4 font-semibold">Date Requested</th>
                    <th class="px-6 py-4 font-semibold text-center">Status</th>
                    <th class="px-6 py-4 font-semibold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 relative">
                @forelse($reservations as $reservation)
                    @php
                        $statusClass = match(strtolower($reservation->bookRequestStatus->status_name)) {
                            'pending' => 'bg-warning/10 text-warning',
                            'approved' => 'bg-info/10 text-info',
                            'ready for pickup' => 'bg-success/10 text-success',
                            'completed', 'fulfilled' => 'bg-gray-100 text-gray-600',
                            'cancelled', 'rejected', 'expired' => 'bg-error/10 text-error',
                            default => 'bg-gray-100 text-gray-600'
                        };
                    @endphp
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold shrink-0">
                                    {{ substr($reservation->member->first_name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="font-bold text-gray-800">{{ $reservation->member->first_name }} {{ $reservation->member->last_name }}</div>
                                    <div class="text-xs text-gray-500">{{ $reservation->member->student_number }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-medium text-gray-800">{{ $reservation->bookData->book_title }}</div>
                            @if($reservation->book)
                                <div class="text-xs text-gray-500">Copy ID: {{ $reservation->book->book_id }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            <div class="mb-1">
                                <span class="text-xs text-gray-400 font-semibold uppercase tracking-wider block">Requested:</span>
                                {{ $reservation->request_date->format('M d, Y') }}
                                <span class="text-xs text-gray-400">{{ $reservation->request_date->format('h:i A') }}</span>
                            </div>
                            @if($reservation->pickup_date)
                                <div>
                                    <span class="text-xs text-primary font-semibold uppercase tracking-wider block">Pickup:</span>
                                    <span class="font-medium text-primary">{{ $reservation->pickup_date->format('M d, Y') }}</span>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold {{ $statusClass }} uppercase tracking-wider">
                                {{ $reservation->bookRequestStatus->status_name }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.reservations.show', $reservation) }}" title="View Reservation" class="inline-flex items-center justify-center px-3 py-1.5 border border-gray-200 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 hover:text-primary transition-colors min-w-[70px]">
                                View
                            </a>
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
