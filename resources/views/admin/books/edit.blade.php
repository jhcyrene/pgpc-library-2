<x-layout.admin>
    <div class="flex-1 flex flex-col min-h-0 h-full p-6 bg-gray-50/50">
        <div class="flex items-center justify-between mb-6 shrink-0">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Edit Book Details</h1>
                <p class="text-sm text-gray-500 mt-1 font-medium">{{ $bookData->book_title }}</p>
            </div>
        </div>

        <div class="flex-1 overflow-y-auto">
            <x-admin.addBook :categories="$categories ?? []" :publishers="$publishers ?? []" :authors="$authors ?? []" :bookData="$bookData ?? null" />
        </div>
    </div>
</x-layout.admin>
