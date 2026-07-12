<x-layout.admin>
    <x-admin.page-header 
        title="Add {{ ucfirst($type) }}" 
        description="Register a new {{ $type }} and optionally create their login account."
        :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
            ['label' => 'Users', 'url' => route('admin.users.index')],
            ['label' => 'Add ' . ucfirst($type)]
        ]"
    />

    <div class="max-w-4xl" x-data="{ createAccount: {{ old('create_account') ? 'true' : 'false' }} }">
        <form action="{{ $type === 'member' ? route('admin.members.store') : route('admin.librarians.store') }}" method="POST">
            @csrf
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
                <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                    <h2 class="text-lg font-bold text-[#1A2B56]">Profile Information</h2>
                    <p class="text-sm text-gray-500">Enter the basic details for the {{ $type }}.</p>
                </div>
                <div class="p-6">
                    <x-admin.users.user-form :type="$type" />
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
                <div class="p-6 border-b border-gray-100 bg-gray-50/50 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h2 class="text-lg font-bold text-[#1A2B56]">Account Settings</h2>
                        <p class="text-sm text-gray-500">Create login credentials for the system.</p>
                    </div>
                    <!-- Used a standard checkbox if Alpine fails, but Alpine is requested off if absent. Wait, standard JS is safer since the user doesn't want Alpine unless it is already there. -->
                    <!-- I will use vanilla JS since Alpine might not be included -->
                    <label class="flex items-center cursor-pointer">
                        <span class="mr-3 font-medium text-sm text-gray-700">Create Account</span> 
                        <input type="checkbox" name="create_account" value="1" id="createAccountToggle" class="toggle toggle-primary" {{ old('create_account') ? 'checked' : '' }} onchange="document.getElementById('accountFormContainer').style.display = this.checked ? 'block' : 'none'" />
                    </label>
                </div>
                <div class="p-6" id="accountFormContainer" style="display: {{ old('create_account') ? 'block' : 'none' }}">
                    <x-admin.users.account-form :type="$type" />
                </div>
            </div>

            <div class="flex justify-end gap-3 mb-8">
                <a href="{{ route('admin.users.index', ['type' => $type]) }}" class="btn btn-ghost">Cancel</a>
                <button type="submit" class="btn btn-primary">Save {{ ucfirst($type) }}</button>
            </div>
        </form>
    </div>
</x-layout.admin>
