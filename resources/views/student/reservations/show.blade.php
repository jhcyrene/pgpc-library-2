<x-layout.student title="Reservation Details">
    <div class="max-w-3xl mx-auto">
        <div class="mb-6 flex items-center justify-between">
            <a href="{{ route('student.reservations.index') }}" class="inline-flex items-center gap-1 text-sm font-semibold text-gray-500 hover:text-primary transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Reservations
            </a>
            
            @php
                $statusName = strtolower((string) $reservation->bookRequestStatus->status_name);
                $statusClass = match($statusName) {
                    'pending' => 'bg-warning/10 text-warning',
                    'approved' => 'bg-info/10 text-info',
                    'ready for pickup' => 'bg-success/10 text-success',
                    'completed' => 'bg-gray-100 text-gray-600',
                    'cancelled', 'rejected', 'expired' => 'bg-error/10 text-error',
                    default => 'bg-gray-100 text-gray-600'
                };
                $statusDate = match($statusName) {
                    'approved' => $reservation->approved_at,
                    'ready for pickup' => $reservation->ready_at ?? $reservation->approved_at,
                    'completed' => $reservation->fulfilled_at,
                    'cancelled' => $reservation->cancelled_at,
                    default => null,
                };
                $authorNames = $reservation->bookData->authors
                    ->map(fn ($author) => trim($author->first_name.' '.$author->last_name))
                    ->filter()
                    ->join(', ');
            @endphp
            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold {{ $statusClass }} uppercase tracking-wider">
                Status: {{ $reservation->bookRequestStatus->status_name }}
            </span>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 md:p-8">
                
                <!-- Book Summary -->
                <div class="flex items-start gap-4 mb-8">
                    <div class="w-16 h-24 bg-gray-200 rounded shrink-0 overflow-hidden flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-800 mb-1">{{ $reservation->bookData->book_title }}</h1>
                        @if($authorNames !== '')
                            <p class="text-sm text-gray-600">by {{ $authorNames }}</p>
                        @endif
                    </div>
                </div>

                <!-- Timeline / Status Indication -->
                <div class="bg-gray-50 rounded-xl border border-gray-100 p-6 mb-8">
                    <h3 class="text-sm font-bold text-gray-800 mb-4 uppercase tracking-wider">Reservation Timeline</h3>
                    
                    <div class="relative">
                        <!-- Connecting Line -->
                        <div class="absolute left-[11px] top-2 bottom-2 w-0.5 bg-gray-200"></div>
                        
                        <div class="space-y-6">
                            <!-- Requested Step -->
                            <div class="relative flex items-start gap-4">
                                <div class="w-6 h-6 rounded-full bg-primary flex items-center justify-center z-10 shrink-0 ring-4 ring-gray-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-white" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-gray-800">Requested</h4>
                                    <p class="text-xs text-gray-500">{{ $reservation->request_date->format('F j, Y, g:i a') }}</p>
                                </div>
                            </div>
                            
                            <!-- Current/Next Step -->
                            <div class="relative flex items-start gap-4">
                                @if(in_array($statusName, ['approved', 'ready for pickup', 'completed']))
                                    <div class="w-6 h-6 rounded-full bg-primary flex items-center justify-center z-10 shrink-0 ring-4 ring-gray-50">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-white" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                @elseif(in_array($statusName, ['cancelled', 'rejected', 'expired']))
                                    <div class="w-6 h-6 rounded-full bg-error flex items-center justify-center z-10 shrink-0 ring-4 ring-gray-50">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-white" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                @else
                                    <div class="w-6 h-6 rounded-full bg-gray-200 flex items-center justify-center z-10 shrink-0 ring-4 ring-gray-50">
                                        <div class="w-2 h-2 rounded-full bg-gray-400"></div>
                                    </div>
                                @endif
                                
                                <div>
                                    <h4 class="text-sm font-bold text-gray-800">
                                        @if($statusName === 'pending')
                                            Awaiting Approval
                                        @else
                                            {{ $reservation->bookRequestStatus->status_name }}
                                        @endif
                                    </h4>
                                    @if($statusDate)
                                        <p class="text-xs text-gray-500">{{ $statusDate->format('F j, Y, g:i a') }}</p>
                                    @endif
                                    
                                    @if($statusName === 'ready for pickup')
                                        <div class="mt-2 p-3 bg-success/10 border border-success/20 rounded-lg text-sm text-success-content">
                                            <strong>Good news!</strong> Your book is ready at the library front desk. Please claim it soon.
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Details Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-6 gap-x-4 mb-8">
                    <div>
                        <span class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Reservation ID</span>
                        <span class="text-sm font-medium text-gray-800">#{{ $reservation->book_request_id }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Requested By</span>
                        <span class="text-sm font-medium text-gray-800">{{ $reservation->member->first_name }} {{ $reservation->member->last_name }}</span>
                    </div>
                    @if($reservation->remarks)
                        <div class="col-span-1 sm:col-span-2">
                            <span class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Your Notes</span>
                            <div class="text-sm text-gray-700 bg-gray-50 p-3 rounded-lg border border-gray-100 italic">
                                "{{ $reservation->remarks }}"
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Actions -->
                @if(in_array($statusName, ['pending', 'approved']))
                    <div class="border-t border-gray-100 pt-6 mt-6">
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                            <p class="text-sm text-gray-500">Changed your mind? You can cancel this reservation.</p>
                            
                            <form action="{{ route('student.reservations.cancel', $reservation) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this reservation?');">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-outline btn-error btn-sm">Cancel Reservation</button>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layout.student>
