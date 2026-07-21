<div class="flex flex-col sm:flex-row justify-between sm:items-start gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-[#102b70]">{{ $user->first_name }} {{ $user->last_name }}</h1>
        <p class="text-sm text-gray-500 mt-1">{{ ucfirst($type) }} Profile</p>
    </div>
    <div class="flex items-center gap-2">
        <a href="{{ $type === 'member' ? route('admin.members.edit', $user->member_id) : route('admin.librarians.edit', $user->librarian_id) }}" class="btn btn-primary btn-sm">
            Edit {{ ucfirst($type) }}
        </a>
        <form action="{{ $type === 'member' ? route('admin.members.destroy', $user->member_id) : route('admin.librarians.destroy', $user->librarian_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete or deactivate this {{ $type }}?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-error btn-outline btn-sm bg-white mr-10">Delete</button>
        </form>
    </div>
</div>

@if(session('success'))
    <x-alert type="success" message="{{ session('success') }}" class="mb-6" />
@endif
@if(session('error'))
    <x-alert type="error" message="{{ session('error') }}" class="mb-6" />
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Left Column: Profile Info -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Profile Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                <h2 class="text-lg font-bold text-[#102b70]">Profile Information</h2>
                <x-admin.users.type-badge :type="ucfirst($type)" />
            </div>
            <div class="p-6">
                <div class="flex flex-col sm:flex-row gap-6 items-start">
                    <div class="avatar placeholder">
                        <div class="bg-indigo-100 text-[#102b70] rounded-full w-24 h-24 flex items-center justify-center">
                            <span class="font-bold text-3xl">{{ substr($user->first_name, 0, 1) }}{{ substr($user->last_name, 0, 1) }}</span>
                        </div>
                    </div>
                    
                    <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-8">
                        <div>
                            <p class="text-sm text-gray-500 font-medium">Full Name</p>
                            <p class="text-base font-semibold text-gray-800">{{ $user->first_name }} {{ $user->middle_name }} {{ $user->last_name }}</p>
                        </div>
                        
                        @if($type === 'member')
                            <div>
                                <p class="text-sm text-gray-500 font-medium">Student ID Number</p>
                                <p class="text-base text-gray-800">{{ $user->student_id_number }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 font-medium">Program / Year</p>
                                <p class="text-base text-gray-800">{{ $user->program ?? 'N/A' }} {{ $user->year_level ? ' - ' . $user->year_level : '' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 font-medium">Contact Number</p>
                                <p class="text-base text-gray-800">{{ $user->contact_num ?? 'N/A' }}</p>
                            </div>
                        @else
                            <div>
                                <p class="text-sm text-gray-500 font-medium">Employee Number</p>
                                <p class="text-base text-gray-800">{{ $user->employee_number }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 font-medium">Position</p>
                                <p class="text-base text-gray-800">{{ $user->position ?? 'N/A' }}</p>
                            </div>
                        @endif
                        
                        <div class="md:col-span-2">
                            <p class="text-sm text-gray-500 font-medium">Email Address</p>
                            <p class="text-base text-gray-800">{{ $user->email ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats (For Members) -->
        @if($type === 'member')
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center text-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Borrows</p>
                        <h3 class="text-2xl font-bold text-[#102b70]">{{ $user->book_borrows_count ?? 0 }}</h3>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-orange-50 flex items-center justify-center text-orange-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Book Requests</p>
                        <h3 class="text-2xl font-bold text-[#102b70]">{{ $user->book_requests_count ?? 0 }}</h3>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Right Column: Account Info -->
    <div class="space-y-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                <h2 class="text-lg font-bold text-[#102b70]">System Account</h2>
            </div>
            
            @if($user->memberAuth)
                <div class="p-6 space-y-4 border-b border-gray-100">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500 font-medium">Status</span>
                        <x-admin.users.status-badge :status="$user->memberAuth->account_status" />
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500 font-medium">Role</span>
                        <span class="text-sm font-medium text-gray-800">{{ $user->memberAuth->account_type }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500 font-medium">Username</span>
                        <span class="text-sm font-medium text-gray-800">{{ $user->memberAuth->username }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500 font-medium">Last Login</span>
                        <span class="text-sm text-gray-800">
                            {{ $user->memberAuth->last_login_at ? \Carbon\Carbon::parse($user->memberAuth->last_login_at)->format('M d, Y h:i A') : 'Never' }}
                        </span>
                    </div>
                    @if($user->memberAuth->failed_attempts > 0)
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500 font-medium">Failed Attempts</span>
                            <span class="text-sm font-medium text-red-600">{{ $user->memberAuth->failed_attempts }}</span>
                        </div>
                    @endif
                </div>
                
                <div class="p-6 bg-gray-50/50 flex flex-col gap-3">
                    @if($user->memberAuth->account_status === 'Locked')
                        <form action="{{ route('admin.accounts.unlock', $user->memberAuth->member_auth_id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-warning btn-sm w-full">Unlock Account</button>
                        </form>
                    @endif
                    
                    <form action="{{ route('admin.accounts.status', $user->memberAuth->member_auth_id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        @if(in_array($user->memberAuth->account_status, ['Active']))
                            <input type="hidden" name="account_status" value="Suspended">
                            <button type="submit" class="btn btn-error btn-outline btn-sm w-full bg-white">Suspend Account</button>
                        @else
                            <input type="hidden" name="account_status" value="Active">
                            <button type="submit" class="btn btn-success btn-outline btn-sm w-full bg-white">Activate Account</button>
                        @endif
                    </form>
                </div>
            @else
                <div class="p-8 text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 text-gray-400 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-1">No Account Setup</h3>
                    <p class="text-sm text-gray-500 mb-6">This {{ $type }} does not have a login account yet.</p>
                    <a href="{{ $type === 'member' ? route('admin.members.edit', $user->member_id) : route('admin.librarians.edit', $user->librarian_id) }}" class="btn btn-primary btn-sm">
                        Create Account
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
