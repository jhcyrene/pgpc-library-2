<x-layout.student title="Reservations">
    <div class="max-w-[1600px] mx-auto w-full">
        <x-student.page-header 
            title="My Reservations" 
            subtitle="Manage your book requests and track their status." 
        />

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                <h3 class="font-bold text-gray-800">Showing {{ $reservations->firstItem() ?? 0 }} to {{ $reservations->lastItem() ?? 0 }} of {{ $reservations->total() }} items</h3>
            </div>

            <div class="responsive-table-scroll">
                <table class="mobile-card-table table w-full">
                    <thead>
                        <tr class="bg-gray-50/50 text-gray-500 uppercase text-xs tracking-wider">
                            <th class="px-6 py-4 font-semibold">Book Details</th>
                            <th class="px-6 py-4 font-semibold">Request Date</th>
                            <th class="px-6 py-4 font-semibold text-center">Status</th>
                            <th class="px-6 py-4 font-semibold text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($reservations as $reservation)
                            @php
                                $statusClass = match(strtolower($reservation->bookRequestStatus->status_name)) {
                                    'pending' => 'bg-warning/10 text-warning',
                                    'approved' => 'bg-info/10 text-info',
                                    'ready for pickup' => 'bg-success/10 text-success',
                                    'completed' => 'bg-gray-100 text-gray-600',
                                    'cancelled', 'rejected', 'expired' => 'bg-error/10 text-error',
                                    default => 'bg-gray-100 text-gray-600'
                                };
                            @endphp
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td data-primary class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-14 bg-gray-200 rounded shrink-0 overflow-hidden flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-gray-800">{{ $reservation->bookData->book_title }}</h4>
                                        </div>
                                    </div>
                                </td>
                                <td data-label="Requested" class="px-6 py-4 text-sm text-gray-600">
                                    {{ $reservation->request_date->format('M d, Y h:i A') }}
                                </td>
                                <td data-label="Status" class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold {{ $statusClass }} uppercase tracking-wider">
                                        {{ $reservation->bookRequestStatus->status_name }}
                                    </span>
                                </td>
                                <td data-label="Action" class="px-6 py-4 text-right">
                                    <a href="{{ route('student.reservations.show', $reservation) }}" class="btn btn-sm btn-ghost hover:bg-primary/10 hover:text-primary">View</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td data-empty colspan="4" class="px-6 py-12 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <p class="text-lg font-medium text-gray-800 mb-1">No Reservations Found</p>
                                        <p class="text-sm">You haven't requested any books yet.</p>
                                        <a href="{{ route('opac.index') }}" class="btn btn-outline btn-primary mt-4">Search OPAC</a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($reservations->hasPages())
                <div class="p-4 border-t border-gray-100 flex justify-center bg-gray-50/50">
                    {{ $reservations->links('vendor.pagination.tailwind') }}
                </div>
            @endif
        </div>
    </div>
</x-layout.student>
