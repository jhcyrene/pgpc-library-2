<!-- Left: Student Borrowing Tracking (2/3 Width) -->
<div class="lg:col-span-2 bg-white border border-slate-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow flex flex-col min-h-0">
    <div class="flex justify-between items-center mb-4 shrink-0">
        <div>
            <h3 class="text-lg font-extrabold text-slate-900 tracking-tight">Current Borrowers</h3>
            <p class="text-xs font-medium text-slate-500 mt-0.5">Tracking students and borrow dates</p>
        </div>
        <a href="{{ route('admin.borrows.index') }}" class="text-xs font-bold text-[#102b70] bg-blue-100 hover:bg-blue-200 px-4 py-2 rounded-lg transition-colors" title="View all circulation records">View All Records</a>
    </div>
    
    <!-- Student Table -->
    <div class="w-full flex-1 overflow-y-auto rounded-xl border border-slate-200 scrollbar-thin scrollbar-thumb-slate-200">
        <table class="w-full text-left text-sm text-slate-600 whitespace-nowrap">
            <thead class="bg-slate-50 text-slate-500 font-bold border-b border-slate-200 uppercase text-xs tracking-wider sticky top-0 z-10">
                <tr>
                    <th class="px-5 py-3.5">Student Name</th>
                    <th class="px-5 py-3.5">Book Title</th>
                    <th class="px-5 py-3.5">Date Borrowed</th>
                    <th class="px-5 py-3.5 text-right">Status</th>
                </tr>
            </thead>
            <tbody id="dashboard-borrowers-tbody" class="divide-y divide-slate-100">
                <!-- Javascript will inject rows here -->
            </tbody>
        </table>
    </div>
</div>
