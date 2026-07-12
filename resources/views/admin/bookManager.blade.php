<x-layout.admin>

<!-- Main Dashboard Content -->
    <div class="flex-1 flex flex-col min-h-0 h-full p-6 bg-gray-50/50">
        <x-admin.page-header 
            title="Book Management" 
            description="Manage the library's entire catalog of books and resources."
            :breadcrumbs="[
                ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
                ['label' => 'Books']
            ]"
        >
            <x-slot:actions>
                <x-admin.button href="{{ route('admin.books.create') }}" variant="primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Add New Book
                </x-admin.button>
            </x-slot:actions>
        </x-admin.page-header>

        @if(session('success'))
            <x-admin.alert type="success" message="{{ session('success') }}" class="mb-6" />
        @endif
        @if(session('error'))
            <x-admin.alert type="error" message="{{ session('error') }}" class="mb-6" />
        @endif

        <!-- Filters & Search -->
        <x-admin.partials.mainTable :allBooks="$allBooks" :categories="$categories ?? []" :publishers="$publishers ?? []" />

    </div>
</x-layout.admin>