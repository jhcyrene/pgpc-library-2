<dialog id="book-details-modal" class="modal modal-bottom sm:modal-middle">
    <div class="modal-box w-[calc(100%-1rem)] max-w-none max-h-[calc(100dvh-1rem)] overflow-y-auto sm:w-11/12 sm:max-w-2xl bg-white p-0">
        
        <!-- Header -->
        <div class="bg-gray-50/50 p-4 sm:p-6 border-b border-gray-100 flex justify-between items-center sticky top-0 z-20">
            <h3 class="font-bold text-xl text-gray-800">Book Details</h3>
            <button class="btn btn-sm btn-circle btn-ghost absolute right-4 top-4" onclick="document.getElementById('book-details-modal').remove()">✕</button>
        </div>

        <div class="p-4 sm:p-6">
            
            <div class="flex flex-col sm:flex-row gap-6">
                <!-- Cover Image -->
                <div class="w-32 h-48 bg-gray-200 rounded-lg shrink-0 overflow-hidden flex items-center justify-center border shadow-sm mx-auto sm:mx-0">
                    @if($bookData->bookDetail && $bookData->bookDetail->image_url)
                        <img src="{{ asset('storage/' . $bookData->bookDetail->image_url) }}" alt="Cover" class="w-full h-full object-cover">
                    @elseif($bookData->bookDetail && $bookData->bookDetail->cover_image)
                        <img src="{{ str_starts_with($bookData->bookDetail->cover_image, 'data:image') ? $bookData->bookDetail->cover_image : asset('storage/' . ltrim($bookData->bookDetail->cover_image, '/')) }}" alt="Cover" class="w-full h-full object-cover">
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    @endif
                </div>
                
                <!-- Info -->
                <div class="flex-1">
                    <h4 class="font-bold text-gray-900 text-2xl leading-tight mb-1">{{ $bookData->book_title }}</h4>
                    @if($bookData->subtitle)
                        <p class="text-gray-500 font-medium mb-2">{{ $bookData->subtitle }}</p>
                    @endif
                    
                    <p class="text-base text-gray-700 mb-4">
                        <span class="font-semibold text-gray-500">By </span>
                        @if($bookData->authors->isNotEmpty())
                            {{ $bookData->authors->map(fn($a) => trim($a->first_name . ' ' . $a->last_name))->join(', ') }}
                        @else
                            Unknown Author
                        @endif
                    </p>

                    <div class="grid grid-cols-2 gap-4 text-sm bg-gray-50 p-4 rounded-xl border border-gray-100">
                        <div>
                            <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Call Number</span>
                            <span class="font-semibold text-gray-800">{{ $bookData->bookDetail?->call_number ?? 'N/A' }}</span>
                        </div>
                        <div>
                            <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">ISBN / ISSN</span>
                            <span class="font-semibold text-gray-800">{{ $bookData->bookDetail?->isbn ?? $bookData->bookDetail?->issn ?? 'N/A' }}</span>
                        </div>
                        <div>
                            <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Publisher</span>
                            <span class="font-semibold text-gray-800">{{ $bookData->bookDetail?->publisher?->publisher_name ?? 'N/A' }}</span>
                        </div>
                        <div>
                            <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Publication Year</span>
                            <span class="font-semibold text-gray-800">{{ $bookData->bookDetail?->publication_year ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            @if($bookData->description)
                <div class="mt-8 pt-6 border-t border-gray-100">
                    <h5 class="font-bold text-gray-800 mb-2">Description</h5>
                    <p class="text-gray-600 text-sm leading-relaxed">{{ $bookData->description }}</p>
                </div>
            @endif

            <div class="mt-8 flex flex-col sm:flex-row items-center justify-between gap-4 p-4 bg-gray-50 rounded-xl border border-gray-100">
                <div>
                    <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Availability</span>
                    <p class="text-sm font-semibold text-gray-700">
                        <span class="text-emerald-600">{{ $bookData->copies_available }}</span> of {{ $bookData->copies_total }} copies available
                    </p>
                </div>
                
                <div class="w-full sm:w-auto text-right">
                    @auth('member')
                        @php
                            $memberAccount = Auth::guard('member')->user();
                            $isStudentAccount = $memberAccount && in_array(strtolower((string) $memberAccount->account_type), ['member', 'student'], true);
                        @endphp
                        @if($isStudentAccount)
                            <a href="{{ route('student.reservations.create', $bookData) }}" class="ajax-reserve-btn btn btn-primary w-full sm:w-auto shadow-sm">Reserve Book</a>
                        @endif
                    @endauth
                </div>
            </div>

        </div>
    </div>
</dialog>

