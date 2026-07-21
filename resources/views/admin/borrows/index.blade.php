<x-layout.admin>
<div class="h-full flex flex-col bg-gray-50/50 p-4 md:p-6 lg:p-8">
    <!-- Header -->
    <div class="mb-8">
        <div>
            <h1 class="text-2xl  md:text-3xl font-bold text-gray-900 tracking-tight">Borrows</h1>
            <p class="text-sm md:text-base text-gray-500 mt-1">Monitor and manage all borrowing transactions.</p>
        </div>

    <x-admin.borrows.stats />

    <!-- Main Content Panel -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 flex flex-col flex-1 overflow-hidden relative">
        <x-admin.borrows.filters />
        <x-admin.borrows.table />
    </div>
</div>

<dialog id="borrowsDetailModal" class="modal modal-bottom sm:modal-middle">
    <div class="modal-box w-[calc(100%-1rem)] max-w-none max-h-[calc(100dvh-1rem)] overflow-y-auto sm:w-11/12 sm:max-w-5xl bg-gray-50 p-0 rounded-2xl">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-4 top-4 z-20 text-gray-500 hover:bg-gray-100 bg-white shadow-sm border border-gray-100">✕</button>
        </form>
        <div id="borrowsDetailModalContent" class="p-6 sm:p-8 transition-opacity duration-300">
            <!-- AJAX Content goes here -->
        </div>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>
<!-- Alert Container -->
<div id="borrows-alert-container" class="fixed top-6 right-6 z-[100] flex flex-col gap-2 pointer-events-none"></div>

<x-admin.borrows.scripts />
</x-layout.admin>

