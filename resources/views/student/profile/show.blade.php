@php
    $memberAuth = Auth::guard('member')->user();
    $member = $memberAuth->member;
@endphp

<x-layout.student title="My Profile">
    <div class="max-w-6xl mx-auto space-y-6 pb-12">
        <!-- Page Title Header -->
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">My Profile</h1>
        </div>

        <!-- User Information Header Card (Matching Mockup with Background Seal) -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6 md:p-8 relative overflow-hidden">
            <!-- Background Seal Watermark -->
            <div class="absolute -right-8 -bottom-8 w-56 h-56 opacity-[0.04] pointer-events-none">
                <img src="{{ Vite::asset('resources/images/webp/hd-pgpc-logo.webp') }}" class="w-full h-full object-contain grayscale" alt="Watermark">
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-between gap-6 relative z-10">
                <div class="flex flex-col sm:flex-row items-center gap-5 text-center sm:text-left">
                    <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-white shadow-md bg-[#102b70] text-[#fcc719] flex items-center justify-center shrink-0">
                        @if($memberAuth->profile_image)
                            <img src="{{ $memberAuth->profile_image }}" alt="Profile Image" class="w-full h-full object-cover" />
                        @else
                            <span class="text-3xl font-black uppercase">{{ substr($member->first_name, 0, 1) }}{{ substr($member->last_name, 0, 1) }}</span>
                        @endif
                    </div>
                    <div class="space-y-1">
                        <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2.5">
                            <h2 class="text-2xl font-black text-slate-900">{{ $member->first_name }} {{ $member->last_name }}</h2>
                            <span class="px-3 py-0.5 rounded-full text-xs font-bold bg-blue-100 text-[#102b70]">Student</span>
                        </div>
                        <p class="text-sm font-semibold text-slate-500">{{ $member->student_id_number }}</p>
                    </div>
                </div>

                <a href="{{ route('student.profile.edit') }}" class="px-3.5 py-1.5 text-xs border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all inline-flex items-center gap-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                    Edit Profile
                </a>
            </div>
        </div>

        <!-- 3-Column Grid for Desktop / Cards for Tablet & Mobile -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- COLUMN 1: Personal Information -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6 flex flex-col justify-between">
                <div>
                    <div class="flex items-center gap-2.5 mb-5 pb-3 border-b border-slate-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5 text-[#102b70]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM4 21a8 8 0 0116 0" />
                        </svg>
                        <h3 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider">Personal Information</h3>
                    </div>

                    <div class="space-y-3.5 text-xs">
                        <div class="flex justify-between items-center py-1">
                            <span class="font-bold text-slate-400">First Name</span>
                            <span class="font-bold text-slate-800">{{ $member->first_name }}</span>
                        </div>
                        <div class="flex justify-between items-center py-1 border-t border-slate-100">
                            <span class="font-bold text-slate-400">Last Name</span>
                            <span class="font-bold text-slate-800">{{ $member->last_name }}</span>
                        </div>
                        <div class="flex justify-between items-start py-1 border-t border-slate-100 gap-2">
                            <span class="font-bold text-slate-400 shrink-0">Email Address</span>
                            <span class="font-bold text-slate-800 text-right truncate max-w-[170px]" title="{{ $member->email }}">{{ $member->email }}</span>
                        </div>
                        <div class="flex justify-between items-center py-1 border-t border-slate-100">
                            <span class="font-bold text-slate-400">Phone Number</span>
                            <span class="font-bold text-slate-800">{{ $member->contact_num ?? 'Not provided' }}</span>
                        </div>
                        <div class="flex justify-between items-center py-1 border-t border-slate-100">
                            <span class="font-bold text-slate-400">Student Number</span>
                            <span class="font-bold text-slate-800">{{ $member->student_id_number }}</span>
                        </div>
                        <div class="flex justify-between items-start py-1 border-t border-slate-100 gap-2">
                            <span class="font-bold text-slate-400 shrink-0">Program / Course</span>
                            <span class="font-bold text-slate-800 text-right leading-tight max-w-[170px]">{{ $member->program ?? 'Bachelor of Science in Information Technology' }}</span>
                        </div>
                        <div class="flex justify-between items-center py-1 border-t border-slate-100">
                            <span class="font-bold text-slate-400">Year Level</span>
                            <span class="font-bold text-slate-800">{{ $member->year_level ?? '3rd Year' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- COLUMN 2: Account & Security -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6 flex flex-col justify-between">
                <div>
                    <div class="flex items-center gap-2.5 mb-5 pb-3 border-b border-slate-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5 text-[#102b70]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        <h3 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider">Account & Security</h3>
                    </div>

                    <div class="space-y-4">
                        <div class="flex justify-between items-center py-1">
                            <span class="text-xs font-bold text-slate-400">Username</span>
                            <span class="text-xs font-bold text-slate-800 font-mono bg-slate-50 px-2 py-1 rounded border border-slate-100">{{ $memberAuth->username ?? 'cyreneuser21' }}</span>
                        </div>

                        <div class="flex justify-between items-center py-1 border-t border-slate-100">
                            <span class="text-xs font-bold text-slate-400">Linked Account</span>
                            @if($memberAuth->isGoogleLinked())
                                <div class="flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-50 border border-emerald-100 text-[11px] font-extrabold text-emerald-700">
                                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24">
                                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                                    </svg>
                                    Linked to Google
                                </div>
                            @else
                                <div class="flex items-center gap-2">
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase bg-slate-100 text-slate-500 border border-slate-200">Not Linked</span>
                                    <a href="{{ route('auth.google') }}" class="px-2.5 py-1 bg-[#102b70] hover:bg-[#071943] text-white text-[10px] font-extrabold rounded-lg shadow-2xs transition-all inline-flex items-center gap-1">
                                        Link Google
                                    </a>
                                </div>
                            @endif
                        </div>

                        <!-- Account Security Link -->
                        <a href="{{ route('student.account-settings.edit') }}" class="flex items-center justify-between p-3 rounded-xl hover:bg-slate-50 border border-slate-100 transition-colors group">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-blue-50 text-[#102b70] flex items-center justify-center shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-800 group-hover:text-[#102b70] transition-colors">Account Security</p>
                                    <p class="text-[10px] font-medium text-slate-400">Manage your security settings</p>
                                </div>
                            </div>
                            <svg class="w-4 h-4 text-slate-400 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" /></svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- COLUMN 3: Support / Settings -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6 flex flex-col justify-between">
                <div>
                    <div class="flex items-center gap-2.5 mb-5 pb-3 border-b border-slate-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5 text-[#102b70]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <h3 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider">Support / Settings</h3>
                    </div>

                    <div class="space-y-2.5">
                        {{-- <button type="button" onclick="alert('Notification Settings: You will receive email notifications for upcoming due dates.')" class="w-full flex items-center justify-between p-3 rounded-xl hover:bg-slate-50 border border-slate-100 transition-colors group text-left">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-blue-50 text-[#102b70] flex items-center justify-center shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-800 group-hover:text-[#102b70] transition-colors">Notification Settings</p>
                                    <p class="text-[10px] font-medium text-slate-400">Manage your notifications</p>
                                </div>
                            </div>
                            <svg class="w-4 h-4 text-slate-400 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" /></svg>
                        </button> --}}

                        <button type="button" onclick="alert('Help & Support: Contact PGPC Library Helpdesk at library@pgpc.edu.ph')" class="w-full flex items-center justify-between p-3 rounded-xl hover:bg-slate-50 border border-slate-100 transition-colors group text-left">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-blue-50 text-[#102b70] flex items-center justify-center shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-800 group-hover:text-[#102b70] transition-colors">Help & Support</p>
                                    <p class="text-[10px] font-medium text-slate-400">Get help and contact support</p>
                                </div>
                            </div>
                            <svg class="w-4 h-4 text-slate-400 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" /></svg>
                        </button>

                        <button type="button" onclick="alert('About the App: PGPC Library System v1.0.0. Padre Garcia Polytechnic College Library Portal.')" class="w-full flex items-center justify-between p-3 rounded-xl hover:bg-slate-50 border border-slate-100 transition-colors group text-left">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-blue-50 text-[#102b70] flex items-center justify-center shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-800 group-hover:text-[#102b70] transition-colors">About the App</p>
                                    <p class="text-[10px] font-medium text-slate-400">Learn more about the app</p>
                                </div>
                            </div>
                            <svg class="w-4 h-4 text-slate-400 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" /></svg>
                        </button>

                        <button type="button" onclick="privacy_modal.showModal()" class="w-full flex items-center justify-between p-3 rounded-xl hover:bg-slate-50 border border-slate-100 transition-colors group text-left">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-blue-50 text-[#102b70] flex items-center justify-center shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-800 group-hover:text-[#102b70] transition-colors">Terms & Privacy</p>
                                    <p class="text-[10px] font-medium text-slate-400">View our terms and privacy policy</p>
                                </div>
                            </div>
                            <svg class="w-4 h-4 text-slate-400 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" /></svg>
                        </button>
                    </div>
                </div>
            </div>

        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-5 flex flex-col items-center justify-center space-y-2">
            <button type="button" onclick="logoutConfirmModal.showModal()" class="w-full max-w-xl px-5 py-2.5 text-sm border border-red-500 bg-white text-red-600 font-bold rounded-xl hover:bg-red-50 transition-all inline-flex items-center justify-center gap-2">
                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                Log out
            </button>
            <span class="text-[11px] font-semibold text-slate-400">Version 1.0.0</span>
        </div>
    </div>

    <!-- Privacy Policy Modal -->
    <dialog id="privacy_modal" class="modal modal-middle text-center">
        <div class="modal-box h-[85dvh] w-full max-w-5xl overflow-y-auto bg-slate-50 p-0">
            <form method="dialog" class="sticky top-4 z-20 ml-auto mr-4 w-fit"><button class="btn btn-circle btn-sm bg-slate-900/70 text-white">✕</button></form>
            <x-auth.privacypolicyCard />
        </div>
        <form method="dialog" class="modal-backdrop"><button>Close</button></form>
    </dialog>

    <!-- Logout Confirmation Modal (Matching Mockup EXACTLY) -->
    <dialog id="logoutConfirmModal" class="modal modal-middle">
        <div class="modal-box w-[calc(100%-2rem)] max-w-sm bg-white p-7 rounded-3xl text-center relative shadow-2xl border border-slate-100/80">
            <div class="mx-auto w-16 h-16 rounded-full bg-red-50 text-red-500 flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
            </div>
            
            <h3 class="font-extrabold text-xl text-[#0A1E4D]">Log out?</h3>
            <p class="text-xs text-slate-500 font-semibold mt-2 leading-relaxed max-w-[220px] mx-auto">Are you sure you want to log out of your account?</p>
            
            <div class="flex items-center justify-center gap-3 mt-6">
                <button type="button" onclick="logoutConfirmModal.close()" class="w-1/2 py-2.5 bg-[#F1F5F9] hover:bg-slate-200 text-[#0A1E4D] font-bold text-xs rounded-xl transition-all">Cancel</button>
                <form action="{{ route('logout') }}" method="POST" class="w-1/2">
                    @csrf
                    <button type="submit" class="w-full py-2.5 bg-[#EF4444] hover:bg-red-700 text-white font-bold text-xs rounded-xl shadow-xs transition-all">Log out</button>
                </form>
            </div>
        </div>
        <form method="dialog" class="modal-backdrop"><button>close</button></form>
    </dialog>
</x-layout.student>
