<x-layout.admin>

<!-- DASHBOARD MAIN WRAPPER -->
<div class="w-full mx-auto flex flex-col h-[calc(100vh-6rem)] max-h-full font-sans text-slate-800">

    <!-- ========================================== -->
    <!-- ROW 1: HERO & DIRECT ACTIONS (Split Layout) -->
    <!-- ========================================== -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 shrink-0 mb-5">
        
        @include('admin.partials.greetingBanner')

        @include('admin.partials.requireAttentionCard')
        
    </div>

    <!-- ROW 2: 4-COLUMN Card -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 shrink-0 mb-5">
        
        <x-admin.totalcard 
            title="Total Book Titles" 
            value="{{ number_format($stats['total_titles'] ?? 0) }}" 
            description="Unique books in catalog" 
        />
        <x-admin.totalcard 
            title="Total Physical Copies" 
            value="{{ number_format($stats['total_copies'] ?? 0) }}" 
            description="Physical items in library" 
        />
        <x-admin.totalcard 
            title="Active Members" 
            value="{{ number_format($stats['active_members'] ?? 0) }}" 
            description="Users with active accounts" 
        />
        <x-admin.totalcard 
            title="Currently Borrowed" 
            value="{{ number_format($stats['borrowed_items'] ?? 0) }}" 
            description="Items checked out right now" 
        />

    </div>

    <!-- ROW 3: DECISION-MAKING DATA SPLIT -->    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 flex-1 min-h-0">
        
        <x-admin.fronttable />
        <!-- Right: Most Borrowed Items (1/3 Width) -->
        <x-admin.subCard 
            title="Most Borrowed Items"
            description="Items that are frequently borrowed by users"
        />

    </div>

</div>

</x-layout.admin>
