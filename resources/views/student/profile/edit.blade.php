<x-layout.student title="Edit Profile">
    <div class="max-w-2xl mx-auto">
        <div class="mb-6 flex items-center justify-between">
            <a href="{{ route('student.profile.show') }}" class="inline-flex items-center gap-1 text-sm font-semibold text-gray-500 hover:text-primary transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Profile
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 md:p-8">
                <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Profile</h1>

                <form action="{{ route('student.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label for="first_name" class="block text-sm font-semibold text-gray-700 mb-1.5">First Name</label>
                                <input type="text" id="first_name" name="first_name" value="{{ old('first_name', $member->first_name) }}" class="input input-bordered w-full focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all rounded-xl" required>
                                @error('first_name')
                                    <p class="text-error text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="last_name" class="block text-sm font-semibold text-gray-700 mb-1.5">Last Name</label>
                                <input type="text" id="last_name" name="last_name" value="{{ old('last_name', $member->last_name) }}" class="input input-bordered w-full focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all rounded-xl" required>
                                @error('last_name')
                                    <p class="text-error text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">Email Address</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $member->email) }}" class="input input-bordered w-full focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all rounded-xl" required>
                            @error('email')
                                <p class="text-error text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="contact_num" class="block text-sm font-semibold text-gray-700 mb-1.5">Phone Number</label>
                            <input type="text" id="contact_num" name="contact_num" value="{{ old('contact_num', $member->contact_num) }}" class="input input-bordered w-full focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all rounded-xl">
                            @error('contact_num')
                                <p class="text-error text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="pt-6 border-t border-gray-100 flex justify-end gap-3">
                            <a href="{{ route('student.profile.show') }}" class="btn btn-ghost">Cancel</a>
                            <button type="submit" class="btn btn-primary px-8">Save Changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout.student>
