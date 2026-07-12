<x-layout.admin>
    <div class="flex-1 flex flex-col min-h-0 h-full p-6 bg-gray-50/50">
        <div class="flex items-center justify-between mb-6 shrink-0">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Book Details</h1>
                <p class="text-sm text-gray-500 mt-1 font-medium">View bibliographic information and copies.</p>
            </div>
            
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.books.index') }}" class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg shadow-sm text-sm font-medium hover:bg-gray-50">Back to Catalog</a>
                <a href="{{ route('admin.books.edit', $bookData->book_data_id) }}" class="flex items-center gap-2 bg-[#1A2B56] hover:bg-[#243B73] text-white text-sm font-bold px-4 py-2 rounded-lg transition-all shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                    Edit Book
                </a>
            </div>
        </div>

        <div class="flex-1 overflow-y-auto">
            <div class="max-w-5xl mx-auto space-y-6">
                
                <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm flex flex-col md:flex-row gap-8">
                    <div class="w-full md:w-1/4 shrink-0">
                        <div class="bg-gray-100 w-full aspect-[2/3] rounded-lg border border-gray-200 flex items-center justify-center">
                            @if($bookData->bookDetail?->cover_image)
                                <img src="{{ asset('storage/' . $bookData->bookDetail->cover_image) }}" alt="Cover" class="w-full h-full object-cover rounded-lg">
                            @else
                                <svg class="h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                            @endif
                        </div>
                    </div>
                    
                    <div class="flex-1">
                        <h2 class="text-3xl font-bold text-gray-800">{{ $bookData->book_title }}</h2>
                        @if($bookData->subtitle)
                            <h3 class="text-xl text-gray-600 mt-1">{{ $bookData->subtitle }}</h3>
                        @endif
                        
                        <p class="text-lg text-[#1A2B56] font-medium mt-3">
                            By 
                            @forelse($bookData->authors as $author)
                                {{ $author->first_name }} {{ $author->last_name }}@if(!$loop->last), @endif
                            @empty
                                Unknown Author
                            @endforelse
                        </p>
                        
                        <div class="flex flex-wrap gap-2 mt-4">
                            @foreach($bookData->categories as $category)
                                <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-semibold">{{ $category->category_name }}</span>
                            @endforeach
                        </div>

                        <div class="mt-6 prose prose-sm text-gray-600 max-w-none">
                            <p>{{ $bookData->description ?? 'No description available.' }}</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                        <h3 class="text-sm font-bold text-[#1A2B56] mb-4 uppercase tracking-wider border-b pb-2">Publication Details</h3>
                        <dl class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <dt class="text-gray-500">ISBN:</dt>
                                <dd class="font-medium text-gray-800">{{ $bookData->bookDetail?->isbn ?? 'N/A' }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-gray-500">Publisher:</dt>
                                <dd class="font-medium text-gray-800">{{ $bookData->bookDetail?->publisher?->publisher_name ?? 'N/A' }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-gray-500">Publication Year:</dt>
                                <dd class="font-medium text-gray-800">{{ $bookData->bookDetail?->publication_year ?? 'N/A' }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-gray-500">Edition:</dt>
                                <dd class="font-medium text-gray-800">{{ $bookData->bookDetail?->edition ?? 'N/A' }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-gray-500">Pages:</dt>
                                <dd class="font-medium text-gray-800">{{ $bookData->bookDetail?->pages ?? 'N/A' }}</dd>
                            </div>
                        </dl>
                    </div>

                    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                        <h3 class="text-sm font-bold text-[#1A2B56] mb-4 uppercase tracking-wider border-b pb-2">Library Details</h3>
                        <dl class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <dt class="text-gray-500">Call Number:</dt>
                                <dd class="font-medium text-gray-800">{{ $bookData->bookDetail?->call_number ?? 'N/A' }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-gray-500">Classification:</dt>
                                <dd class="font-medium text-gray-800">{{ $bookData->bookDetail?->classification ?? 'N/A' }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-gray-500">Format:</dt>
                                <dd class="font-medium text-gray-800">{{ $bookData->bookDetail?->format ?? 'N/A' }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-gray-500">Language:</dt>
                                <dd class="font-medium text-gray-800">{{ $bookData->language ?? 'N/A' }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                    <div class="flex items-center justify-between border-b pb-4 mb-4">
                        <h3 class="text-lg font-bold text-[#1A2B56]">Physical Copies ({{ $bookData->books->count() }})</h3>
                        <a href="{{ route('admin.books.copies.index', $bookData->book_data_id) }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">Manage Copies &rarr;</a>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead>
                                <tr class="text-gray-500 border-b">
                                    <th class="pb-2 font-medium">Accession #</th>
                                    <th class="pb-2 font-medium">Barcode</th>
                                    <th class="pb-2 font-medium">Status</th>
                                    <th class="pb-2 font-medium text-right">Location</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($bookData->books as $copy)
                                    <tr>
                                        <td class="py-3 font-medium text-gray-800">{{ $copy->accession_number }}</td>
                                        <td class="py-3 text-gray-600">{{ $copy->barcode ?? 'N/A' }}</td>
                                        <td class="py-3">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium 
                                                {{ $copy->status === 'Available' ? 'bg-green-100 text-green-800' : 
                                                   ($copy->status === 'Borrowed' ? 'bg-blue-100 text-blue-800' : 
                                                   ($copy->status === 'Archived' ? 'bg-gray-100 text-gray-800' : 'bg-red-100 text-red-800')) }}">
                                                {{ $copy->status }}
                                            </span>
                                        </td>
                                        <td class="py-3 text-right text-gray-600">{{ $copy->location ?? 'N/A' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-4 text-center text-gray-500">No physical copies found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-layout.admin>
