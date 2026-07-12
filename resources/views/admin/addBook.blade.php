<x-layout.admin>
    <!-- Main Dashboard Content -->
    <div class="flex-1 flex flex-col min-h-0 h-full p-6 bg-gray-50/50">
        <!-- Page Header -->
        <div class="flex items-center justify-between mb-6 shrink-0">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Add New Book</h1>
                <p class="text-sm text-gray-500 mt-1 font-medium">Register a new book into the library catalog.</p>
            </div>
            
            <a href="{{ route('admin.bookManager') ?? '#' }}" class="flex items-center gap-2 text-[#1A2B56] bg-white border border-gray-200 hover:bg-gray-50 text-sm font-bold px-4 py-2.5 rounded-lg transition-all shadow-sm">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Catalog
            </a>
        </div>

        <!-- Add Book Form Component -->
        <div class="flex-1 overflow-y-auto">
            <x-admin.addBook />
        </div>
    </div>
</x-layout.admin>
