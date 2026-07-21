<div>
    <!-- Back to login link -->
    <div class="mb-6">
        <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-600 hover:text-[#102b70] transition-colors">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to login
        </a>
    </div>

    <!-- Header / Title -->
    <div class="mb-6">
        <p class="mb-2 text-[11px] font-extrabold uppercase tracking-[0.18em] text-[#102b70]">STUDENT ACCESS</p>
        <h2 class="text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">Forgot Password</h2>
        <p class="mt-2 text-xs sm:text-sm font-medium text-slate-500 leading-relaxed">
            Enter your student email address and we'll send a six-digit verification code to reset your password.
        </p>
    </div>

    @if (session('status'))
        <x-alert type="success" message="{{ session('status') }}" class="mb-6" />
    @endif

    <form action="{{ route('forgot-password.send') }}" method="POST" class="space-y-5">
        @csrf

        <!-- Email Field -->
        <div>
            <label for="email" class="mb-2 block text-xs font-bold text-slate-800">Student Email Address</label>
            <div class="group relative">
                <svg class="pointer-events-none absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400 transition group-focus-within:text-[#102b70]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                <input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email') }}"
                    required
                    autocomplete="email"
                    placeholder="student@pgpc.edu.ph"
                    class="h-13 w-full rounded-2xl border border-slate-200 bg-white pl-12 pr-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 hover:border-slate-300 focus:border-[#102b70] focus:ring-4 focus:ring-blue-100"
                />
            </div>
            @error('email')
                <p class="mt-1.5 text-xs font-medium text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit Button -->
        <div>
            <button
                type="submit"
                class="w-full h-13 rounded-2xl bg-[#0a1b42] hover:bg-[#071330] text-white font-bold text-sm shadow-md transition-all active:scale-[0.99] flex items-center justify-center gap-2"
            >
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9-7-9-7-9 7 9 7zm0 0v-8" />
                </svg>
                <span>Send Verification Code</span>
            </button>
        </div>
    </form>

    <!-- Or Divider -->
    <div class="my-5 flex items-center gap-3">
        <div class="h-px flex-1 bg-slate-200"></div>
        <span class="text-[10px] font-bold uppercase text-slate-400">or</span>
        <div class="h-px flex-1 bg-slate-200"></div>
    </div>

    <!-- Back to Login Link -->
    <div class="text-center">
        <span class="text-xs font-medium text-slate-500">Remember your password?</span>
        <a href="{{ route('login') }}" class="ml-1 text-xs font-bold text-[#102b70] hover:underline inline-flex items-center gap-0.5">
            <span>Back to login</span>
            <svg class="w-3.5 h-3.5 text-[#102b70]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" /></svg>
        </a>
    </div>

    <!-- Info Alert Box -->
    <div class="mt-6 rounded-2xl border border-slate-200/80 bg-slate-100/80 p-3.5 flex items-center gap-3">
        <div class="w-6 h-6 rounded-full bg-slate-200 text-slate-600 flex items-center justify-center shrink-0 font-bold text-xs">
            i
        </div>
        <p class="text-xs font-medium text-slate-600 leading-snug">
            Only registered student email accounts can receive a reset code.
        </p>
    </div>
</div>
