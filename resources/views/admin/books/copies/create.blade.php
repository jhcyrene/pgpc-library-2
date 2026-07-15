<x-layout.admin>
    <div class="flex-1 flex flex-col min-h-0 h-full p-6 bg-gray-50/50">
        <div class="flex items-center justify-between mb-6 shrink-0">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Add Physical Copy</h1>
                <p class="text-sm text-gray-500 mt-1 font-medium">{{ $bookData->book_title }}</p>
            </div>
            
            <a href="{{ route('admin.books.copies.index', $bookData->book_data_id) }}" class="flex items-center gap-2 text-[#1A2B56] bg-white border border-gray-200 hover:bg-gray-50 text-sm font-bold px-4 py-2.5 rounded-lg transition-all shadow-sm">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Copies
            </a>
        </div>

        <div class="flex-1 overflow-y-auto">
            <div class="max-w-2xl mx-auto bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                <form action="{{ route('admin.books.copies.store', $bookData->book_data_id) }}" method="POST" class="space-y-6">
                    @csrf

                    @if($errors->any())
                        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-md">
                            <ul class="list-disc pl-5 text-sm text-red-700">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

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

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <x-admin.partials.select name="status" label="Status" required="true">
                            <option value="Available" @selected(old('status', 'Available') == 'Available')>Available</option>
                            <option value="Reserved" @selected(old('status') == 'Reserved')>Reserved</option>
                            <option value="Lost" @selected(old('status') == 'Lost')>Lost</option>
                            <option value="Damaged" @selected(old('status') == 'Damaged')>Damaged</option>
                            <option value="Archived" @selected(old('status') == 'Archived')>Archived</option>
                        </x-admin.partials.select>
                        <x-admin.partials.input name="date_acquired" type="date" label="Date Acquired" value="{{ old('date_acquired', now()->toDateString()) }}" />
                    </div>

                    <x-admin.partials.input name="location" label="Location / Shelf" placeholder="e.g. Shelf A1" value="{{ old('location') }}" />

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                        <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-[#1A2B56] border border-transparent rounded-lg hover:bg-[#243B73] focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-[#1A2B56] transition-colors shadow-sm flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Add Copy
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout.admin>
