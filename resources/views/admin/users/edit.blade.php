<x-layout.admin>
    <x-admin.page-header 
        title="Edit {{ ucfirst($type) }}" 
        description="Update the {{ $type }}'s profile and account settings."
        :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
            ['label' => 'Users', 'url' => route('admin.users.index')],
            ['label' => 'Edit ' . ucfirst($type)]
        ]"
    >
        <x-slot:actions>
            <a href="{{ route('admin.users.show', ['type' => $type, 'id' => $type === 'member' ? $user->member_id : $user->librarian_id]) }}" class="btn btn-outline btn-sm bg-white">
                View Profile
            </a>
        </x-slot:actions>
    </x-admin.page-header>

    <div class="max-w-4xl">
        <form action="{{ $type === 'member' ? route('admin.members.update', $user->member_id) : route('admin.librarians.update', $user->librarian_id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
                <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                    <h2 class="text-lg font-bold text-[#1A2B56]">Profile Information</h2>
                    <p class="text-sm text-gray-500">Update the basic details for the {{ $type }}.</p>
                </div>
                <div class="p-6">
                    <x-admin.users.user-form :type="$type" :user="$user" />
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
                <div class="p-6 border-b border-gray-100 bg-gray-50/50 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h2 class="text-lg font-bold text-[#1A2B56]">Account Settings</h2>
                        <p class="text-sm text-gray-500">
                            @if($user->memberAuth)
                                Manage login credentials and account access.
                            @else
                                This {{ $type }} does not have an account yet. Enable to create one.
                            @endif
                        </p>
                    </div>
                    @if(!$user->memberAuth)
                        <label class="flex items-center cursor-pointer">
                            <span class="mr-3 font-medium text-sm text-gray-700">Create Account</span> 
                            <input type="checkbox" name="create_account" value="1" id="createAccountToggleEdit" class="toggle toggle-primary" {{ old('create_account') ? 'checked' : '' }} onchange="document.getElementById('accountFormContainerEdit').style.display = this.checked ? 'block' : 'none'" />
                        </label>
                    @else
                        <input type="hidden" name="create_account" value="1" />
                        <x-admin.users.status-badge :status="$user->memberAuth->account_status" />
                    @endif
                </div>
                <div class="p-6" id="accountFormContainerEdit" style="display: {{ (old('create_account') || $user->memberAuth) ? 'block' : 'none' }}">
                    <x-admin.users.account-form :type="$type" :user="$user" :is-edit="true" />
                </div>
            </div>

            <div class="flex justify-end gap-3 mb-8">
                <a href="{{ route('admin.users.index', ['type' => $type]) }}" class="btn btn-ghost">Cancel</a>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </form>
    </div>
</x-layout.admin>
