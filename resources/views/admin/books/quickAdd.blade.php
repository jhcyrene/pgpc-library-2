<x-layout.admin>
    <!-- Main Dashboard Content -->
    <div class="flex-1 flex flex-col min-h-0 h-full p-6 bg-gray-50/50">
        <!-- Page Header -->
        <div class="flex items-center justify-between mb-6 shrink-0">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Quick Add Book</h1>
                <p class="text-sm text-gray-500 mt-1 font-medium">Rapidly register a new book with minimal details.</p>
            </div>
            
            <a href="{{ route('admin.books.index') }}" class="flex items-center gap-2 text-[#1A2B56] bg-white border border-gray-200 hover:bg-gray-50 text-sm font-bold px-4 py-2.5 rounded-lg transition-all shadow-sm">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Catalog
            </a>
        </div>

        <div class="flex-1 overflow-y-auto">
            <div class="w-full">
                <form action="{{ route('admin.books.quick-store') }}" method="POST" class="flex flex-col gap-6">
                    @csrf

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
                        <x-alert type="error" message="{{ session('error') }}" />
                    @endif

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 w-full">
                        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm space-y-5">
                        <h3 class="text-sm font-bold text-[#1A2B56] mb-2 uppercase tracking-wider">Book Information</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <x-admin.partials.input name="book_title" label="Book Title" placeholder="Required" required="true" value="{{ old('book_title') }}" />
                            <x-admin.partials.input name="isbn" label="ISBN" placeholder="Optional" value="{{ old('isbn') }}" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <x-admin.partials.input name="main_author_last_name" label="Author Last Name" placeholder="Required" required="true" value="{{ old('main_author_last_name') }}" />
                            <x-admin.partials.input name="main_author_first_name" label="Author First Name" placeholder="Optional" value="{{ old('main_author_first_name') }}" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                            <div>
                                <x-admin.partials.select name="category_id" label="Category (Optional)">
                                    <option value="">-- Select Category --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->category_id }}" @selected(old('category_id') == $category->category_id)>
                                            {{ $category->category_name }}
                                        </option>
                                    @endforeach
                                </x-admin.partials.select>
                            </div>
                            <div>
                                <x-admin.partials.publisherAutocomplete :value="old('publisher')" />
                            </div>
                            <x-admin.partials.input name="publication_year" label="Publication Year" type="number" placeholder="Optional" value="{{ old('publication_year') }}" />
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm space-y-5">
                        <h3 class="text-sm font-bold text-[#1A2B56] mb-2 uppercase tracking-wider">Physical Copy</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <x-admin.partials.input name="accession_number" label="Accession Number" placeholder="Required" required="true" value="{{ old('accession_number') }}" />
                            <div class="flex flex-col gap-1.5">
                                <label for="barcode" class="text-sm font-semibold text-gray-700">Barcode</label>
                                <div class="flex">
                                    <input 
                                        type="text" 
                                        id="barcode" 
                                        name="barcode" 
                                        value="{{ old('barcode') }}" 
                                        placeholder="Optional"
                                        class="w-full px-4 py-2.5 rounded-l-lg border border-gray-300 focus:ring-2 focus:ring-[#1A2B56] focus:border-[#1A2B56] outline-none transition-all shadow-sm text-gray-800 text-sm"
                                    >
                                    <button type="button" onclick="document.getElementById('barcode').value = 'PGPC-BAR-' + Math.random().toString(36).substr(2, 9).toUpperCase();" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-2.5 rounded-r-lg border border-l-0 border-gray-300 text-sm font-medium transition-colors" title="Generate Random Barcode">
                                        Generate
                                    </button>
                                </div>
                                @error('barcode')
                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                            <x-admin.partials.input name="call_number" label="Call Number" placeholder="Optional" value="{{ old('call_number') }}" />
                            <x-admin.partials.input name="location" label="Location / Shelf" placeholder="Optional" value="{{ old('location') }}" />
                            <x-admin.partials.input name="date_acquired" type="date" label="Date Acquired" value="{{ old('date_acquired', now()->toDateString()) }}" />
                        </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 pb-6">
                        <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-[#1A2B56] border border-transparent rounded-lg hover:bg-[#243B73] focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-[#1A2B56] transition-colors shadow-sm flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            Quick Add Book
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout.admin>
