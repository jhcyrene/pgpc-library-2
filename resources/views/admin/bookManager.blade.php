<x-layout.admin>

<!-- Main Dashboard Content -->
    <div class="flex-1 flex flex-col min-h-0 h-full p-6 bg-gray-50/50">
        <!-- Page Header -->
        <div class="flex items-center justify-between mb-6 shrink-0">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Book Management</h1>
                <p class="text-sm text-gray-500 mt-1 font-medium">Manage the library's entire catalog of books and resources.</p>
            </div>
            <a href="{{ route('admin.books.create') }}"
                class="flex items-center gap-2 bg-[#1A2B56] hover:bg-[#243B73] text-white text-sm font-bold px-4 py-2.5 rounded-lg transition-all shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add New Book
            </a>
        </div>

        @if(session('success'))
            <x-admin.partials.alert type="success" message="{{ session('success') }}" />
        @endif
        @if(session('error'))
            <x-admin.partials.alert type="error" message="{{ session('error') }}" />
        @endif

        <!-- Filters & Search -->
        <x-admin.partials.mainTable :allBooks="$allBooks" :categories="$categories ?? []" :publishers="$publishers ?? []" />

    </div>
</x-layout.admin>