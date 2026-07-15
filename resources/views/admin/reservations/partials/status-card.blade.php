<!-- Status Card -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden p-6 relative">
    
    <!-- Loading Overlay -->
    <div id="status-card-loader" class="absolute inset-0 bg-white/60 backdrop-blur-[1px] flex items-center justify-center z-10 hidden">
        <span class="loading loading-spinner loading-md text-primary"></span>
    </div>

    <h3 class="text-lg font-bold text-gray-800 border-b border-gray-100 pb-4 mb-4">Reservation Status</h3>
    
    @php
        $statusClass = match(strtolower($reservation->bookRequestStatus->status_name)) {
            'pending' => 'bg-yellow-100 text-yellow-800',
            'approved' => 'bg-blue-100 text-blue-800',
            'ready for pickup' => 'bg-green-100 text-green-800',
            'completed', 'fulfilled' => 'bg-gray-100 text-gray-800',
            'cancelled', 'rejected', 'expired' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800'
        };
        $currentStatus = strtolower($reservation->bookRequestStatus->status_name);
    @endphp

    <div class="flex justify-center mb-6">
        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold {{ $statusClass }} uppercase tracking-wider">
            {{ $reservation->bookRequestStatus->status_name }}
        </span>
    </div>

    <div class="space-y-3 text-sm">
        <div class="flex justify-between">
            <span class="text-gray-500">Requested:</span>
            <span class="font-medium text-gray-800">{{ $reservation->request_date->format('M d, Y h:i A') }}</span>
        </div>
        @if($reservation->pickup_date)
            <div class="flex justify-between">
                <span class="text-gray-500">Pickup Date:</span>
                <span class="font-medium text-primary">{{ $reservation->pickup_date->format('M d, Y') }}</span>
            </div>
        @endif
        @if($reservation->approved_at)
            <div class="flex justify-between">
                <span class="text-gray-500">Approved:</span>
                <span class="font-medium text-gray-800">{{ $reservation->approved_at->format('M d, Y h:i A') }}</span>
            </div>
        @endif
        @if($reservation->ready_at)
            <div class="flex justify-between">
                <span class="text-gray-500">Ready:</span>
                <span class="font-medium text-gray-800">{{ $reservation->ready_at->format('M d, Y h:i A') }}</span>
            </div>
        @endif
        @if($reservation->fulfilled_at)
            <div class="flex justify-between">
                <span class="text-gray-500">Fulfilled:</span>
                <span class="font-medium text-gray-800">{{ $reservation->fulfilled_at->format('M d, Y h:i A') }}</span>
            </div>
        @endif
        @if($reservation->cancelled_at)
            <div class="flex justify-between">
                <span class="text-gray-500">Cancelled:</span>
                <span class="font-medium text-gray-800">{{ $reservation->cancelled_at->format('M d, Y h:i A') }}</span>
            </div>
        @endif
    </div>

    <!-- Actions Form -->
    @if(in_array($currentStatus, ['pending', 'approved', 'ready for pickup']))
        <div class="mt-6 pt-6 border-t border-gray-100">
            
            @if($currentStatus === 'pending')
                <div class="flex gap-3">
                    <form action="{{ route('admin.reservations.status', $reservation) }}" method="POST" class="flex-1 ajax-form">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="Approved">
                        <button type="submit" class="w-full bg-brand-navy hover:bg-brand-navy-light text-white font-bold py-2 px-4 rounded-lg transition-colors">
                            Approve
                        </button>
                    </form>
                    <form action="{{ route('admin.reservations.status', $reservation) }}" method="POST" class="flex-1 ajax-form" data-confirm="Are you sure you want to reject this request?">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="Rejected">
                        <button type="submit" class="w-full bg-error/10 hover:bg-error/20 text-error font-bold py-2 px-4 rounded-lg transition-colors">
                            Reject
                        </button>
                    </form>
                </div>
            @elseif($currentStatus === 'approved')
                <form action="{{ route('admin.reservations.status', $reservation) }}" method="POST" class="space-y-4 ajax-form">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="Ready for Pickup">
                    
                    <div>
                        <label for="book_id" class="block text-sm font-medium text-gray-700 mb-1">Assign Book Copy</label>
                        <select name="book_id" id="book_id" required class="w-full border-gray-300 rounded-lg shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                            <option value="" disabled selected>Select an available copy</option>
                            @foreach($availableCopies as $copy)
                                <option value="{{ $copy->book_id }}">Copy #{{ $copy->book_id }}</option>
                            @endforeach
                        </select>
                        @if($availableCopies->isEmpty())
                            <p class="mt-1 text-xs text-error">No available copies found for this title.</p>
                        @endif
                    </div>

                    <button type="submit" class="w-full bg-success hover:bg-success/90 text-white font-bold py-2 px-4 rounded-lg transition-colors" {{ $availableCopies->isEmpty() ? 'disabled' : '' }}>
                        Mark Ready for Pickup
                    </button>
                </form>
                <form action="{{ route('admin.reservations.status', $reservation) }}" method="POST" class="mt-3 ajax-form" data-confirm="Are you sure you want to cancel this approved request?">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="Cancelled">
                    <button type="submit" class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2 px-4 rounded-lg transition-colors">
                        Cancel Request
                    </button>
                </form>
            @elseif($currentStatus === 'ready for pickup')
                <form action="{{ route('admin.reservations.status', $reservation) }}" method="POST" class="space-y-3 ajax-form">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="Fulfilled">
                    <button type="submit" class="w-full bg-brand-navy hover:bg-brand-navy-light text-white font-bold py-2 px-4 rounded-lg transition-colors">
                        Mark as Fulfilled
                    </button>
                </form>
                <form action="{{ route('admin.reservations.status', $reservation) }}" method="POST" class="mt-3 ajax-form" data-confirm="Are you sure you want to cancel? (e.g. Student didn't pick up)">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="Cancelled">
                    <button type="submit" class="w-full bg-error/10 hover:bg-error/20 text-error font-bold py-2 px-4 rounded-lg transition-colors">
                        Cancel Request
                    </button>
                </form>
            @endif

        </div>
    @endif

</div>
