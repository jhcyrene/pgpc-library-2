<!-- Left: Primary Circulation Station / Greeting (2/3 Width) -->
<div class="lg:col-span-2 bg-[#1A2B56] rounded-2xl p-6 md:p-8 relative overflow-hidden shadow-md hover:shadow-lg transition-shadow flex flex-col justify-between min-h-[220px] group">
    <!-- Decorative background elements -->
    <div class="absolute -right-10 -top-10 w-64 h-64 bg-white opacity-5 rounded-full blur-3xl group-hover:scale-110 transition-transform duration-700"></div>
    <div class="absolute right-20 -bottom-20 w-40 h-40 bg-amber-400 opacity-10 rounded-full blur-2xl group-hover:scale-110 transition-transform duration-700 delay-100"></div>

    <div class="relative z-10 flex flex-col h-full">
        <div class="mb-6 flex-1">
            <div class="flex flex-wrap items-center gap-4 justify-between mb-4">
                <p class="text-white/60 text-xs font-bold uppercase tracking-wider">
                    {{ now()->format('l, F j, Y') }}
                </p>
            </div>
            
            <h1 class="text-3xl md:text-4xl font-extrabold text-white leading-tight tracking-tight mb-2">
                Good {{ now()->hour < 12 ? 'morning' : (now()->hour < 18 ? 'afternoon' : 'evening') }}, 
                <span class="text-[#FFC107]">Admin</span> 👋
            </h1>
            <p class="text-slate-300 text-sm font-medium max-w-lg leading-relaxed">
                Here's an overview of the library today. Process returning items or check-out new books immediately below.
            </p>
        </div>
        
        <!-- Direct Actions -->
        <div class="flex flex-col sm:flex-row gap-4 mt-auto">
            <button class="px-6 py-3 bg-emerald-500 hover:bg-emerald-400 text-white text-sm font-bold rounded-xl shadow-md shadow-emerald-500/30 hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Quick Check-In (Return)
            </button>
            <button class="px-6 py-3 bg-[#FFC107] hover:bg-[#FFD54F] text-[#1A2B56] text-sm font-bold rounded-xl shadow-md shadow-[#FFC107]/30 hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                Quick Check-Out (Borrow)
            </button>
        </div>
    </div>
</div>