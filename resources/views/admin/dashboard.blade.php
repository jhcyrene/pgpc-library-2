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
            title="Total Books Borrowed" 
            value="1,205" 
            description="All-time active & returned" 
        />
        <x-admin.totalcard 
            title="Total Books Borrowed" 
            value="1,205" 
            description="All-time active & returned" 
        />
        <x-admin.totalcard 
            title="Total Books Borrowed" 
            value="1,205" 
            description="All-time active & returned" 
        />
        <x-admin.totalcard 
            title="Total Books Borrowed" 
            value="1,205" 
            description="All-time active & returned" 
        />

    </div>

    <!-- ROW 3: DECISION-MAKING DATA SPLIT -->    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 flex-1 min-h-0">
        
        <x-admin.fronttable />
        <!-- Right: Procurement Insights (1/3 Width) -->
        <x-admin.subCard />

    </div>

</div>

</x-layout.admin>
