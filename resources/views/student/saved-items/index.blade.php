<x-layout.student title="Saved Items">
    <div class="max-w-7xl mx-auto">
        <x-student.page-header 
            title="My Saved Items" 
            subtitle="Books you've bookmarked for later." 
        />

        @if($savedItems->isEmpty())
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
                <div class="flex flex-col items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                    </svg>
                    <p class="text-xl font-bold text-gray-800 mb-2">No saved items yet.</p>
                    <p class="text-gray-500 max-w-md mx-auto mb-6">When browsing the OPAC, you can bookmark interesting titles to save them here for easy access later.</p>
                    <a href="{{ route('opac.index') }}" class="btn btn-primary">Browse Catalog</a>
                </div>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($savedItems as $item)
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden hover:shadow-elegant transition-shadow flex flex-col group relative">
                        <!-- Book Cover Placeholder -->
                        <div class="aspect-[2/3] bg-gray-100 w-full relative flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            
                            <!-- Remove Button -->
                            <form action="{{ route('student.saved-items.destroy', $item->bookData) }}" method="POST" class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity z-10">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-circle btn-error shadow-sm" title="Remove from saved list">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                        
                        <div class="p-4 flex flex-col flex-1">
                            @php
                                $authorNames = $item->bookData->authors
                                    ->map(fn ($author) => trim($author->first_name.' '.$author->last_name))
                                    ->filter()
                                    ->join(', ');
                            @endphp

                            <h3 class="font-bold text-gray-800 text-sm mb-1 line-clamp-2" title="{{ $item->bookData->book_title }}">
                                {{ $item->bookData->book_title }}
                            </h3>
                            @if($authorNames !== '')
                                <p class="text-xs text-gray-500 line-clamp-1 mb-2">by {{ $authorNames }}</p>
                            @endif
                            
                            <div class="mt-auto pt-4 flex gap-2">
                                <a href="{{ route('student.reservations.create', $item->bookData) }}" class="ajax-reserve-btn btn btn-sm btn-primary flex-1">Reserve</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($savedItems->hasPages())
                <div class="mt-8 flex justify-center">
                    {{ $savedItems->links('vendor.pagination.tailwind') }}
                </div>
            @endif
        @endif
    </div>
</x-layout.student>

<!-- AJAX Reservation Modal Handler -->
<div id="modal-container"></div>
