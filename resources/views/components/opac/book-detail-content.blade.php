{{-- Partial content injected into #opac-modal-content via AJAX --}}
<div class="flex flex-col sm:flex-row gap-6">
    {{-- Cover Image --}}
    @if($bookData->bookDetail?->cover_image)
        <div class="w-36 h-52 bg-gradient-to-br from-slate-100 to-slate-200 rounded-xl shrink-0 overflow-hidden flex items-center justify-center border border-slate-200 shadow-sm mx-auto sm:mx-0">
            <img
                src="{{ str_starts_with($bookData->bookDetail->cover_image, 'data:image') ? $bookData->bookDetail->cover_image : asset('storage/' . ltrim($bookData->bookDetail->cover_image, '/')) }}"
                alt="Cover of {{ $bookData->book_title }}"
                class="h-full w-full object-cover"
            >
        </div>
    @else
        <div class="w-36 h-52 bg-brand-navy/5 rounded-xl shrink-0 overflow-hidden flex items-center justify-center border border-brand-navy/10 shadow-sm mx-auto sm:mx-0">
            <div class="flex flex-col items-center justify-center text-brand-navy text-center px-3">
                <svg class="h-10 w-10 text-brand-navy" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20M4 19.5A2.5 2.5 0 0 0 6.5 22H20V2H6.5A2.5 2.5 0 0 0 4 4.5v15Z" />
                </svg>
                <span class="mt-2 text-[10px] font-bold uppercase tracking-wider text-brand-navy">PGPC Library</span>
            </div>
        </div>
    @endif

    {{-- Info --}}
    <div class="flex-1 min-w-0">
        @if($bookData->categories->isNotEmpty())
            <div class="flex flex-wrap gap-1.5 mb-2.5">
                @foreach($bookData->categories as $category)
                    <span class="inline-flex items-center rounded-full bg-brand-gold/15 px-2.5 py-0.5 text-[10px] font-bold text-brand-navy uppercase tracking-wider">
                        {{ $category->category_name }}
                    </span>
                @endforeach
            </div>
        @endif

        <h4 class="mt-1 text-2xl font-bold leading-tight text-gray-900 break-words">{{ $bookData->book_title }}</h4>

        @if($bookData->subtitle)
            <p class="mt-1 text-gray-500 font-medium break-words">{{ $bookData->subtitle }}</p>
        @endif

        <p class="mt-2 text-base text-gray-700">
            <span class="font-semibold text-gray-500">By </span>
            @if($bookData->authors->isNotEmpty())
                {{ $bookData->authors->map(fn($a) => trim(collect([$a->first_name, $a->middle_name, $a->last_name, $a->suffix])->filter()->implode(' ')))->join(', ') }}
            @else
                Unknown Author
            @endif
        </p>

        {{-- Metadata Grid --}}
        <div class="grid grid-cols-2 xl:grid-cols-4 gap-3 mt-4">
            <div class="bg-gray-50 border border-gray-100 rounded-xl p-3">
                <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Call Number</span>
                <span class="text-sm font-semibold text-gray-900">{{ $bookData->bookDetail?->call_number ?? 'N/A' }}</span>
            </div>
            <div class="bg-gray-50 border border-gray-100 rounded-xl p-3">
                <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">ISBN / ISSN</span>
                <span class="text-sm font-semibold text-gray-900 break-all">{{ $bookData->bookDetail?->isbn ?? $bookData->bookDetail?->issn ?? 'N/A' }}</span>
            </div>
            <div class="bg-gray-50 border border-gray-100 rounded-xl p-3">
                <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Publisher</span>
                <span class="text-sm font-semibold text-gray-900">{{ $bookData->bookDetail?->publisher?->publisher_name ?? 'N/A' }}</span>
            </div>
            <div class="bg-gray-50 border border-gray-100 rounded-xl p-3">
                <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Year</span>
                <span class="text-sm font-semibold text-gray-900">{{ $bookData->bookDetail?->publication_year ?? 'N/A' }}</span>
            </div>
        </div>
    </div>
</div>

{{-- Description --}}
@if($bookData->description)
    <div class="mt-6 pt-5 border-t border-gray-100">
        <h5 class="font-bold text-gray-800 mb-2">Description</h5>
        <p class="text-gray-600 text-sm leading-relaxed">{{ $bookData->description }}</p>
    </div>
@endif

{{-- Availability + Actions --}}
<div class="mt-6 flex flex-col sm:flex-row items-center justify-between gap-4 p-4 bg-gray-50 rounded-xl border border-gray-100">
    <div>
        <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Availability</span>
        <p class="text-sm font-medium text-gray-500">
            <span class="font-bold text-emerald-600">{{ $bookData->copies_available }}</span> of <span class="font-semibold text-gray-700">{{ $bookData->copies_total }}</span> copies available
        </p>
    </div>

    <div class="flex items-center gap-2 w-full sm:w-auto">
        @if($isStudentAccount)
            {{-- Save / Unsave --}}
            @if($isSaved)
                <form action="{{ route('student.saved-items.destroy', $bookData) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn h-auto min-h-10 rounded-xl border border-red-200 bg-red-50 px-4 py-2 text-sm font-bold text-red-600 transition hover:bg-red-100" title="Remove from saved items">
                        <svg class="h-4 w-4 mr-1.5 inline" fill="currentColor" viewBox="0 0 24 24"><path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
                        Saved
                    </button>
                </form>
            @else
                <form action="{{ route('student.saved-items.store', $bookData) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="btn h-auto min-h-10 rounded-xl border border-brand-navy/20 bg-white px-4 py-2 text-sm font-bold text-brand-navy transition hover:bg-brand-navy/5" title="Save to your list">
                        <svg class="h-4 w-4 mr-1.5 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
                        Save
                    </button>
                </form>
            @endif

            {{-- Reserve --}}
            <a href="{{ route('student.reservations.create', $bookData) }}"
                class="ajax-reserve-btn btn h-auto min-h-10 rounded-xl border-none bg-brand-navy px-5 py-2 font-bold text-white shadow-sm transition hover:bg-brand-navy-light sm:w-auto">
                Reserve Book
            </a>
        @elseif(!$memberAccount)
            <a href="{{ route('login') }}"
                class="btn h-auto min-h-10 w-full rounded-xl border border-brand-navy/20 bg-white px-5 py-2 font-bold text-brand-navy transition hover:bg-brand-navy/5 sm:w-auto">
                Log In to Reserve
            </a>
        @endif
    </div>
</div>
