@php
    $student = Auth::guard('member')->user()->member;
@endphp

<x-layout.student title="Dashboard">
    <div class="mx-auto w-full max-w-[1600px] space-y-5">
        <section class="grid grid-cols-1 gap-5 xl:grid-cols-[minmax(0,2.2fr)_minmax(280px,0.8fr)]">
            <div class="group relative flex min-h-[220px] flex-col justify-between overflow-hidden rounded-2xl bg-[#102b70] p-6 shadow-md transition-shadow hover:shadow-lg md:p-7">
                <div class="absolute -right-10 -top-10 w-64 h-64 bg-white opacity-5 rounded-full blur-3xl group-hover:scale-110 transition-transform duration-700"></div>
                <div class="absolute right-20 -bottom-20 w-40 h-40 bg-[#fcc719] opacity-10 rounded-full blur-2xl"></div>

                <div class="relative z-10 flex flex-col h-full">
                    <div class="flex-1">
                        <p class="text-white/60 text-xs font-bold uppercase tracking-wider mb-4">{{ now()->format('l, F j, Y') }}</p>
                        <h1 class="text-3xl md:text-4xl font-extrabold text-white leading-tight tracking-tight mb-2">
                            Good {{ now()->hour < 12 ? 'morning' : (now()->hour < 18 ? 'afternoon' : 'evening') }},
                            <span class="text-[#fcc719]">{{ $student->first_name }}</span>
                        </h1>
                        <p class="text-slate-300 text-sm font-medium max-w-xl leading-relaxed">
                            Review your borrowed books, reservations, and due dates from one place.
                        </p>

                        <div class="flex flex-wrap gap-x-6 gap-y-2 mt-5 text-xs font-semibold text-slate-300">
                            <span><strong class="text-white">{{ $summary['ready_for_pickup'] }}</strong> ready for pickup</span>
                            <span><strong class="text-white">₱{{ number_format((float) $summary['outstanding_fines'], 2) }}</strong> fine balance</span>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3 mt-6">
                        <a href="{{ route('opac.index') }}" class="px-6 py-3 bg-[#fcc719] hover:bg-[#FFD54F] text-[#102b70] text-sm font-bold rounded-xl shadow-md shadow-[#fcc719]/20 hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                            Browse Catalog
                        </a>
                        <a href="{{ route('student.borrow-transactions.current') }}" class="px-6 py-3 bg-white/10 hover:bg-white/15 border border-white/15 text-white text-sm font-bold rounded-xl transition-all flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                            My Current Borrows
                        </a>
                    </div>
                </div>
            </div>

            <div class="flex min-h-[220px] flex-col rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition-shadow hover:shadow-md">
                <div class="flex items-center justify-between gap-3 mb-4">
                    <div>
                        <h2 class="text-lg font-extrabold text-slate-900 tracking-tight">Requires Attention</h2>
                        <p class="text-xs font-medium text-slate-500 mt-0.5">Items that may need action</p>
                    </div>
                    <span class="min-w-8 h-8 px-2 rounded-full bg-red-50 border border-red-100 text-red-700 text-xs font-black flex items-center justify-center">{{ count($attentionItems) }}</span>
                </div>

                @if(count($attentionItems))
                    <div class="space-y-3 overflow-y-auto pr-1 max-h-44">
                        @foreach(array_slice($attentionItems, 0, 4) as $item)
                            @php
                                $attentionStyle = match($item['type']) {
                                    'overdue' => 'bg-red-50 border-red-100 text-red-700',
                                    'ready' => 'bg-emerald-50 border-emerald-100 text-emerald-700',
                                    default => 'bg-amber-50 border-amber-100 text-amber-700',
                                };
                            @endphp
                            <a href="{{ $item['action_url'] }}" class="block p-3 rounded-xl border {{ $attentionStyle }} hover:brightness-95 transition-all group">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="min-w-0">
                                        <p class="text-sm font-extrabold">{{ $item['title'] }}</p>
                                        <p class="text-xs opacity-80 mt-1 line-clamp-2">{{ $item['message'] }}</p>
                                    </div>
                                    <svg class="w-4 h-4 shrink-0 mt-1 group-hover:translate-x-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="flex-1 flex flex-col items-center justify-center text-center py-5">
                        <div class="w-12 h-12 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center mb-3">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <p class="text-sm font-bold text-slate-800">You're all caught up</p>
                        <p class="text-xs text-slate-500 mt-1">No overdue, pickup, or fine alerts.</p>
                    </div>
                @endif
            </div>
        </section>

        <section class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <x-student.summary-card
                title="Active Borrows"
                :value="$summary['active_borrows']"
                icon="<path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253' />"
                color="primary"
                description="Books currently on your account"
                :link="route('student.borrow-transactions.current')"
            />
            <x-student.summary-card
                title="Overdue Items"
                :value="$summary['overdue_items']"
                icon="<path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z' />"
                :color="$summary['overdue_items'] > 0 ? 'error' : 'success'"
                description="Past their scheduled due date"
                :link="route('student.overdue-items.index')"
            />
            <x-student.summary-card
                title="Reservations"
                :value="$summary['pending_reservations']"
                icon="<path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z' />"
                color="info"
                description="Pending library requests"
                :link="route('student.reservations.index')"
            />
            <x-student.summary-card
                title="Books Borrowed"
                :value="$summary['total_books_borrowed']"
                icon="<path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z' />"
                color="gold"
                description="Your complete circulation history"
                :link="route('student.borrow-transactions.history')"
            />
        </section>

        <section class="grid grid-cols-1 gap-5 xl:grid-cols-[minmax(0,2.2fr)_minmax(280px,0.8fr)]">
            <div class="flex min-h-[280px] flex-col rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition-shadow hover:shadow-md">
                <div class="flex items-center justify-between gap-4 mb-4">
                    <div>
                        <h2 class="text-lg font-extrabold text-slate-900 tracking-tight">Current Borrows</h2>
                        <p class="text-xs font-medium text-slate-500 mt-0.5">Books assigned to your library account</p>
                    </div>
                    <a href="{{ route('student.borrow-transactions.current') }}" class="text-xs font-bold text-blue-700 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 px-4 py-2 rounded-lg transition-colors">View all</a>
                </div>

                @if($currentBorrows->isEmpty())
                    <div class="flex flex-1 flex-col items-center justify-center rounded-xl border border-dashed border-slate-200 bg-slate-50/60 py-8 text-center">
                        <svg class="h-10 w-10 text-slate-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                        <p class="text-sm font-bold text-slate-700">No books are currently borrowed</p>
                        <a href="{{ route('opac.index') }}" class="mt-4 text-sm font-bold text-blue-700 hover:text-blue-900">Search the catalog</a>
                    </div>
                @else
                    <div class="overflow-x-auto rounded-xl border border-slate-200">
                        <table class="w-full text-left text-sm text-slate-600 whitespace-nowrap">
                            <thead class="bg-slate-50 text-slate-500 font-bold border-b border-slate-200 uppercase text-xs tracking-wider">
                                <tr>
                                    <th class="px-5 py-3.5">Book</th>
                                    <th class="hidden px-5 py-3.5 sm:table-cell">Accession No.</th>
                                    <th class="px-5 py-3.5">Due Date</th>
                                    <th class="px-5 py-3.5 text-right">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($currentBorrows as $borrow)
                                    @php
                                        $isOverdue = $borrow->due_date?->isPast() ?? false;
                                    @endphp
                                    <tr class="hover:bg-slate-50 transition-colors">
                                        <td class="px-5 py-4 max-w-xs truncate font-bold text-slate-900">{{ $borrow->book?->bookData?->book_title ?? 'Untitled book' }}</td>
                                        <td class="hidden px-5 py-4 text-xs font-medium text-slate-500 sm:table-cell">{{ $borrow->book?->accession_number ?? '—' }}</td>
                                        <td class="px-5 py-4 text-xs font-medium">{{ $borrow->due_date?->format('M d, Y') ?? '—' }}</td>
                                        <td class="px-5 py-4 text-right">
                                            <span class="inline-flex px-2.5 py-1 rounded-md text-xs font-bold border {{ $isOverdue ? 'text-red-700 bg-red-50 border-red-200' : 'text-emerald-700 bg-emerald-50 border-emerald-200' }}">
                                                {{ $isOverdue ? 'Overdue' : 'Active' }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <div class="flex min-h-[280px] flex-col rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition-shadow hover:shadow-md">
                <div class="flex items-center justify-between gap-4 mb-4">
                    <div>
                        <h2 class="text-lg font-extrabold text-slate-900 tracking-tight">Reservations</h2>
                        <p class="text-xs font-medium text-slate-500 mt-0.5">Your latest active requests</p>
                    </div>
                    <a href="{{ route('student.reservations.index') }}" class="text-xs font-bold text-blue-700 hover:text-blue-900">View all</a>
                </div>

                @if($reservations->isEmpty())
                    <div class="flex-1 flex flex-col items-center justify-center text-center py-8">
                        <svg class="h-10 w-10 text-slate-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        <p class="text-sm font-bold text-slate-700">No active reservations</p>
                        <p class="text-xs text-slate-500 mt-1">Reserve available titles from the catalog.</p>
                    </div>
                @else
                    <div class="space-y-3">
                        @foreach($reservations as $reservation)
                            @php
                                $statusName = $reservation->bookRequestStatus?->status_name ?? 'Pending';
                                $statusStyle = match(strtolower($statusName)) {
                                    'ready for pickup' => 'text-emerald-700 bg-emerald-50 border-emerald-200',
                                    'approved' => 'text-blue-700 bg-blue-50 border-blue-200',
                                    default => 'text-amber-700 bg-amber-50 border-amber-200',
                                };
                            @endphp
                            <a href="{{ route('student.reservations.show', $reservation) }}" class="block p-3 rounded-xl border border-slate-100 hover:border-slate-200 hover:bg-slate-50 transition-all group">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="min-w-0">
                                        <p class="text-sm font-bold text-slate-900 truncate group-hover:text-blue-700 transition-colors">{{ $reservation->bookData?->book_title ?? 'Untitled book' }}</p>
                                        <p class="text-xs text-slate-500 mt-1">Requested {{ $reservation->request_date?->diffForHumans() ?? 'recently' }}</p>
                                    </div>
                                    <span class="shrink-0 inline-flex px-2 py-1 rounded-md border text-[10px] font-bold {{ $statusStyle }}">{{ $statusName }}</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>
    </div>
</x-layout.student>
