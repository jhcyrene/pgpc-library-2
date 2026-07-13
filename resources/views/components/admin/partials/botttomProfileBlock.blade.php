@php
    $staffAccount = Auth::guard('member')->user();
    $staff = $staffAccount?->librarian;
    $displayName = trim(($staff?->first_name ?? 'Staff') . ' ' . ($staff?->last_name ?? 'User'));
    $initials = strtoupper(substr($staff?->first_name ?? 'S', 0, 1) . substr($staff?->last_name ?? 'U', 0, 1));
    $roleLabel = in_array(strtolower((string) $staffAccount?->account_type), ['administrator', 'admin'], true) ? 'Administrator' : 'Librarian';
@endphp

<div class="p-3 shrink-0 border-t border-white/5">
    <div class="flex items-center gap-3 rounded-xl px-2 py-2">
        <div class="w-9 h-9 rounded-full flex items-center justify-center shrink-0 text-sm font-black text-[#1A2B56] bg-[#FFC107]">
            {{ $initials }}
        </div>
        <div class="min-w-0 flex-1">
            <p class="text-sm font-bold text-white truncate">{{ $displayName }}</p>
            <p class="text-[11px] text-slate-400 truncate">{{ $roleLabel }}</p>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="p-2 text-slate-400 hover:text-white hover:bg-white/10 rounded-lg transition-colors" title="Log out" aria-label="Log out">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
            </button>
        </form>
    </div>
</div>
