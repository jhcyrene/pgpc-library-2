<a href="/admin/profile" class="p-4 shrink-0 border-t border-white/5 block hover:bg-white/5 transition-colors {{ request()->is('admin/profile') ? 'bg-white/10' : '' }}">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3 overflow-hidden">
            <div class="w-9 h-9 rounded-full flex items-center justify-center shrink-0 text-sm font-bold text-[#1A2B56]" style="background-color: #FFC107;">
                AD
            </div>
            <div class="overflow-hidden">
                <p class="text-sm font-bold text-white truncate group-hover:text-[#FFC107] transition-colors">Admin User</p>
                <p class="text-xs text-gray-400 truncate">admin@pgpc.edu.ph</p>
            </div>
        </div>
        <span class="text-gray-400 hover:text-white transition-colors p-1" title="Logout">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>
        </span>
    </div>
</a>