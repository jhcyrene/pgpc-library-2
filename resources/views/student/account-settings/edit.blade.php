<x-layout.student title="Account Settings">
    <div class="max-w-2xl mx-auto">
        <x-student.page-header 
            title="Account Settings" 
            subtitle="Manage your password and security settings." 
        />

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
            <div class="p-6 md:p-8">
                <h3 class="text-lg font-bold text-gray-800 mb-6 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    Change Password
                </h3>

                <form action="{{ route('student.account-settings.password') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="space-y-5">
                        <div>
                            <label for="current_password" class="block text-sm font-semibold text-gray-700 mb-1.5">Current Password</label>
                            <input type="password" id="current_password" name="current_password" class="input input-bordered w-full focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all rounded-xl" required>
                            @error('current_password')
                                <p class="text-error text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-semibold text-gray-700 mb-1.5">New Password</label>
                            <input type="password" id="password" name="password" class="input input-bordered w-full focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all rounded-xl" required>
                            @error('password')
                                <p class="text-error text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1.5">Confirm New Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="input input-bordered w-full focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all rounded-xl" required>
                        </div>

                        <div class="pt-4 flex justify-end">
                            <button type="submit" class="btn btn-primary px-8">Update Password</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout.student>
