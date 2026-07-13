@props(['categories' => [], 'publishers' => [], 'authors' => [], 'bookData' => null])

@php
    $isEdit = !is_null($bookData);
    $action = $isEdit ? route('admin.books.update', $bookData->book_data_id) : route('admin.books.store');
    
    // Helper function to get values: old() takes precedence, then $bookData, then empty string
    $val = function($field, $relation = null) use ($isEdit, $bookData) {
        if (old($field) !== null) return old($field);
        if (!$isEdit) return '';
        
        if ($relation === 'detail') return $bookData->bookDetail->$field ?? '';
        if ($relation === 'author_id') return $bookData->authors->first()->author_id ?? '';
        
        return $bookData->$field ?? '';
    };

    $selectedCategories = old('categories');
    if ($selectedCategories === null) {
        $selectedCategories = $isEdit ? $bookData->categories->pluck('category_id')->toArray() : [];
    }

    $currentCoverImage = $isEdit && $bookData->bookDetail?->cover_image
        ? asset('storage/' . ltrim($bookData->bookDetail->cover_image, '/'))
        : null;
@endphp

<form action="{{ $action }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @if($isEdit)
        @method('PUT')
    @endif

    @if($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-md">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">There were errors with your submission</h3>
                    <div class="mt-2 text-sm text-red-700">
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-md">
            <p class="text-sm text-red-700">{{ session('error') }}</p>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left Column: Inventory Details & Cover -->
        <div class="lg:col-span-1 space-y-6">
            @if(!$isEdit)
            <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm">
                <h3 class="text-sm font-bold text-[#1A2B56] mb-4 uppercase tracking-wider">Initial Physical Copy</h3>
                
                <div class="space-y-4">
                    <x-admin.partials.input name="accession_number" label="Accession Number" placeholder="Required" required="true" value="{{ old('accession_number') }}" />
                    <x-admin.partials.input name="barcode" label="Barcode" placeholder="Optional" value="{{ old('barcode') }}" />
                    
                    <x-admin.partials.select name="status" label="Status">
                        <option value="Available" @selected(old('status') == 'Available')>Available</option>
                        <option value="Reserved" @selected(old('status') == 'Reserved')>Reserved</option>
                        <option value="Archived" @selected(old('status') == 'Archived')>Archived</option>
                    </x-admin.partials.select>
                    
                    <x-admin.partials.input name="location" label="Location / Shelf" placeholder="e.g. Shelf A1" value="{{ old('location') }}" />
                    <x-admin.partials.input name="date_acquired" type="date" label="Date Acquired" value="{{ old('date_acquired', now()->toDateString()) }}" />
                </div>
            </div>
            @endif

            <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm">
                <h3 class="text-sm font-bold text-[#1A2B56] mb-4 uppercase tracking-wider">Book Cover</h3>
                <x-admin.partials.fileUpload name="cover_image" label="" :current-image="$currentCoverImage" />
                <p class="text-xs text-gray-500 mt-3 text-center">A high-quality cover image helps users easily identify the book in the catalog.</p>
            </div>
        </div>

        <!-- Right Column: Main Details -->
        <div class="lg:col-span-2 space-y-6">
            
            <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm space-y-5">
                <h3 class="text-sm font-bold text-[#1A2B56] mb-2 uppercase tracking-wider">Bibliographic Information</h3>
                
                <x-admin.partials.input name="book_title" label="Book Title" placeholder="Enter the complete book title" required="true" value="{{ $val('book_title') }}" />
                <x-admin.partials.input name="subtitle" label="Subtitle" placeholder="Optional" value="{{ $val('subtitle') }}" />
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <x-admin.partials.select name="main_author_id" label="Main Author (Existing)">
                            <option value="">-- Select Existing Author --</option>
                            @foreach($authors as $author)
                                <option value="{{ $author->author_id }}" @selected($val('main_author_id', 'author_id') == $author->author_id)>
                                    {{ $author->last_name }}, {{ $author->first_name }}
                                </option>
                            @endforeach
                        </x-admin.partials.select>
                    </div>
                    <div>
                        <x-admin.partials.input name="main_author_last_name" label="OR New Author Last Name" placeholder="If author not in list" value="{{ old('main_author_last_name') }}" />
                        <x-admin.partials.input name="main_author_first_name" label="New Author First Name" placeholder="Optional" value="{{ old('main_author_first_name') }}" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <x-admin.partials.input name="isbn" label="ISBN" placeholder="10 or 13-digit ISBN" value="{{ $val('isbn', 'detail') }}" />
                    <x-admin.partials.input name="issn" label="ISSN" placeholder="Optional" value="{{ $val('issn', 'detail') }}" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <x-admin.partials.input name="call_number" label="Call Number" placeholder="e.g. QA76.73.J38" value="{{ $val('call_number', 'detail') }}" />
                    <x-admin.partials.input name="classification" label="Classification" placeholder="Optional" value="{{ $val('classification', 'detail') }}" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="col-span-1 md:col-span-2">
                        <x-admin.partials.publisherAutocomplete :value="old('publisher') ?? ($isEdit ? ($bookData->bookDetail->publisher->publisher_name ?? '') : '')" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <x-admin.partials.input name="publication_year" label="Publication Year" type="number" placeholder="YYYY" value="{{ $val('publication_year', 'detail') }}" />
                    <x-admin.partials.input name="edition" label="Edition" placeholder="e.g. 1st Edition" value="{{ $val('edition', 'detail') }}" />
                    <x-admin.partials.input name="pages" label="Pages" type="number" placeholder="e.g. 350" value="{{ $val('pages', 'detail') }}" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="form-control">
                        <label class="label"><span class="label-text font-semibold text-gray-700">Categories</span></label>
                        <select name="categories[]" multiple class="border border-gray-200 rounded-lg text-sm px-3 py-2 outline-none focus:ring-1 focus:ring-[#1A2B56] bg-gray-50 text-gray-700 font-medium w-full h-32">
                            @foreach($categories as $category)
                                <option value="{{ $category->category_id }}" @selected(in_array($category->category_id, collect($selectedCategories)->toArray()))>
                                    {{ $category->category_name }}
                                </option>
                            @endforeach
                        </select>
                        <label class="label"><span class="label-text-alt text-gray-500">Hold Ctrl/Cmd to select multiple</span></label>
                    </div>
                    
                    <div class="space-y-4">
                        <x-admin.partials.input name="language" label="Language" placeholder="e.g. English" value="{{ $val('language') }}" />
                        <x-admin.partials.input name="copyright_year" label="Copyright Year" type="number" placeholder="YYYY" value="{{ $val('copyright_year') }}" />
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="block text-sm font-semibold text-gray-700">Book Description</label>
                    <textarea name="description" rows="4" class="block w-full border border-gray-200 rounded-lg text-sm bg-gray-50 focus:bg-white focus:border-[#1A2B56] focus:ring-1 focus:ring-[#1A2B56] outline-none transition-all shadow-sm p-3" placeholder="Write a brief summary...">{{ $val('description') }}</textarea>
                </div>
                
                <div class="space-y-1">
                    <label class="block text-sm font-semibold text-gray-700">Notes</label>
                    <textarea name="notes" rows="2" class="block w-full border border-gray-200 rounded-lg text-sm bg-gray-50 focus:bg-white focus:border-[#1A2B56] focus:ring-1 focus:ring-[#1A2B56] outline-none transition-all shadow-sm p-3" placeholder="Additional notes...">{{ $val('notes') }}</textarea>
                </div>

            </div>

        </div>
    </div>

    <!-- Form Actions -->
    <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-200 mt-8">
        <a href="{{ route('admin.books.index') }}" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-gray-200 transition-colors shadow-sm">
            Cancel
        </a>
        <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-[#1A2B56] border border-transparent rounded-lg hover:bg-[#243B73] focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-[#1A2B56] transition-colors shadow-sm flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            Save Book Details
        </button>
    </div>
</form>
