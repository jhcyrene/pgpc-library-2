@props([
    'role' => 'Staff',
    'description' => 'Sign in to continue to your secure workspace.',
    'action',
    'buttonLabel' => 'Sign in securely',
])

<div>
    <div class="mb-8">
        <p class="mb-3 text-xs font-bold uppercase tracking-[0.2em] text-[#102b70]">{{ $role }} access</p>
        <h2 class="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">Welcome back</h2>
        <p class="mt-3 leading-7 text-slate-500">{{ $description }}</p>
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

    <form action="{{ $action }}" method="POST" class="space-y-5" data-ajax-form>
        @csrf

        <div>
            <label for="login" class="mb-2 block text-sm font-bold text-slate-700">Username</label>
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
                    autofocus
                    autocomplete="username"
                    placeholder="Enter your staff username"
                    class="h-14 w-full rounded-2xl border border-slate-200 bg-white pl-12 pr-4 text-base sm:text-sm text-slate-900 outline-none transition placeholder:text-slate-400 hover:border-slate-300 focus:border-[#102b70] focus:ring-4 focus:ring-blue-100"
                >
            </div>
            <p data-error-for="login" class="mt-1.5 text-xs font-medium text-red-600 hidden"></p>
        </div>

        <div>
            <div class="mb-2 flex items-center justify-between">
                <label for="password" class="block text-sm font-bold text-slate-700">Password</label>
                <span class="text-xs font-medium text-slate-400">Case-sensitive</span>
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
                    data-password-toggle
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
            {{ $buttonLabel }}
            <svg class="h-5 w-5 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
            </svg>
        </button>
    </form>

    <div class="mt-8 border-t border-slate-200 pt-6 text-center">
        <p class="text-sm text-slate-500">
            Student or library member?
            <a href="{{ route('login') }}" class="ml-1 font-bold text-[#102b70] underline decoration-[#fcc719] decoration-2 underline-offset-4 transition hover:text-blue-800">
                Go to student login
            </a>
        </p>
        <p class="mt-5 text-xs leading-5 text-slate-400">
            Having trouble signing in? Contact the system administrator.
        </p>
    </div>
</div>

@once
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('[data-password-toggle]').forEach((button) => {
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
@endonce
