<!-- Right: Urgent Alerts (1/3 Width) -->
<div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow flex flex-col">
    <h3 class="text-lg font-extrabold text-slate-900 mb-4 flex items-center gap-2">
        Requires Attention
    </h3>
    
    <div class="space-y-4 flex-1">
        <!-- Alert Item -->
        <div class="flex justify-between items-center p-4 bg-red-50/50 rounded-xl border border-red-100 group">
            <div class="flex items-center gap-3 text-sm font-bold text-red-700">
                <div class="w-10 h-10 rounded-full bg-red-100 text-red-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                Overdue Items
            </div>
            <span id="stat-overdue-items" class="text-2xl font-black text-red-700"><span class="loading loading-spinner loading-md"></span></span>
        </div>
        <!-- Alert Item -->
        <div class="flex justify-between items-center p-4 bg-amber-50/50 rounded-xl border border-amber-100 group">
            <div class="flex items-center gap-3 text-sm font-bold text-amber-700">
                <div class="w-10 h-10 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                Pending Reservations
            </div>
            <span id="stat-pending-reservations" class="text-2xl font-black text-amber-700"><span class="loading loading-spinner loading-md"></span></span>
        </div>
    </div>
</div>
