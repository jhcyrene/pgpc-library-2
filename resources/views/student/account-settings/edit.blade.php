@php
    $memberAuth = Auth::guard('member')->user();
    $member = $memberAuth->member;
    $hasPassword = $memberAuth->hasPassword();
@endphp

<x-layout.student title="Account & Security">
    <div class="max-w-2xl mx-auto space-y-6 pb-12">
        <!-- Back Navigation -->
        <div>
            <a href="{{ route('student.profile.show') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-500 hover:text-[#102b70] transition-colors uppercase tracking-wider">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Account & Security
            </a>
        </div>

        <h1 class="text-2xl font-black text-slate-900 tracking-tight">Account & Security</h1>

        <!-- Alert Notification Box -->
        <div id="password-alert-container" class="hidden p-4 rounded-2xl text-xs font-bold transition-all shadow-2xs"></div>

        <!-- 1. USERNAME CARD -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6">
            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Username</label>
            <div class="flex items-center justify-between p-3.5 bg-slate-50 rounded-xl border border-slate-200/80">
                <span id="username-text" class="text-sm font-bold text-slate-800 font-mono">{{ $memberAuth->username ?? 'cyreneuser21' }}</span>
                <button type="button" onclick="copyUsername()" class="p-1.5 text-slate-400 hover:text-[#102b70] transition-colors rounded-lg hover:bg-slate-200/60" title="Copy username">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- 2. LINKED GOOGLE ACCOUNT CARD -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6 flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Linked Google Account</p>
                <p class="text-xs font-bold text-slate-800">{{ $member->email }}</p>
            </div>
            @if($memberAuth->isGoogleLinked())
                <div class="flex items-center gap-2">
                    <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-emerald-50 border border-emerald-100 text-xs font-extrabold text-emerald-700 shrink-0">
                        <svg class="w-4 h-4" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                        </svg>
                        Linked to Google
                    </div>
                    @if($memberAuth->hasPassword())
                        <form action="{{ route('student.account-settings.unlink-google') }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Are you sure you want to unlink your Google account? You will log in using your Student ID/email password.')" class="px-3 py-1.5 text-xs font-bold text-rose-600 hover:text-rose-800 hover:bg-rose-50 rounded-xl transition-all border border-rose-200/80">
                                Unlink
                            </button>
                        </form>
                    @endif
                </div>
            @else
                <div class="flex items-center gap-2">
                    <span class="px-3 py-1.5 rounded-full bg-slate-100 text-xs font-extrabold text-slate-500 border border-slate-200">Not Linked</span>
                    <a href="{{ route('auth.google') }}" class="px-3.5 py-1.5 bg-[#102b70] hover:bg-[#071943] text-white text-xs font-extrabold rounded-xl shadow-xs transition-all inline-flex items-center gap-1.5">
                        <svg class="w-4 h-4" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                        </svg>
                        Link Google Account
                    </a>
                </div>
            @endif
        </div>

        <!-- 3. SECURITY & VERIFICATION OPTIONS -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6 space-y-3">
            <!-- Change / Add Password -->
            <button type="button" onclick="changePasswordModal.showModal()" class="w-full flex items-center justify-between p-3.5 rounded-xl hover:bg-slate-50 border border-slate-100 transition-colors group text-left">
                <div class="flex items-center gap-3.5">
                    <div class="w-9 h-9 rounded-xl bg-blue-50 text-[#102b70] flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-800 group-hover:text-[#102b70] transition-colors">{{ $hasPassword ? 'Change Password' : 'Add Password' }}</p>
                        <p class="text-[10px] font-medium text-slate-400">{{ $hasPassword ? 'Update your account password' : 'Create a password for your Google account' }}</p>
                    </div>
                </div>
                <svg class="w-4 h-4 text-slate-400 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" /></svg>
            </button>

            <!-- Two-step Verification -->
            <button type="button" onclick="alert('Two-step Verification: Email-based 2FA is automatically enabled for your Google account.')" class="w-full flex items-center justify-between p-3.5 rounded-xl hover:bg-slate-50 border border-slate-100 transition-colors group text-left">
                <div class="flex items-center gap-3.5">
                    <div class="w-9 h-9 rounded-xl bg-blue-50 text-[#102b70] flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-800 group-hover:text-[#102b70] transition-colors">Two-step Verification</p>
                        <p class="text-[10px] font-medium text-slate-400">Add an extra layer of security</p>
                    </div>
                </div>
                <svg class="w-4 h-4 text-slate-400 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" /></svg>
            </button>

            <!-- Email Verification -->
            <div class="flex items-center justify-between p-3.5 rounded-xl border border-slate-100">
                <div class="flex items-center gap-3.5">
                    <div class="w-9 h-9 rounded-xl bg-blue-50 text-[#102b70] flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-800">Email Verification</p>
                        <p class="text-[10px] font-medium text-slate-400">Verify your email address</p>
                    </div>
                </div>
                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase bg-emerald-50 text-emerald-700 border border-emerald-100">Verified</span>
            </div>

            <!-- Active Sessions -->
            <button type="button" onclick="alert('Active Sessions: 1 active browser session on Windows desktop.')" class="w-full flex items-center justify-between p-3.5 rounded-xl hover:bg-slate-50 border border-slate-100 transition-colors group text-left">
                <div class="flex items-center gap-3.5">
                    <div class="w-9 h-9 rounded-xl bg-blue-50 text-[#102b70] flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-800 group-hover:text-[#102b70] transition-colors">Active Sessions</p>
                        <p class="text-[10px] font-medium text-slate-400">Manage your active sessions • <span class="text-blue-700 font-bold">1 active session</span></p>
                    </div>
                </div>
                <svg class="w-4 h-4 text-slate-400 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" /></svg>
            </button>
        </div>

        <div class="text-center pt-2">
            <span class="text-[10px] font-semibold text-slate-400">Version 1.0.0</span>
        </div>
    </div>

    <!-- Change Password Modal -->
    <dialog id="changePasswordModal" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box w-[calc(100%-1rem)] max-w-md bg-white p-6 rounded-2xl relative shadow-xl border border-slate-100">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-3 top-3 text-slate-400 hover:bg-slate-100" onclick="changePasswordModal.close()">✕</button>
            
            <h3 class="font-extrabold text-lg text-slate-900 mb-1">{{ $hasPassword ? 'Change Password' : 'Add Password' }}</h3>
            <p class="text-xs text-slate-500 mb-4">{{ $hasPassword ? 'Update your password to keep your account secure.' : 'Create a password to sign in using your email or Student ID.' }}</p>

            @if(!$hasPassword)
                <div class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded-xl text-xs font-semibold text-blue-900 flex items-start gap-2">
                    <svg class="w-4 h-4 text-blue-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span>You currently sign in using Google. Adding a password allows you to log in with your Student ID or email as well.</span>
                </div>
            @endif

            <form id="change-password-form" action="{{ route('student.account-settings.password') }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                @if($hasPassword)
                    <div>
                        <label for="modal_current_password" class="block text-xs font-bold text-slate-700 mb-1">Current Password</label>
                        <input type="password" id="modal_current_password" name="current_password" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 focus:bg-white focus:border-[#102b70] outline-none" required>
                        <p id="error-current_password" class="text-red-500 text-xs mt-1 hidden"></p>
                    </div>
                @endif

                <div>
                    <label for="modal_password" class="block text-xs font-bold text-slate-700 mb-1">New Password</label>
                    <input type="password" id="modal_password" name="password" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 focus:bg-white focus:border-[#102b70] outline-none" required>
                    <p id="error-password" class="text-red-500 text-xs mt-1 hidden"></p>
                </div>

                <div>
                    <label for="modal_password_confirmation" class="block text-xs font-bold text-slate-700 mb-1">Confirm New Password</label>
                    <input type="password" id="modal_password_confirmation" name="password_confirmation" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 focus:bg-white focus:border-[#102b70] outline-none" required>
                </div>

                <div class="pt-2 flex gap-3">
                    <button type="button" class="w-1/2 py-2.5 border border-slate-200 hover:bg-slate-50 text-slate-700 font-bold text-xs rounded-xl transition-all" onclick="changePasswordModal.close()">Cancel</button>
                    <button type="submit" id="btn-save-password" class="w-1/2 py-2.5 bg-[#102b70] hover:bg-[#0b225e] text-white font-bold text-xs rounded-xl transition-all shadow-sm">
                        {{ $hasPassword ? 'Update Password' : 'Add Password' }}
                    </button>
                </div>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop"><button>close</button></form>
    </dialog>

    @push('scripts')
    <script>
        function copyUsername() {
            const username = document.getElementById('username-text').textContent;
            navigator.clipboard.writeText(username).then(() => {
                alert('Username copied to clipboard!');
            });
        }

        document.getElementById('change-password-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            const btn = document.getElementById('btn-save-password');
            btn.disabled = true;
            btn.innerHTML = '<span class="loading loading-spinner loading-xs"></span> Updating...';

            const formData = new FormData(this);

            try {
                const response = await fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    },
                    body: formData
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    alert(data.message || 'Password updated successfully!');
                    window.location.reload();
                } else if (response.status === 422 && data.errors) {
                    for (const [key, messages] of Object.entries(data.errors)) {
                        const errorEl = document.getElementById(`error-${key}`);
                        if (errorEl) {
                            errorEl.textContent = messages[0];
                            errorEl.classList.remove('hidden');
                        }
                    }
                } else {
                    alert(data.message || 'Failed to update password.');
                }
            } catch (err) {
                alert('Network error occurred.');
            } finally {
                btn.disabled = false;
                btn.innerHTML = 'Update Password';
            }
        });
    </script>
    @endpush
</x-layout.student>
