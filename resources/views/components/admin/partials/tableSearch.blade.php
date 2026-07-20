<form action="{{ route('admin.books.index') }}" method="GET" class="bg-white rounded-2xl border border-slate-200 p-4 mb-5 shadow-xs flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-3 shrink-0">
    
    <!-- Search Bar -->
    <div class="relative flex-1 group">
        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 group-focus-within:text-[#102b70] transition-colors">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
        
        <input 
            type="text" 
            name="search" 
            value="{{ request('search') }}"
            class="block w-full pl-10 pr-20 py-2.5 border border-slate-200 rounded-xl text-sm bg-slate-50 focus:bg-white focus:border-[#102b70] focus:ring-2 focus:ring-[#102b70]/20 outline-none transition-all text-slate-900 placeholder:text-slate-400" 
            placeholder="Search by title, author, or ISBN..."
        >   

        <button type="submit" class="absolute top-1/2 -translate-y-1/2 right-1.5 px-3 py-1.5 bg-[#102b70] hover:bg-[#0b225e] text-white text-xs font-bold rounded-lg transition-colors shadow-xs">
            Search
        </button>
    </div>

    <!-- Filter Dropdowns Grid / Row -->
    <div class="grid grid-cols-2 sm:grid-cols-4 lg:flex items-center gap-2.5 w-full lg:w-auto">
        
        <!-- Category Dropdown -->
        <select name="category_id"
            class="w-full border border-slate-200 rounded-xl text-xs font-semibold px-3 py-2.5 outline-none focus:ring-2 focus:ring-[#102b70]/20 focus:border-[#102b70] bg-slate-50 text-slate-700 transition-colors">
            <option value="">All Categories</option>
            @foreach($categories ?? [] as $category)
                <option value="{{ $category->category_id }}" {{ request('category_id') == $category->category_id ? 'selected' : '' }}>
                    {{ $category->category_name }}
                </option>
            @endforeach
        </select>

        <!-- Publisher Dropdown -->
        <select name="publisher_id"
            class="w-full border border-slate-200 rounded-xl text-xs font-semibold px-3 py-2.5 outline-none focus:ring-2 focus:ring-[#102b70]/20 focus:border-[#102b70] bg-slate-50 text-slate-700 transition-colors">
            <option value="">All Publishers</option>
            @foreach($publishers ?? [] as $publisher)
                <option value="{{ $publisher->publisher_id }}" {{ request('publisher_id') == $publisher->publisher_id ? 'selected' : '' }}>
                    {{ $publisher->publisher_name }}
                </option>
            @endforeach
        </select>

        <!-- Status Dropdown -->
        <select name="status"
            class="w-full border border-slate-200 rounded-xl text-xs font-semibold px-3 py-2.5 outline-none focus:ring-2 focus:ring-[#102b70]/20 focus:border-[#102b70] bg-slate-50 text-slate-700 transition-colors">
            <option value="">All Status</option>
            <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Available</option>
            <option value="borrowed" {{ request('status') == 'borrowed' ? 'selected' : '' }}>Borrowed</option>
            <option value="unavailable" {{ request('status') == 'unavailable' ? 'selected' : '' }}>Unavailable</option>
        </select>

        <!-- Clear Button -->
        <a href="{{ route('admin.books.index') }}" 
           class="col-span-2 sm:col-span-1 px-3 py-2.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-100 text-slate-600 font-bold text-xs flex items-center justify-center gap-1.5 transition-colors shadow-xs">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
            </svg>
            Clear
        </a>
    </div>
</form>
