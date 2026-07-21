@php
    $statusName = strtolower($reservation->bookRequestStatus->status_name ?? 'pending');
    $bookData = $reservation->bookData;
    $detail = $bookData?->bookDetail;
    $authors = $bookData?->authors;
    $authorName = $authors && $authors->isNotEmpty() 
        ? $authors->map(fn($a) => trim($a->first_name . ' ' . $a->last_name))->filter()->join(', ') 
        : 'Unknown Author';

    $availableCopies = \App\Models\Book::where('book_data_id', $reservation->book_data_id)
        ->where(function ($q) use ($reservation) {
            $q->where('status', 'Available');
            if ($reservation->book_id) {
                $q->orWhere('book_id', $reservation->book_id);
            }
        })
        ->get();

    $statusBadgeClass = match($statusName) {
        'approved' => 'bg-blue-100 text-blue-800 border-blue-200',
        'ready for pickup', 'ready' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
        'fulfilled', 'completed' => 'bg-purple-100 text-purple-800 border-purple-200',
        'cancelled', 'rejected' => 'bg-red-100 text-red-800 border-red-200',
        default => 'bg-amber-100 text-amber-800 border-amber-200',
    };

    $statusMessage = match($statusName) {
        'approved' => 'Reservation is approved. Select a book copy below or mark it ready for pickup.',
        'ready for pickup', 'ready' => 'Book copy is assigned and ready for student pickup.',
        'fulfilled', 'completed' => 'Book has been picked up and reservation is completed.',
        'cancelled', 'rejected' => 'This reservation has been cancelled.',
        default => 'This reservation is waiting for librarian approval.',
    };

    $isRequested = (bool) $reservation->request_date;
    $isApproved = (bool) $reservation->approved_at || in_array($statusName, ['approved', 'ready for pickup', 'ready', 'fulfilled', 'completed']);
    $isReady = (bool) $reservation->ready_at || in_array($statusName, ['ready for pickup', 'ready', 'fulfilled', 'completed']);
    $isFulfilled = (bool) $reservation->fulfilled_at || in_array($statusName, ['fulfilled', 'completed']);
    $isCancelled = (bool) $reservation->cancelled_at || in_array($statusName, ['cancelled', 'rejected']);
@endphp

<!-- MODAL HEADER -->
<div class="flex items-center justify-between px-6 py-5 border-b border-slate-100 bg-white sticky top-0 z-20">
    <div>
        <h2 class="text-lg sm:text-xl font-extrabold text-slate-900 tracking-tight">Reservation Details</h2>
        <p class="text-xs font-bold text-slate-400 mt-0.5">Reservation #{{ $reservation->book_request_id }}</p>
    </div>
    <button type="button" onclick="closeDetailsModal()" class="w-8 h-8 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 flex items-center justify-center transition-colors">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
    </button>
</div>

<!-- MODAL BODY GRID -->
<div class="p-6 overflow-y-auto max-h-[calc(88vh-130px)] space-y-6 font-sans">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- LEFT COLUMN (2/3) -->
        <div class="lg:col-span-2 space-y-5">
            
            <!-- 1. Book Information Card -->
            <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Book Information</h3>
                <div class="flex flex-col sm:flex-row gap-4">
                    <!-- Book Cover -->
                    <div class="w-20 h-28 shrink-0 bg-slate-100 rounded-xl overflow-hidden border border-slate-200 shadow-2xs flex items-center justify-center">
                        @if($detail && $detail->image_url)
                            <img src="{{ asset('storage/' . $detail->image_url) }}" alt="Cover" class="w-full h-full object-cover">
                        @elseif($detail && $detail->cover_image)
                            <img src="{{ str_starts_with($detail->cover_image, 'data:image') ? $detail->cover_image : asset('storage/' . ltrim($detail->cover_image, '/')) }}" alt="Cover" class="w-full h-full object-cover">
                        @else
                            <svg class="w-8 h-8 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                        @endif
                    </div>
                    
                    <div class="flex-1 min-w-0">
                        <h4 class="text-base font-extrabold text-slate-900 leading-snug">{{ $bookData?->book_title ?? 'Untitled Book' }}</h4>
                        <p class="text-xs font-semibold text-slate-500 mt-0.5">{{ $authorName }}</p>

                        <!-- Key-Value Grid Table -->
                        <div class="grid grid-cols-2 gap-y-2.5 gap-x-4 text-xs mt-4 pt-3 border-t border-slate-100">
                            <div>
                                <span class="text-slate-400 font-medium block text-[11px]">ISBN</span>
                                <span class="font-bold text-slate-800">{{ $detail?->isbn ?? 'N/A' }}</span>
                            </div>
                            <div>
                                <span class="text-slate-400 font-medium block text-[11px]">Publisher</span>
                                <span class="font-bold text-slate-800">{{ $detail?->publisher?->publisher_name ?? 'N/A' }}</span>
                            </div>
                            <div>
                                <span class="text-slate-400 font-medium block text-[11px]">Edition</span>
                                <span class="font-bold text-slate-800">{{ $detail?->edition ?? 'N/A' }}</span>
                            </div>
                            <div>
                                <span class="text-slate-400 font-medium block text-[11px]">Category</span>
                                <span class="font-bold text-slate-800">{{ $bookData?->categories?->first()?->category_name ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. Student Information Card -->
            <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Student Information</h3>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-[#0a1b42] text-[#fcc719] font-black text-lg flex items-center justify-center shrink-0 shadow-xs">
                        {{ strtoupper(substr($reservation->member->first_name ?? 'S', 0, 1)) }}
                    </div>
                    <div class="space-y-0.5 text-xs">
                        <p class="text-sm font-extrabold text-slate-900">{{ $reservation->member->first_name }} {{ $reservation->member->last_name }}</p>
                        <p class="font-bold text-slate-500">Student ID: <span class="text-slate-800">{{ $reservation->member->student_number ?? 'N/A' }}</span></p>
                        <p class="font-semibold text-slate-500">Email: <span class="text-slate-800">{{ $reservation->member->email ?? 'N/A' }}</span></p>
                        <p class="font-semibold text-slate-500">Phone: <span class="text-slate-800">{{ $reservation->member->contact_num ?? 'N/A' }}</span></p>
                    </div>
                </div>
            </div>

            <!-- 3. Request Details Card -->
            <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs space-y-3 text-xs">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Request Details</h3>
                
                <div class="flex justify-between py-1 border-b border-slate-100">
                    <span class="text-slate-500 font-medium">Requested Date</span>
                    <span class="font-bold text-slate-800">{{ $reservation->request_date ? $reservation->request_date->format('M d, Y h:i A') : 'N/A' }}</span>
                </div>
                <div class="flex justify-between py-1 border-b border-slate-100">
                    <span class="text-slate-500 font-medium">Preferred Pickup Date</span>
                    <span class="font-bold text-slate-800">{{ $reservation->pickup_date ? $reservation->pickup_date->format('M d, Y') : 'N/A' }}</span>
                </div>
                <div class="flex justify-between py-1 border-b border-slate-100">
                    <span class="text-slate-500 font-medium">Pickup Location</span>
                    <span class="font-bold text-slate-800">Main Library - Circulation Desk</span>
                </div>
                <div class="flex justify-between py-1">
                    <span class="text-slate-500 font-medium">Notes</span>
                    <span class="font-bold text-slate-700 italic">"{{ $reservation->remarks ?? 'No notes provided' }}"</span>
                </div>
            </div>

        </div>

        <!-- RIGHT COLUMN (1/3) -->
        <div class="space-y-5">
            
            <!-- 4. Reservation Status Card -->
            <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs text-center space-y-4">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider text-left">Reservation Status</h3>
                
                <div class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-black {{ $statusBadgeClass }} tracking-wider">
                    {{ strtoupper($reservation->bookRequestStatus->status_name ?? 'PENDING') }}
                </div>
                
                <p class="text-xs font-semibold text-slate-500">{{ $statusMessage }}</p>

                @if($statusName === 'pending')
                    <form action="{{ route('admin.reservations.status', $reservation) }}" method="POST" class="ajax-form text-left space-y-3 pt-2">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" id="status-target-{{ $reservation->book_request_id }}" value="Approved">

                        @if($availableCopies->isNotEmpty())
                            <div>
                                <label for="modal_book_id" class="block text-[11px] font-extrabold uppercase tracking-wider text-slate-400 mb-1">
                                    Assign Book Copy (Optional)
                                </label>
                                <select id="modal_book_id" name="book_id" class="w-full rounded-xl border border-slate-200 bg-slate-50 p-2 text-xs font-bold text-slate-800 focus:bg-white focus:border-[#102b70] outline-none">
                                    <option value="">-- Select Available Copy --</option>
                                    @foreach($availableCopies as $copy)
                                        <option value="{{ $copy->book_id }}" @selected($reservation->book_id == $copy->book_id)>
                                            Copy #{{ $copy->book_id }} (Acc: {{ $copy->accession_number ?? 'N/A' }}) - {{ $copy->status }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @else
                            <div class="p-2.5 rounded-xl bg-amber-50 border border-amber-200 text-[11px] font-semibold text-amber-800">
                                No book copies currently marked 'Available'.
                            </div>
                        @endif

                        <div class="flex gap-2 pt-1">
                            <button type="submit" onclick="document.getElementById('status-target-{{ $reservation->book_request_id }}').value='Approved'" class="flex-1 py-2.5 px-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-extrabold text-xs shadow-sm transition-all">
                                Approve
                            </button>
                            <button type="submit" onclick="document.getElementById('status-target-{{ $reservation->book_request_id }}').value='Ready for Pickup'" class="flex-1 py-2.5 px-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs shadow-sm transition-all">
                                Approve & Make Ready
                            </button>
                        </div>
                        <button type="button" 
                                onclick="openCancelModal('{{ route('admin.reservations.status', $reservation) }}', '{{ $reservation->book_request_id }}')" 
                                class="w-full py-1 text-red-600 hover:text-red-700 font-bold text-xs hover:underline transition-colors text-center block">
                            Reject Reservation
                        </button>
                    </form>
                @elseif($statusName === 'approved')
                    <form action="{{ route('admin.reservations.status', $reservation) }}" method="POST" class="ajax-form text-left space-y-3 pt-2">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="Ready for Pickup">

                        @if($availableCopies->isNotEmpty())
                            <div>
                                <label for="modal_book_id_approved" class="block text-[11px] font-extrabold uppercase tracking-wider text-slate-400 mb-1">
                                    Assign Book Copy
                                </label>
                                <select id="modal_book_id_approved" name="book_id" class="w-full rounded-xl border border-slate-200 bg-slate-50 p-2 text-xs font-bold text-slate-800 focus:bg-white focus:border-[#102b70] outline-none">
                                    <option value="">-- Select Available Copy --</option>
                                    @foreach($availableCopies as $copy)
                                        <option value="{{ $copy->book_id }}" @selected($reservation->book_id == $copy->book_id)>
                                            Copy #{{ $copy->book_id }} (Acc: {{ $copy->accession_number ?? 'N/A' }}) - {{ $copy->status }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @else
                            <div class="p-2.5 rounded-xl bg-amber-50 border border-amber-200 text-[11px] font-semibold text-amber-800">
                                No book copies currently marked 'Available'.
                            </div>
                        @endif

                        <button type="submit" class="w-full py-2.5 px-4 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs shadow-sm transition-all">
                            Mark Ready for Pickup
                        </button>
                    </form>
                @elseif(in_array($statusName, ['ready for pickup', 'ready']))
                    @if($reservation->book)
                        <div class="p-3 bg-emerald-50 border border-emerald-200 rounded-xl text-left text-xs font-semibold text-emerald-900">
                            <span class="font-extrabold block text-[11px] uppercase tracking-wider text-emerald-700">Assigned Copy</span>
                            Copy #{{ $reservation->book->book_id }} (Acc: {{ $reservation->book->accession_number ?? 'N/A' }})
                        </div>
                    @endif
                    <form action="{{ route('admin.reservations.status', $reservation) }}" method="POST" class="ajax-form pt-1">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="Completed">
                        <button type="submit" class="w-full py-2.5 px-4 rounded-xl bg-purple-600 hover:bg-purple-700 text-white font-extrabold text-xs shadow-sm transition-all">
                            Complete & Fulfill Reservation
                        </button>
                    </form>
                @endif
            </div>

            <!-- 5. Reservation Timeline Card -->
            <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs space-y-4">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Reservation Timeline</h3>
                
                <div class="relative pl-6 space-y-5 text-xs before:absolute before:left-2 before:top-2 before:bottom-2 before:w-0.5 before:bg-slate-200">
                    <!-- Step 1: Requested -->
                    <div class="relative">
                        <div class="absolute -left-6 top-0.5 w-4 h-4 rounded-full bg-amber-500 border-2 border-white shadow-xs"></div>
                        <p class="font-extrabold text-slate-900">Requested</p>
                        <p class="text-[11px] text-slate-500 font-semibold mt-0.5">{{ $reservation->request_date ? $reservation->request_date->format('M d, Y h:i A') : 'N/A' }}</p>
                    </div>

                    @if($isCancelled)
                        <!-- Step Cancelled / Rejected -->
                        <div class="relative">
                            <div class="absolute -left-6 top-0.5 w-4 h-4 rounded-full bg-red-500 border-2 border-white shadow-xs"></div>
                            <p class="font-extrabold text-red-600">Cancelled / Rejected</p>
                            @if($reservation->cancelled_at)
                                <p class="text-[11px] text-slate-500 font-semibold mt-0.5">{{ $reservation->cancelled_at->format('M d, Y h:i A') }}</p>
                            @endif
                        </div>
                    @else
                        <!-- Step 2: Approved -->
                        <div class="relative {{ $isApproved ? '' : 'opacity-40' }}">
                            <div class="absolute -left-6 top-0.5 w-4 h-4 rounded-full {{ $isApproved ? 'bg-blue-600 border-2 border-white shadow-xs' : 'bg-slate-300 border-2 border-white' }}"></div>
                            <p class="{{ $isApproved ? 'font-extrabold text-slate-900' : 'font-bold text-slate-600' }}">Approved</p>
                            @if($reservation->approved_at)
                                <p class="text-[11px] text-slate-500 font-semibold mt-0.5">{{ $reservation->approved_at->format('M d, Y h:i A') }}</p>
                            @endif
                        </div>

                        <!-- Step 3: Ready for Pickup -->
                        <div class="relative {{ $isReady ? '' : 'opacity-40' }}">
                            <div class="absolute -left-6 top-0.5 w-4 h-4 rounded-full {{ $isReady ? 'bg-emerald-600 border-2 border-white shadow-xs' : 'bg-slate-300 border-2 border-white' }}"></div>
                            <p class="{{ $isReady ? 'font-extrabold text-slate-900' : 'font-bold text-slate-600' }}">Ready for Pickup</p>
                            @if($reservation->ready_at)
                                <p class="text-[11px] text-slate-500 font-semibold mt-0.5">{{ $reservation->ready_at->format('M d, Y h:i A') }}</p>
                            @endif
                        </div>

                        <!-- Step 4: Completed -->
                        <div class="relative {{ $isFulfilled ? '' : 'opacity-40' }}">
                            <div class="absolute -left-6 top-0.5 w-4 h-4 rounded-full {{ $isFulfilled ? 'bg-purple-600 border-2 border-white shadow-xs' : 'bg-slate-300 border-2 border-white' }}"></div>
                            <p class="{{ $isFulfilled ? 'font-extrabold text-slate-900' : 'font-bold text-slate-600' }}">Completed</p>
                            @if($reservation->fulfilled_at)
                                <p class="text-[11px] text-slate-500 font-semibold mt-0.5">{{ $reservation->fulfilled_at->format('M d, Y h:i A') }}</p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            <!-- 6. Selected Pickup Date Card -->
            <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-xs space-y-2">
                <h4 class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Selected Pickup Date</h4>
                <div class="flex items-center gap-3 p-3 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-800">
                    <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    <span>{{ $reservation->pickup_date ? $reservation->pickup_date->format('M d, Y') : 'Not specified' }}</span>
                </div>
            </div>

        </div>

    </div>
</div>

<!-- MODAL FOOTER -->
<div class="flex items-center justify-between px-6 py-4 border-t border-slate-100 bg-slate-50/50 rounded-b-2xl">
    <button type="button" onclick="closeDetailsModal()" class="px-5 py-2.5 border border-slate-200 hover:bg-white text-slate-700 font-bold text-xs rounded-xl transition-all shadow-2xs">
        Close
    </button>
</div>
