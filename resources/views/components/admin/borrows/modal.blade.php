<!-- Drawer / Modal for Details -->
<dialog id="loan-details-modal" class="modal modal-bottom sm:modal-middle">
    <div class="modal-box p-0 overflow-hidden sm:rounded-2xl max-w-3xl flex flex-col max-h-[90dvh]">
        <div class="p-4 sm:p-6 border-b border-primary/20 bg-primary flex justify-between items-start shrink-0">
            <div>
                <h3 class="text-xl font-bold text-white">Borrow Details</h3>
                <p class="text-sm text-white/80 mt-1" id="modal-subtitle">Loading...</p>
            </div>
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost text-white hover:bg-white/20 border-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </form>
        </div>
        
        <div class="p-4 sm:p-6 overflow-y-auto flex-1">
            <div id="modal-content">
                <!-- Injected by JS -->
            </div>
        </div>

        <div class="p-4 border-t border-gray-100 bg-gray-50 flex flex-col sm:flex-row justify-end gap-3 shrink-0" id="modal-actions">
            <form method="dialog">
                <button class="btn btn-ghost font-medium">Close</button>
            </form>
            <button class="btn bg-brand-navy hover:bg-brand-navy-light text-white font-bold shadow-md shadow-brand-navy/20 border-none" onclick="window.location.href='{{ route('admin.circulation.index') }}'">
                Go to Circulation Desk
            </button>   
        </div>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>

