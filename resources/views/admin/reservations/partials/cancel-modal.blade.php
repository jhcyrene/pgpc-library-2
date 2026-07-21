<dialog id="cancelConfirmModal" class="modal modal-bottom sm:modal-middle font-sans">
    <div class="modal-box w-[calc(100%-2rem)] max-w-md bg-white p-6 sm:p-7 rounded-3xl text-center relative shadow-2xl border border-slate-100">
        <!-- Close Button -->
        <button type="button" onclick="closeCancelModal()" class="w-8 h-8 rounded-full text-slate-400 hover:text-slate-600 hover:bg-slate-100 flex items-center justify-center absolute right-4 top-4 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>

        <!-- Warning Icon -->
        <div class="w-12 h-12 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center mx-auto mb-3 shadow-xs">
            <svg class="w-6 h-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        </div>

        <h3 class="text-xl font-extrabold text-slate-900 tracking-tight">Cancel Reservation?</h3>
        <p class="text-xs font-medium text-slate-500 max-w-xs mx-auto mt-1 mb-5">
            Are you sure you want to cancel this reservation? This action cannot be undone.
        </p>

        <!-- Cancel Form -->
        <form id="cancel-reservation-form" action="" method="POST" class="space-y-4 text-left">
            @csrf
            @method('PATCH')
            <input type="hidden" name="status" value="Cancelled">

            <!-- Reason Select Dropdown -->
            <div>
                <label for="cancel_reason" class="block text-xs font-bold text-slate-700 mb-1">Reason (optional)</label>
                <select id="cancel_reason" name="reason" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-800 focus:bg-white focus:border-[#102b70] focus:ring-2 focus:ring-[#102b70]/20 outline-none transition-colors">
                    <option value="">Select a reason</option>
                    <option value="student_request">Student Request</option>
                    <option value="item_unavailable">Book Copy Unavailable</option>
                    <option value="hold_expired">Hold Expired</option>
                    <option value="other">Other</option>
                </select>
            </div>

            <!-- Additional Details Textarea -->
            <div>
                <div class="flex justify-between items-center mb-1">
                    <label for="cancel_details" class="block text-xs font-bold text-slate-700">Additional details (optional)...</label>
                    <span id="char-count" class="text-[10px] text-slate-400 font-medium">0/300</span>
                </div>
                <textarea id="cancel_details" name="details" maxlength="300" oninput="document.getElementById('char-count').textContent = this.value.length + '/300'" rows="3" class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-[#102b70] focus:ring-2 focus:ring-[#102b70]/20 outline-none transition-colors placeholder:text-slate-400" placeholder="Provide extra context for student log..."></textarea>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-between gap-3 pt-3">
                <button type="button" onclick="closeCancelModal()" class="w-1/2 py-2.5 border border-slate-200 hover:bg-slate-50 text-slate-700 font-bold text-xs rounded-xl transition-all">
                    Keep Reservation
                </button>
                <button type="submit" class="w-1/2 py-2.5 bg-red-600 hover:bg-red-700 text-white font-extrabold text-xs rounded-xl transition-all shadow-sm">
                    Confirm Cancel
                </button>
            </div>
        </form>
    </div>
    <form method="dialog" class="modal-backdrop bg-slate-950/50 backdrop-blur-[2px]"><button>close</button></form>
</dialog>
