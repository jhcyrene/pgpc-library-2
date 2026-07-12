<form action="{{ route('admin.addBook') ?? '#' }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left Column: Image Upload & Short Info -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm">
                <h3 class="text-sm font-bold text-[#1A2B56] mb-4 uppercase tracking-wider">Book Cover</h3>
                <x-admin.partials.fileUpload name="cover_image" label="" />
                <p class="text-xs text-gray-500 mt-3 text-center">A high-quality cover image helps users easily identify the book in the catalog.</p>
            </div>
            
            <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm">
                <h3 class="text-sm font-bold text-[#1A2B56] mb-4 uppercase tracking-wider">Inventory Details</h3>
                
                <div class="space-y-4">
                    <x-admin.partials.input name="copies_total" label="Total Copies" type="number" placeholder="1" value="1" required="true" />
                    <x-admin.partials.input name="edition" label="Edition" placeholder="e.g. 1st Edition" />
                </div>
            </div>
        </div>

        <!-- Right Column: Main Details -->
        <div class="lg:col-span-2 space-y-6">
            
            <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm space-y-5">
                <h3 class="text-sm font-bold text-[#1A2B56] mb-2 uppercase tracking-wider">Basic Information</h3>
                
                <x-admin.partials.input name="book_title" label="Book Title" placeholder="Enter the complete book title" required="true" />
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <x-admin.partials.input name="author" label="Author(s)" placeholder="Author name" required="true" />
                    <x-admin.partials.input name="isbn" label="ISBN" placeholder="10 or 13-digit ISBN" required="true" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <x-admin.partials.input name="call_number" label="Call Number" placeholder="e.g. QA76.73.J38" required="true" />
                    <x-admin.partials.input name="publication_year" label="Publication Year" type="number" placeholder="YYYY" required="true" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Publisher Dropdown: using the reusable component -->
                    <x-admin.partials.select name="publisher_id" label="Publisher" required="true">
                        <option value="" disabled selected>Select a publisher...</option>
                        <!-- TODO: Populate publishers dynamically -->
                        <option value="1">Example Publisher Inc.</option>
                        <option value="2">Tech Books Publishing</option>
                    </x-admin.partials.select>
                    
                    <!-- Example Extra Dropdown -->
                    <x-admin.partials.select name="category" label="Category / Genre">
                        <option value="" disabled selected>Select a category...</option>
                        <option value="fiction">Fiction</option>
                        <option value="non-fiction">Non-Fiction</option>
                        <option value="science">Science</option>
                        <option value="history">History</option>
                    </x-admin.partials.select>
                </div>

                <x-admin.partials.textarea name="description" label="Book Description" placeholder="Write a brief summary or description of the book..." rows="5" />

            </div>

        </div>
    </div>

    <!-- Form Actions -->
    <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-200 mt-8">
        <button type="button" onclick="window.history.back()" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-gray-200 transition-colors shadow-sm">
            Cancel
        </button>
        <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-[#1A2B56] border border-transparent rounded-lg hover:bg-[#243B73] focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-[#1A2B56] transition-colors shadow-sm flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            Save Book Details
        </button>
    </div>
</form>
