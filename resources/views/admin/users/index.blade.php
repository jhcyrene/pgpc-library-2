<x-layout.admin>
    <x-admin.page-header 
        title="User Management" 
        description="Manage members, librarians, and login accounts."
        :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
            ['label' => 'Users']
        ]"
    >
        <x-slot:actions>
            <a href="{{ route('admin.members.create') }}" class="btn btn-primary btn-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>
                Add Member
            </a>
            <a href="{{ route('admin.librarians.create') }}" class="btn btn-outline btn-primary btn-sm bg-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                Add Librarian
            </a>
        </x-slot:actions>
    </x-admin.page-header>

    @if(session('success'))
        <div class="alert alert-success mb-6 rounded-lg shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Members</p>
                <h3 class="text-2xl font-bold text-[#1A2B56] mt-1">{{ number_format($totalMembers) }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center text-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Librarians</p>
                <h3 class="text-2xl font-bold text-[#1A2B56] mt-1">{{ number_format($totalLibrarians) }}</h3>
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
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- Toolbar -->
        <div class="p-4 border-b border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
            
            <!-- Tabs -->
            <div class="flex gap-2">
                <a href="{{ route('admin.users.index', array_merge(request()->query(), ['type' => 'all'])) }}" class="px-3 py-1.5 text-sm font-medium rounded-md transition-colors {{ $type === 'all' ? 'bg-[#1A2B56] text-white' : 'text-gray-600 hover:bg-gray-100' }}">All Users</a>
                <a href="{{ route('admin.users.index', array_merge(request()->query(), ['type' => 'member'])) }}" class="px-3 py-1.5 text-sm font-medium rounded-md transition-colors {{ $type === 'member' ? 'bg-[#1A2B56] text-white' : 'text-gray-600 hover:bg-gray-100' }}">Members</a>
                <a href="{{ route('admin.users.index', array_merge(request()->query(), ['type' => 'librarian'])) }}" class="px-3 py-1.5 text-sm font-medium rounded-md transition-colors {{ $type === 'librarian' ? 'bg-[#1A2B56] text-white' : 'text-gray-600 hover:bg-gray-100' }}">Librarians</a>
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
                    <input type="text" name="search" value="{{ $search }}" placeholder="Search users..." class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-1 focus:ring-[#1A2B56] focus:border-[#1A2B56]">
                </div>
                <button type="submit" class="btn btn-primary btn-sm h-[38px]">Search</button>
                @if($search)
                    <a href="{{ route('admin.users.index', ['type' => $type]) }}" class="btn btn-ghost btn-sm h-[38px]">Clear</a>
                @endif
            </form>
        </div>

        <!-- Table Wrapper -->
        <div class="overflow-x-auto">
            <x-admin.users.user-table :users="$users" />
        </div>
        
        <!-- Pagination -->
        <div class="p-4 border-t border-gray-100">
            {{ $users->links() }}
        </div>
    </div>

</x-layout.admin>
