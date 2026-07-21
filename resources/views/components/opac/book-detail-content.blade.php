@php
    $availableCopies = (int) $bookData->copies_available;
    $totalCopies = (int) $bookData->copies_total;
    $isAvailable = $availableCopies > 0;
    $authors = $bookData->authors->isNotEmpty()
        ? $bookData->authors
            ->map(fn ($author) => trim(collect([$author->first_name, $author->middle_name, $author->last_name, $author->suffix])->filter()->implode(' ')))
            ->join(', ')
        : 'Unknown author';
@endphp

<div class="grid min-w-0 gap-6 sm:grid-cols-[10rem_minmax(0,1fr)] sm:gap-7 lg:gap-8">
    {{-- Cover --}}
    <div class="mx-auto w-36 shrink-0 sm:mx-0 sm:w-40">
        <div class="relative aspect-[2/3] overflow-hidden rounded-2xl border border-slate-200 bg-gradient-to-br from-slate-50 to-slate-200 shadow-[0_16px_35px_-20px_rgba(15,23,42,0.55)]">
            @if($bookData->bookDetail?->cover_image)
                <img
                    src="{{ str_starts_with($bookData->bookDetail->cover_image, 'data:image') ? $bookData->bookDetail->cover_image : asset('storage/' . ltrim($bookData->bookDetail->cover_image, '/')) }}"
                    alt="Cover of {{ $bookData->book_title }}"
                    class="h-full w-full object-cover"
                >
            @else
                <div class="flex h-full flex-col items-center justify-center px-4 text-center text-brand-navy">
                    <div class="grid h-14 w-14 place-items-center rounded-full bg-brand-navy/10">
                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20M4 19.5A2.5 2.5 0 0 0 6.5 22H20V2H6.5A2.5 2.5 0 0 0 4 4.5v15Z" />
                        </svg>
                    </div>
                    <span class="mt-3 text-[10px] font-extrabold uppercase tracking-[0.14em]">PGPC Library</span>
                    <span class="mt-1 text-[9px] font-medium text-slate-400">Catalog copy</span>
                </div>
            @endif
        </div>
    </div>

    {{-- Main information --}}
    <div class="min-w-0">
        <div class="flex flex-wrap items-center gap-2">
            <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-[10px] font-extrabold uppercase tracking-wider {{ $isAvailable ? 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200' : 'bg-amber-50 text-amber-700 ring-1 ring-amber-200' }}">
                <span class="h-1.5 w-1.5 rounded-full {{ $isAvailable ? 'bg-emerald-500' : 'bg-amber-500' }}"></span>
                {{ $isAvailable ? 'Available' : 'Currently unavailable' }}
            </span>

            @foreach($bookData->categories->take(3) as $category)
                <span class="inline-flex items-center rounded-full bg-brand-gold/15 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-brand-navy">
                    {{ $category->category_name }}
                </span>
            @endforeach

            @if($bookData->categories->count() > 3)
                <span class="text-[10px] font-bold text-slate-400">+{{ $bookData->categories->count() - 3 }} more</span>
            @endif
        </div>

        <h4 class="mt-3 break-words text-2xl font-extrabold leading-tight tracking-tight text-slate-950 sm:text-3xl">
            {{ $bookData->book_title }}
        </h4>

        @if($bookData->subtitle)
            <p class="mt-1.5 break-words text-sm font-medium leading-6 text-slate-500">{{ $bookData->subtitle }}</p>
        @endif

        <p class="mt-2.5 text-sm leading-6 text-slate-600 sm:text-base">
            <span class="text-slate-400">By</span>
            <span class="font-semibold text-slate-700">{{ $authors }}</span>
        </p>

        {{-- Metadata --}}
        <dl class="mt-5 grid grid-cols-1 gap-2.5 min-[420px]:grid-cols-2">
            <div class="min-w-0 rounded-xl border border-slate-200 bg-slate-50/80 px-3.5 py-3">
                <dt class="text-[10px] font-extrabold uppercase tracking-[0.12em] text-slate-400">Call number</dt>
                <dd class="mt-1 break-words text-sm font-bold text-slate-800">{{ $bookData->bookDetail?->call_number ?? 'Not assigned' }}</dd>
            </div>
            <div class="min-w-0 rounded-xl border border-slate-200 bg-slate-50/80 px-3.5 py-3">
                <dt class="text-[10px] font-extrabold uppercase tracking-[0.12em] text-slate-400">ISBN / ISSN</dt>
                <dd class="mt-1 break-all text-sm font-bold text-slate-800">{{ $bookData->bookDetail?->isbn ?? $bookData->bookDetail?->issn ?? 'Not available' }}</dd>
            </div>
            <div class="min-w-0 rounded-xl border border-slate-200 bg-slate-50/80 px-3.5 py-3">
                <dt class="text-[10px] font-extrabold uppercase tracking-[0.12em] text-slate-400">Publisher</dt>
                <dd class="mt-1 break-words text-sm font-bold text-slate-800">{{ $bookData->bookDetail?->publisher?->publisher_name ?? 'Not available' }}</dd>
            </div>
            <div class="min-w-0 rounded-xl border border-slate-200 bg-slate-50/80 px-3.5 py-3">
                <dt class="text-[10px] font-extrabold uppercase tracking-[0.12em] text-slate-400">Publication year</dt>
                <dd class="mt-1 text-sm font-bold text-slate-800">{{ $bookData->bookDetail?->publication_year ?? 'Not available' }}</dd>
            </div>
        </dl>
    </div>
</div>

@if($bookData->description)
    <section class="mt-7 rounded-2xl border border-slate-200 bg-white px-4 py-4 sm:px-5" aria-labelledby="opac-book-description-title">
        <div class="flex items-center gap-2">
            <div class="h-4 w-1 rounded-full bg-brand-gold"></div>
            <h5 id="opac-book-description-title" class="font-bold text-slate-900">About this book</h5>
        </div>
        <p class="mt-2.5 text-sm leading-6 text-slate-600">{{ $bookData->description }}</p>
    </section>
@endif

{{-- Availability and actions --}}
<div class="mt-7 rounded-2xl border {{ $isAvailable ? 'border-emerald-200 bg-emerald-50/60' : 'border-amber-200 bg-amber-50/60' }} p-4 sm:p-5">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div class="flex min-w-0 items-center gap-3">
            <div class="grid h-11 w-11 shrink-0 place-items-center rounded-xl {{ $isAvailable ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    @if($isAvailable)
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m5 12 4 4L19 6" />
                    @else
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                    @endif
                </svg>
            </div>
            <div class="min-w-0">
                <p class="text-[10px] font-extrabold uppercase tracking-[0.14em] {{ $isAvailable ? 'text-emerald-700' : 'text-amber-700' }}">Availability</p>
                <p class="mt-0.5 text-sm font-semibold text-slate-700">
                    <span class="font-extrabold {{ $isAvailable ? 'text-emerald-700' : 'text-amber-700' }}">{{ $availableCopies }}</span>
                    of {{ $totalCopies }} {{ Str::plural('copy', $totalCopies) }} available
                </p>
            </div>
        </div>

        <div class="flex w-full flex-col gap-2 min-[420px]:flex-row sm:w-auto">
            @if($isStudentAccount)
                @if($isSaved)
                    <form action="{{ route('student.saved-items.destroy', $bookData) }}" method="POST" class="ajax-save-form w-full min-[420px]:w-auto" data-book-id="{{ $bookData->book_data_id }}" data-store-url="{{ route('student.saved-items.store', $bookData) }}" data-destroy-url="{{ route('student.saved-items.destroy', $bookData) }}" data-saved="true" data-save-variant="button">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn h-11 min-h-11 w-full rounded-xl border border-red-200 bg-white px-4 text-sm font-bold text-red-600 shadow-sm transition hover:bg-red-50 min-[420px]:w-auto" title="Remove from saved items" aria-pressed="true">
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M5 5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16l-7-3.5L5 21V5Z"/></svg>
                            Saved
                        </button>
                    </form>
                @else
                    <form action="{{ route('student.saved-items.store', $bookData) }}" method="POST" class="ajax-save-form w-full min-[420px]:w-auto" data-book-id="{{ $bookData->book_data_id }}" data-store-url="{{ route('student.saved-items.store', $bookData) }}" data-destroy-url="{{ route('student.saved-items.destroy', $bookData) }}" data-saved="false" data-save-variant="button">
                        @csrf
                        <button type="submit" class="btn h-11 min-h-11 w-full rounded-xl border border-brand-navy/20 bg-white px-4 text-sm font-bold text-brand-navy shadow-sm transition hover:bg-brand-navy/5 min-[420px]:w-auto" title="Save to your list" aria-pressed="false">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16l-7-3.5L5 21V5Z"/></svg>
                            Save
                        </button>
                    </form>
                @endif

                <a href="{{ route('student.reservations.create', $bookData) }}"
                    class="ajax-reserve-btn btn h-11 min-h-11 w-full rounded-xl border-none bg-brand-navy px-5 font-bold text-white shadow-sm transition hover:bg-brand-navy-light min-[420px]:w-auto">
                    Reserve Book
                </a>
            @elseif(!$memberAccount)
                <a href="{{ route('login') }}"
                    class="btn h-11 min-h-11 w-full rounded-xl border-none bg-brand-navy px-5 font-bold text-white shadow-sm transition hover:bg-brand-navy-light min-[420px]:w-auto">
                    Log In to Reserve
                </a>
            @else
                <p class="rounded-xl bg-white/70 px-4 py-2 text-center text-xs font-semibold leading-5 text-slate-500">
                    Reservations require a student account.
                </p>
            @endif
        </div>
    </div>
</div>
