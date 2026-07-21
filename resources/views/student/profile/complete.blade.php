@php
    $memberAuth = Auth::guard('member')->user();
    $member = $memberAuth->member;
@endphp

<x-layout.onboarding title="Complete Your Profile" subtitle="Student Account Onboarding">
    <div class="max-w-6xl mx-auto w-full font-sans select-none">
        
        <!-- MAIN WIZARD CONTAINER CARD -->
        <div class="bg-white rounded-3xl border border-slate-200/90 shadow-2xl overflow-hidden grid grid-cols-1 lg:grid-cols-12 min-h-[640px]">
            
            <!-- LEFT NAVY SIDEBAR (Web / Tablet view matching Mockup) -->
            <div class="lg:col-span-4 bg-gradient-to-b from-[#071943] via-[#0a1b42] to-[#102b70] text-white p-6 sm:p-8 flex flex-col justify-between relative overflow-hidden">
                
                <!-- Watermark Background Seal -->
                <div class="absolute -right-12 -bottom-12 opacity-10 pointer-events-none">
                    <img src="{{ Vite::asset('resources/images/webp/hd-pgpc-logo.webp') }}" alt="Seal Watermark" class="w-72 h-72 object-contain filter grayscale contrast-200" />
                </div>

                <div class="space-y-6 z-10">
                    <!-- Onboarding Badge Icon -->
                    <div class="w-12 h-12 rounded-2xl bg-white/10 border border-white/20 backdrop-blur-md flex items-center justify-center text-[#fcc719] shadow-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>

                    <!-- Intro Text -->
                    <div class="space-y-2">
                        <span class="inline-block px-2.5 py-1 rounded-full bg-[#fcc719]/20 border border-[#fcc719]/30 text-[10px] font-extrabold text-[#fcc719] uppercase tracking-wider">
                            Account Setup
                        </span>
                        <h2 class="text-2xl sm:text-3xl font-black text-white leading-tight tracking-tight">Welcome, {{ $member->first_name ?? 'Student' }}!</h2>
                        <p class="text-xs text-blue-100/80 leading-relaxed font-medium">Please review and complete your student account profile to unlock full access to library borrowing and reservations.</p>
                    </div>
                </div>

                <!-- Left Sidebar Help Box -->
                <div class="z-10 bg-white/10 border border-white/15 backdrop-blur-md rounded-2xl p-4 mt-8 space-y-1">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-[#fcc719] text-[#071943] flex items-center justify-center shrink-0 shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-xs font-extrabold text-white">Need Assistance?</h4>
                            <p class="text-[10px] text-blue-100/80 leading-tight">Contact your library administrator for help with your student ID record.</p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- RIGHT FORM CONTENT AREA -->
            <div class="lg:col-span-8 p-6 sm:p-8 lg:p-10 flex flex-col justify-between space-y-6 bg-slate-50/40">
                
                <form id="complete-profile-form" action="{{ route('student.profile.complete.store') }}" method="POST" class="space-y-6 flex-1 flex flex-col justify-between">
                    @csrf

                    <div class="space-y-6">
                        
                        <!-- Top Header & Security Banner (Matching Mockup) -->
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-200/80 pb-5">
                            <div>
                                <span class="text-xs font-black uppercase tracking-widest text-[#102b70]">WELCOME!</span>
                                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight mt-0.5">Complete Your Profile</h1>
                                <p class="text-xs text-slate-500 font-medium mt-1">Please provide the following information to complete your library account setup.</p>
                            </div>
                            
                            <div class="flex items-center gap-2 bg-blue-50 border border-blue-100 rounded-2xl px-3.5 py-2 text-xs font-bold text-[#102b70] shrink-0 self-start sm:self-auto shadow-2xs">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                                <div>
                                    <span class="block text-[11px] font-extrabold leading-none text-[#102b70]">Secure your account</span>
                                    <span class="block text-[9px] font-semibold text-slate-400 mt-0.5">We keep your information safe.</span>
                                </div>
                            </div>
                        </div>

                        <!-- 4-STEP CONNECTED STEPPER (Matching Mockup) -->
                        <div class="relative pb-4 border-b border-slate-200/80">
                            <!-- Horizontal Connecting Line -->
                            <div class="absolute top-4 left-[12%] right-[12%] h-0.5 bg-slate-200 -z-0"></div>

                            <div class="grid grid-cols-4 gap-2 relative z-10">
                                <!-- Step 1 Tab -->
                                <div onclick="goToWizardStep(1)" class="wizard-step-tab cursor-pointer flex flex-col items-center text-center group" data-step="1">
                                    <div class="step-num-circle w-8 h-8 rounded-full bg-[#102b70] text-white flex items-center justify-center text-xs font-black transition-all mb-1.5 ring-4 ring-[#102b70]/15 shadow-sm">1</div>
                                    <span class="step-label text-[10px] font-extrabold uppercase tracking-wider text-[#102b70]">Personal Info</span>
                                </div>

                                <!-- Step 2 Tab -->
                                <div onclick="goToWizardStep(2)" class="wizard-step-tab cursor-pointer flex flex-col items-center text-center group" data-step="2">
                                    <div class="step-num-circle w-8 h-8 rounded-full bg-slate-200 text-slate-500 flex items-center justify-center text-xs font-black transition-all mb-1.5">2</div>
                                    <span class="step-label text-[10px] font-extrabold uppercase tracking-wider text-slate-400">Academic Info</span>
                                </div>

                                <!-- Step 3 Tab -->
                                <div onclick="goToWizardStep(3)" class="wizard-step-tab cursor-pointer flex flex-col items-center text-center group" data-step="3">
                                    <div class="step-num-circle w-8 h-8 rounded-full bg-slate-200 text-slate-500 flex items-center justify-center text-xs font-black transition-all mb-1.5">3</div>
                                    <span class="step-label text-[10px] font-extrabold uppercase tracking-wider text-slate-400">Contact Info</span>
                                </div>

                                <!-- Step 4 Tab -->
                                <div onclick="goToWizardStep(4)" class="wizard-step-tab cursor-pointer flex flex-col items-center text-center group" data-step="4">
                                    <div class="step-num-circle w-8 h-8 rounded-full bg-slate-200 text-slate-500 flex items-center justify-center text-xs font-black transition-all mb-1.5">4</div>
                                    <span class="step-label text-[10px] font-extrabold uppercase tracking-wider text-slate-400">Review</span>
                                </div>
                            </div>
                        </div>

                        <!-- STEP 1: PERSONAL INFORMATION -->
                        <div id="wizard-step-1" class="wizard-step-panel space-y-5">
                            <div class="flex flex-col md:flex-row items-center gap-6">
                                <!-- Left Illustration (Desktop View) -->
                                <div class="hidden md:flex flex-col items-center justify-center w-1/3 bg-blue-50/50 rounded-2xl p-6 border border-blue-100/60 text-center shrink-0">
                                    <div class="w-20 h-20 rounded-2xl bg-white p-3 shadow-md border border-slate-100 flex items-center justify-center mb-3">
                                        <svg class="w-12 h-12 text-[#102b70]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                        </svg>
                                    </div>
                                    <h4 class="text-xs font-extrabold text-slate-800">Personal Details</h4>
                                    <p class="text-[10px] text-slate-500 font-medium mt-0.5">Please ensure all required information matches your official student ID.</p>
                                </div>

                                <!-- Form Fields -->
                                <div class="flex-1 w-full space-y-4">
                                    <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-900 border-b border-slate-100 pb-2">Personal Information</h3>
                                    
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <!-- First Name -->
                                        <div class="space-y-1">
                                            <label for="first_name" class="block text-xs font-extrabold text-slate-800">First Name <span class="text-red-500">*</span></label>
                                            <div class="relative">
                                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM4 21a8 8 0 0116 0" /></svg>
                                                </div>
                                                <input type="text" id="first_name" name="first_name" value="{{ old('first_name', $member->first_name) }}" placeholder="Enter your first name" class="w-full pl-9 pr-4 py-2.5 text-xs bg-white border border-slate-200 rounded-xl font-semibold text-slate-800 focus:bg-white focus:border-[#102b70] focus:ring-2 focus:ring-[#102b70]/10 outline-none transition-all shadow-2xs" required>
                                            </div>
                                        </div>

                                        <!-- Last Name -->
                                        <div class="space-y-1">
                                            <label for="last_name" class="block text-xs font-extrabold text-slate-800">Last Name <span class="text-red-500">*</span></label>
                                            <div class="relative">
                                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM4 21a8 8 0 0116 0" /></svg>
                                                </div>
                                                <input type="text" id="last_name" name="last_name" value="{{ old('last_name', $member->last_name) }}" placeholder="Enter your last name" class="w-full pl-9 pr-4 py-2.5 text-xs bg-white border border-slate-200 rounded-xl font-semibold text-slate-800 focus:bg-white focus:border-[#102b70] focus:ring-2 focus:ring-[#102b70]/10 outline-none transition-all shadow-2xs" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <!-- Student ID -->
                                        <div class="space-y-1">
                                            <label for="student_id_number" class="block text-xs font-extrabold text-slate-800">Student ID / Number <span class="text-red-500">*</span></label>
                                            <div class="relative">
                                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3 3 0 00-3 3h6a3 3 0 00-3-3z" /></svg>
                                                </div>
                                                <input type="text" id="student_id_number" name="student_id_number" value="{{ old('student_id_number', $member->student_id_number) }}" placeholder="Enter your student ID" class="w-full pl-9 pr-4 py-2.5 text-xs bg-white border border-slate-200 rounded-xl font-semibold text-slate-800 focus:bg-white focus:border-[#102b70] focus:ring-2 focus:ring-[#102b70]/10 outline-none transition-all shadow-2xs" required>
                                            </div>
                                        </div>

                                        <!-- Date of Birth -->
                                        <div class="space-y-1">
                                            <label for="date_of_birth" class="block text-xs font-extrabold text-slate-800">Date of Birth <span class="text-red-500">*</span></label>
                                            <div class="relative">
                                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                                </div>
                                                <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', '2004-01-01') }}" class="w-full pl-9 pr-4 py-2.5 text-xs bg-white border border-slate-200 rounded-xl font-semibold text-slate-800 focus:bg-white focus:border-[#102b70] focus:ring-2 focus:ring-[#102b70]/10 outline-none transition-all shadow-2xs">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <!-- Gender -->
                                        <div class="space-y-1">
                                            <label for="gender" class="block text-xs font-extrabold text-slate-800">Gender <span class="text-red-500">*</span></label>
                                            <select id="gender" name="gender" class="w-full px-4 py-2.5 text-xs bg-white border border-slate-200 rounded-xl font-semibold text-slate-800 focus:bg-white focus:border-[#102b70] focus:ring-2 focus:ring-[#102b70]/10 outline-none transition-all shadow-2xs">
                                                <option value="Male" selected>Male</option>
                                                <option value="Female">Female</option>
                                                <option value="Other">Other</option>
                                            </select>
                                        </div>

                                        <!-- Civil Status -->
                                        <div class="space-y-1">
                                            <label for="civil_status" class="block text-xs font-extrabold text-slate-800">Civil Status</label>
                                            <select id="civil_status" name="civil_status" class="w-full px-4 py-2.5 text-xs bg-white border border-slate-200 rounded-xl font-semibold text-slate-800 focus:bg-white focus:border-[#102b70] focus:ring-2 focus:ring-[#102b70]/10 outline-none transition-all shadow-2xs">
                                                <option value="Single" selected>Single</option>
                                                <option value="Married">Married</option>
                                                <option value="Widowed">Widowed</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- STEP 2: ACADEMIC INFORMATION -->
                        <div id="wizard-step-2" class="wizard-step-panel hidden space-y-4">
                            <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-900 border-b border-slate-100 pb-2">Academic Information</h3>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="space-y-1">
                                    <label for="program" class="block text-xs font-extrabold text-slate-800">Course / Program <span class="text-red-500">*</span></label>
                                    <select id="program" name="program" class="w-full px-4 py-2.5 text-xs bg-white border border-slate-200 rounded-xl font-semibold text-slate-800 focus:bg-white focus:border-[#102b70] focus:ring-2 focus:ring-[#102b70]/10 outline-none transition-all shadow-2xs">
                                        <option value="Bachelor of Science in Information Technology" selected>Bachelor of Science in Information Technology</option>
                                        <option value="Bachelor of Science in Business Administration">Bachelor of Science in Business Administration</option>
                                        <option value="Bachelor of Secondary Education">Bachelor of Secondary Education</option>
                                        <option value="Bachelor of Elementary Education">Bachelor of Elementary Education</option>
                                    </select>
                                </div>

                                <div class="space-y-1">
                                    <label for="year_level" class="block text-xs font-extrabold text-slate-800">Year Level <span class="text-red-500">*</span></label>
                                    <select id="year_level" name="year_level" class="w-full px-4 py-2.5 text-xs bg-white border border-slate-200 rounded-xl font-semibold text-slate-800 focus:bg-white focus:border-[#102b70] focus:ring-2 focus:ring-[#102b70]/10 outline-none transition-all shadow-2xs">
                                        <option value="1st Year" {{ old('year_level', $member->year_level) == '1st Year' ? 'selected' : '' }}>1st Year</option>
                                        <option value="2nd Year" {{ old('year_level', $member->year_level) == '2nd Year' || !$member->year_level ? 'selected' : '' }}>2nd Year</option>
                                        <option value="3rd Year" {{ old('year_level', $member->year_level) == '3rd Year' ? 'selected' : '' }}>3rd Year</option>
                                        <option value="4th Year" {{ old('year_level', $member->year_level) == '4th Year' ? 'selected' : '' }}>4th Year</option>
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="space-y-1">
                                    <label for="section" class="block text-xs font-extrabold text-slate-800">Section</label>
                                    <select id="section" name="section" class="w-full px-4 py-2.5 text-xs bg-white border border-slate-200 rounded-xl font-semibold text-slate-800 focus:bg-white focus:border-[#102b70] focus:ring-2 focus:ring-[#102b70]/10 outline-none transition-all shadow-2xs">
                                        <option value="BSIT-2A" selected>BSIT-2A</option>
                                        <option value="BSIT-2B">BSIT-2B</option>
                                        <option value="BSIT-3A">BSIT-3A</option>
                                        <option value="BSIT-4A">BSIT-4A</option>
                                    </select>
                                </div>

                                <div class="space-y-1">
                                    <label for="enrollment_status" class="block text-xs font-extrabold text-slate-800">Enrollment Status</label>
                                    <select id="enrollment_status" name="enrollment_status" class="w-full px-4 py-2.5 text-xs bg-white border border-slate-200 rounded-xl font-semibold text-slate-800 focus:bg-white focus:border-[#102b70] focus:ring-2 focus:ring-[#102b70]/10 outline-none transition-all shadow-2xs">
                                        <option value="Regular" selected>Regular</option>
                                        <option value="Irregular">Irregular</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- STEP 3: CONTACT INFO -->
                        <div id="wizard-step-3" class="wizard-step-panel hidden space-y-4">
                            <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-900 border-b border-slate-100 pb-2">Contact Information</h3>
                            
                            <div class="space-y-1">
                                <label for="email" class="block text-xs font-extrabold text-slate-800">Email Address <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                                    </div>
                                    <input type="email" id="email" name="email" value="{{ old('email', $member->email) }}" placeholder="student@pgpc.edu.ph" class="w-full pl-9 pr-4 py-2.5 text-xs bg-white border border-slate-200 rounded-xl font-semibold text-slate-800 focus:bg-white focus:border-[#102b70] focus:ring-2 focus:ring-[#102b70]/10 outline-none transition-all shadow-2xs" required>
                                </div>
                            </div>

                            <div class="space-y-1">
                                <label for="contact_num" class="block text-xs font-extrabold text-slate-800">Phone Number</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                                    </div>
                                    <input type="text" id="contact_num" name="contact_num" value="{{ old('contact_num', $member->contact_num) }}" placeholder="0912 345 6789" class="w-full pl-9 pr-4 py-2.5 text-xs bg-white border border-slate-200 rounded-xl font-semibold text-slate-800 focus:bg-white focus:border-[#102b70] focus:ring-2 focus:ring-[#102b70]/10 outline-none transition-all shadow-2xs">
                                </div>
                            </div>

                            <div class="space-y-1">
                                <label for="address" class="block text-xs font-extrabold text-slate-800">Complete Address</label>
                                <div class="relative">
                                    <div class="absolute top-3 left-0 pl-3 pointer-events-none text-slate-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                    </div>
                                    <textarea id="address" name="address" rows="3" placeholder="Brgy, Municipality, Province" class="w-full pl-9 pr-4 py-2.5 text-xs bg-white border border-slate-200 rounded-xl font-semibold text-slate-800 focus:bg-white focus:border-[#102b70] focus:ring-2 focus:ring-[#102b70]/10 outline-none transition-all shadow-2xs">Brgy. Burgos, Padre Garcia, Batangas</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- STEP 4: REVIEW YOUR INFORMATION (Matching Mockup) -->
                        <div id="wizard-step-4" class="wizard-step-panel hidden space-y-4">
                            <div class="flex items-center justify-between border-b border-slate-200/80 pb-2">
                                <div>
                                    <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-900">Review Your Information</h3>
                                    <p class="text-[11px] text-slate-500 font-medium mt-0.5">Please review your details before completing your profile.</p>
                                </div>
                            </div>

                            <!-- Review Card 1: Personal Information -->
                            <div class="bg-white rounded-2xl p-4 border border-slate-200/90 shadow-2xs space-y-2 text-xs">
                                <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-[#102b70]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM4 21a8 8 0 0116 0" /></svg>
                                        <span class="font-extrabold text-[#102b70] uppercase text-[10px] tracking-wider">Personal Information</span>
                                    </div>
                                    <button type="button" onclick="goToWizardStep(1)" class="text-xs font-bold text-blue-600 hover:text-blue-800 hover:underline">Edit</button>
                                </div>
                                <div class="grid grid-cols-2 gap-2 text-slate-700 pt-1">
                                    <div><span class="text-slate-400 font-medium">Name:</span> <span id="rev-name" class="font-bold text-slate-900 ml-1">-</span></div>
                                    <div><span class="text-slate-400 font-medium">Student ID:</span> <span id="rev-studentid" class="font-bold text-slate-900 ml-1">-</span></div>
                                    <div><span class="text-slate-400 font-medium">Date of Birth:</span> <span id="rev-dob" class="font-bold text-slate-900 ml-1">-</span></div>
                                    <div><span class="text-slate-400 font-medium">Gender:</span> <span id="rev-gender" class="font-bold text-slate-900 ml-1">-</span></div>
                                    <div><span class="text-slate-400 font-medium">Civil Status:</span> <span id="rev-civil" class="font-bold text-slate-900 ml-1">-</span></div>
                                </div>
                            </div>

                            <!-- Review Card 2: Academic Information -->
                            <div class="bg-white rounded-2xl p-4 border border-slate-200/90 shadow-2xs space-y-2 text-xs">
                                <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-[#102b70]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" /></svg>
                                        <span class="font-extrabold text-[#102b70] uppercase text-[10px] tracking-wider">Academic Information</span>
                                    </div>
                                    <button type="button" onclick="goToWizardStep(2)" class="text-xs font-bold text-blue-600 hover:text-blue-800 hover:underline">Edit</button>
                                </div>
                                <div class="grid grid-cols-2 gap-2 text-slate-700 pt-1">
                                    <div class="col-span-2"><span class="text-slate-400 font-medium">Course:</span> <span id="rev-course" class="font-bold text-slate-900 ml-1">-</span></div>
                                    <div><span class="text-slate-400 font-medium">Year Level:</span> <span id="rev-yearlevel" class="font-bold text-slate-900 ml-1">-</span></div>
                                    <div><span class="text-slate-400 font-medium">Section:</span> <span id="rev-section" class="font-bold text-slate-900 ml-1">-</span></div>
                                    <div><span class="text-slate-400 font-medium">Enrollment Status:</span> <span id="rev-status" class="font-bold text-slate-900 ml-1">-</span></div>
                                </div>
                            </div>

                            <!-- Review Card 3: Contact Information -->
                            <div class="bg-white rounded-2xl p-4 border border-slate-200/90 shadow-2xs space-y-2 text-xs">
                                <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-[#102b70]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002-2v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                                        <span class="font-extrabold text-[#102b70] uppercase text-[10px] tracking-wider">Contact Information</span>
                                    </div>
                                    <button type="button" onclick="goToWizardStep(3)" class="text-xs font-bold text-blue-600 hover:text-blue-800 hover:underline">Edit</button>
                                </div>
                                <div class="space-y-1.5 text-slate-700 pt-1">
                                    <div><span class="text-slate-400 font-medium">Email:</span> <span id="rev-email" class="font-bold text-slate-900 ml-1">-</span></div>
                                    <div><span class="text-slate-400 font-medium">Phone:</span> <span id="rev-phone" class="font-bold text-slate-900 ml-1">-</span></div>
                                    <div><span class="text-slate-400 font-medium">Address:</span> <span id="rev-address" class="font-bold text-slate-900 ml-1">-</span></div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- WIZARD STEP CONTROLS (Matching Mockup Buttons) -->
                    <div class="flex items-center justify-between pt-6 border-t border-slate-200/80 mt-auto">
                        <button type="button" id="btn-wizard-prev" onclick="prevWizardStep()" disabled class="px-5 py-2.5 text-sm border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all inline-flex items-center gap-2 opacity-40 cursor-not-allowed">
                            &larr; Previous
                        </button>

                        <button type="button" id="btn-wizard-next" onclick="nextWizardStep()" class="px-5 py-2.5 text-sm bg-[#102b70] hover:bg-[#071943] text-white font-extrabold rounded-xl transition-all shadow-sm inline-flex items-center gap-2">
                            <span id="wizard-next-label">Next: Academic Info</span> &rarr;
                        </button>

                        <button type="submit" id="btn-wizard-submit" style="display: none;" class="px-5 py-2.5 text-sm bg-[#102b70] hover:bg-[#071943] text-white font-extrabold rounded-xl transition-all shadow-sm inline-flex items-center gap-2">
                            <svg class="w-4 h-4 text-[#fcc719]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                            <span>Confirm &amp; Complete Account</span>
                        </button>
                    </div>
                </form>

            </div>

        </div>
    </div>

    <!-- Client-side Wizard Step Switcher -->
    <script>
        let currentWizardStep = 1;

        function goToWizardStep(step) {
            currentWizardStep = step;
            updateWizardUI();
        }

        function nextWizardStep() {
            if (currentWizardStep < 4) {
                currentWizardStep++;
                updateWizardUI();
            }
        }

        function prevWizardStep() {
            if (currentWizardStep > 1) {
                currentWizardStep--;
                updateWizardUI();
            }
        }

        function updateWizardUI() {
            // Panels
            for (let i = 1; i <= 4; i++) {
                const panel = document.getElementById(`wizard-step-${i}`);
                if (panel) {
                    if (i === currentWizardStep) {
                        panel.classList.remove('hidden');
                    } else {
                        panel.classList.add('hidden');
                    }
                }
            }

            // Tabs Styling
            document.querySelectorAll('.wizard-step-tab').forEach(tab => {
                const step = parseInt(tab.getAttribute('data-step'));
                const numCircle = tab.querySelector('.step-num-circle');
                const label = tab.querySelector('.step-label');

                if (step === currentWizardStep) {
                    numCircle.className = 'step-num-circle w-8 h-8 rounded-full bg-[#102b70] text-white flex items-center justify-center text-xs font-black transition-all mb-1.5 ring-4 ring-[#102b70]/15 shadow-sm';
                    label.className = 'step-label text-[10px] font-extrabold uppercase tracking-wider text-[#102b70]';
                } else if (step < currentWizardStep) {
                    numCircle.className = 'step-num-circle w-8 h-8 rounded-full bg-emerald-500 text-white flex items-center justify-center text-xs font-black transition-all mb-1.5 shadow-xs';
                    label.className = 'step-label text-[10px] font-extrabold uppercase tracking-wider text-emerald-600';
                } else {
                    numCircle.className = 'step-num-circle w-8 h-8 rounded-full bg-slate-200 text-slate-500 flex items-center justify-center text-xs font-black transition-all mb-1.5';
                    label.className = 'step-label text-[10px] font-extrabold uppercase tracking-wider text-slate-400';
                }
            });

            // Buttons
            const prevBtn = document.getElementById('btn-wizard-prev');
            const nextBtn = document.getElementById('btn-wizard-next');
            const submitBtn = document.getElementById('btn-wizard-submit');
            const nextLabel = document.getElementById('wizard-next-label');

            if (prevBtn) {
                if (currentWizardStep === 1) {
                    prevBtn.disabled = true;
                    prevBtn.classList.add('opacity-40', 'cursor-not-allowed');
                } else {
                    prevBtn.disabled = false;
                    prevBtn.classList.remove('opacity-40', 'cursor-not-allowed');
                }
            }

            if (currentWizardStep === 4) {
                if (nextBtn) nextBtn.style.display = 'none';
                if (submitBtn) submitBtn.style.display = 'inline-flex';

                // Populate Step 4 Review Fields
                document.getElementById('rev-name').innerText = (document.getElementById('first_name').value + ' ' + document.getElementById('last_name').value).trim() || '-';
                document.getElementById('rev-studentid').innerText = document.getElementById('student_id_number').value || '-';
                document.getElementById('rev-dob').innerText = document.getElementById('date_of_birth').value || '-';
                document.getElementById('rev-gender').innerText = document.getElementById('gender').value || '-';
                document.getElementById('rev-civil').innerText = document.getElementById('civil_status').value || '-';
                
                document.getElementById('rev-course').innerText = document.getElementById('program').value || '-';
                document.getElementById('rev-yearlevel').innerText = document.getElementById('year_level').value || '-';
                document.getElementById('rev-section').innerText = document.getElementById('section').value || '-';
                document.getElementById('rev-status').innerText = document.getElementById('enrollment_status').value || '-';

                document.getElementById('rev-email').innerText = document.getElementById('email').value || '-';
                document.getElementById('rev-phone').innerText = document.getElementById('contact_num').value || '-';
                document.getElementById('rev-address').innerText = document.getElementById('address').value || '-';

            } else {
                if (nextBtn) nextBtn.style.display = 'inline-flex';
                if (submitBtn) submitBtn.style.display = 'none';

                if (nextLabel) {
                    nextLabel.innerText = currentWizardStep === 1 ? 'Next: Academic Info' : currentWizardStep === 2 ? 'Next: Contact Info' : 'Next: Review Information';
                }
            }
        }
    </script>
</x-layout.onboarding>
