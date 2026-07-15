<x-layout.admin>
<div class="h-full flex flex-col bg-gray-50/50 p-4 md:p-6 lg:p-8">
    <!-- Header -->
    <div class="mb-8">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900 tracking-tight">Borrows</h1>
            <p class="text-sm md:text-base text-gray-500 mt-1">Monitor and manage all borrowing transactions.</p>
        </div>

    <x-admin.borrows.stats />

    <!-- Main Content Panel -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 flex flex-col flex-1 overflow-hidden relative">
        <x-admin.borrows.filters />
        <x-admin.borrows.table />
    </div>
</div>

<x-admin.borrows.modal />

<!-- Alert Container -->
<div id="borrows-alert-container" class="fixed top-6 right-6 z-[100] flex flex-col gap-2 pointer-events-none"></div>

<x-admin.borrows.scripts />
</x-layout.admin>
