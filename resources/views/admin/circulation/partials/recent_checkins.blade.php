@if($recentCheckins->count() > 0)
<div>
    <div class="border-t border-gray-100 pt-6">
        <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-4">Recent System Check-ins</h4>
        <div class="space-y-3">
            @foreach($recentCheckins as $return)
            <div class="bg-gray-50 rounded-xl p-3 flex items-center gap-4">
                <div class="w-10 h-14 bg-gray-200 rounded shrink-0 overflow-hidden flex items-center justify-center">
                    @if($return->book->bookData->bookDetail && $return->book->bookData->bookDetail->image_url)
                        <img src="{{ asset('storage/' . $return->book->bookData->bookDetail->image_url) }}" alt="Cover" class="w-full h-full object-cover">
                    @elseif($return->book->bookData->bookDetail && $return->book->bookData->bookDetail->cover_image)
                        <img src="{{ str_starts_with($return->book->bookData->bookDetail->cover_image, 'data:image') ? $return->book->bookData->bookDetail->cover_image : asset('storage/' . ltrim($return->book->bookData->bookDetail->cover_image, '/')) }}" alt="Cover" class="w-full h-full object-cover">
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <h5 class="text-sm font-bold text-gray-900 truncate leading-tight">{{ $return->book->bookData->book_title }}</h5>
                    <p class="text-xs text-gray-500 truncate">{{ $return->book->bookData->authors->pluck('author_name')->join(', ') }}</p>
                    <p class="text-[10px] text-gray-400 mt-1 uppercase tracking-wider">{{ $return->return_date->diffForHumans() }}</p>
                </div>
                <div class="shrink-0">
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-green-100 text-green-700 border border-green-200">
                        Returned
                    </span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif
