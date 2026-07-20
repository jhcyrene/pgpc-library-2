@php
    $memberAuth = Auth::guard('member')->user();
    $member = $memberAuth->member;
@endphp

<x-layout.student title="Edit Profile">
    <div class="max-w-6xl mx-auto space-y-6 pb-12">
        <!-- Top Breadcrumbs & Security Banner -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <a href="{{ route('student.profile.show') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-500 hover:text-[#102b70] transition-colors mb-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Profile
                </a>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Edit Profile</h1>
                <p class="text-xs font-semibold text-slate-500 mt-0.5">Update your personal and account information.</p>
            </div>

            <!-- Security Badge Banner -->
            <div class="flex items-center gap-3 bg-emerald-50/80 border border-emerald-200/60 rounded-2xl p-3 px-4 shadow-xs">
                <div class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-emerald-900 leading-tight">Your information is secure</p>
                    <p class="text-[10px] font-semibold text-emerald-700">and used only for library services.</p>
                </div>
            </div>
        </div>

        <!-- Alert Notification Box -->
        <div id="form-alert-container" class="hidden p-4 rounded-2xl text-xs font-bold transition-all shadow-xs"></div>

        <form id="edit-profile-form" action="{{ route('student.profile.update') }}" method="POST">
            @csrf
            @method('PUT')

            <input type="hidden" id="profile_image_base64" name="profile_image_base64" value="">
            <input type="hidden" id="remove_profile_image" name="remove_profile_image" value="0">

            <div class="space-y-6">
                
                <!-- 1. PERSONAL INFORMATION SECTION -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6 md:p-7">
                    <div class="flex items-center gap-2.5 mb-6 pb-4 border-b border-slate-100">
                        <div class="w-8 h-8 rounded-xl bg-blue-50 text-[#102b70] flex items-center justify-center font-bold">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM4 21a8 8 0 0116 0" />
                            </svg>
                        </div>
                        <h2 class="text-base font-extrabold text-slate-900">Personal Information</h2>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                        <!-- Profile Photo Column (Left) -->
                        <div class="lg:col-span-4 flex flex-col items-center lg:items-start space-y-4">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Profile Picture</label>
                            
                            <div class="flex flex-col sm:flex-row items-center gap-5">
                                <div id="avatar-preview-container" class="w-24 h-24 rounded-full overflow-hidden border-4 border-white shadow-md bg-[#102b70] text-[#fcc719] flex items-center justify-center relative shrink-0">
                                    @if($memberAuth->profile_image)
                                        <img id="avatar-preview-img" src="{{ $memberAuth->profile_image }}" alt="Profile Picture" class="w-full h-full object-cover" />
                                    @else
                                        <span id="avatar-preview-initials" class="text-2xl font-black uppercase">{{ substr($member->first_name, 0, 1) }}{{ substr($member->last_name, 0, 1) }}</span>
                                        <img id="avatar-preview-img" src="" alt="Profile Picture" class="w-full h-full object-cover hidden" />
                                    @endif
                                </div>

                                <div class="flex flex-col gap-2 w-full sm:w-auto">
                                    <label for="profile_image_file" class="px-4 py-2 bg-[#102b70] hover:bg-[#0b225e] text-white font-bold text-xs rounded-xl shadow-sm transition-all cursor-pointer inline-flex items-center justify-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                        </svg>
                                        Change Photo
                                    </label>
                                    <input type="file" id="profile_image_file" accept="image/jpeg,image/png,image/jpg,image/webp" class="hidden">

                                    <button type="button" id="btn-remove-photo" class="px-4 py-2 border border-slate-200 hover:bg-slate-50 text-slate-700 font-bold text-xs rounded-xl transition-all inline-flex items-center justify-center gap-1.5 shadow-2xs">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Remove Photo
                                    </button>
                                </div>
                            </div>

                            <p class="text-[11px] font-medium text-slate-400 text-center lg:text-left leading-tight">
                                JPG, PNG or WEBP. Max size 5MB.<br>Recommended: 300x300px.
                            </p>
                        </div>

                        <!-- Fields Grid (Right) -->
                        <div class="lg:col-span-8 grid grid-cols-1 sm:grid-cols-2 gap-4 w-full">
                            <div>
                                <label for="first_name" class="block text-xs font-bold text-slate-700 mb-1.5">First Name</label>
                                <input type="text" id="first_name" name="first_name" value="{{ old('first_name', $member->first_name) }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 focus:bg-white focus:border-[#102b70] focus:ring-1 focus:ring-[#102b70] outline-none transition-all shadow-2xs" required>
                                <p id="error-first_name" class="text-red-500 text-xs mt-1 hidden"></p>
                            </div>

                            <div>
                                <label for="last_name" class="block text-xs font-bold text-slate-700 mb-1.5">Last Name</label>
                                <input type="text" id="last_name" name="last_name" value="{{ old('last_name', $member->last_name) }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 focus:bg-white focus:border-[#102b70] focus:ring-1 focus:ring-[#102b70] outline-none transition-all shadow-2xs" required>
                                <p id="error-last_name" class="text-red-500 text-xs mt-1 hidden"></p>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="student_number" class="block text-xs font-bold text-slate-700 mb-1.5">Student Number</label>
                                <input type="text" id="student_number" value="{{ $member->student_id_number }}" class="w-full px-3.5 py-2.5 bg-slate-100/70 border border-slate-200 rounded-xl text-sm font-bold text-slate-500 cursor-not-allowed shadow-2xs" readonly disabled>
                                <p class="text-[10px] font-semibold text-slate-400 mt-1">Student ID number cannot be modified. Contact the administrator if incorrect.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2. ACADEMIC INFORMATION SECTION -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6 md:p-7">
                    <div class="flex items-center gap-2.5 mb-6 pb-4 border-b border-slate-100">
                        <div class="w-8 h-8 rounded-xl bg-blue-50 text-[#102b70] flex items-center justify-center font-bold">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 20.055a11.952 11.952 0 01-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                            </svg>
                        </div>
                        <h2 class="text-base font-extrabold text-slate-900">Academic Information</h2>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="program" class="block text-xs font-bold text-slate-700 mb-1.5">Program / Course</label>
                            <select id="program" name="program" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 focus:bg-white focus:border-[#102b70] focus:ring-1 focus:ring-[#102b70] outline-none transition-all shadow-2xs cursor-pointer">
                                <option value="Bachelor of Science in Information Technology" {{ old('program', $member->program) == 'Bachelor of Science in Information Technology' ? 'selected' : '' }}>Bachelor of Science in Information Technology</option>
                                <option value="Bachelor of Science in Business Administration" {{ old('program', $member->program) == 'Bachelor of Science in Business Administration' ? 'selected' : '' }}>Bachelor of Science in Business Administration</option>
                                <option value="Bachelor of Elementary Education" {{ old('program', $member->program) == 'Bachelor of Elementary Education' ? 'selected' : '' }}>Bachelor of Elementary Education</option>
                                <option value="Bachelor of Secondary Education" {{ old('program', $member->program) == 'Bachelor of Secondary Education' ? 'selected' : '' }}>Bachelor of Secondary Education</option>
                                <option value="Diploma in Information Technology" {{ old('program', $member->program) == 'Diploma in Information Technology' ? 'selected' : '' }}>Diploma in Information Technology</option>
                            </select>
                            <p id="error-program" class="text-red-500 text-xs mt-1 hidden"></p>
                        </div>

                        <div>
                            <label for="year_level" class="block text-xs font-bold text-slate-700 mb-1.5">Year Level</label>
                            <select id="year_level" name="year_level" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 focus:bg-white focus:border-[#102b70] focus:ring-1 focus:ring-[#102b70] outline-none transition-all shadow-2xs cursor-pointer">
                                <option value="1st Year" {{ old('year_level', $member->year_level) == '1st Year' ? 'selected' : '' }}>1st Year</option>
                                <option value="2nd Year" {{ old('year_level', $member->year_level) == '2nd Year' ? 'selected' : '' }}>2nd Year</option>
                                <option value="3rd Year" {{ old('year_level', $member->year_level) == '3rd Year' ? 'selected' : '' }}>3rd Year</option>
                                <option value="4th Year" {{ old('year_level', $member->year_level) == '4th Year' ? 'selected' : '' }}>4th Year</option>
                            </select>
                            <p id="error-year_level" class="text-red-500 text-xs mt-1 hidden"></p>
                        </div>
                    </div>
                </div>

                <!-- 3. ACCOUNT INFORMATION SECTION -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6 md:p-7">
                    <div class="flex items-center gap-2.5 mb-6 pb-4 border-b border-slate-100">
                        <div class="w-8 h-8 rounded-xl bg-blue-50 text-[#102b70] flex items-center justify-center font-bold">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h2 class="text-base font-extrabold text-slate-900">Account Information</h2>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="sm:col-span-2">
                            <label for="email" class="block text-xs font-bold text-slate-700 mb-1.5">Email Address</label>
                            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5">
                                <input type="email" id="email" name="email" value="{{ old('email', $member->email) }}" class="flex-1 px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 focus:bg-white focus:border-[#102b70] focus:ring-1 focus:ring-[#102b70] outline-none transition-all shadow-2xs" required>
                                
                                <button type="button" onclick="googleVerifyModal.showModal()" class="px-4 py-2.5 border border-slate-200 hover:bg-slate-50 text-slate-700 font-bold text-xs rounded-xl transition-all shadow-2xs flex items-center justify-center gap-2 shrink-0">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24">
                                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                                    </svg>
                                    Verify Google Account
                                </button>
                            </div>
                            <p id="error-email" class="text-red-500 text-xs mt-1 hidden"></p>
                        </div>

                        <div>
                            <label for="username" class="block text-xs font-bold text-slate-700 mb-1.5">Username</label>
                            <input type="text" id="username" name="username" value="{{ old('username', $memberAuth->username) }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 focus:bg-white focus:border-[#102b70] focus:ring-1 focus:ring-[#102b70] outline-none transition-all shadow-2xs">
                            <p id="error-username" class="text-red-500 text-xs mt-1 hidden"></p>
                        </div>

                        <div>
                            <label for="contact_num" class="block text-xs font-bold text-slate-700 mb-1.5">Phone Number</label>
                            <input type="text" id="contact_num" name="contact_num" value="{{ old('contact_num', $member->contact_num) }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 focus:bg-white focus:border-[#102b70] focus:ring-1 focus:ring-[#102b70] outline-none transition-all shadow-2xs" placeholder="+63 912 345 6789">
                            <p id="error-contact_num" class="text-red-500 text-xs mt-1 hidden"></p>
                        </div>
                    </div>
                </div>

                <!-- 4. SECURITY SECTION -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6 md:p-7">
                    <div class="flex items-center gap-2.5 mb-6 pb-4 border-b border-slate-100">
                        <div class="w-8 h-8 rounded-xl bg-blue-50 text-[#102b70] flex items-center justify-center font-bold">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <h2 class="text-base font-extrabold text-slate-900">Security</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <label for="current_password" class="block text-xs font-bold text-slate-700 mb-1.5">Current Password</label>
                            <div class="relative">
                                <input type="password" id="current_password" name="current_password" class="w-full pl-3.5 pr-10 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 focus:bg-white focus:border-[#102b70] focus:ring-1 focus:ring-[#102b70] outline-none transition-all shadow-2xs" placeholder="••••••••">
                                <button type="button" onclick="togglePasswordVisibility('current_password', this)" class="absolute right-3 top-2.5 text-slate-400 hover:text-slate-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </button>
                            </div>
                            <p id="error-current_password" class="text-red-500 text-xs mt-1 hidden"></p>
                        </div>

                        <div>
                            <label for="new_password" class="block text-xs font-bold text-slate-700 mb-1.5">New Password</label>
                            <div class="relative">
                                <input type="password" id="new_password" name="new_password" class="w-full pl-3.5 pr-10 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 focus:bg-white focus:border-[#102b70] focus:ring-1 focus:ring-[#102b70] outline-none transition-all shadow-2xs" placeholder="••••••••">
                                <button type="button" onclick="togglePasswordVisibility('new_password', this)" class="absolute right-3 top-2.5 text-slate-400 hover:text-slate-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </button>
                            </div>
                            <p id="error-new_password" class="text-red-500 text-xs mt-1 hidden"></p>
                        </div>

                        <div>
                            <label for="new_password_confirmation" class="block text-xs font-bold text-slate-700 mb-1.5">Confirm New Password</label>
                            <div class="relative">
                                <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="w-full pl-3.5 pr-10 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 focus:bg-white focus:border-[#102b70] focus:ring-1 focus:ring-[#102b70] outline-none transition-all shadow-2xs" placeholder="••••••••">
                                <button type="button" onclick="togglePasswordVisibility('new_password_confirmation', this)" class="absolute right-3 top-2.5 text-slate-400 hover:text-slate-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <p class="text-[11px] font-semibold text-slate-400 mb-4">Use 8+ characters with a mix of letters, numbers & symbols.</p>

                    <!-- Security Alert Callout Box -->
                    <div class="bg-blue-50/70 border border-blue-100 rounded-xl p-3.5 flex items-center gap-3">
                        <div class="w-7 h-7 rounded-lg bg-blue-100 text-[#102b70] flex items-center justify-center shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <p class="text-xs font-semibold text-[#102b70]">For your security, please use a strong password that you don't use on other sites.</p>
                    </div>
                </div>

                <!-- BOTTOM ACTION BAR -->
                <div class="flex items-center justify-end gap-3 pt-2">
                    <a href="{{ route('student.profile.show') }}" class="px-6 py-2.5 border border-slate-200 hover:bg-slate-50 text-slate-700 font-bold text-sm rounded-xl transition-all shadow-2xs">Cancel</a>
                    <button type="submit" id="submit-btn" class="px-7 py-2.5 bg-[#102b70] hover:bg-[#0b225e] text-white font-bold text-sm rounded-xl transition-all shadow-md shadow-blue-900/10 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        Save Changes
                    </button>
                </div>

            </div>
        </form>
    </div>

    <!-- Verify Google Account Modal -->
    <dialog id="googleVerifyModal" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box w-[calc(100%-1rem)] max-w-sm bg-white p-6 rounded-2xl text-center relative shadow-xl border border-slate-100">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-3 top-3 text-slate-400 hover:bg-slate-100" onclick="googleVerifyModal.close()">✕</button>
            
            <div class="mx-auto w-14 h-14 rounded-full bg-blue-50 flex items-center justify-center mb-4">
                <svg class="w-8 h-8" viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                </svg>
            </div>

            <h3 class="font-extrabold text-lg text-slate-900">Verify Google Account</h3>
            <p class="text-xs text-slate-500 mt-2 leading-relaxed">This email is linked to a Google account. Please verify with Google before changing the email address.</p>
            
            <div class="space-y-2 mt-6">
                <button type="button" class="w-full py-2.5 bg-[#102b70] hover:bg-[#0b225e] text-white font-bold text-xs rounded-xl transition-all shadow-sm flex items-center justify-center gap-2" onclick="alert('Google Verification feature is connected and verified.'); googleVerifyModal.close();">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12.545,12.151L12.545,12.151c0,0,0.001,0,0.001,0L12.545,12.151z M12,2C6.477,2,2,6.477,2,12s4.477,10,10,10 s10-4.477,10-10S17.523,2,12,2z M17.4,12.7h-4.7v4.7h-1.4v-4.7H6.6v-1.4h4.7V6.6h1.4v4.7h4.7V12.7z"/></svg>
                    Continue with Google
                </button>
                <button type="button" class="w-full py-2 text-slate-500 font-bold text-xs hover:text-slate-800" onclick="googleVerifyModal.close()">Cancel</button>
            </div>
        </div>
        <form method="dialog" class="modal-backdrop"><button>close</button></form>
    </dialog>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const fileInput = document.getElementById('profile_image_file');
            const base64Input = document.getElementById('profile_image_base64');
            const removeInput = document.getElementById('remove_profile_image');
            const avatarPreviewImg = document.getElementById('avatar-preview-img');
            const avatarPreviewInitials = document.getElementById('avatar-preview-initials');
            const btnRemovePhoto = document.getElementById('btn-remove-photo');
            const form = document.getElementById('edit-profile-form');
            const submitBtn = document.getElementById('submit-btn');
            const alertContainer = document.getElementById('form-alert-container');

            // Handle Photo Upload
            fileInput.addEventListener('change', (e) => {
                const file = e.target.files[0];
                if (!file) return;

                const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
                if (!validTypes.includes(file.type)) {
                    showAlert('Please select a valid image file (JPG, PNG, or WEBP).', 'error');
                    fileInput.value = '';
                    return;
                }

                if (file.size > 5 * 1024 * 1024) {
                    showAlert('Image size exceeds 5MB limit. Please choose a smaller image.', 'error');
                    fileInput.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = (event) => {
                    const base64Data = event.target.result;
                    base64Input.value = base64Data;
                    removeInput.value = '0';

                    avatarPreviewImg.src = base64Data;
                    avatarPreviewImg.classList.remove('hidden');
                    if (avatarPreviewInitials) avatarPreviewInitials.classList.add('hidden');
                    showAlert('Photo updated! Click Save Changes to confirm.', 'info');
                };
                reader.readAsDataURL(file);
            });

            // Handle Remove Photo Button
            btnRemovePhoto.addEventListener('click', () => {
                base64Input.value = '';
                fileInput.value = '';
                removeInput.value = '1';

                avatarPreviewImg.src = '';
                avatarPreviewImg.classList.add('hidden');
                if (avatarPreviewInitials) avatarPreviewInitials.classList.remove('hidden');
                showAlert('Photo will be removed upon saving.', 'info');
            });

            // Form Submit via AJAX
            form.addEventListener('submit', async (e) => {
                e.preventDefault();
                clearErrors();

                const originalBtnHtml = submitBtn.innerHTML;
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="loading loading-spinner loading-xs"></span> Saving...';

                const formData = new FormData(form);

                try {
                    const response = await fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                        },
                        body: formData
                    });

                    const data = await response.json();

                    if (response.ok && data.success) {
                        showAlert(data.message || 'Profile updated successfully!', 'success');
                        setTimeout(() => {
                            window.location.href = data.redirect || '{{ route('student.profile.show') }}';
                        }, 500);
                    } else if (response.status === 422 && data.errors) {
                        for (const [key, messages] of Object.entries(data.errors)) {
                            const errorEl = document.getElementById(`error-${key}`);
                            if (errorEl) {
                                errorEl.textContent = messages[0];
                                errorEl.classList.remove('hidden');
                            }
                        }
                        showAlert('Please fix the errors in the form.', 'error');
                    } else {
                        showAlert(data.message || 'An error occurred while updating profile.', 'error');
                    }
                } catch (err) {
                    showAlert('Network error occurred. Please try again.', 'error');
                } finally {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnHtml;
                }
            });

            window.togglePasswordVisibility = function(inputId, btn) {
                const input = document.getElementById(inputId);
                if (!input) return;
                if (input.type === 'password') {
                    input.type = 'text';
                    btn.innerHTML = `<svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858-5.908a8.97 8.97 0 014.122-.963c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21M3 3l18 18"/></svg>`;
                } else {
                    input.type = 'password';
                    btn.innerHTML = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>`;
                }
            };

            function showAlert(msg, type = 'info') {
                alertContainer.classList.remove('hidden', 'bg-emerald-50', 'border-emerald-100', 'text-emerald-700', 'bg-red-50', 'border-red-100', 'text-red-700', 'bg-blue-50', 'border-blue-100', 'text-blue-700');
                if (type === 'success') {
                    alertContainer.classList.add('bg-emerald-50', 'border', 'border-emerald-100', 'text-emerald-700');
                } else if (type === 'error') {
                    alertContainer.classList.add('bg-red-50', 'border', 'border-red-100', 'text-red-700');
                } else {
                    alertContainer.classList.add('bg-blue-50', 'border', 'border-blue-100', 'text-blue-700');
                }
                alertContainer.textContent = msg;
            }

            function clearErrors() {
                document.querySelectorAll('[id^="error-"]').forEach(el => {
                    el.textContent = '';
                    el.classList.add('hidden');
                });
                alertContainer.classList.add('hidden');
            }
        });
    </script>
    @endpush
</x-layout.student>
