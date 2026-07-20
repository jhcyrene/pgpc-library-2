<x-layout.admin>
    <div class="flex flex-col h-auto lg:h-[calc(100dvh-6.5rem)]">
        <div class="flex-none mt-4 mb-2">
            <x-admin.page-header 
                title="User Management" 
                description="Manage members, librarians, and login accounts.">
                <x-slot:actions>
                    <div class="flex items-center gap-2 mt-1">
                        <button onclick="addMemberModal.showModal()" class="btn btn-primary btn-sm flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>
                            Add Member
                        </button>
                        <button onclick="addLibrarianModal.showModal()" class="btn btn-outline btn-primary btn-sm bg-white flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                            Add Librarian
                        </button>
                    </div>
                </x-slot:actions>
            </x-admin.page-header>
        </div>

        @if(session('success'))
            <x-alert type="success" message="{{ session('success') }}" class="mb-6 flex-none" />
        @endif

        <!-- Summary Cards -->
        <div class="flex-none grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Members</p>
                    <h3 class="text-2xl font-bold text-[#102b70] mt-1">{{ number_format($totalMembers) }}</h3>
                </div>
                <div class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Librarians</p>
                    <h3 class="text-2xl font-bold text-[#102b70] mt-1">{{ number_format($totalLibrarians) }}</h3>
                </div>
                <div class="w-12 h-12 rounded-full bg-purple-50 flex items-center justify-center text-purple-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Active Accounts</p>
                    <h3 class="text-2xl font-bold text-green-600 mt-1">{{ number_format($activeAccounts) }}</h3>
                </div>
                <div class="w-12 h-12 rounded-full bg-green-50 flex items-center justify-center text-green-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Locked/Suspended</p>
                    <h3 class="text-2xl font-bold text-red-600 mt-1">{{ number_format($lockedAccounts) }}</h3>
                </div>
                <div class="w-12 h-12 rounded-full bg-red-50 flex items-center justify-center text-red-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                </div>
            </div>
        </div>

        <!-- Filters and Table Card -->
        <div class="flex-1 flex flex-col min-h-0 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <!-- Toolbar -->
            <div class="flex-none p-4 border-b border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
                
                <!-- Tabs -->
                <div class="flex gap-2">
                    <a href="{{ route('admin.users.index', array_merge(request()->query(), ['type' => 'all'])) }}" class="px-3 py-1.5 text-sm font-medium rounded-md transition-colors {{ $type === 'all' ? 'bg-[#102b70] text-white' : 'text-gray-600 hover:bg-gray-100' }}">All Users</a>
                    <a href="{{ route('admin.users.index', array_merge(request()->query(), ['type' => 'member'])) }}" class="px-3 py-1.5 text-sm font-medium rounded-md transition-colors {{ $type === 'member' ? 'bg-[#102b70] text-white' : 'text-gray-600 hover:bg-gray-100' }}">Members</a>
                    <a href="{{ route('admin.users.index', array_merge(request()->query(), ['type' => 'librarian'])) }}" class="px-3 py-1.5 text-sm font-medium rounded-md transition-colors {{ $type === 'librarian' ? 'bg-[#102b70] text-white' : 'text-gray-600 hover:bg-gray-100' }}">Librarians</a>
                </div>

                <!-- Search -->
                <form method="GET" action="{{ route('admin.users.index') }}" class="flex gap-2 w-full md:w-auto">
                    <input type="hidden" name="type" value="{{ $type }}">
                    <div class="relative flex-1 md:w-64">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ $search }}" placeholder="Search users..." class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-1 focus:ring-[#102b70] focus:border-[#102b70]">
                    </div>
                    <x-admin.button type="submit" variant="primary" size="md">Search</x-admin.button>
                    @if($search)
                        <x-admin.button variant="ghost" size="md" href="{{ route('admin.users.index', ['type' => $type]) }}">Clear</x-admin.button>
                    @endif
                </form>
            </div>

            <div class="flex-1 flex flex-col min-h-0 overflow-y-auto">
                @include('admin.users.partials.table', ['users' => $users])
            </div>
        </div>
    </div>

    <!-- AJAX Loading JS -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const container = document.querySelector('.bg-white.rounded-xl.shadow-sm.border.border-gray-100.overflow-hidden');
            const searchForm = container.querySelector('form');
            const typeLinks = container.querySelectorAll('a[href*="type="]');

            // Generic fetch and replace function
            const loadPage = (url) => {
                const tableContainer = document.getElementById('users-table-container');
                
                if (tableContainer) {
                    tableContainer.style.position = 'relative';
                    
                    // Create overlay if it doesn't exist
                    let overlay = document.getElementById('table-loading-overlay');
                    if (!overlay) {
                        overlay = document.createElement('div');
                        overlay.id = 'table-loading-overlay';
                        overlay.className = 'absolute inset-0 z-50 flex items-center justify-center';
                        // Semi-transparent background behind the spinner helps visibility
                        overlay.innerHTML = '<div class="absolute inset-0 bg-white/30"></div><span class="loading loading-spinner loading-lg text-primary relative z-10"></span>';
                        tableContainer.appendChild(overlay);
                    }
                    
                    // Blur the actual table content
                    Array.from(tableContainer.children).forEach(child => {
                        if (child.id !== 'table-loading-overlay') {
                            child.style.filter = 'blur(4px)';
                            child.style.transition = 'filter 0.2s';
                        }
                    });
                    
                    tableContainer.style.pointerEvents = 'none';
                }

                const controller = new AbortController();
                const timeoutId = setTimeout(() => controller.abort(), 10000); // 10 second timeout

                fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'text/html'
                    },
                    signal: controller.signal
                })
                .then(response => {
                    clearTimeout(timeoutId);
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.text();
                })
                .then(html => {
                    if (tableContainer) {
                        tableContainer.outerHTML = html;
                    }
                    // Update URL without reloading
                    window.history.pushState(null, '', url);
                })
                .catch(error => {
                    console.error('Error loading data:', error);
                    if (tableContainer) {
                        tableContainer.style.pointerEvents = 'auto';
                        tableContainer.innerHTML = '<div class="p-8 text-center text-red-500 font-bold mt-4">Failed to load data. Please refresh the page.</div>';
                    }
                });
            };

            // Intercept Pagination Clicks
            container.addEventListener('click', function(e) {
                const paginationLink = e.target.closest('.ajax-pagination-wrapper a');
                if (paginationLink) {
                    e.preventDefault();
                    loadPage(paginationLink.href);
                }

                // Intercept Type Tab Clicks
                const typeLink = e.target.closest('a[href*="type="]');
                if (typeLink && typeLink.parentElement.classList.contains('flex') && typeLink.parentElement.classList.contains('gap-2')) {
                    e.preventDefault();
                    
                    // Update active tab styling
                    typeLinks.forEach(link => {
                        link.classList.remove('bg-[#102b70]', 'text-white');
                        link.classList.add('text-gray-600', 'hover:bg-gray-100');
                    });
                    typeLink.classList.remove('text-gray-600', 'hover:bg-gray-100');
                    typeLink.classList.add('bg-[#102b70]', 'text-white');

                    // Update hidden type input in form
                    const url = new URL(typeLink.href);
                    const type = url.searchParams.get('type');
                    const hiddenInput = searchForm.querySelector('input[name="type"]');
                    if (hiddenInput) hiddenInput.value = type;

                    loadPage(typeLink.href);
                }
            });

            // Intercept Search Form Submission
            if (searchForm) {
                searchForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const formData = new FormData(searchForm);
                    const params = new URLSearchParams(formData);
                    const url = `${searchForm.action}?${params.toString()}`;
                    loadPage(url);
                });
            }

            // Handle browser back/forward buttons
            window.addEventListener('popstate', function() {
                loadPage(window.location.href);
            });

            // Intercept View User Clicks
            container.addEventListener('click', function(e) {
                const viewBtn = e.target.closest('.view-user-btn');
                if (viewBtn) {
                    e.preventDefault();
                    window.openDetailModal(viewBtn.href, 'viewUserModal');
                }
            });
        });
    </script>

    <!-- View User Modal -->
    <dialog id="viewUserModal" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box w-[calc(100%-1rem)] max-w-none max-h-[calc(100dvh-1rem)] overflow-y-auto sm:w-11/12 sm:max-w-5xl bg-gray-50 p-0 rounded-2xl">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-4 top-4 z-20 text-gray-500 hover:bg-gray-100 bg-white shadow-sm border border-gray-100">✕</button>
            </form>
            <div id="viewUserModalContent" class="p-6 sm:p-8 transition-opacity duration-300">
                <!-- AJAX Content goes here -->
            </div>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>

    <!-- Add Member Modal -->
    <dialog id="addMemberModal" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box w-[calc(100%-1rem)] max-w-none max-h-[calc(100dvh-1rem)] overflow-y-auto sm:w-11/12 sm:max-w-2xl bg-white p-6 rounded-2xl relative">
            <h3 class="font-extrabold text-xl text-[#102b70] mb-4 sm:mb-6">Add Member</h3>
            <button class="btn btn-sm btn-circle btn-ghost absolute right-4 top-4 text-gray-500 hover:bg-gray-100" onclick="addMemberModal.close()">✕</button>

            <!-- Wizard Step Indicators (Mobile Only) -->
            <div class="sm:hidden flex items-center justify-center gap-6 mb-6 pb-4 border-b border-slate-100" id="member-wizard-header">
                <div class="flex items-center gap-2" id="member-step1-indicator">
                    <span class="step-num w-6 h-6 rounded-full flex items-center justify-center bg-[#102b70] text-white text-xs font-bold">1</span>
                    <span class="step-label text-xs font-bold text-slate-800">Profile</span>
                </div>
                <div class="w-10 h-[2px] bg-slate-200" id="member-step-divider"></div>
                <div class="flex items-center gap-2" id="member-step2-indicator">
                    <span class="step-num w-6 h-6 rounded-full flex items-center justify-center bg-slate-100 text-slate-400 text-xs font-bold">2</span>
                    <span class="step-label text-xs font-bold text-slate-400">Account</span>
                </div>
            </div>

            <form action="{{ route('admin.members.store') }}" method="POST" id="addMemberForm">
                @csrf
                <input type="hidden" name="user_type" value="member">
                
                @if($errors->any() && old('user_type') === 'member')
                    <div class="alert alert-error mb-6 rounded-xl p-4 text-sm text-red-700 bg-red-50 border border-red-200">
                        <ul class="list-disc pl-5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Step 1: Profile Section -->
                <div id="member-profile-section" class="space-y-6">
                    <div class="flex items-start gap-3 border-b border-slate-100 pb-3">
                        <div class="w-9 h-9 rounded-xl bg-blue-50 flex items-center justify-center text-[#102b70] shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM4 21a8 8 0 0116 0" /></svg>
                        </div>
                        <div>
                            <h2 class="text-base font-bold text-slate-800">Profile Information</h2>
                            <p class="text-xs text-slate-400">Basic details about the member.</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <x-admin.users.user-form type="member" />
                    </div>
                </div>

                <!-- Step 2: Account Setup Section -->
                <div id="member-account-section" class="space-y-6 mt-6 sm:mt-8">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                        <div class="flex items-start gap-3">
                            <div class="w-9 h-9 rounded-xl bg-blue-50 flex items-center justify-center text-[#102b70] shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                            </div>
                            <div>
                                <h2 class="text-base font-bold text-slate-800">Account Setup</h2>
                                <p class="text-xs text-slate-400">Create login credentials for system access.</p>
                            </div>
                        </div>
                        <label class="flex items-center cursor-pointer">
                            <span class="mr-3 font-semibold text-sm text-slate-700">Create Account</span> 
                            <input type="checkbox" name="create_account" value="1" class="toggle toggle-primary toggle-sm member-account-toggle" {{ old('create_account') && old('user_type') === 'member' ? 'checked' : '' }} onchange="document.getElementById('memberAccountFieldsContainer').style.display = this.checked ? 'block' : 'none'" />
                        </label>
                    </div>

                    <!-- Setup Helper Banner -->
                    <div class="bg-blue-50/70 border border-blue-100 rounded-xl p-4 flex gap-3 text-xs text-blue-700 font-semibold mb-6">
                        <svg class="w-4 h-4 shrink-0 mt-0.5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span>Account credentials will be created for this member when the toggle is enabled. You can always create or update the account later.</span>
                    </div>

                    <div id="memberAccountFieldsContainer" style="display: {{ old('create_account') && old('user_type') === 'member' ? 'block' : 'none' }}" class="space-y-4">
                        <x-admin.users.account-form type="member" />
                        
                        <div class="bg-blue-50/70 border border-blue-100 rounded-xl p-4 flex gap-3 text-xs text-blue-700 font-semibold mt-4">
                            <svg class="w-4 h-4 shrink-0 mt-0.5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            <span>The member will be able to log in using the username and password above.</span>
                        </div>
                    </div>
                </div>
                
                <!-- Desktop Action Buttons (Hidden on Mobile) -->
                <div class="hidden sm:flex justify-end gap-3 mt-8 border-t border-slate-100 pt-5">
                    <button type="button" class="px-5 py-2.5 rounded-xl border border-slate-200 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition-colors" onclick="addMemberModal.close()">Cancel</button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#102b70] hover:bg-[#0b225e] text-white text-sm font-semibold shadow-sm transition-colors">Save Member</button>
                </div>

                <!-- Mobile Action Buttons Footer (Step 1) -->
                <div class="flex sm:hidden justify-between gap-3 mt-8 border-t border-slate-100 pt-5" id="member-mobile-footer-step1">
                    <button type="button" class="w-1/2 py-2.5 rounded-xl border border-slate-200 text-sm font-semibold text-slate-600 hover:bg-slate-50 text-center" onclick="addMemberModal.close()">Cancel</button>
                    <button type="button" class="w-1/2 py-2.5 rounded-xl bg-[#102b70] hover:bg-[#0b225e] text-white text-sm font-semibold text-center" id="member-next-btn">Next</button>
                </div>

                <!-- Mobile Action Buttons Footer (Step 2) -->
                <div class="hidden sm:hidden justify-between gap-3 mt-8 border-t border-slate-100 pt-5" id="member-mobile-footer-step2">
                    <button type="button" class="w-1/2 py-2.5 rounded-xl border border-slate-200 text-sm font-semibold text-slate-600 hover:bg-slate-50 text-center" id="member-back-btn">Back</button>
                    <button type="submit" class="w-1/2 py-2.5 rounded-xl bg-[#102b70] hover:bg-[#0b225e] text-white text-sm font-semibold text-center">Save Member</button>
                </div>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>

    <!-- Add Librarian Modal -->
    <dialog id="addLibrarianModal" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box w-[calc(100%-1rem)] max-w-none max-h-[calc(100dvh-1rem)] overflow-y-auto sm:w-11/12 sm:max-w-2xl bg-white p-6 rounded-2xl relative">
            <h3 class="font-extrabold text-xl text-[#102b70] mb-4 sm:mb-6">Add Librarian</h3>
            <button class="btn btn-sm btn-circle btn-ghost absolute right-4 top-4 text-gray-500 hover:bg-gray-100" onclick="addLibrarianModal.close()">✕</button>

            <!-- Wizard Step Indicators (Mobile Only) -->
            <div class="sm:hidden flex items-center justify-center gap-6 mb-6 pb-4 border-b border-slate-100" id="librarian-wizard-header">
                <div class="flex items-center gap-2" id="librarian-step1-indicator">
                    <span class="step-num w-6 h-6 rounded-full flex items-center justify-center bg-[#102b70] text-white text-xs font-bold">1</span>
                    <span class="step-label text-xs font-bold text-slate-800">Profile</span>
                </div>
                <div class="w-10 h-[2px] bg-slate-200" id="librarian-step-divider"></div>
                <div class="flex items-center gap-2" id="librarian-step2-indicator">
                    <span class="step-num w-6 h-6 rounded-full flex items-center justify-center bg-slate-100 text-slate-400 text-xs font-bold">2</span>
                    <span class="step-label text-xs font-bold text-slate-400">Account</span>
                </div>
            </div>

            <form action="{{ route('admin.librarians.store') }}" method="POST" id="addLibrarianForm">
                @csrf
                <input type="hidden" name="user_type" value="librarian">
                
                @if($errors->any() && old('user_type') === 'librarian')
                    <div class="alert alert-error mb-6 rounded-xl p-4 text-sm text-red-700 bg-red-50 border border-red-200">
                        <ul class="list-disc pl-5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Step 1: Profile Section -->
                <div id="librarian-profile-section" class="space-y-6">
                    <div class="flex items-start gap-3 border-b border-slate-100 pb-3">
                        <div class="w-9 h-9 rounded-xl bg-blue-50 flex items-center justify-center text-[#102b70] shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM4 21a8 8 0 0116 0" /></svg>
                        </div>
                        <div>
                            <h2 class="text-base font-bold text-slate-800">Profile Information</h2>
                            <p class="text-xs text-slate-400">Basic details about the librarian.</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <x-admin.users.user-form type="librarian" />
                    </div>
                </div>

                <!-- Step 2: Account Setup Section -->
                <div id="librarian-account-section" class="space-y-6 mt-6 sm:mt-8">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                        <div class="flex items-start gap-3">
                            <div class="w-9 h-9 rounded-xl bg-blue-50 flex items-center justify-center text-[#102b70] shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                            </div>
                            <div>
                                <h2 class="text-base font-bold text-slate-800">Account Setup</h2>
                                <p class="text-xs text-slate-400">Create login credentials for system access.</p>
                            </div>
                        </div>
                        <label class="flex items-center cursor-pointer">
                            <span class="mr-3 font-semibold text-sm text-slate-700">Create Account</span> 
                            <input type="checkbox" name="create_account" value="1" class="toggle toggle-primary toggle-sm librarian-account-toggle" {{ old('create_account') && old('user_type') === 'librarian' ? 'checked' : '' }} onchange="document.getElementById('librarianAccountFieldsContainer').style.display = this.checked ? 'block' : 'none'" />
                        </label>
                    </div>

                    <!-- Setup Helper Banner -->
                    <div class="bg-blue-50/70 border border-blue-100 rounded-xl p-4 flex gap-3 text-xs text-blue-700 font-semibold mb-6">
                        <svg class="w-4 h-4 shrink-0 mt-0.5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span>Account credentials will be created for this member when the toggle is enabled. You can always create or update the account later.</span>
                    </div>

                    <div id="librarianAccountFieldsContainer" style="display: {{ old('create_account') && old('user_type') === 'librarian' ? 'block' : 'none' }}" class="space-y-4">
                        <x-admin.users.account-form type="librarian" />
                        
                        <div class="bg-blue-50/70 border border-blue-100 rounded-xl p-4 flex gap-3 text-xs text-blue-700 font-semibold mt-4">
                            <svg class="w-4 h-4 shrink-0 mt-0.5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            <span>The librarian will be able to log in using the username and password above.</span>
                        </div>
                    </div>
                </div>
                
                <!-- Desktop Action Buttons (Hidden on Mobile) -->
                <div class="hidden sm:flex justify-end gap-3 mt-8 border-t border-slate-100 pt-5">
                    <button type="button" class="px-5 py-2.5 rounded-xl border border-slate-200 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition-colors" onclick="addLibrarianModal.close()">Cancel</button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#102b70] hover:bg-[#0b225e] text-white text-sm font-semibold shadow-sm transition-colors">Save Librarian</button>
                </div>

                <!-- Mobile Action Buttons Footer (Step 1) -->
                <div class="flex sm:hidden justify-between gap-3 mt-8 border-t border-slate-100 pt-5" id="librarian-mobile-footer-step1">
                    <button type="button" class="w-1/2 py-2.5 rounded-xl border border-slate-200 text-sm font-semibold text-slate-600 hover:bg-slate-50 text-center" onclick="addLibrarianModal.close()">Cancel</button>
                    <button type="button" class="w-1/2 py-2.5 rounded-xl bg-[#102b70] hover:bg-[#0b225e] text-white text-sm font-semibold text-center" id="librarian-next-btn">Next</button>
                </div>

                <!-- Mobile Action Buttons Footer (Step 2) -->
                <div class="hidden sm:hidden justify-between gap-3 mt-8 border-t border-slate-100 pt-5" id="librarian-mobile-footer-step2">
                    <button type="button" class="w-1/2 py-2.5 rounded-xl border border-slate-200 text-sm font-semibold text-slate-600 hover:bg-slate-50 text-center" id="librarian-back-btn">Back</button>
                    <button type="submit" class="w-1/2 py-2.5 rounded-xl bg-[#102b70] hover:bg-[#0b225e] text-white text-sm font-semibold text-center">Save Librarian</button>
                </div>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Reopen modals if there are validation errors
            @if($errors->any())
                @if(old('user_type') === 'member')
                    addMemberModal.showModal();
                @elseif(old('user_type') === 'librarian')
                    addLibrarianModal.showModal();
                @endif
            @endif

            // Wizard Step Navigation Logic (Responsive)
            function initWizard(modalId, prefix) {
                const modal = document.getElementById(modalId);
                if (!modal) return;

                let currentStep = 1;

                const step1Indicator = document.getElementById(`${prefix}-step1-indicator`);
                const step2Indicator = document.getElementById(`${prefix}-step2-indicator`);

                const profileSection = document.getElementById(`${prefix}-profile-section`);
                const accountSection = document.getElementById(`${prefix}-account-section`);

                const mobileFooterStep1 = document.getElementById(`${prefix}-mobile-footer-step1`);
                const mobileFooterStep2 = document.getElementById(`${prefix}-mobile-footer-step2`);
                
                const nextBtn = document.getElementById(`${prefix}-next-btn`);
                const backBtn = document.getElementById(`${prefix}-back-btn`);

                function updateWizardUI() {
                    if (window.innerWidth < 640) {
                        if (currentStep === 1) {
                            profileSection.style.display = 'block';
                            accountSection.style.display = 'none';
                            
                            mobileFooterStep1.style.display = 'flex';
                            mobileFooterStep2.style.display = 'none';

                            step1Indicator.querySelector('.step-num').className = 'step-num w-6 h-6 rounded-full flex items-center justify-center bg-[#102b70] text-white text-xs font-bold';
                            step1Indicator.querySelector('.step-label').className = 'step-label text-xs font-bold text-slate-800';

                            step2Indicator.querySelector('.step-num').className = 'step-num w-6 h-6 rounded-full flex items-center justify-center bg-slate-100 text-slate-400 text-xs font-bold';
                            step2Indicator.querySelector('.step-label').className = 'step-label text-xs font-bold text-slate-400';
                        } else {
                            profileSection.style.display = 'none';
                            accountSection.style.display = 'block';

                            mobileFooterStep1.style.display = 'none';
                            mobileFooterStep2.style.display = 'flex';

                            step1Indicator.querySelector('.step-num').className = 'step-num w-6 h-6 rounded-full flex items-center justify-center bg-green-100 text-green-600 text-xs font-bold';
                            step1Indicator.querySelector('.step-label').className = 'step-label text-xs font-bold text-green-600';

                            step2Indicator.querySelector('.step-num').className = 'step-num w-6 h-6 rounded-full flex items-center justify-center bg-[#102b70] text-white text-xs font-bold';
                            step2Indicator.querySelector('.step-label').className = 'step-label text-xs font-bold text-slate-800';
                        }
                    } else {
                        // Desktop View
                        profileSection.style.display = 'block';
                        accountSection.style.display = 'block';
                    }
                }

                if (nextBtn) {
                    nextBtn.addEventListener('click', () => {
                        currentStep = 2;
                        updateWizardUI();
                    });
                }

                if (backBtn) {
                    backBtn.addEventListener('click', () => {
                        currentStep = 1;
                        updateWizardUI();
                    });
                }

                window.addEventListener('resize', updateWizardUI);
                
                modal.addEventListener('close', () => {
                    currentStep = 1;
                    updateWizardUI();
                });
                
                updateWizardUI();
            }

            initWizard('addMemberModal', 'member');
            initWizard('addLibrarianModal', 'librarian');
        });
    </script>
</x-layout.admin>
