<div class="flex flex-col sm:flex-row justify-between sm:items-start gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-[#102b70]">Edit Physical Copy</h1>
        <p class="text-sm text-gray-500 mt-1">Update details for this copy of {{ $book->bookData->book_title }}.</p>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden p-6">
                <form action="{{ route('admin.book-copies.update', $book->book_id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

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
                        <x-admin.partials.input name="accession_number" label="Accession Number" placeholder="Required" required="true" value="{{ old('accession_number', $book->accession_number) }}" />
                        <div class="flex flex-col gap-1.5">
                            <label for="barcode" class="text-sm font-semibold text-gray-700">Barcode</label>
                            <div class="flex">
                                <input 
                                    type="text" 
                                    id="barcode" 
                                    name="barcode" 
                                    value="{{ old('barcode', $book->barcode) }}" 
                                    placeholder="Optional"
                                    class="w-full px-4 py-2.5 rounded-l-lg border border-gray-300 focus:ring-2 focus:ring-[#102b70] focus:border-[#102b70] outline-none transition-all shadow-sm text-gray-800 text-sm"
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
                            <option value="Available" @selected(old('status', $book->status) == 'Available')>Available</option>
                            <option value="Borrowed" @selected(old('status', $book->status) == 'Borrowed') disabled>Borrowed (Managed automatically)</option>
                            <option value="Reserved" @selected(old('status', $book->status) == 'Reserved')>Reserved</option>
                            <option value="Lost" @selected(old('status', $book->status) == 'Lost')>Lost</option>
                            <option value="Damaged" @selected(old('status', $book->status) == 'Damaged')>Damaged</option>
                            <option value="Archived" @selected(old('status', $book->status) == 'Archived')>Archived</option>
                        </x-admin.partials.select>
                        <x-admin.partials.input name="date_acquired" type="date" label="Date Acquired" value="{{ old('date_acquired', optional($book->date_acquired)->toDateString() ?? $book->date_acquired) }}" />
                    </div>

                    <x-admin.partials.input name="location" label="Location / Shelf" placeholder="e.g. Shelf A1" value="{{ old('location', $book->location) }}" />

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                        <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-[#102b70] border border-transparent rounded-lg hover:bg-[#0b225e] focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-[#102b70] transition-colors shadow-sm flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Save Changes
                        </button>
                    </div>
                </form>
</div>
