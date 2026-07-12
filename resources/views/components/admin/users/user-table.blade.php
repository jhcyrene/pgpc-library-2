@props(['users'])

<table class="table w-full">
    <thead>
        <tr class="bg-gray-50/50 text-gray-500 border-b border-gray-100">
            <th class="font-medium px-4 py-3 text-left">User</th>
            <th class="font-medium px-4 py-3 text-left">ID Number</th>
            <th class="font-medium px-4 py-3 text-left">Account Type</th>
            <th class="font-medium px-4 py-3 text-left">Status</th>
            <th class="font-medium px-4 py-3 text-left">Last Login</th>
            <th class="font-medium px-4 py-3 text-right">Actions</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-100">
        @forelse($users as $user)
            <tr class="hover:bg-gray-50/50 transition-colors">
                <td class="px-4 py-3">
                    <div class="flex items-center gap-3">
                        <div class="avatar placeholder">
                            <div class="bg-indigo-100 text-[#1A2B56] rounded-full w-10">
                                <span class="font-bold text-sm">{{ substr($user->first_name, 0, 1) }}{{ substr($user->last_name, 0, 1) }}</span>
                            </div>
                        </div>
                        <div>
                            <div class="font-semibold text-[#1A2B56]">{{ $user->first_name }} {{ $user->last_name }}</div>
                            <div class="text-xs text-gray-500">{{ $user->email ?? 'No email' }}</div>
                        </div>
                    </div>
                </td>
                <td class="px-4 py-3">
                    <span class="text-sm text-gray-600 font-medium">{{ $user->identifier }}</span>
                </td>
                <td class="px-4 py-3">
                    <x-admin.users.type-badge :type="$user->type" />
                </td>
                <td class="px-4 py-3">
                    @if($user->member_auth_id)
                        <x-admin.users.status-badge :status="$user->account_status" />
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border bg-gray-100 text-gray-800 border-gray-200">No Account</span>
                    @endif
                </td>
                <td class="px-4 py-3">
                    <div class="text-sm text-gray-600">
                        @if($user->last_login_at)
                            {{ \Carbon\Carbon::parse($user->last_login_at)->diffForHumans() }}
                        @else
                            <span class="text-gray-400">Never</span>
                        @endif
                    </div>
                </td>
                <td class="px-4 py-3 text-right">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('admin.users.show', ['type' => strtolower($user->type), 'id' => $user->id]) }}" class="btn btn-sm btn-ghost text-blue-600 hover:bg-blue-50">
                            View
                        </a>
                        <a href="{{ strtolower($user->type) === 'member' ? route('admin.members.edit', $user->id) : route('admin.librarians.edit', $user->id) }}" class="btn btn-sm btn-ghost text-gray-600">
                            Edit
                        </a>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                    <div class="flex flex-col items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <p class="font-medium text-gray-600">No users found</p>
                        <p class="text-sm text-gray-400 mt-1">Try adjusting your search or filter.</p>
                    </div>
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
