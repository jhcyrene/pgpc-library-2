<div>
    <div class="mb-8">
        <p class="mb-3 text-xs font-bold uppercase tracking-[0.2em] text-[#102b70]">Student access</p>
        <h2 class="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">Welcome back</h2>
        <p class="mt-3 leading-7 text-slate-500">Sign in to access your personal library account.</p>
    </div>

    <div id="ajax-general-error" role="alert" class="mb-6 flex gap-3 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-700 @if(!$errors->any()) hidden @endif">
        <svg class="mt-0.5 h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M5.07 19h13.86a2 2 0 001.74-3l-6.93-12a2 2 0 00-3.48 0L3.33 16a2 2 0 001.74 3z" />
        </svg>
        <div>
            <p class="font-bold">We couldn't sign you in.</p>
            <p class="mt-0.5" data-alert-message>{{ $errors->first() }}</p>
        </div>
    </div>

    @if (session('success'))
        <x-alert type="success" message="{{ session('success') }}" class="mb-6" />
    @endif

    <form action="{{ route('login.store') }}" method="POST" class="space-y-5" data-ajax-form>
        @csrf

        <div>
            <label for="login" class="mb-2 block text-sm font-bold text-slate-700">Username or Student ID <span class="text-red-500">*</span></label>
            <div class="group relative">
                <svg class="pointer-events-none absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400 transition group-focus-within:text-[#102b70]" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM4 21a8 8 0 0116 0" />
                </svg>
                <input
                    id="login"
                    name="login"
                    type="text"
                    value="{{ old('login') }}"
                    required
                    autocomplete="username"
                    placeholder="Enter username or student ID"
                    class="h-14 w-full rounded-2xl border border-slate-200 bg-white pl-12 pr-4 text-base sm:text-sm text-slate-900 outline-none transition placeholder:text-slate-400 hover:border-slate-300 focus:border-[#102b70] focus:ring-4 focus:ring-blue-100"
                >
            </div>
            <p data-error-for="login" class="mt-1.5 text-xs font-medium text-red-600 hidden"></p>
        </div>

        <div>
            <div class="mb-2 flex items-center justify-between">
                <label for="password" class="block text-sm font-bold text-slate-700">Password <span class="text-red-500">*</span></label>
                <a href="{{ route('forgot-password') }}" class="text-sm font-bold text-[#102b70] transition hover:text-blue-800">Forgot password?</a>
            </div>
            <div class="group relative">
                <svg class="pointer-events-none absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400 transition group-focus-within:text-[#102b70]" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 15v2m-6 4h12a2 2 0 002-2v-7a2 2 0 00-2-2H6a2 2 0 00-2 2v7a2 2 0 002 2zm10-11V7a4 4 0 00-8 0v3h8z" />
                </svg>
                <input
                    id="password"
                    name="password"
                    type="password"
                    required
                    autocomplete="current-password"
                    placeholder="Enter your password"
                    class="h-14 w-full rounded-2xl border border-slate-200 bg-white pl-12 pr-14 text-base sm:text-sm text-slate-900 outline-none transition placeholder:text-slate-400 hover:border-slate-300 focus:border-[#102b70] focus:ring-4 focus:ring-blue-100"
                >
                <button
                    type="button"
                    data-student-password-toggle
                    aria-label="Show password"
                    class="absolute right-2 top-1/2 grid h-10 w-10 -translate-y-1/2 place-items-center rounded-xl text-slate-400 transition hover:bg-slate-100 hover:text-[#102b70] focus:outline-none focus:ring-2 focus:ring-blue-200"
                >
                    <svg data-eye-open class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.46 12C3.73 7.94 7.52 5 12 5c4.48 0 8.27 2.94 9.54 7-1.27 4.06-5.06 7-9.54 7-4.48 0-8.27-2.94-9.54-7z" />
                    </svg>
                    <svg data-eye-closed class="hidden h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 3l18 18M10.6 10.6a2 2 0 002.8 2.8M9.9 4.2A10.5 10.5 0 0112 4c4.48 0 8.27 2.94 9.54 8a11.8 11.8 0 01-2.1 3.8M6.2 6.2A11.7 11.7 0 002.46 12C3.73 17.06 7.52 20 12 20a10.5 10.5 0 004.1-.8" />
                    </svg>
                </button>
            </div>
            <p data-error-for="password" class="mt-1.5 text-xs font-medium text-red-600 hidden"></p>
        </div>

        <label class="inline-flex cursor-pointer items-center gap-3 text-sm text-slate-600">
            <input type="checkbox" name="remember" value="1" class="h-4 w-4 rounded border-slate-300 text-[#102b70] focus:ring-[#102b70]">
            Keep me signed in on this device
        </label>

        <button type="submit" class="group flex h-14 w-full items-center justify-center gap-2 rounded-2xl bg-[#102b70] px-5 font-bold text-white shadow-lg shadow-blue-900/15 transition hover:-translate-y-0.5 hover:bg-[#0b225e] hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-blue-200 active:translate-y-0">
            Sign in to your account
            <svg class="h-5 w-5 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
            </svg>
        </button>
    </form>

    <!-- Social Sign In Divider -->
    <div class="relative my-6">
        <div class="absolute inset-0 flex items-center" aria-hidden="true">
            <div class="w-full border-t border-slate-200"></div>
        </div>
        <div class="relative flex justify-center text-xs uppercase font-extrabold tracking-wide">
            <span class="bg-white px-4 text-slate-400">Or continue with</span>
        </div>
    </div>

    <!-- Google Login Button -->
    <div class="mb-2">
        <a href="{{ route('auth.google') }}" class="w-full flex items-center justify-center gap-2.5 py-3 border border-slate-200 hover:bg-slate-50 transition-colors rounded-2xl text-sm font-bold text-slate-700 bg-white shadow-xs">
            <svg class="h-5 w-5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z" fill="#FBBC05"/>
                <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z" fill="#EA4335"/>
            </svg>
            Log in with Google
        </a>
    </div>

    <div class="mt-8 border-t border-slate-200 pt-6 text-center">
        <p class="text-sm text-slate-500">
            New to the PGPC Library?
            <a href="{{ route('register') }}" class="ml-1 font-bold text-[#102b70] underline decoration-[#fcc719] decoration-2 underline-offset-4 transition hover:text-blue-800">
                Create an account
            </a>
        </p>
        <p class="mt-5 text-xs text-slate-400">
            Library employee?
            <a href="{{ route('staff.login') }}" class="ml-1 font-semibold text-slate-500 hover:text-[#102b70]">Staff login</a>
        </p>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('[data-student-password-toggle]').forEach((button) => {
            button.addEventListener('click', () => {
                const input = button.closest('.relative').querySelector('input');
                const showing = input.type === 'text';
                input.type = showing ? 'password' : 'text';
                button.setAttribute('aria-label', showing ? 'Show password' : 'Hide password');
                button.querySelector('[data-eye-open]').classList.toggle('hidden', !showing);
                button.querySelector('[data-eye-closed]').classList.toggle('hidden', showing);
            });
        });
    });
</script>
