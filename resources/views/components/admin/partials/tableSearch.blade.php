<form action="{{ route('admin.books.index') }}" method="GET" class="bg-white rounded-t-xl border border-gray-200 p-4 flex flex-col sm:flex-row items-center justify-between gap-4 shrink-0">
    
    <div class="relative w-full sm:w-96 group">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <svg class="h-4 w-4 text-gray-400 group-focus-within:text-[#1A2B56] transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
        
        <input 
            type="text" 
            name="search" 
            value="{{ request('search') }}"
            class="block w-full pl-9 pr-20 py-2 border border-gray-200 rounded-lg text-sm bg-gray-50 focus:bg-white focus:border-[#1A2B56] focus:ring-1 focus:ring-[#1A2B56] outline-none transition-all shadow-sm" 
            placeholder="Search by title, author, or ISBN..."
        >   

        <button type="submit" class="absolute top-1/2 -translate-y-1/2 right-1.5 px-3 py-1.5 bg-[#1A2B56] hover:bg-[#243B73] text-white text-xs font-medium rounded-md transition-colors shadow-sm focus:outline-none">
            Search
        </button>
    </div>

    <div class="flex items-center gap-3 w-full sm:w-auto">
        <select name="category_id" onchange="this.form.submit()"
            class="border border-gray-200 rounded-lg text-sm px-3 py-2 outline-none focus:ring-1 focus:ring-[#1A2B56] bg-gray-50 text-gray-700 font-medium">
            <option value="">All Categories</option>
            @foreach($categories ?? [] as $category)
                <option value="{{ $category->category_id }}" {{ request('category_id') == $category->category_id ? 'selected' : '' }}>
                    {{ $category->category_name }}
                </option>
            @endforeach
        </select>
        <select name="publisher_id" onchange="this.form.submit()"
            class="border border-gray-200 rounded-lg text-sm px-3 py-2 outline-none focus:ring-1 focus:ring-[#1A2B56] bg-gray-50 text-gray-700 font-medium">
            <option value="">All Publishers</option>
            @foreach($publishers ?? [] as $publisher)
                <option value="{{ $publisher->publisher_id }}" {{ request('publisher_id') == $publisher->publisher_id ? 'selected' : '' }}>
                    {{ $publisher->publisher_name }}
                </option>
            @endforeach
        </select>
    </div>
</form>