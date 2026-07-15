<dialog id="reservation-modal" class="modal modal-bottom sm:modal-middle">
    <div class="modal-box w-11/12 max-w-4xl bg-white p-0 overflow-hidden">
        
        <!-- Header -->
        <div class="bg-gray-50/50 p-4 sm:p-6 border-b border-gray-100 flex justify-between items-center sticky top-0 z-20">
            <h3 class="font-bold text-xl text-gray-800">Reserve Book</h3>
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-4 top-4" onclick="document.getElementById('reservation-modal').remove()">✕</button>
            </form>
        </div>

        <div class="p-4 sm:p-6 max-h-[70vh] overflow-y-auto">
            
            <!-- Book Summary -->
            <div class="flex flex-col sm:flex-row gap-4 mb-6">
                <div class="w-16 h-24 bg-gray-200 rounded shrink-0 overflow-hidden flex items-center justify-center border shadow-sm">
                    @if($bookData->bookDetail && $bookData->bookDetail->image_url)
                        <img src="{{ asset('storage/' . $bookData->bookDetail->image_url) }}" alt="Cover" class="w-full h-full object-cover">
                    @elseif($bookData->bookDetail && $bookData->bookDetail->cover_image)
                        <img src="{{ str_starts_with($bookData->bookDetail->cover_image, 'data:image') ? $bookData->bookDetail->cover_image : asset('storage/' . ltrim($bookData->bookDetail->cover_image, '/')) }}" alt="Cover" class="w-full h-full object-cover">
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    @endif
                </div>
                <div>
                    <h4 class="font-bold text-gray-900 text-lg leading-tight">{{ $bookData->book_title }}</h4>
                    <p class="text-sm text-gray-600">
                        @if($bookData->authors->isNotEmpty())
                            by {{ $bookData->authors->map(fn($a) => trim($a->first_name . ' ' . $a->last_name))->join(', ') }}
                        @else
                            Unknown Author
                        @endif
                    </p>
                </div>
            </div>

            @if(!$eligibility['eligible'])
                <!-- Ineligible -->
                <div class="p-4 rounded-xl bg-error/10 border border-error/20 text-center">
                    <p class="text-error font-medium mb-1">Reservation Not Allowed</p>
                    <p class="text-sm text-error/80">{{ $eligibility['reason'] }}</p>
                </div>
            @else
                <!-- Calendar & Form -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    
                    <!-- Calendar Section -->
                    <div>
                        <h4 class="font-bold text-gray-800 mb-2">1. Select Pickup Date</h4>
                        <p class="text-sm text-gray-500 mb-4">Choose a date from the calendar below.</p>
                        
                        <div class="border border-gray-200 rounded-xl bg-white p-2 text-sm shadow-sm flex justify-center">
                            <input type="text" id="flatpickr-inline" class="hidden">
                        </div>
                    </div>

                    <!-- Form Section -->
                    <div class="flex flex-col">
                        <h4 class="font-bold text-gray-800 mb-2">2. Confirm Details</h4>
                        
                        <form id="reservation-form" action="{{ route('student.reservations.store', $bookData) }}" method="POST" class="flex-1 flex flex-col">
                            @csrf
                            
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Selected Date</label>
                                <input type="text" id="display_pickup_date" class="w-full bg-gray-50 border-gray-200 rounded-lg text-gray-800 focus:ring-0 cursor-not-allowed sm:text-sm" readonly placeholder="Please select a date from the calendar" required>
                                <input type="hidden" id="pickup_date" name="pickup_date" required>
                            </div>

                            <div class="mb-6 flex-1">
                                <label for="remarks" class="block text-sm font-medium text-gray-700 mb-1">Remarks / Notes (Optional)</label>
                                <textarea id="remarks" name="remarks" rows="3" class="w-full bg-white border border-gray-300 rounded-lg shadow-sm text-gray-800 p-3 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all sm:text-sm" placeholder="Any special notes for the librarian..."></textarea>
                            </div>

                            <div class="bg-blue-50 border border-blue-100 rounded-lg p-3 mb-6 text-xs text-blue-800 flex gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p>You will be notified when the book is Ready for Pickup on your selected date.</p>
                            </div>

                            <div class="flex items-center justify-end gap-3">
                                <button type="button" class="btn btn-ghost hover:bg-gray-100" onclick="document.getElementById('reservation-modal').remove()">Cancel</button>
                                <button type="submit" id="btn-confirm-reservation" class="btn btn-primary px-8" disabled>
                                    Confirm Reservation
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            @endif

        </div>
    </div>
</dialog>

<!-- Load Flatpickr -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    (function() {
        const eventsData = {!! json_encode($events ?? []) !!};
        
        // Initialize Flatpickr inline
        const pickerInput = document.getElementById('flatpickr-inline');
        if (pickerInput) {
            flatpickr(pickerInput, {
                inline: true,
                minDate: "today",
                onChange: function(selectedDates, dateStr, instance) {
                    if (selectedDates.length > 0) {
                        const clickedDate = dateStr;
                        
                        document.getElementById('pickup_date').value = clickedDate;
                        document.getElementById('display_pickup_date').value = selectedDates[0].toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
                        document.getElementById('display_pickup_date').classList.remove('border-red-300', 'bg-red-50');
                        document.getElementById('display_pickup_date').classList.add('border-primary', 'bg-blue-50');
                        
                        document.getElementById('btn-confirm-reservation').disabled = false;
                    }
                }
            });
        }

        // Handle Form Submission
        const form = document.getElementById('reservation-form');
        if (form) {
            form.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                const btn = document.getElementById('btn-confirm-reservation');
                const originalText = btn.innerHTML;
                btn.disabled = true;
                btn.innerHTML = '<span class="loading loading-spinner loading-sm"></span> Processing...';
                
                try {
                    const formData = new FormData(form);
                    const response = await fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]')?.value
                        }
                    });

                    const result = await response.json();

                    if (response.ok) {
                        // Success toast
                        showGlobalToast(result.message || 'Reservation placed!', 'success');
                        
                        // Close modal
                        document.getElementById('reservation-modal').remove();
                    } else {
                        showGlobalToast(result.message || 'Validation failed. Please check inputs.', 'error');
                        btn.disabled = false;
                        btn.innerHTML = originalText;
                    }
                } catch (error) {
                    showGlobalToast('Network error occurred.', 'error');
                    btn.disabled = false;
                    btn.innerHTML = originalText;
                }
            });
        }
        
        // Helper function for toast
        function showGlobalToast(message, type = 'success') {
            // Check if toast container exists
            let container = document.getElementById('global-toast-container');
            if (!container) {
                container = document.createElement('div');
                container.id = 'global-toast-container';
                container.className = 'fixed bottom-6 right-6 z-[9999] flex flex-col gap-2';
                document.body.appendChild(container);
            }
            
            const toast = document.createElement('div');
            toast.className = `p-4 rounded-xl shadow-xl border font-medium flex items-center gap-3 transition-all duration-300 transform translate-y-4 opacity-0 ${
                type === 'success' ? 'bg-success/10 border-success text-success-content' : 'bg-error/10 border-error text-error-content'
            }`;
            
            toast.innerHTML = `
                <div class="${type === 'success' ? 'text-success' : 'text-error'}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        ${type === 'success' 
                            ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />'
                            : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />'
                        }
                    </svg>
                </div>
                <span>${message}</span>
            `;
            
            container.appendChild(toast);
            
            // Animate in
            requestAnimationFrame(() => {
                toast.classList.remove('translate-y-4', 'opacity-0');
            });
            
            // Remove after 4s
            setTimeout(() => {
                toast.classList.add('opacity-0', 'translate-x-4');
                setTimeout(() => toast.remove(), 300);
            }, 4000);
        }
    })();
</script>
