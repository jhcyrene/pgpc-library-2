<div class="flex flex-col sm:flex-row justify-between sm:items-start gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-[#102b70]">Borrow Details</h1>
        <p class="text-sm text-gray-500 mt-1">Loaned on {{ \Carbon\Carbon::parse($first->issue_date)->format('M d, Y') }}</p>
    </div>
    <div class="flex items-center gap-2">
        <a href="{{ route('admin.circulation.index') }}" class="btn bg-brand-navy hover:bg-brand-navy-light text-white font-bold shadow-md border-none btn-sm mr-5">
            Go to Circulation Desk
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
        <!-- Borrower Info -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden p-6 flex items-center gap-4">
            <div class="w-16 h-16 rounded-full bg-blue-100 text-brand-navy flex items-center justify-center text-2xl font-bold overflow-hidden shrink-0">
                @if($first->member->memberAuth && $first->member->memberAuth->profile_image)
                    <img src="{{ str_starts_with($first->member->memberAuth->profile_image, 'data:image') ? $first->member->memberAuth->profile_image : asset('storage/' . ltrim($first->member->memberAuth->profile_image, '/')) }}" class="w-full h-full object-cover">
                @else
                    {{ substr($first->member->first_name, 0, 1) }}
                @endif
            </div>
            <div>
                <h4 class="font-bold text-gray-900 text-xl">{{ $first->member->first_name }} {{ $first->member->last_name }}</h4>
                <p class="text-sm text-gray-500">Student ID: <span class="font-medium text-gray-700">{{ $first->member->student_id_number }}</span></p>
            </div>
        </div>

        <!-- Books List -->
        <div class="space-y-4">
            <h3 class="text-lg font-bold text-[#102b70] mb-2 border-b border-gray-100 pb-2">Borrowed Books ({{ $borrows->count() }})</h3>
            @foreach($borrows as $book)
                @php
                    $statusClass = $book->status === 'Returned' ? 'text-green-800 bg-green-100' : 'text-blue-800 bg-blue-100';
                    if ($book->status === 'Borrowed' && $book->due_date < now()) $statusClass = 'text-red-800 bg-red-100';
                @endphp
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 p-4 border border-gray-100 rounded-xl bg-white shadow-sm hover:border-gray-200 transition-colors">
                    <div class="w-12 h-16 shrink-0 shadow-sm bg-gray-100 rounded overflow-hidden">
                        @if($book->book->bookData->bookDetail && $book->book->bookData->bookDetail->image_url)
                            <img src="{{ asset('storage/' . $book->book->bookData->bookDetail->image_url) }}" class="w-full h-full object-cover">
                        @elseif($book->book->bookData->bookDetail && $book->book->bookData->bookDetail->cover_image)
                            <img src="{{ str_starts_with($book->book->bookData->bookDetail->cover_image, 'data:image') ? $book->book->bookData->bookDetail->cover_image : asset('storage/' . ltrim($book->book->bookData->bookDetail->cover_image, '/')) }}" class="w-full h-full object-cover">
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-bold text-gray-900 leading-tight mb-1 truncate">{{ $book->book->bookData->book_title }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ $book->book->bookData->authors->pluck('author_name')->join(', ') ?: 'Unknown Author' }}</p>
                        <p class="text-[11px] text-gray-400 mt-1 font-mono">{{ $book->book->barcode ?? $book->book->accession_number }}</p>
                    </div>
                    <div class="shrink-0 flex flex-col items-end">
                        <div class="px-3 py-1 rounded-full {{ $statusClass }} text-xs font-bold whitespace-nowrap">
                            {{ $book->status === 'Borrowed' && $book->due_date < now() ? 'Overdue' : $book->status }}
                        </div>
                        @if($book->return_date)
                            <p class="text-[10px] text-gray-500 mt-2">Returned: {{ \Carbon\Carbon::parse($book->return_date)->format('M d, Y') }}</p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Stats Column -->
    <div class="space-y-6 lg:col-span-1">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-4">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Status</p>
                <p class="font-bold text-gray-900 mt-1">{{ $groupStatus }}</p>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Due Date</p>
                @php
                    $dueDate = \Carbon\Carbon::parse($first->due_date);
                @endphp
                <p class="font-bold {{ $groupStatus === 'Overdue' ? 'text-red-600' : 'text-gray-900' }} mt-1">{{ $dueDate->format('M d, Y') }}</p>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Fine</p>
                <p class="font-bold text-gray-900 mt-1">₱{{ number_format($totalFine, 2) }}</p>
            </div>
        </div>
    </div>
</div>
