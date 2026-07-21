<x-layout.adminLogin
    title="Link Google Account"
    portal="Account Verification"
    form-side="left"
    access-label="Secure Account Linking"
    headline="Connect your,"
    highlight="Google Account."
    description="Verify your existing account credentials to safely link Google authentication to your profile."
    :features="['Verify', 'Link', 'Access']"
>
    <div class="w-full max-w-md bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 shadow-xs">
        <h2 class="text-xl font-extrabold text-[#102b70] mb-2">Verify Password</h2>
        <p class="text-xs font-semibold text-slate-500 mb-6 leading-relaxed">
            An account with the email <strong class="text-slate-800">{{ $email }}</strong> already exists. 
            Enter your password to authorize linking your Google account.
        </p>

        <form action="{{ route('auth.google.link.submit') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="password" class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wide">Password</label>
                <input type="password" name="password" id="password" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:border-[#102b70] focus:ring-2 focus:ring-[#102b70]/20 outline-none text-slate-900 transition-all placeholder:text-slate-400">
                @error('password')
                    <span class="text-xs text-rose-500 font-bold mt-1.5 block">{{ $message }}</span>
                @enderror
            </div>
            
            <button type="submit" class="w-full py-2.5 bg-[#102b70] hover:bg-[#0b225e] text-white font-bold text-sm rounded-xl shadow-md transition-all">
                Verify & Link Google
            </button>
        </form>
    </div>
</x-layout.adminLogin>
