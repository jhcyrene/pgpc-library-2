<div class="bg-white rounded-t-xl border border-gray-200 p-4 flex flex-col sm:flex-row items-center justify-between gap-4 shrink-0">
    
    <div class="relative w-full sm:w-96">
        <x-admin.partials.searchBar 
            :action="route('admin.bookManager')" 
            placeholder="Search by title, author, or ISBN..." 
        />
    </div>

    <div class="flex items-center gap-3 w-full sm:w-auto">
        <select
            class="border border-gray-200 rounded-lg text-sm px-3 py-2 outline-none focus:ring-1 focus:ring-[#1A2B56] bg-gray-50 text-gray-700 font-medium">
            <option>All Categories</option>
            <option>Computer Science</option>
            <option>History</option>
            <option>Mathematics</option>
        </select>
        <select
            class="border border-gray-200 rounded-lg text-sm px-3 py-2 outline-none focus:ring-1 focus:ring-[#1A2B56] bg-gray-50 text-gray-700 font-medium">
            <option>All Status</option>
            <option>Available</option>
            <option>Borrowed</option>
            <option>Lost</option>
        </select>
    </div>
</div>