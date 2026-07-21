@php
    $memberAuth = Auth::guard('member')->user();
    $member = $memberAuth->member;
@endphp

<x-layout.student title="Edit Profile">
    <div class="max-w-6xl mx-auto space-y-6 pb-12 font-sans select-none">
        
        <!-- Header & Breadcrumbs (Matching Mockup) -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <nav class="flex text-xs text-slate-400 font-semibold mb-1" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 sm:space-x-2">
                        <li><a href="{{ route('student.dashboard') }}" class="hover:text-[#102b70] transition-colors">Home</a></li>
                        <li><span class="mx-1 text-slate-300">&gt;</span></li>
                        <li><a href="{{ route('student.profile.show') }}" class="hover:text-[#102b70] transition-colors">Profile</a></li>
                        <li><span class="mx-1 text-slate-300">&gt;</span></li>
                        <li class="text-slate-700 font-bold">Edit Profile</li>
                    </ol>
                </nav>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Edit Profile</h1>
                <p class="text-xs text-slate-500 font-medium mt-0.5">Update your personal information, account details, and security settings.</p>
            </div>
        </div>

        <form id="edit-profile-main-form" action="{{ route('student.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Hidden Inputs for Base64 Profile Photo & Image Removal -->
            <input type="hidden" id="profile_image_base64" name="profile_image_base64" value="">
            <input type="hidden" id="remove_profile_image" name="remove_profile_image" value="0">

            <!-- MAIN GRID LAYOUT (Desktop 3-column/2-column hybrid matching Mockup) -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

                <!-- CARD 1: PROFILE PHOTO (Left Column on Desktop) -->
                <div class="lg:col-span-4 bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 flex flex-col items-center justify-between text-center space-y-6">
                    <div class="w-full">
                        <div class="flex items-center gap-2 pb-4 border-b border-slate-100 text-slate-800">
                            <svg class="w-4.5 h-4.5 text-[#102b70]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-900">Profile Photo</h3>
                        </div>

                        <div class="mt-6 flex flex-col items-center">
                            <!-- Avatar Preview Container -->
                            <div class="relative group">
                                <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-slate-50 shadow-md bg-[#102b70] text-[#fcc719] flex items-center justify-center relative">
                                    @if($memberAuth->profile_image)
                                        <img id="avatar-preview-img" src="{{ $memberAuth->profile_image }}" alt="Profile Photo" class="w-full h-full object-cover" />
                                    @else
                                        <span id="avatar-preview-initials" class="text-4xl font-black uppercase">{{ substr($member->first_name, 0, 1) }}{{ substr($member->last_name, 0, 1) }}</span>
                                        <img id="avatar-preview-img" src="" alt="Profile Photo" class="w-full h-full object-cover hidden" />
                                    @endif
                                </div>
                                
                                <button type="button" onclick="document.getElementById('file-upload-input').click()" class="absolute bottom-1 right-1 bg-[#102b70] text-white p-2.5 rounded-full shadow-lg hover:bg-[#071943] transition-all border-2 border-white">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                </button>
                            </div>

                            <input type="file" id="file-upload-input" accept="image/jpeg,image/png,image/webp" class="hidden" onchange="handleImageSelection(event)">

                            <div class="mt-4 space-y-2 w-full">
                                <button type="button" onclick="document.getElementById('file-upload-input').click()" class="w-full px-3.5 py-1.5 text-xs border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all inline-flex items-center justify-center gap-1.5">
                                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" /></svg>
                                    Change Photo
                                </button>
                                
                                @if($memberAuth->profile_image)
                                    <button type="button" onclick="removePhoto()" class="text-[11px] font-bold text-red-500 hover:text-red-700 transition-colors">
                                        Remove Photo
                                    </button>
                                @endif
                                
                                <p class="text-[10px] font-medium text-slate-400">JPG, PNG (max. 2MB)</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CARD 2: PERSONAL INFORMATION (Right Top Column on Desktop) -->
                <div class="lg:col-span-8 bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 space-y-4">
                    <div class="flex items-center gap-2 pb-4 border-b border-slate-100">
                        <svg class="w-4.5 h-4.5 text-[#102b70]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM4 21a8 8 0 0116 0" /></svg>
                        <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-900">Personal Information</h3>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                        <!-- First Name -->
                        <div class="space-y-1">
                            <label for="first_name" class="block font-extrabold text-slate-800">First Name <span class="text-red-500">*</span></label>
                            <input type="text" id="first_name" name="first_name" value="{{ old('first_name', $member->first_name) }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl font-semibold text-slate-800 focus:bg-white focus:border-[#102b70] outline-none transition-all" required>
                        </div>

                        <!-- Last Name -->
                        <div class="space-y-1">
                            <label for="last_name" class="block font-extrabold text-slate-800">Last Name <span class="text-red-500">*</span></label>
                            <input type="text" id="last_name" name="last_name" value="{{ old('last_name', $member->last_name) }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl font-semibold text-slate-800 focus:bg-white focus:border-[#102b70] outline-none transition-all" required>
                        </div>

                        <!-- Student Number -->
                        <div class="space-y-1">
                            <label for="student_id_number" class="block font-extrabold text-slate-800">Student Number <span class="text-red-500">*</span></label>
                            <input type="text" id="student_id_number" name="student_id_number" value="{{ old('student_id_number', $member->student_id_number) }}" class="w-full px-3.5 py-2.5 bg-slate-100 border border-slate-200 rounded-xl font-semibold text-slate-500 cursor-not-allowed outline-none" readonly>
                        </div>

                        <!-- Program / Course -->
                        <div class="space-y-1">
                            <label for="program" class="block font-extrabold text-slate-800">Program / Course <span class="text-red-500">*</span></label>
                            <select id="program" name="program" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl font-semibold text-slate-800 focus:bg-white focus:border-[#102b70] outline-none transition-all">
                                <option value="Bachelor of Science in Information Technology" {{ old('program', $member->program) == 'Bachelor of Science in Information Technology' || !$member->program ? 'selected' : '' }}>Bachelor of Science in Information Technology</option>
                                <option value="Bachelor of Science in Business Administration" {{ old('program', $member->program) == 'Bachelor of Science in Business Administration' ? 'selected' : '' }}>Bachelor of Science in Business Administration</option>
                                <option value="Bachelor of Secondary Education" {{ old('program', $member->program) == 'Bachelor of Secondary Education' ? 'selected' : '' }}>Bachelor of Secondary Education</option>
                                <option value="Bachelor of Elementary Education" {{ old('program', $member->program) == 'Bachelor of Elementary Education' ? 'selected' : '' }}>Bachelor of Elementary Education</option>
                            </select>
                        </div>

                        <!-- Year Level -->
                        <div class="space-y-1">
                            <label for="year_level" class="block font-extrabold text-slate-800">Year Level <span class="text-red-500">*</span></label>
                            <select id="year_level" name="year_level" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl font-semibold text-slate-800 focus:bg-white focus:border-[#102b70] outline-none transition-all">
                                <option value="1st Year" {{ old('year_level', $member->year_level) == '1st Year' ? 'selected' : '' }}>1st Year</option>
                                <option value="2nd Year" {{ old('year_level', $member->year_level) == '2nd Year' ? 'selected' : '' }}>2nd Year</option>
                                <option value="3rd Year" {{ old('year_level', $member->year_level) == '3rd Year' || !$member->year_level ? 'selected' : '' }}>3rd Year</option>
                                <option value="4th Year" {{ old('year_level', $member->year_level) == '4th Year' ? 'selected' : '' }}>4th Year</option>
                            </select>
                        </div>

                        <!-- Section -->
                        <div class="space-y-1">
                            <label for="section" class="block font-extrabold text-slate-800">Section <span class="text-red-500">*</span></label>
                            <select id="section" name="section" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl font-semibold text-slate-800 focus:bg-white focus:border-[#102b70] outline-none transition-all">
                                <option value="BSIT-2A" selected>BSIT-2A</option>
                                <option value="BSIT-2B">BSIT-2B</option>
                                <option value="BSIT-3A">BSIT-3A</option>
                                <option value="BSIT-4A">BSIT-4A</option>
                            </select>
                        </div>

                        <!-- Phone Number -->
                        <div class="space-y-1 sm:col-span-2">
                            <label for="contact_num" class="block font-extrabold text-slate-800">Phone Number <span class="text-red-500">*</span></label>
                            <input type="text" id="contact_num" name="contact_num" value="{{ old('contact_num', $member->contact_num ?? '0912 345 6789') }}" placeholder="0912 345 6789" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl font-semibold text-slate-800 focus:bg-white focus:border-[#102b70] outline-none transition-all">
                        </div>
                    </div>
                </div>

                <!-- CARD 3: ACCOUNT INFORMATION (Bottom Left Column on Desktop) -->
                <div class="lg:col-span-6 bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 space-y-4">
                    <div class="flex items-center gap-2 pb-4 border-b border-slate-100">
                        <svg class="w-4.5 h-4.5 text-[#102b70]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" /></svg>
                        <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-900">Account Information</h3>
                    </div>

                    <div class="space-y-4 text-xs">
                        <!-- Email Address -->
                        <div class="space-y-1.5">
                            <div class="flex items-center justify-between">
                                <label for="email" class="block font-extrabold text-slate-800">Email Address <span class="text-red-500">*</span></label>
                                
                                @if($memberAuth->isGoogleLinked())
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-emerald-50 border border-emerald-200 text-[10px] font-extrabold text-emerald-700">
                                        <svg class="w-3 h-3" viewBox="0 0 24 24">
                                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                                        </svg>
                                        Verified with Google
                                    </span>
                                @endif
                            </div>
                            <input type="email" id="email" name="email" value="{{ old('email', $member->email) }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl font-semibold text-slate-800 focus:bg-white focus:border-[#102b70] outline-none transition-all" required>
                        </div>

                        <!-- Username -->
                        <div class="space-y-1">
                            <label for="username" class="block font-extrabold text-slate-800">Username <span class="text-red-500">*</span></label>
                            <input type="text" id="username" name="username" value="{{ old('username', $memberAuth->username) }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl font-mono font-semibold text-slate-800 focus:bg-white focus:border-[#102b70] outline-none transition-all" required>
                        </div>
                    </div>
                </div>

                <!-- CARD 4: SECURITY (Bottom Right Column on Desktop) -->
                <div class="lg:col-span-6 bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 space-y-4 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-2 pb-4 border-b border-slate-100">
                            <svg class="w-4.5 h-4.5 text-[#102b70]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                            <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-900">Security</h3>
                        </div>

                        <div class="mt-4 flex items-center justify-between p-3.5 bg-slate-50 rounded-xl border border-slate-100">
                            <div>
                                <span class="block text-xs font-extrabold text-slate-800">Password</span>
                                @if($memberAuth->hasPassword())
                                    <span class="block text-xs text-slate-400 font-bold tracking-widest mt-0.5">••••••••••••••</span>
                                @else
                                    <span class="block text-[11px] text-amber-700 font-bold mt-0.5">No password set (Google Sign-In)</span>
                                @endif
                            </div>

                            <button type="button" onclick="changePasswordModal.showModal()" class="px-3.5 py-1.5 text-xs border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all inline-flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                                {{ $memberAuth->hasPassword() ? 'Change Password' : 'Add Password' }}
                            </button>
                        </div>
                    </div>
                </div>

            </div>

            <!-- ACTION BUTTONS FOOTER BAR (Matching Mockup) -->
            <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-200/80">
                <a href="{{ route('student.profile.show') }}" class="px-5 py-2.5 text-sm border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all inline-flex items-center gap-2">
                    Cancel
                </a>
                <button type="submit" class="px-5 py-2.5 text-sm bg-[#102b70] hover:bg-[#071943] text-white font-extrabold rounded-xl transition-all shadow-sm inline-flex items-center gap-2">
                    <svg class="w-4 h-4 text-[#fcc719]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" /></svg>
                    Save Changes
                </button>
            </div>
        </form>

    </div>

    <!-- CHANGE PASSWORD MODAL (DaisyUI Dialog) -->
    <dialog id="changePasswordModal" class="modal modal-middle">
        <div class="modal-box max-w-md bg-white p-6 rounded-2xl shadow-xl border border-slate-100 relative">
            <form method="dialog" class="absolute top-4 right-4"><button class="btn btn-circle btn-sm bg-slate-100 hover:bg-slate-200 text-slate-600 border-none">✕</button></form>

            <div class="flex items-center gap-3 mb-4 pb-3 border-b border-slate-100">
                <div class="w-10 h-10 rounded-full bg-blue-50 text-[#102b70] flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                </div>
                <div>
                    <h3 class="font-extrabold text-base text-slate-900">{{ $memberAuth->hasPassword() ? 'Change Password' : 'Add Password' }}</h3>
                    <p class="text-xs text-slate-500 font-medium">{{ $memberAuth->hasPassword() ? 'Update your account login password.' : 'Create a password to sign in with your email or Student ID.' }}</p>
                </div>
            </div>

            @if(!$memberAuth->hasPassword())
                <div class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded-xl text-xs font-semibold text-blue-900 flex items-start gap-2">
                    <svg class="w-4 h-4 text-blue-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span>You signed in using Google and haven't created a password yet. Adding a password allows you to log in using either Google or your Student ID / email password.</span>
                </div>
            @endif

            <form action="{{ route('student.profile.update') }}" method="POST" class="space-y-4 text-xs">
                @csrf
                @method('PUT')

                <!-- Carry over required standard fields so request validation passes -->
                <input type="hidden" name="first_name" value="{{ $member->first_name }}">
                <input type="hidden" name="last_name" value="{{ $member->last_name }}">
                <input type="hidden" name="email" value="{{ $member->email }}">

                @if($memberAuth->hasPassword())
                    <div class="space-y-1">
                        <label for="pwd_current" class="block font-extrabold text-slate-800">Current Password <span class="text-red-500">*</span></label>
                        <input type="password" id="pwd_current" name="current_password" required placeholder="Enter current password" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl font-semibold text-slate-800 focus:bg-white focus:border-[#102b70] outline-none">
                    </div>
                @endif

                <div class="space-y-1">
                    <label for="pwd_new" class="block font-extrabold text-slate-800">New Password <span class="text-red-500">*</span></label>
                    <input type="password" id="pwd_new" name="new_password" required placeholder="At least 8 characters" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl font-semibold text-slate-800 focus:bg-white focus:border-[#102b70] outline-none">
                </div>

                <div class="space-y-1">
                    <label for="pwd_confirm" class="block font-extrabold text-slate-800">Confirm New Password <span class="text-red-500">*</span></label>
                    <input type="password" id="pwd_confirm" name="new_password_confirmation" required placeholder="Re-type new password" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl font-semibold text-slate-800 focus:bg-white focus:border-[#102b70] outline-none">
                </div>

                <div class="flex items-center justify-end gap-2 pt-4 border-t border-slate-100">
                    <button type="button" onclick="changePasswordModal.close()" class="px-4 py-2 border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all">Cancel</button>
                    <button type="submit" class="px-5 py-2 bg-[#102b70] hover:bg-[#071943] text-white font-extrabold rounded-xl transition-all shadow-sm">
                        {{ $memberAuth->hasPassword() ? 'Update Password' : 'Add Password' }}
                    </button>
                </div>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop"><button>close</button></form>
    </dialog>

    <script>
        function handleImageSelection(event) {
            const file = event.target.files[0];
            if (!file) return;

            if (file.size > 2 * 1024 * 1024) {
                alert('File size exceeds 2MB limit.');
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                const base64Data = e.target.result;
                document.getElementById('profile_image_base64').value = base64Data;
                document.getElementById('remove_profile_image').value = "0";

                const imgPreview = document.getElementById('avatar-preview-img');
                const initialsPreview = document.getElementById('avatar-preview-initials');

                if (imgPreview) {
                    imgPreview.src = base64Data;
                    imgPreview.classList.remove('hidden');
                }
                if (initialsPreview) {
                    initialsPreview.classList.add('hidden');
                }
            };
            reader.readAsDataURL(file);
        }

        function removePhoto() {
            document.getElementById('profile_image_base64').value = "";
            document.getElementById('remove_profile_image').value = "1";
            
            const imgPreview = document.getElementById('avatar-preview-img');
            const initialsPreview = document.getElementById('avatar-preview-initials');

            if (imgPreview) {
                imgPreview.src = "";
                imgPreview.classList.add('hidden');
            }
            if (initialsPreview) {
                initialsPreview.classList.remove('hidden');
            }
        }
    </script>
</x-layout.student>
