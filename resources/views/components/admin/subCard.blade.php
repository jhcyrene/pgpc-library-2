<div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow flex flex-col min-h-0">
    <div class="mb-4 shrink-0">
        <h3 class="text-lg font-extrabold text-slate-900 tracking-tight">{{ $title }}</h3>
        <p class="text-xs font-medium text-slate-500 mt-0.5">{{ $description }}</p>
    </div>
    
    <!-- Procurement List -->
    <div id="dashboard-most-borrowed-container" class="space-y-3 flex-1 overflow-y-auto pr-2 scrollbar-thin scrollbar-thumb-slate-200">
        <!-- Javascript will inject most borrowed items here -->
    </div>
    
    <button type="button" disabled class="mt-4 shrink-0 w-full py-2.5 border-2 border-slate-200 bg-slate-50 text-slate-400 font-bold rounded-xl text-sm cursor-not-allowed">
        Reports coming soon
    </button>
</div>
