@props(['type', 'user' => null, 'isEdit' => false])

@php
    $auth = $user ? $user->memberAuth : null;
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Username <span class="text-red-500">*</span></label>
        <input type="text" name="username" value="{{ old('username', $auth->username ?? '') }}" class="input input-bordered w-full h-11 rounded-xl text-sm focus:border-[#102b70] focus:ring-[#102b70]/20" placeholder="e.g. jsantos" />
        @error('username') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
    </div>

    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Account Type <span class="text-red-500">*</span></label>
        <select name="account_type" class="select select-bordered w-full h-11 min-h-[2.75rem] rounded-xl text-sm focus:border-[#102b70] focus:ring-[#102b70]/20">
            @if($type === 'member')
                <option value="Member" {{ old('account_type', $auth->account_type ?? '') === 'Member' ? 'selected' : '' }}>Member</option>
            @else
                <option value="Librarian" {{ old('account_type', $auth->account_type ?? '') === 'Librarian' ? 'selected' : '' }}>Librarian</option>
                <option value="Administrator" {{ old('account_type', $auth->account_type ?? '') === 'Administrator' ? 'selected' : '' }}>Administrator</option>
            @endif
        </select>
        @error('account_type') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
    </div>

    @if($isEdit && $auth)
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Account Status</label>
            <select name="account_status" class="select select-bordered w-full h-11 min-h-[2.75rem] rounded-xl text-sm focus:border-[#102b70] focus:ring-[#102b70]/20">
                <option value="Active" {{ old('account_status', $auth->account_status) === 'Active' ? 'selected' : '' }}>Active</option>
                <option value="Inactive" {{ old('account_status', $auth->account_status) === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                <option value="Suspended" {{ old('account_status', $auth->account_status) === 'Suspended' ? 'selected' : '' }}>Suspended</option>
                <option value="Locked" {{ old('account_status', $auth->account_status) === 'Locked' ? 'selected' : '' }}>Locked</option>
            </select>
            @error('account_status') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
        </div>
    @else
        <input type="hidden" name="account_status" value="Active" />
    @endif

    <div class="md:col-span-2 mt-4">
        <h3 class="text-sm font-bold text-[#102b70] border-b border-gray-100 pb-2 mb-4">
            {{ $isEdit && $auth ? 'Change Password (Leave blank to keep current)' : 'Password Setup' }}
        </h3>
    </div>

    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Password {!! !$isEdit || !$auth ? '<span class="text-red-500">*</span>' : '' !!}</label>
        <input type="password" name="password" class="input input-bordered w-full h-11 rounded-xl text-sm focus:border-[#102b70] focus:ring-[#102b70]/20" placeholder="{{ $isEdit && $auth ? 'Leave blank to keep unchanged' : 'Minimum 8 characters' }}" />
        @error('password') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
    </div>

    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Confirm Password {!! !$isEdit || !$auth ? '<span class="text-red-500">*</span>' : '' !!}</label>
        <input type="password" name="password_confirmation" class="input input-bordered w-full h-11 rounded-xl text-sm focus:border-[#102b70] focus:ring-[#102b70]/20" placeholder="Re-type password" />
    </div>
</div>
