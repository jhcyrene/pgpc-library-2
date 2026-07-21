<x-layout.admin>
    <div class="mb-6">
        <x-admin.breadcrumbs :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
            ['label' => 'Users', 'url' => route('admin.users.index')],
            ['label' => 'View ' . ucfirst($type)]
        ]" />
    </div>

    @include('admin.users.partials.show-content')
</x-layout.admin>
