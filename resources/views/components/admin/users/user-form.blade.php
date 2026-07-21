@props(['type', 'user' => null])

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    @if($type === 'member')
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Student ID Number <span class="text-red-500">*</span></label>
            <input type="text" name="student_id_number" value="{{ old('student_id_number', $user->student_id_number ?? '') }}" class="input input-bordered w-full h-11 rounded-xl text-sm focus:border-[#102b70] focus:ring-[#102b70]/20" placeholder="e.g. 2024-00123" required />
            @error('student_id_number') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
        </div>
    @else
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Employee Number <span class="text-red-500">*</span></label>
            <input type="text" name="employee_number" value="{{ old('employee_number', $user->employee_number ?? '') }}" class="input input-bordered w-full h-11 rounded-xl text-sm focus:border-[#102b70] focus:ring-[#102b70]/20" placeholder="e.g. EMP-2024-01" required />
            @error('employee_number') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
        </div>
    @endif

    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Email Address <span class="text-red-500">*</span></label>
        <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" class="input input-bordered w-full h-11 rounded-xl text-sm focus:border-[#102b70] focus:ring-[#102b70]/20" placeholder="e.g. student@pgpc.edu.ph" required />
        @error('email') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
    </div>

    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-1.5">First Name <span class="text-red-500">*</span></label>
        <input type="text" name="first_name" value="{{ old('first_name', $user->first_name ?? '') }}" class="input input-bordered w-full h-11 rounded-xl text-sm focus:border-[#102b70] focus:ring-[#102b70]/20" placeholder="e.g. Juan" required />
        @error('first_name') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
    </div>

    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Middle Name</label>
        <input type="text" name="middle_name" value="{{ old('middle_name', $user->middle_name ?? '') }}" class="input input-bordered w-full h-11 rounded-xl text-sm focus:border-[#102b70] focus:ring-[#102b70]/20" placeholder="e.g. Dela Cruz" />
        @error('middle_name') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
    </div>

    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Last Name <span class="text-red-500">*</span></label>
        <input type="text" name="last_name" value="{{ old('last_name', $user->last_name ?? '') }}" class="input input-bordered w-full h-11 rounded-xl text-sm focus:border-[#102b70] focus:ring-[#102b70]/20" placeholder="e.g. Santos" required />
        @error('last_name') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
    </div>

    @if($type === 'member')
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Contact Number</label>
            <input type="text" name="contact_num" value="{{ old('contact_num', $user->contact_num ?? '') }}" class="input input-bordered w-full h-11 rounded-xl text-sm focus:border-[#102b70] focus:ring-[#102b70]/20" placeholder="e.g. +63 912 345 6789" />
            @error('contact_num') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Program/Course</label>
            <select name="program" class="select select-bordered w-full h-11 min-h-[2.75rem] rounded-xl text-sm focus:border-[#102b70] focus:ring-[#102b70]/20">
                <option value="" disabled @selected(!old('program', $user->program ?? ''))>Select program / course</option>
                @foreach(['BSCS', 'BSIT', 'BSCPE', 'BSEMC', 'BSIS', 'BSA', 'BSHM', 'BSTM', 'BSEd'] as $prog)
                    <option value="{{ $prog }}" @selected(old('program', $user->program ?? '') === $prog)>{{ $prog }}</option>
                @endforeach
            </select>
            @error('program') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Year Level</label>
            <select name="year_level" class="select select-bordered w-full h-11 min-h-[2.75rem] rounded-xl text-sm focus:border-[#102b70] focus:ring-[#102b70]/20">
                <option value="" disabled @selected(!old('year_level', $user->year_level ?? ''))>Select year level</option>
                @foreach(['1st Year', '2nd Year', '3rd Year', '4th Year'] as $year)
                    <option value="{{ $year }}" @selected(old('year_level', $user->year_level ?? '') === $year)>{{ $year }}</option>
                @endforeach
            </select>
            @error('year_level') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
        </div>
    @else
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Position</label>
            <input type="text" name="position" value="{{ old('position', $user->position ?? '') }}" class="input input-bordered w-full h-11 rounded-xl text-sm focus:border-[#102b70] focus:ring-[#102b70]/20" placeholder="e.g. Chief Librarian" />
            @error('position') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
        </div>
    @endif
</div>
