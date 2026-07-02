<!-- View Book Details Modal -->
<div id="viewBookModal" class="fixed inset-0 z-50 hidden">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity"></div>
    
    <!-- Modal Panel -->
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
        <div class="relative bg-white rounded-xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:max-w-2xl sm:w-full border border-gray-100 flex flex-col max-h-[90vh]">
            
            <!-- Header -->
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center shrink-0">
                <h3 class="text-lg leading-6 font-bold text-gray-900 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    Book Details
                </h3>
                <button onclick="document.getElementById('viewBookModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-500 hover:bg-gray-200 p-1 rounded-full transition-colors">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
            
            <!-- Body -->
            <div class="px-6 py-6 overflow-y-auto">
                <div class="flex flex-col sm:flex-row gap-6">
                    <!-- Book Cover Mock -->
                    <div class="w-full sm:w-1/3 shrink-0 flex flex-col gap-3">
                        <div class="w-full aspect-[2/3] bg-gradient-to-br from-blue-50 to-indigo-100 rounded-lg border border-blue-200 flex flex-col items-center justify-center text-center p-4 shadow-inner">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-blue-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                            <span class="text-xs font-bold text-blue-800 uppercase tracking-widest opacity-50">No Cover</span>
                        </div>
                        <span class="inline-flex items-center justify-center gap-1.5 px-2 py-1.5 rounded-md text-xs font-bold bg-green-50 text-green-700 border border-green-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Available (3 Copies)
                        </span>
                    </div>
                    
                    <!-- Book Info -->
                    <div class="flex-1 flex flex-col gap-4">
                        <div>
                            <h4 class="text-xl font-black text-gray-900 leading-tight">Software Engineering, 10th Edition</h4>
                            <p class="text-sm font-bold text-gray-500 mt-1">by Ian Sommerville</p>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-y-3 gap-x-4 bg-gray-50 p-4 rounded-lg border border-gray-100">
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">ISBN</p>
                                <p class="text-sm font-semibold text-gray-800">978-0133943030</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Category</p>
                                <p class="text-sm font-semibold text-gray-800">Computer Science</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Publisher</p>
                                <p class="text-sm font-semibold text-gray-800">Pearson</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Date Published</p>
                                <p class="text-sm font-semibold text-gray-800">April 3, 2015</p>
                            </div>
                        </div>
                        
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Description</p>
                            <p class="text-sm text-gray-600 leading-relaxed">
                                The tenth edition of Software Engineering presents a broad perspective of software engineering, focusing on the processes and techniques fundamental to the creation of reliable, software systems.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex justify-end gap-3 shrink-0">
                <button onclick="document.getElementById('viewBookModal').classList.add('hidden')" type="button" class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-bold text-gray-700 hover:bg-gray-50 transition-colors shadow-sm">Close</button>
                <button type="button" class="px-4 py-2 bg-blue-50 border border-blue-200 rounded-lg text-sm font-bold text-blue-700 hover:bg-blue-100 transition-colors shadow-sm flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                    Edit Details
                </button>
            </div>
        </div>
    </div>
</div>
