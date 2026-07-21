@props(['title' => '', 'description' => ''])

<div class="bg-white border border-slate-200 rounded-2xl p-4 sm:p-6 shadow-sm hover:shadow-md transition-shadow flex flex-col min-h-[300px] lg:min-h-0">
    <div class="mb-4 shrink-0">
        <h3 class="text-lg font-extrabold text-slate-900 tracking-tight">{{ $title }}</h3>
        <p class="text-xs font-medium text-slate-500 mt-0.5">{{ $description }}</p>
    </div>
    
    <!-- Most Borrowed List Container -->
    <div id="dashboard-most-borrowed-container" class="space-y-3 flex-1 min-h-[180px] lg:min-h-0 overflow-y-auto pr-2 scrollbar-thin scrollbar-thumb-slate-200">
        <!-- Skeletal Shimmer Loading State -->
        <div class="p-3 animate-pulse rounded-xl border border-slate-100 bg-slate-50/50 space-y-2">
            <div class="flex justify-between items-center">
                <div class="h-4 w-40 bg-slate-200 rounded-md"></div>
                <div class="h-5 w-16 bg-slate-200 rounded-md"></div>
            </div>
            <div class="h-3 w-24 bg-slate-200/70 rounded-md"></div>
        </div>
        <div class="p-3 animate-pulse rounded-xl border border-slate-100 bg-slate-50/50 space-y-2">
            <div class="flex justify-between items-center">
                <div class="h-4 w-36 bg-slate-200 rounded-md"></div>
                <div class="h-5 w-16 bg-slate-200 rounded-md"></div>
            </div>
            <div class="h-3 w-28 bg-slate-200/70 rounded-md"></div>
        </div>
        <div class="p-3 animate-pulse rounded-xl border border-slate-100 bg-slate-50/50 space-y-2">
            <div class="flex justify-between items-center">
                <div class="h-4 w-44 bg-slate-200 rounded-md"></div>
                <div class="h-5 w-16 bg-slate-200 rounded-md"></div>
            </div>
            <div class="h-3 w-32 bg-slate-200/70 rounded-md"></div>
        </div>
    </div>
    
    <button type="button" disabled class="mt-4 shrink-0 w-full py-2.5 border-2 border-slate-200 bg-slate-50 text-slate-400 font-bold rounded-xl text-sm cursor-not-allowed">
        Reports coming soon
    </button>
</div>
