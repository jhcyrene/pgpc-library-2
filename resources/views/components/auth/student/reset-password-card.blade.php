<div class="relative z-20 w-full max-w-md px-6 py-12 flex flex-col">
    <a href="{{ route('home') }}" class="md:hidden flex items-center gap-2 text-white/90 hover:text-white transition-colors self-start mb-6 font-medium">
        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
        Back to Home
    </a>

    <div class="bg-white rounded-3xl shadow-elegant p-8 md:p-10">
        <div class="flex justify-center mb-6">
            <div class="w-16 h-16 rounded-full bg-blue-50 flex items-center justify-center text-primary shadow-soft">
                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
            </div>
        </div>

        <div class="text-center mb-8">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">Create a new password</h2>
            <p class="text-gray-500 text-sm">Use at least eight characters with both letters and numbers.</p>
        </div>

        <form action="{{ route('forgot-password.update') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label for="password" class="block text-sm font-semibold text-gray-700 mb-1.5">New Password</label>
                <input id="password" type="password" name="password" required autocomplete="new-password"
                       class="w-full px-4 py-3 bg-gray-50 border {{ $errors->has('password') ? 'border-red-400' : 'border-gray-200' }} rounded-xl text-gray-800 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all">
                @error('password')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1.5">Confirm New Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                       class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-800 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all">
            </div>

            <button type="submit" class="w-full bg-primary text-white hover:bg-primaryfade py-3.5 rounded-full font-bold shadow-soft hover:shadow-elegant transform transition-all hover:-translate-y-0.5">
                Save New Password
            </button>
        </form>
    </div>
</div>
