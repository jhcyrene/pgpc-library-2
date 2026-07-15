<!-- Table / List Area -->
<div class="flex-1 overflow-y-auto relative bg-gray-50/20" id="loans-container">
    
    <!-- Loading Overlay -->
    <div id="loading-overlay" class="absolute inset-0 bg-white/80 backdrop-blur-sm z-10 flex flex-col items-center justify-center hidden">
        <span class="loading loading-spinner loading-lg text-blue-600"></span>
        <p class="mt-4 font-medium text-gray-500">Loading loans...</p>
    </div>

    <!-- Desktop Table -->
    <div class="hidden md:block w-full">
        <table class="w-full text-left text-sm whitespace-nowrap">
            <thead class="bg-white sticky top-0 z-10 shadow-sm ring-1 ring-gray-100 text-gray-500 uppercase text-[10px] font-bold tracking-wider">
                <tr>
                    <th class="px-6 py-4">Borrower</th>
                    <th class="px-6 py-4">Books</th>
                    <th class="px-6 py-4">Borrow Date</th>
                    <th class="px-6 py-4">Due Date</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4">Fine</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody id="desktop-tbody" class="divide-y divide-gray-100 bg-white">
                <!-- Injected by JS -->
            </tbody>
        </table>
    </div>

    <!-- Mobile Cards -->
    <div class="md:hidden p-4 space-y-4" id="mobile-list">
        <!-- Injected by JS -->
    </div>

    <!-- Empty State -->
    <div id="empty-state" class="hidden flex-col items-center justify-center p-12 text-center h-full">
        <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center text-gray-300 mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
        </div>
        <h3 class="text-lg font-bold text-gray-900 mb-1">No loans found</h3>
        <p class="text-sm text-gray-500">Try adjusting your search or filter criteria.</p>
        <button onclick="window.resetFilters()" class="btn btn-outline btn-sm mt-6">Clear Filters</button>
    </div>
</div>

<!-- Pagination -->
<div class="p-4 border-t border-gray-100 bg-white shrink-0 flex flex-col sm:flex-row gap-4 items-center justify-between">
    <p class="text-sm text-gray-500" id="pagination-info">Showing <span class="font-bold text-gray-900">0</span> to <span class="font-bold text-gray-900">0</span> of <span class="font-bold text-gray-900">0</span> entries</p>
    <div class="join shadow-sm border border-gray-200 rounded-lg overflow-hidden" id="pagination-controls">
        <!-- Injected by JS -->
    </div>
</div>
