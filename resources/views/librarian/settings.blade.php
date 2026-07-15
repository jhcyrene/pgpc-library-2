<x-layout.admin title="Settings">
    <div class="flex-1 flex flex-col min-h-0 h-full p-6 bg-gray-50/50">

        <x-admin.page-header
            title="Settings"
            description="Manage your profile and account security."
        />

        @if(session('success'))
            <div class="mb-6 flex items-center gap-3 rounded-2xl border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-700">
                <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

            {{-- ─── LEFT: Avatar / Identity Card ──────────────────── --}}
            <div class="xl:col-span-1">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 flex flex-col items-center text-center gap-4">
                    {{-- Avatar --}}
                    <div class="w-24 h-24 rounded-full bg-[#fcc719] flex items-center justify-center text-[#102b70] text-3xl font-black shadow-md overflow-hidden shrink-0">
                        @if($staffAccount?->profile_image)
                            <img src="{{ $staffAccount->profile_image }}" alt="Profile photo" class="w-full h-full object-cover">
                        @else
                            {{ strtoupper(substr($librarian?->first_name ?? 'L', 0, 1) . substr($librarian?->last_name ?? 'U', 0, 1)) }}
                        @endif
                    </div>

                    <div>
                        <p class="text-xl font-bold text-gray-900">
                            {{ trim(($librarian?->first_name ?? '') . ' ' . ($librarian?->last_name ?? '')) ?: 'Staff User' }}
                        </p>
                        <p class="text-sm text-gray-500 mt-0.5">{{ $librarian?->position ?? '—' }}</p>
                        <span class="mt-2 inline-block px-3 py-0.5 rounded-full bg-blue-100 text-blue-700 text-xs font-bold uppercase tracking-wide">
                            {{ ucfirst($staffAccount?->account_type ?? 'Librarian') }}
                        </span>
                    </div>

                    <div class="w-full border-t border-gray-100 pt-4 space-y-2 text-left text-sm text-gray-600">
                        <div class="flex items-center gap-2">
                            <svg class="h-4 w-4 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                            <span class="truncate">{{ $librarian?->email ?? '—' }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="h-4 w-4 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" /></svg>
                            <span>{{ $staffAccount?->username ?? '—' }}</span>
                        </div>
                        @if($librarian?->employee_number)
                        <div class="flex items-center gap-2">
                            <svg class="h-4 w-4 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" /></svg>
                            <span>{{ $librarian->employee_number }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- ─── RIGHT: Edit Forms ───────────────────────────────── --}}
            <div class="xl:col-span-2 space-y-6">

                {{-- Profile Information --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                        <h2 class="text-base font-bold text-gray-900">Profile Information</h2>
                        <p class="text-xs text-gray-500 mt-0.5">Update your personal details.</p>
                    </div>

                    <form action="{{ route('librarian.settings.profile') }}" method="POST" class="p-6 space-y-5">
                        @csrf
                        @method('PUT')

                        {{-- Name row --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="first_name" class="block text-sm font-semibold text-gray-700 mb-1.5">First Name <span class="text-red-500">*</span></label>
                                <input id="first_name" name="first_name" type="text" required
                                    value="{{ old('first_name', $librarian?->first_name) }}"
                                    class="input input-bordered w-full h-10 text-sm shadow-sm bg-white focus:border-blue-500 @error('first_name') border-red-400 @enderror">
                                @error('first_name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="last_name" class="block text-sm font-semibold text-gray-700 mb-1.5">Last Name <span class="text-red-500">*</span></label>
                                <input id="last_name" name="last_name" type="text" required
                                    value="{{ old('last_name', $librarian?->last_name) }}"
                                    class="input input-bordered w-full h-10 text-sm shadow-sm bg-white focus:border-blue-500 @error('last_name') border-red-400 @enderror">
                                @error('last_name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div>
                            <label for="middle_name" class="block text-sm font-semibold text-gray-700 mb-1.5">Middle Name <span class="text-xs font-normal text-gray-400">(optional)</span></label>
                            <input id="middle_name" name="middle_name" type="text"
                                value="{{ old('middle_name', $librarian?->middle_name) }}"
                                class="input input-bordered w-full h-10 text-sm shadow-sm bg-white focus:border-blue-500">
                        </div>

                        {{-- Email & Position --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">Email Address <span class="text-red-500">*</span></label>
                                <input id="email" name="email" type="email" required
                                    value="{{ old('email', $librarian?->email) }}"
                                    class="input input-bordered w-full h-10 text-sm shadow-sm bg-white focus:border-blue-500 @error('email') border-red-400 @enderror">
                                @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="position" class="block text-sm font-semibold text-gray-700 mb-1.5">Position <span class="text-xs font-normal text-gray-400">(optional)</span></label>
                                <input id="position" name="position" type="text"
                                    value="{{ old('position', $librarian?->position) }}"
                                    placeholder="e.g. Head Librarian"
                                    class="input input-bordered w-full h-10 text-sm shadow-sm bg-white focus:border-blue-500">
                            </div>
                        </div>

                        <div class="pt-2 flex justify-end">
                            <button type="submit"
                                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-[#102b70] text-white text-sm font-bold shadow-sm hover:bg-[#0b225e] transition-colors focus:outline-none focus:ring-4 focus:ring-blue-200">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                Save Profile
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Change Password --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                        <h2 class="text-base font-bold text-gray-900">Change Password</h2>
                        <p class="text-xs text-gray-500 mt-0.5">Ensure your account uses a strong password.</p>
                    </div>

                    <form action="{{ route('librarian.settings.password') }}" method="POST" class="p-6 space-y-5">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="current_password" class="block text-sm font-semibold text-gray-700 mb-1.5">Current Password <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <input id="current_password" name="current_password" type="password" required autocomplete="current-password"
                                    class="input input-bordered w-full h-10 text-sm shadow-sm bg-white pr-11 focus:border-blue-500 @error('current_password') border-red-400 @enderror">
                                <button type="button" data-pwd-toggle="current_password" class="absolute right-2 top-1/2 -translate-y-1/2 grid h-7 w-7 place-items-center rounded-lg text-gray-400 hover:text-gray-700 hover:bg-gray-100 transition-colors">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.46 12C3.73 7.94 7.52 5 12 5c4.48 0 8.27 2.94 9.54 7-1.27 4.06-5.06 7-9.54 7-4.48 0-8.27-2.94-9.54-7z"/></svg>
                                </button>
                            </div>
                            @error('current_password') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="password" class="block text-sm font-semibold text-gray-700 mb-1.5">New Password <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <input id="password" name="password" type="password" required autocomplete="new-password"
                                        placeholder="At least 8 characters"
                                        class="input input-bordered w-full h-10 text-sm shadow-sm bg-white pr-11 focus:border-blue-500 @error('password') border-red-400 @enderror">
                                    <button type="button" data-pwd-toggle="password" class="absolute right-2 top-1/2 -translate-y-1/2 grid h-7 w-7 place-items-center rounded-lg text-gray-400 hover:text-gray-700 hover:bg-gray-100 transition-colors">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.46 12C3.73 7.94 7.52 5 12 5c4.48 0 8.27 2.94 9.54 7-1.27 4.06-5.06 7-9.54 7-4.48 0-8.27-2.94-9.54-7z"/></svg>
                                    </button>
                                </div>
                                @error('password') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1.5">Confirm Password <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"
                                        placeholder="Repeat new password"
                                        class="input input-bordered w-full h-10 text-sm shadow-sm bg-white pr-11 focus:border-blue-500">
                                    <button type="button" data-pwd-toggle="password_confirmation" class="absolute right-2 top-1/2 -translate-y-1/2 grid h-7 w-7 place-items-center rounded-lg text-gray-400 hover:text-gray-700 hover:bg-gray-100 transition-colors">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.46 12C3.73 7.94 7.52 5 12 5c4.48 0 8.27 2.94 9.54 7-1.27 4.06-5.06 7-9.54 7-4.48 0-8.27-2.94-9.54-7z"/></svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="pt-2 flex justify-end">
                            <button type="submit"
                                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-[#102b70] text-white text-sm font-bold shadow-sm hover:bg-[#0b225e] transition-colors focus:outline-none focus:ring-4 focus:ring-blue-200">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                                Update Password
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    {{-- Password toggle script --}}
    <script>
        document.querySelectorAll('[data-pwd-toggle]').forEach(btn => {
            btn.addEventListener('click', () => {
                const input = document.getElementById(btn.dataset.pwdToggle);
                input.type = input.type === 'password' ? 'text' : 'password';
            });
        });
    </script>
</x-layout.admin>
