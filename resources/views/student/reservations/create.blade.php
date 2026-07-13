<x-layout.student title="Reserve Book">
    <div class="max-w-3xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('opac.index') }}" class="inline-flex items-center gap-1 text-sm font-semibold text-gray-500 hover:text-primary transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Catalog
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 md:p-8">
                <h1 class="text-2xl font-bold text-gray-800 mb-6">Confirm Reservation</h1>

                <!-- Book Details -->
                <div class="flex flex-col sm:flex-row gap-6 mb-8 p-6 rounded-xl bg-gray-50 border border-gray-100">
                    <div class="w-24 h-36 bg-gray-200 rounded-lg shrink-0 overflow-hidden flex items-center justify-center shadow-sm mx-auto sm:mx-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div class="flex-1 text-center sm:text-left">
                        @php
                            $authorNames = $bookData->authors
                                ->map(fn ($author) => trim($author->first_name.' '.$author->last_name))
                                ->filter()
                                ->join(', ');
                        @endphp

                        <h2 class="text-xl font-bold text-gray-800 mb-1">{{ $bookData->book_title }}</h2>
                        @if($authorNames !== '')
                            <p class="text-gray-600 mb-3">by {{ $authorNames }}</p>
                        @endif
                        
                        <div class="grid grid-cols-2 gap-4 mt-4">
                            <div>
                                <span class="block text-xs font-semibold text-gray-400 uppercase tracking-wider">ISBN</span>
                                <span class="text-sm font-medium text-gray-800">{{ $bookData->bookDetail?->isbn ?? 'N/A' }}</span>
                            </div>
                            <div>
                                <span class="block text-xs font-semibold text-gray-400 uppercase tracking-wider">Publication Year</span>
                                <span class="text-sm font-medium text-gray-800">{{ $bookData->bookDetail?->publication_year ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                @if(!$eligibility['eligible'])
                    <!-- Ineligible state -->
                    <div class="p-6 rounded-xl bg-error/5 border border-error/20 flex flex-col items-center text-center">
                        <div class="w-12 h-12 bg-error/10 text-error rounded-full flex items-center justify-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-error mb-2">Reservation Not Allowed</h3>
                        <p class="text-gray-600">{{ $eligibility['reason'] }}</p>
                        <a href="{{ route('opac.index') }}" class="btn btn-outline mt-6">Return to Catalog</a>
                    </div>
                @else
                    <!-- Eligible form -->
                    <form action="{{ route('student.reservations.store', $bookData) }}" method="POST">
                        @csrf
                        
                        <div class="mb-6">
                            <label for="remarks" class="block text-sm font-semibold text-gray-700 mb-1.5">Remarks / Notes (Optional)</label>
                            <textarea id="remarks" name="remarks" rows="3" class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-800 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all placeholder:text-gray-400" placeholder="Any special notes for the librarian..."></textarea>
                            @error('remarks')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 mb-8 text-sm text-blue-800 flex gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p>By confirming this reservation, the book will be prepared for you. Please monitor your dashboard for status updates. You will be notified when it is Ready for Pickup.</p>
                        </div>

                        <div class="flex items-center justify-end gap-3">
                            <a href="{{ route('opac.index') }}" class="btn btn-ghost hover:bg-gray-100">Cancel</a>
                            <button type="submit" class="btn btn-primary px-8">Confirm Reservation</button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</x-layout.student>
