<!-- Left: Student Borrowing Tracking (2/3 Width) -->
<div class="lg:col-span-2 min-w-0 bg-white border border-slate-200 rounded-2xl p-4 sm:p-6 shadow-sm hover:shadow-md transition-shadow flex flex-col min-h-[320px] lg:min-h-0">
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 mb-4 shrink-0">
        <div>
            <h3 class="text-lg font-extrabold text-slate-900 tracking-tight">Current Borrowers</h3>
            <p class="text-xs font-medium text-slate-500 mt-0.5">Tracking students and borrow dates</p>
        </div>
        <a href="{{ route('admin.borrows.index') }}" class="self-start sm:self-auto text-xs font-bold text-[#102b70] bg-blue-100 hover:bg-blue-200 px-4 py-2 rounded-lg transition-colors" title="View all circulation records">View All Records</a>
    </div>
    
    <!-- Student Table -->
    <div class="responsive-table-scroll w-full flex-1 min-h-[220px] lg:min-h-0 overflow-y-auto rounded-xl border border-slate-200 scrollbar-thin scrollbar-thumb-slate-200">
        <table class="mobile-card-table w-full text-left text-sm text-slate-600 whitespace-nowrap">
            <thead class="bg-slate-50 text-slate-500 font-bold border-b border-slate-200 uppercase text-xs tracking-wider">
                <tr>
                    <th class="px-5 py-3.5">Member</th>
                    <th class="px-5 py-3.5">Book</th>
                    <th class="hidden px-5 py-3.5 sm:table-cell">Borrowed</th>
                    <th class="px-5 py-3.5 text-right">Status</th>
                </tr>
            </thead>
            <tbody id="dashboard-borrowers-tbody" class="divide-y divide-slate-100">
                <!-- Javascript will inject rows here -->
            </tbody>
        </table>
    </div>
</div>
