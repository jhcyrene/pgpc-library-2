@props(['type', 'user' => null])

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    @if($type === 'member')
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Student ID Number <span class="text-red-500">*</span></label>
            <input type="text" name="student_id_number" value="{{ old('student_id_number', $user->student_id_number ?? '') }}" class="input input-bordered w-full" required />
            @error('student_id_number') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
        </div>
    @else
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Employee Number <span class="text-red-500">*</span></label>
            <input type="text" name="employee_number" value="{{ old('employee_number', $user->employee_number ?? '') }}" class="input input-bordered w-full" required />
            @error('employee_number') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
        </div>
    @endif

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Email Address <span class="text-red-500">*</span></label>
        <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" class="input input-bordered w-full" required />
        @error('email') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">First Name <span class="text-red-500">*</span></label>
        <input type="text" name="first_name" value="{{ old('first_name', $user->first_name ?? '') }}" class="input input-bordered w-full" required />
        @error('first_name') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Middle Name</label>
        <input type="text" name="middle_name" value="{{ old('middle_name', $user->middle_name ?? '') }}" class="input input-bordered w-full" />
        @error('middle_name') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Last Name <span class="text-red-500">*</span></label>
        <input type="text" name="last_name" value="{{ old('last_name', $user->last_name ?? '') }}" class="input input-bordered w-full" required />
        @error('last_name') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
    </div>

    @if($type === 'member')
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Contact Number</label>
            <input type="text" name="contact_num" value="{{ old('contact_num', $user->contact_num ?? '') }}" class="input input-bordered w-full" />
            @error('contact_num') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Program/Course</label>
            <input type="text" name="program" value="{{ old('program', $user->program ?? '') }}" class="input input-bordered w-full" placeholder="e.g. BSCS" />
            @error('program') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Year Level</label>
            <input type="text" name="year_level" value="{{ old('year_level', $user->year_level ?? '') }}" class="input input-bordered w-full" placeholder="e.g. 1st Year" />
            @error('year_level') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
        </div>
    @else
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Position</label>
            <input type="text" name="position" value="{{ old('position', $user->position ?? '') }}" class="input input-bordered w-full" />
            @error('position') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
        </div>
    @endif
</div>
