<dialog id="book-details-modal" class="modal modal-bottom sm:modal-middle font-sans">
    <div class="modal-box w-[calc(100%-1rem)] max-w-none max-h-[calc(100dvh-1rem)] overflow-y-auto sm:w-11/12 sm:max-w-2xl bg-white p-0 rounded-3xl shadow-2xl relative border border-slate-100">
        
        <!-- Header -->
        <div class="bg-slate-50/80 p-4 sm:p-6 border-b border-slate-100 flex justify-between items-center sticky top-0 z-20 backdrop-blur-md">
            <div>
                <h3 class="font-extrabold text-xl text-slate-900 tracking-tight">Book Details</h3>
                <p class="text-xs font-semibold text-slate-400 mt-0.5">PGPC Bibliographic Catalog</p>
            </div>
            <button class="w-8 h-8 rounded-full text-slate-400 hover:text-slate-600 hover:bg-slate-200/60 flex items-center justify-center transition-colors" onclick="document.getElementById('book-details-modal').remove()">✕</button>
        </div>

        <div class="p-5 sm:p-7 space-y-6">
            
            <div class="flex flex-col sm:flex-row gap-6 items-start">
                <!-- Cover Image -->
                <div class="w-36 h-52 bg-slate-100 rounded-2xl shrink-0 overflow-hidden flex items-center justify-center border border-slate-200 shadow-md mx-auto sm:mx-0 relative">
                    @if($bookData->bookDetail && $bookData->bookDetail->image_url)
                        <img src="{{ asset('storage/' . $bookData->bookDetail->image_url) }}" alt="Cover" class="w-full h-full object-cover">
                    @elseif($bookData->bookDetail && $bookData->bookDetail->cover_image)
                        <img src="{{ str_starts_with($bookData->bookDetail->cover_image, 'data:image') ? $bookData->bookDetail->cover_image : asset('storage/' . ltrim($bookData->bookDetail->cover_image, '/')) }}" alt="Cover" class="w-full h-full object-cover">
                    @else
                        <div class="flex flex-col items-center justify-center text-center p-3 text-[#102b70]">
                            <svg class="h-10 w-10 text-[#102b70]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            <span class="mt-2 text-[10px] font-black uppercase tracking-wider text-[#102b70]">PGPC LIBRARY</span>
                        </div>
                    @endif
                </div>
                
                <!-- Title & Key Metadata -->
                <div class="flex-1 space-y-2">
                    <div class="flex flex-wrap items-center gap-2">
                        @php
                            $isAvailable = (int)$bookData->copies_available > 0;
                        @endphp
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-extrabold border {{ $isAvailable ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-amber-50 text-amber-700 border-amber-200' }}">
                            {{ $isAvailable ? 'Available' : 'Checked Out' }}
                        </span>
                        @foreach($bookData->categories->take(2) as $cat)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-extrabold bg-blue-50 text-blue-800 border border-blue-100">
                                {{ $cat->category_name }}
                            </span>
                        @endforeach
                    </div>

                    <h4 class="font-extrabold text-slate-900 text-xl sm:text-2xl leading-snug">{{ $bookData->book_title }}</h4>
                    @if($bookData->subtitle)
                        <p class="text-xs font-semibold text-slate-500">{{ $bookData->subtitle }}</p>
                    @endif
                    
                    <p class="text-xs font-semibold text-slate-600">
                        <span class="text-slate-400">By </span>
                        @if($bookData->authors->isNotEmpty())
                            {{ $bookData->authors->map(fn($a) => trim($a->first_name . ' ' . $a->last_name))->join(', ') }}
                        @else
                            Unknown Author
                        @endif
                    </p>

                    <!-- Details Grid -->
                    <div class="grid grid-cols-2 gap-3 text-xs bg-slate-50 p-3.5 rounded-2xl border border-slate-200/80 mt-3">
                        <div>
                            <span class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-0.5">Call Number</span>
                            <span class="font-bold text-slate-800 font-mono">{{ $bookData->bookDetail?->call_number ?? 'N/A' }}</span>
                        </div>
                        <div>
                            <span class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-0.5">ISBN / ISSN</span>
                            <span class="font-bold text-slate-800 font-mono">{{ $bookData->bookDetail?->isbn ?? $bookData->bookDetail?->issn ?? 'N/A' }}</span>
                        </div>
                        <div>
                            <span class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-0.5">Publisher</span>
                            <span class="font-bold text-slate-800">{{ $bookData->bookDetail?->publisher?->publisher_name ?? 'N/A' }}</span>
                        </div>
                        <div>
                            <span class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-0.5">Publication Year</span>
                            <span class="font-bold text-slate-800">{{ $bookData->bookDetail?->publication_year ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            @if($bookData->description)
                <div class="pt-4 border-t border-slate-100 space-y-1">
                    <h5 class="font-extrabold text-xs text-slate-900 uppercase tracking-wider">About this book</h5>
                    <p class="text-slate-600 text-xs font-medium leading-relaxed">{{ $bookData->description }}</p>
                </div>
            @endif

            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 p-4 bg-slate-50 rounded-2xl border border-slate-200/80">
                <div>
                    <span class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-0.5">Availability</span>
                    <p class="text-xs font-bold text-slate-700">
                        <span class="text-emerald-600 font-extrabold">{{ $bookData->copies_available }}</span> of {{ $bookData->copies_total }} copies available
                    </p>
                </div>
                
                <div class="w-full sm:w-auto flex items-center gap-2">
                    @auth('member')
                        @php
                            $memberAccount = Auth::guard('member')->user();
                            $isStudentAccount = $memberAccount && in_array(strtolower((string) $memberAccount->account_type), ['member', 'student'], true);
                        @endphp
                        @if($isStudentAccount)
                            <a href="{{ route('student.reservations.create', $bookData) }}" class="ajax-reserve-btn w-full sm:w-auto px-5 py-2.5 rounded-xl bg-[#0a1b42] hover:bg-[#102b70] text-white font-extrabold text-xs shadow-sm transition-all text-center">
                                Reserve Book
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="w-full sm:w-auto px-5 py-2.5 rounded-xl bg-[#0a1b42] hover:bg-[#102b70] text-white font-extrabold text-xs shadow-sm transition-all text-center">
                            Log In to Reserve
                        </a>
                    @endauth
                </div>
            </div>

        </div>
    </div>
</dialog>
