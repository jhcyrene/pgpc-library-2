<!-- Filters Area -->
<div class="p-4 md:p-5 border-b border-gray-100 bg-gray-50/50 shrink-0">
    <div class="flex flex-col lg:flex-row gap-4 justify-between items-start">
        <!-- Search -->
        <div class="relative w-full lg:w-96 shrink-0">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
            </div>
            <input type="text" id="search-input" class="input input-bordered w-full pl-10 h-10 text-sm focus:border-blue-500 focus:ring-blue-500 transition-colors shadow-sm bg-white" placeholder="Search by ID, Name, Book, Barcode...">
        </div>

        <!-- Filters -->
        <div class="flex flex-wrap items-center gap-3 w-full lg:w-auto justify-start lg:justify-end">
            <select id="filter-status" class="select select-bordered h-10 min-h-10 text-sm shadow-sm bg-white w-full sm:w-40">
                <option value="all">All Status</option>
                <option value="active">Active</option>
                <option value="overdue">Overdue</option>
                <option value="returned">Returned</option>
            </select>
            
            <select id="filter-due-date" class="select select-bordered h-10 min-h-10 text-sm shadow-sm bg-white w-full sm:w-40">
                <option value="all">Any Due Date</option>
                <option value="today">Due Today</option>
                <option value="this_week">Due This Week</option>
                <option value="overdue">Overdue</option>
            </select>

            <select id="sort-by" class="select select-bordered h-10 min-h-10 text-sm shadow-sm bg-white w-full sm:w-48">
                <option value="borrow_date_desc">Newest First</option>
                <option value="borrow_date_asc">Oldest First</option>
                <option value="due_date_asc">Due Date (Asc)</option>
                <option value="due_date_desc">Due Date (Desc)</option>
                <option value="student_name_asc">Student Name (A-Z)</option>
            </select>

            <button onclick="window.resetFilters()" class="btn btn-ghost btn-sm text-gray-500 hover:text-gray-900 w-full sm:w-auto">Reset</button>
        </div>
    </div>
</div>
