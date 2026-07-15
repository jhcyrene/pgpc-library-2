<x-layout.admin title="Reservation Details">
    <div class="flex-1 flex flex-col min-h-0 h-full p-6 bg-gray-50/50 overflow-y-auto">
        <x-admin.page-header 
            title="Reservation Details" 
            description="View and manage the status of this reservation."
            :breadcrumbs="[
                [
                    'label' => 'Dashboard',
                    'url' => strtolower((string) auth('member')->user()?->account_type) === 'librarian'
                        ? route('librarian.dashboard')
                        : route('admin.dashboard'),
                ],
                ['label' => 'Reservations', 'url' => route('admin.reservations.index')],
                ['label' => 'Reservation #' . $reservation->book_request_id]
            ]"
        />

        @if(session('success'))
            <x-alert type="success" message="{{ session('success') }}" class="mb-6" />
        @endif
        @if(session('error'))
            <x-alert type="error" message="{{ session('error') }}" class="mb-6" />
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Details Column -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Book Info -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden p-6">
                    <h3 class="text-lg font-bold text-gray-800 border-b border-gray-100 pb-4 mb-4">Book Information</h3>
                    <div class="flex flex-col md:flex-row gap-6">
                        @if($reservation->bookData->bookDetail && $reservation->bookData->bookDetail->image_url)
                            <div class="w-32 h-44 shrink-0 bg-gray-100 rounded-lg overflow-hidden border border-gray-200 shadow-sm">
                                <img src="{{ asset('storage/' . $reservation->bookData->bookDetail->image_url) }}" alt="Book Cover" class="w-full h-full object-cover">
                            </div>
                        @elseif($reservation->bookData->bookDetail && $reservation->bookData->bookDetail->cover_image)
                            <div class="w-32 h-44 shrink-0 bg-gray-100 rounded-lg overflow-hidden border border-gray-200 shadow-sm">
                                <img src="{{ str_starts_with($reservation->bookData->bookDetail->cover_image, 'data:image') ? $reservation->bookData->bookDetail->cover_image : asset('storage/' . ltrim($reservation->bookData->bookDetail->cover_image, '/')) }}" alt="Book Cover" class="w-full h-full object-cover">
                            </div>
                        @else
                            <div class="w-32 h-44 shrink-0 bg-gray-100 rounded-lg border border-gray-200 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif
                        
                        <div class="flex-1 space-y-3">
                            <h4 class="text-xl font-bold text-gray-900 leading-tight">{{ $reservation->bookData->book_title }}</h4>
                            <p class="text-sm text-gray-600">
                                <span class="font-semibold text-gray-700">Author(s):</span> 
                                @if($reservation->bookData->authors->isNotEmpty())
                                    {{ $reservation->bookData->authors->pluck('author_name')->join(', ') }}
                                @else
                                    Unknown Author
                                @endif
                            </p>
                            
                            @if($reservation->bookData->bookDetail)
                                <div class="grid grid-cols-2 gap-4 text-sm mt-4 p-4 bg-gray-50 rounded-xl">
                                    <div>
                                        <span class="block text-gray-500 mb-1">ISBN</span>
                                        <span class="font-medium text-gray-800">{{ $reservation->bookData->bookDetail->isbn ?? 'N/A' }}</span>
                                    </div>
                                    <div>
                                        <span class="block text-gray-500 mb-1">Publisher</span>
                                        <span class="font-medium text-gray-800">{{ $reservation->bookData->bookDetail->publisher->publisher_name ?? 'N/A' }}</span>
                                    </div>
                                </div>
                            @endif
                            
                            @if($reservation->book)
                                <div class="mt-4 p-4 border border-info/20 bg-info/5 rounded-xl flex items-center gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-info" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                    </svg>
                                    <div>
                                        <span class="text-sm font-bold text-info">Assigned Copy</span>
                                        <div class="text-xs text-info/80">Copy ID: {{ $reservation->book->book_id }}</div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Member Info -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden p-6">
                    <h3 class="text-lg font-bold text-gray-800 border-b border-gray-100 pb-4 mb-4">Student Information</h3>
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 rounded-full bg-primary/10 text-primary flex items-center justify-center text-2xl font-bold">
                            {{ substr($reservation->member->first_name, 0, 1) }}
                        </div>
                        <div>
                            <div class="text-xl font-bold text-gray-900">{{ $reservation->member->first_name }} {{ $reservation->member->last_name }}</div>
                            <div class="text-gray-500">Student Number: <span class="font-medium text-gray-700">{{ $reservation->member->student_number }}</span></div>
                            <div class="text-gray-500">Email: <span class="font-medium text-gray-700">{{ $reservation->member->email ?? 'N/A' }}</span></div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Action Column -->
            <div class="space-y-6">
                <!-- Status Card Container -->
                <div id="status-card-container">
                    @include('admin.reservations.partials.status-card')
                </div>
            </div>

        </div>
    </div>

    <!-- Alert Container for AJAX -->
    <div id="ajax-alert-container" class="fixed top-6 right-6 z-50 flex flex-col gap-2"></div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            
            function showAlert(message, type = 'success') {
                const container = document.getElementById('ajax-alert-container');
                const alertDiv = document.createElement('div');
                alertDiv.className = `p-4 rounded-lg shadow-lg border text-sm font-medium flex items-center gap-3 transition-opacity duration-300 ${
                    type === 'success' 
                        ? 'bg-success/10 border-success text-success' 
                        : 'bg-error/10 border-error text-error'
                }`;
                alertDiv.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        ${type === 'success' 
                            ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />'
                            : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />'
                        }
                    </svg>
                    <span>${message}</span>
                `;
                container.appendChild(alertDiv);
                
                setTimeout(() => {
                    alertDiv.style.opacity = '0';
                    setTimeout(() => alertDiv.remove(), 300);
                }, 4000);
            }

            document.addEventListener('submit', async function(e) {
                if (e.target && e.target.classList.contains('ajax-form')) {
                    e.preventDefault();
                    
                    const form = e.target;
                    const confirmMsg = form.getAttribute('data-confirm');
                    if (confirmMsg && !confirm(confirmMsg)) {
                        return;
                    }

                    const loader = document.getElementById('status-card-loader');
                    if (loader) loader.classList.remove('hidden');

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
                            if (result.html) {
                                document.getElementById('status-card-container').innerHTML = result.html;
                            }
                            showAlert(result.message || 'Updated successfully', 'success');
                        } else {
                            showAlert(result.message || 'An error occurred', 'error');
                        }
                    } catch (error) {
                        showAlert('A network error occurred.', 'error');
                    } finally {
                        const newLoader = document.getElementById('status-card-loader');
                        if (newLoader) newLoader.classList.add('hidden');
                    }
                }
            });
        });
    </script>
</x-layout.admin>
