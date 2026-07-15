<x-layout.student title="My Profile">
    <div class="max-w-4xl mx-auto">
        <x-student.page-header 
            title="My Profile" 
            subtitle="Manage your personal information." 
        />

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-8">
                <div class="flex flex-col sm:flex-row items-center gap-6 mb-8 pb-8 border-b border-gray-100">
                    <div class="avatar {{ !Auth::guard('member')->user()->profile_image ? 'placeholder' : '' }}">
                        <div class="{{ !Auth::guard('member')->user()->profile_image ? 'bg-primary/10 text-primary' : '' }} rounded-full w-24 h-24 text-2xl font-bold border-4 border-white shadow-sm overflow-hidden">
                            @if(Auth::guard('member')->user()->profile_image)
                                <img src="{{ Auth::guard('member')->user()->profile_image }}" alt="Profile Image" class="w-full h-full object-cover" />
                            @else
                                <span>{{ substr($member->first_name, 0, 1) }}{{ substr($member->last_name, 0, 1) }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="text-center sm:text-left">
                        <h2 class="text-2xl font-bold text-gray-800">{{ $member->first_name }} {{ $member->last_name }}</h2>
                        <p class="text-gray-500 font-medium">Student</p>
                        <p class="text-sm text-gray-400 mt-1">Member since {{ $member->created_at->format('M d, Y') }}</p>
                    </div>
                    <div class="sm:ml-auto">
                        <a href="{{ route('student.profile.edit') }}" class="btn btn-primary">Edit Profile</a>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-6 gap-x-8">
                    <div>
                        <h4 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">First Name</h4>
                        <p class="text-gray-800 font-medium">{{ $member->first_name }}</p>
                    </div>
                    <div>
                        <h4 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Last Name</h4>
                        <p class="text-gray-800 font-medium">{{ $member->last_name }}</p>
                    </div>
                    <div>
                        <h4 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Email Address</h4>
                        <p class="text-gray-800 font-medium">{{ $member->email }}</p>
                    </div>
                    <div>
                        <h4 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Phone Number</h4>
                        <p class="text-gray-800 font-medium">{{ $member->contact_num ?? 'Not provided' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout.student>
