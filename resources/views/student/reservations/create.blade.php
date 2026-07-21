@php
    $member = Auth::guard('member')->user()->member;
@endphp

<x-layout.student title="Confirm Reservation">
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Back Button -->
        <div>
            <a href="{{ route('opac.index') }}" class="inline-flex items-center gap-1.5 text-xs font-extrabold text-slate-500 hover:text-blue-700 transition-colors uppercase tracking-wider">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Catalog
            </a>
        </div>

        <h1 class="text-2xl font-black text-slate-900 tracking-tight">Confirm Reservation</h1>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-6 md:p-8">
                <!-- Book Details Card -->
                <div class="flex flex-col sm:flex-row gap-6 mb-8 p-5 rounded-2xl bg-slate-50 border border-slate-100 items-center sm:items-start">
                    <div class="w-24 aspect-[2/3] bg-gradient-to-br from-slate-100 to-slate-200 rounded-xl shrink-0 overflow-hidden flex items-center justify-center border border-slate-200 shadow-soft">
                        @if($bookData->bookDetail?->cover_image)
                            <img src="{{ str_starts_with($bookData->bookDetail->cover_image, 'data:image') ? $bookData->bookDetail->cover_image : asset('storage/' . ltrim($bookData->bookDetail->cover_image, '/')) }}" alt="Cover" class="w-full h-full object-cover" />
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20M4 19.5A2.5 2.5 0 0 0 6.5 22H20V2H6.5A2.5 2.5 0 0 0 4 4.5v15Z" />
                            </svg>
                        @endif
                    </div>
                    <div class="flex-1 text-center sm:text-left min-w-0">
                        @php
                            $authorNames = $bookData->authors
                                ->map(fn ($author) => trim($author->first_name.' '.$author->last_name))
                                ->filter()
                                ->join(', ');
                        @endphp

                        <h2 class="text-xl font-extrabold text-slate-900 leading-snug truncate">{{ $bookData->book_title }}</h2>
                        @if($authorNames !== '')
                            <p class="text-sm font-semibold text-slate-500 mt-1">by {{ $authorNames }}</p>
                        @endif
                        
                        <div class="grid grid-cols-2 gap-4 mt-5">
                            <div>
                                <span class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">ISBN</span>
                                <span class="text-xs font-bold text-slate-800 mt-0.5 block">{{ $bookData->bookDetail?->isbn ?? 'N/A' }}</span>
                            </div>
                            <div>
                                <span class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">Publication Year</span>
                                <span class="text-xs font-bold text-slate-800 mt-0.5 block">{{ $bookData->bookDetail?->publication_year ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                @if(!$eligibility['eligible'])
                    <!-- Ineligible state -->
                    <div class="p-8 rounded-2xl bg-red-50 border border-red-100 flex flex-col items-center text-center">
                        <div class="w-12 h-12 bg-red-100 text-red-600 rounded-full flex items-center justify-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <h3 class="text-base font-extrabold text-red-800 mb-2">Reservation Not Allowed</h3>
                        <p class="text-xs font-semibold text-slate-500 max-w-sm">{{ $eligibility['reason'] }}</p>
                        <a href="{{ route('opac.index') }}" class="mt-6 px-6 py-2.5 bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 text-xs font-bold rounded-xl transition-all shadow-xs">Return to Catalog</a>
                    </div>
                @else
                    <!-- Eligible form -->
                    <form id="reservation-form" action="{{ route('student.reservations.store', $bookData) }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <!-- Hidden inputs -->
                        <input type="hidden" id="pickup_date" name="pickup_date" value="{{ old('pickup_date', now()->format('Y-m-d')) }}">

                        <div>
                            <div class="flex items-center gap-2 mb-4">
                                <span class="w-5 h-5 rounded-full bg-[#102b70] text-white text-xs font-black flex items-center justify-center">1</span>
                                <h3 class="text-xs font-extrabold text-[#102b70] uppercase tracking-widest">Reservation Details</h3>
                            </div>
                            
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">
                                <!-- Preferred Reservation Date Inline Calendar -->
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-2">Preferred Reservation Date</label>
                                    <div class="border border-slate-200 rounded-2xl p-4 bg-white shadow-sm">
                                        <!-- Calendar Header -->
                                        <div class="flex items-center justify-between mb-4">
                                            <button type="button" id="prev-month-btn" class="p-1.5 hover:bg-slate-50 text-slate-600 rounded-lg transition-colors border border-slate-100">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" /></svg>
                                            </button>
                                            <span id="calendar-month-year" class="text-sm font-extrabold text-slate-800">July 2026</span>
                                            <button type="button" id="next-month-btn" class="p-1.5 hover:bg-slate-50 text-slate-600 rounded-lg transition-colors border border-slate-100">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" /></svg>
                                            </button>
                                        </div>

                                        <!-- Day Names -->
                                        <div class="grid grid-cols-7 gap-1 text-center text-[10px] font-black text-slate-400 uppercase tracking-wider mb-2">
                                            <span>Sun</span>
                                            <span>Mon</span>
                                            <span>Tue</span>
                                            <span>Wed</span>
                                            <span>Thu</span>
                                            <span>Fri</span>
                                            <span>Sat</span>
                                        </div>

                                        <!-- Days Grid -->
                                        <div id="calendar-days" class="grid grid-cols-7 gap-1 text-center">
                                            <!-- Generated via JS -->
                                        </div>

                                        <!-- Legend -->
                                        <div class="flex justify-center gap-6 mt-4 pt-3 border-t border-slate-100 text-[10px] font-bold text-slate-400">
                                            <div class="flex items-center gap-1.5">
                                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                                Available
                                            </div>
                                            <div class="flex items-center gap-1.5">
                                                <span class="w-2 h-2 rounded-full bg-red-400"></span>
                                                Unavailable
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Time & Notes -->
                                <div class="space-y-4">
                                    <!-- Pickup Time Window -->
                                    <div>
                                        <label for="pickup_time" class="block text-xs font-bold text-slate-700 mb-1.5">Pickup Time Window</label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                            </div>
                                            <select id="pickup_time" name="pickup_time" class="block w-full pl-9 pr-3 py-2.5 border border-slate-200 rounded-xl text-sm bg-slate-50 focus:bg-white focus:border-[#102b70] focus:ring-1 focus:ring-[#102b70] outline-none transition-all shadow-xs text-slate-700 font-semibold appearance-none">
                                                <option value="8:00 AM - 12:00 PM">8:00 AM - 12:00 PM</option>
                                                <option value="1:00 PM - 5:00 PM">1:00 PM - 5:00 PM</option>
                                            </select>
                                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" /></svg>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Remarks -->
                                    <div>
                                        <div class="flex items-center justify-between gap-4 mb-1.5">
                                            <label for="remarks" class="block text-xs font-bold text-slate-700">Remarks / Notes (Optional)</label>
                                            <span id="char-counter" class="text-[10px] font-semibold text-slate-400">0 / 250</span>
                                        </div>
                                        <textarea id="remarks" name="remarks" rows="3" maxlength="250" class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:bg-white focus:border-[#102b70] focus:ring-1 focus:ring-[#102b70] outline-none transition-all placeholder:text-slate-400 shadow-xs" placeholder="Any special notes for the librarian..."></textarea>
                                        @error('remarks')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Status Message Alert Box -->
                                    <div id="status-alert-box" class="border rounded-2xl p-4 text-xs font-semibold flex gap-3 shadow-xs transition-colors bg-emerald-50 border-emerald-100 text-emerald-700">
                                        <div id="status-icon-wrapper" class="shrink-0 text-emerald-600">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        </div>
                                        <div>
                                            <p id="status-title" class="font-extrabold text-emerald-800">Available on selected date</p>
                                            <p id="status-desc" class="mt-0.5 text-[10px] text-emerald-600 font-medium">Monday, July 20, 2026 is available for reservation.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Reservation Summary section -->
                        <div>
                            <div class="flex items-center gap-2 mb-4">
                                <span class="w-5 h-5 rounded-full bg-[#102b70] text-white text-xs font-black flex items-center justify-center">2</span>
                                <h3 class="text-xs font-extrabold text-[#102b70] uppercase tracking-widest">Reservation Summary</h3>
                            </div>
                            
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                <div class="bg-slate-50 border border-slate-100 p-4 rounded-2xl flex items-center gap-3 shadow-xs">
                                    <div class="w-9 h-9 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    </div>
                                    <div class="min-w-0">
                                        <span class="block text-[9px] font-extrabold text-slate-400 uppercase tracking-wider">Availability Status</span>
                                        <span id="summary-avail-status" class="text-xs font-black text-emerald-700 mt-0.5 block truncate">Available</span>
                                    </div>
                                </div>

                                <div class="bg-slate-50 border border-slate-100 p-4 rounded-2xl flex items-center gap-3 shadow-xs">
                                    <div class="w-9 h-9 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                    </div>
                                    <div class="min-w-0">
                                        <span class="block text-[9px] font-extrabold text-slate-400 uppercase tracking-wider">Hold Period</span>
                                        <span class="text-xs font-black text-slate-700 mt-0.5 block truncate">3 days</span>
                                    </div>
                                </div>

                                <div class="bg-slate-50 border border-slate-100 p-4 rounded-2xl flex items-center gap-3 shadow-xs">
                                    <div class="w-9 h-9 rounded-full bg-purple-50 text-purple-600 flex items-center justify-center shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                    </div>
                                    <div class="min-w-0">
                                        <span class="block text-[9px] font-extrabold text-slate-400 uppercase tracking-wider">Selected Pickup Date</span>
                                        <span id="summary-date-display" class="text-xs font-black text-slate-700 mt-0.5 block truncate">—</span>
                                    </div>
                                </div>

                                <div class="bg-slate-50 border border-slate-100 p-4 rounded-2xl flex items-center gap-3 shadow-xs">
                                    <div class="w-9 h-9 rounded-full bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    </div>
                                    <div class="min-w-0">
                                        <span class="block text-[9px] font-extrabold text-slate-400 uppercase tracking-wider">Pickup Time Window</span>
                                        <span id="summary-time-display" class="text-xs font-black text-slate-700 mt-0.5 block truncate">8:00 AM - 12:00 PM</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                            <a href="{{ route('opac.index') }}" class="px-6 py-2.5 border border-slate-200 text-slate-600 hover:bg-slate-50 font-bold text-sm rounded-xl transition-all shadow-xs">Cancel</a>
                            <button type="submit" id="submit-btn" class="px-6 py-2.5 bg-[#102b70] hover:bg-[#0b225e] text-white font-bold text-sm rounded-xl transition-all shadow-md shadow-blue-900/10 flex items-center gap-2">
                                Confirm Reservation
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" /></svg>
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const dateInput = document.getElementById('pickup_date');
            const summaryDateDisplay = document.getElementById('summary-date-display');
            const summaryTimeDisplay = document.getElementById('summary-time-display');
            const timeSelect = document.getElementById('pickup_time');
            const remarksTextarea = document.getElementById('remarks');
            const charCounter = document.getElementById('char-counter');
            const submitBtn = document.getElementById('submit-btn');

            const monthYearLabel = document.getElementById('calendar-month-year');
            const daysGrid = document.getElementById('calendar-days');
            const prevMonthBtn = document.getElementById('prev-month-btn');
            const nextMonthBtn = document.getElementById('next-month-btn');

            const statusAlertBox = document.getElementById('status-alert-box');
            const statusIconWrapper = document.getElementById('status-icon-wrapper');
            const statusTitle = document.getElementById('status-title');
            const statusDesc = document.getElementById('status-desc');
            const summaryAvailStatus = document.getElementById('summary-avail-status');

            const unavailableInfo = @json($unavailableInfo ?? ['all' => false, 'dates' => []]);
            let currentCalendarDate = new Date();
            let selectedDateStr = dateInput ? dateInput.value : new Date().toISOString().split('T')[0];

            const formatYmd = (year, monthZeroIndexed, day) => {
                const m = String(monthZeroIndexed + 1).padStart(2, '0');
                const d = String(day).padStart(2, '0');
                return `${year}-${m}-${d}`;
            };

            const formatDate = (dateStr) => {
                if (!dateStr) return '—';
                const parts = dateStr.split('-');
                if (parts.length === 3) {
                    const date = new Date(parseInt(parts[0]), parseInt(parts[1]) - 1, parseInt(parts[2]));
                    if (!isNaN(date.getTime())) {
                        return date.toLocaleDateString('en-US', { weekday: 'short', month: 'short', day: 'numeric', year: 'numeric' });
                    }
                }
                const date = new Date(dateStr);
                if (isNaN(date.getTime())) return '—';
                return date.toLocaleDateString('en-US', { weekday: 'short', month: 'short', day: 'numeric', year: 'numeric' });
            };

            const selectDate = (dateStr) => {
                selectedDateStr = dateStr;
                if (dateInput) {
                    dateInput.value = dateStr;
                }

                const dayButtons = daysGrid.querySelectorAll('button[data-date]');
                dayButtons.forEach(btn => {
                    const bDate = btn.getAttribute('data-date');
                    const isDis = btn.getAttribute('data-disabled') === 'true';

                    if (bDate === selectedDateStr) {
                        btn.className = 'p-2 text-xs font-bold rounded-lg transition-all focus:outline-none flex items-center justify-center h-8 w-8 mx-auto bg-[#102b70] text-white shadow-sm ring-2 ring-[#102b70]/20';
                    } else if (isDis) {
                        btn.className = 'p-2 text-xs font-bold rounded-lg transition-all focus:outline-none flex items-center justify-center h-8 w-8 mx-auto bg-red-50 text-red-400 cursor-not-allowed';
                    } else {
                        btn.className = 'p-2 text-xs font-bold rounded-lg transition-all focus:outline-none flex items-center justify-center h-8 w-8 mx-auto bg-emerald-50/50 hover:bg-emerald-100 text-emerald-700 hover:scale-105';
                    }
                });

                updateAlertStatus(dateStr, true);
            };

            const renderCalendar = () => {
                const year = currentCalendarDate.getFullYear();
                const month = currentCalendarDate.getMonth();

                // Set Header Month Year
                monthYearLabel.textContent = currentCalendarDate.toLocaleString('default', { month: 'long', year: 'numeric' });

                // Clear days
                daysGrid.innerHTML = '';

                // Get first day and number of days
                const firstDayIndex = new Date(year, month, 1).getDay();
                const totalDays = new Date(year, month + 1, 0).getDate();
                const prevLastDay = new Date(year, month, 0).getDate();

                // Add empty spaces for previous month's padding
                for (let i = firstDayIndex; i > 0; i--) {
                    const paddingDay = document.createElement('span');
                    paddingDay.className = 'p-2 text-xs font-semibold text-slate-300 pointer-events-none select-none';
                    paddingDay.textContent = prevLastDay - i + 1;
                    daysGrid.appendChild(paddingDay);
                }

                // Add current month days
                const today = new Date();
                today.setHours(0, 0, 0, 0);

                for (let day = 1; day <= totalDays; day++) {
                    const dayDate = new Date(year, month, day);
                    const dateStr = formatYmd(year, month, day);

                    const isPast = dayDate < today;
                    const isUnavailable = unavailableInfo.all || (unavailableInfo.dates || []).includes(dateStr) || isPast;
                    const isSelected = dateStr === selectedDateStr;

                    const dayBtn = document.createElement('button');
                    dayBtn.type = 'button';
                    dayBtn.setAttribute('data-date', dateStr);
                    dayBtn.textContent = day;

                    if (isSelected && !isUnavailable) {
                        dayBtn.className = 'p-2 text-xs font-bold rounded-lg transition-all focus:outline-none flex items-center justify-center h-8 w-8 mx-auto bg-[#102b70] text-white shadow-sm ring-2 ring-[#102b70]/20';
                    } else if (isUnavailable) {
                        dayBtn.className = 'p-2 text-xs font-bold rounded-lg transition-all focus:outline-none flex items-center justify-center h-8 w-8 mx-auto bg-red-50 text-red-400 cursor-not-allowed';
                        dayBtn.setAttribute('disabled', 'true');
                        dayBtn.setAttribute('data-disabled', 'true');
                    } else {
                        dayBtn.className = 'p-2 text-xs font-bold rounded-lg transition-all focus:outline-none flex items-center justify-center h-8 w-8 mx-auto bg-emerald-50/50 hover:bg-emerald-100 text-emerald-700 hover:scale-105';
                    }

                    if (!isUnavailable) {
                        dayBtn.addEventListener('click', () => {
                            selectDate(dateStr);
                        });
                    }

                    daysGrid.appendChild(dayBtn);
                }
            };

            const updateAlertStatus = (dateStr, isAvailable) => {
                // Update dynamic alert banner
                if (isAvailable) {
                    statusAlertBox.className = 'border rounded-2xl p-4 text-xs font-semibold flex gap-3 shadow-xs transition-colors bg-emerald-50 border-emerald-100 text-emerald-700';
                    statusIconWrapper.className = 'shrink-0 text-emerald-600';
                    statusIconWrapper.innerHTML = `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>`;
                    statusTitle.textContent = 'Available on selected date';
                    statusDesc.textContent = `${formatDate(dateStr)} is available for reservation.`;
                    summaryAvailStatus.textContent = 'Available';
                    summaryAvailStatus.className = 'text-xs font-black text-emerald-700 mt-0.5 block truncate';
                    if (submitBtn) submitBtn.removeAttribute('disabled');
                } else {
                    statusAlertBox.className = 'border rounded-2xl p-4 text-xs font-semibold flex gap-3 shadow-xs transition-colors bg-red-50 border-red-100 text-red-700';
                    statusIconWrapper.className = 'shrink-0 text-red-600';
                    statusIconWrapper.innerHTML = `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>`;
                    statusTitle.textContent = 'Unavailable on selected date';
                    statusDesc.textContent = `${formatDate(dateStr)} has no copies available.`;
                    summaryAvailStatus.textContent = 'Unavailable';
                    summaryAvailStatus.className = 'text-xs font-black text-red-700 mt-0.5 block truncate';
                    if (submitBtn) submitBtn.setAttribute('disabled', 'true');
                }

                // Update summary pickup date
                if (summaryDateDisplay) {
                    summaryDateDisplay.textContent = formatDate(dateStr);
                }
            };

            // Prev and Next month buttons
            if (prevMonthBtn && nextMonthBtn) {
                prevMonthBtn.addEventListener('click', () => {
                    currentCalendarDate.setMonth(currentCalendarDate.getMonth() - 1);
                    renderCalendar();
                });
                nextMonthBtn.addEventListener('click', () => {
                    currentCalendarDate.setMonth(currentCalendarDate.getMonth() + 1);
                    renderCalendar();
                });
            }

            // Sync Pickup Time select with summary
            if (timeSelect && summaryTimeDisplay) {
                timeSelect.addEventListener('change', () => {
                    summaryTimeDisplay.textContent = timeSelect.value;
                });
            }

            // Character counter for remarks
            if (remarksTextarea && charCounter) {
                remarksTextarea.addEventListener('input', () => {
                    const currentLen = remarksTextarea.value.length;
                    charCounter.textContent = `${currentLen} / 250`;
                });
            }

            // Handle AJAX form submission with spinner loading & error handling
            const reservationForm = document.getElementById('reservation-form');
            if (reservationForm) {
                reservationForm.addEventListener('submit', async (e) => {
                    e.preventDefault();

                    const originalBtnContent = submitBtn.innerHTML;
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = `
                        <svg class="animate-spin h-4 w-4 text-white inline-block mr-1.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Processing...
                    `;

                    try {
                        const formData = new FormData(reservationForm);
                        const response = await fetch(reservationForm.action, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]')?.value || ''
                            }
                        });

                        const result = await response.json();

                        if (response.ok && result.success) {
                            submitBtn.className = 'px-6 py-2.5 bg-emerald-600 text-white font-bold text-sm rounded-xl flex items-center gap-2 shadow-md';
                            submitBtn.innerHTML = `
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                                Reserved Successfully!
                            `;
                            setTimeout(() => {
                                window.location.href = result.redirect_url || "{{ route('student.reservations.index') }}";
                            }, 500);
                        } else {
                            const errorMsg = result.message || 'Validation failed. Please check your inputs.';
                            showErrorAlert(errorMsg);
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = originalBtnContent;
                        }
                    } catch (err) {
                        console.error('Reservation error:', err);
                        showErrorAlert('Network error occurred. Please check your connection and try again.');
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalBtnContent;
                    }
                });
            }

            const showErrorAlert = (msg) => {
                statusAlertBox.className = 'border rounded-2xl p-4 text-xs font-semibold flex gap-3 shadow-xs transition-colors bg-red-50 border-red-100 text-red-700';
                statusIconWrapper.className = 'shrink-0 text-red-600';
                statusIconWrapper.innerHTML = `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>`;
                statusTitle.textContent = 'Reservation Failed';
                statusDesc.textContent = msg;
                statusAlertBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
            };

            // Initial render
            renderCalendar();
            updateAlertStatus(selectedDateStr, true);
        });
    </script>
    @endpush
</x-layout.student>
