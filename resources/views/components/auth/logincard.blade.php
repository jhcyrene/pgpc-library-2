<div class="relative z-20 w-full max-w-md px-6 py-12 flex flex-col">
    <!-- Mobile Back to Home -->
    <a href="/"
        class="md:hidden flex items-center gap-2 text-white/90 hover:text-white transition-colors self-start mb-6 font-medium">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Back to Homes
    </a>

    <div class="bg-white rounded-3xl shadow-elegant p-8 md:p-10 transform transition-all">

        <!-- Logo -->
        <div class="flex justify-center mb-6">
            <div class="w-16 h-16 rounded-full bg-gray-50 flex items-center justify-center overflow-hidden shadow-soft">
                <img src="{{ Vite::asset('resources/images/hd-pgpc-logo.png') }}" alt="PGPC Logo" class="w-full h-full object-cover"
                    onerror="this.src='https://ui-avatars.com/api/?name=PG&background=fcc719&color=212e5e'" />
            </div>
        </div>

        <!-- Header -->
        <div class="text-center mb-8">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">Welcome back</h2>
            <p class="text-gray-500 text-sm">Sign in to access your library account</p>
        </div>

        <!-- Form -->
        <form action="#" method="POST" class="space-y-5">
            @csrf

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">Email Address</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                        </svg>
                    </div>
                    <input id="email" type="email" name="email" required autofocus
                        placeholder="student@pgpc.edu.ph"
                        class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-800 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all placeholder:text-gray-400" />
                </div>
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-semibold text-gray-700 mb-1.5">Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <input id="password" type="password" name="password" required placeholder="••••••••"
                        class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-800 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all placeholder:text-gray-400" />
                </div>
            </div>

            <!-- Remember & Forgot -->
            <div class="flex items-center justify-between pt-2">
                <label class="flex items-center gap-2 cursor-pointer group">
                    <input type="checkbox"
                        class="checkbox checkbox-sm rounded border-gray-300 checked:bg-primary checked:border-primary group-hover:border-primary transition-colors" />
                    <span class="text-sm text-gray-600 select-none">Remember me</span>
                </label>
                <a href="/forgot-password"
                    class="text-sm font-semibold text-primary hover:text-primary transition-colors">Forgot
                    password?</a>
            </div>

            <!-- Submit Button -->
            <div class="pt-2">
                <button type="submit"
                    class="w-full bg-primary text-white hover:bg-primaryfade py-3.5 rounded-full font-bold shadow-soft hover:shadow-elegant transform transition-all hover:-translate-y-0.5">
                    Sign In
                </button>
            </div>
        </form>

        <!-- Footer -->
        <div class="mt-8 pt-6 border-t border-gray-100 text-center">
            <p class="text-sm text-gray-600">
                Don't have an account?
                <a href="/student/register"
                    class="font-bold text-primary hover:text-gold transition-colors ml-1">Register
                    now</a>
            </p>
        </div>
    </div>
</div>
