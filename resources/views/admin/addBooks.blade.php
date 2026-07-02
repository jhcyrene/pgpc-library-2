<!-- Add Book Modal -->
<div id="addBookModal" class="fixed inset-0 z-50 hidden">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity"></div>
    
    <!-- Modal Panel -->
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
        <div class="relative bg-white rounded-xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:max-w-2xl sm:w-full border border-gray-100 flex flex-col max-h-[90vh]">
            
            <!-- Header -->
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center shrink-0">
                <h3 class="text-lg leading-6 font-bold text-gray-900 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#FFC107]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                    Add New Book
                </h3>
                <button onclick="document.getElementById('addBookModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-500 hover:bg-gray-200 p-1 rounded-full transition-colors">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
            
            <!-- Body -->
            <div class="px-6 py-6 overflow-y-auto">
                <form id="addBookForm">
                    <div class="grid grid-cols-2 gap-5">
                        <div class="col-span-2 sm:col-span-1">
                            <label class="block text-sm font-bold text-gray-700 mb-1">Book Title <span class="text-red-500">*</span></label>
                            <input type="text" class="w-full border border-gray-300 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-2 focus:ring-[#1A2B56] focus:border-transparent" placeholder="e.g. Introduction to Algorithms">
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label class="block text-sm font-bold text-gray-700 mb-1">Author <span class="text-red-500">*</span></label>
                            <input type="text" class="w-full border border-gray-300 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-2 focus:ring-[#1A2B56] focus:border-transparent" placeholder="e.g. Thomas H. Cormen">
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label class="block text-sm font-bold text-gray-700 mb-1">ISBN <span class="text-red-500">*</span></label>
                            <input type="text" class="w-full border border-gray-300 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-2 focus:ring-[#1A2B56] focus:border-transparent" placeholder="e.g. 978-0262033848">
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label class="block text-sm font-bold text-gray-700 mb-1">Category</label>
                            <select class="w-full border border-gray-300 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-2 focus:ring-[#1A2B56] focus:border-transparent">
                                <option>Computer Science</option>
                                <option>Mathematics</option>
                                <option>Physics</option>
                                <option>History</option>
                            </select>
                        </div>
                        <div class="col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-1">Description</label>
                            <textarea rows="3" class="w-full border border-gray-300 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-2 focus:ring-[#1A2B56] focus:border-transparent" placeholder="Brief description of the book..."></textarea>
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label class="block text-sm font-bold text-gray-700 mb-1">Publisher</label>
                            <input type="text" class="w-full border border-gray-300 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-2 focus:ring-[#1A2B56] focus:border-transparent" placeholder="e.g. MIT Press">
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label class="block text-sm font-bold text-gray-700 mb-1">Date Published</label>
                            <input type="date" class="w-full border border-gray-300 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-2 focus:ring-[#1A2B56] focus:border-transparent">
                        </div>
                    </div>
                </form>
            </div>
            
            <!-- Footer -->
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex justify-end gap-3 shrink-0">
                <button onclick="document.getElementById('addBookModal').classList.add('hidden')" type="button" class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-bold text-gray-700 hover:bg-gray-50 transition-colors shadow-sm">Cancel</button>
                <button type="button" class="px-4 py-2 bg-[#1A2B56] border border-transparent rounded-lg text-sm font-bold text-white hover:bg-blue-900 transition-colors shadow-sm flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" /></svg>
                    Save Book
                </button>
            </div>
        </div>
    </div>
</div>