<!-- Left: Student Borrowing Tracking (2/3 Width) -->
<div class="lg:col-span-2 bg-white border border-slate-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow flex flex-col min-h-0">
    <div class="flex justify-between items-center mb-4 shrink-0">
        <div>
            <h3 class="text-lg font-extrabold text-slate-900 tracking-tight">Current Borrowers</h3>
            <p class="text-xs font-medium text-slate-500 mt-0.5">Tracking students and borrow dates</p>
        </div>
        <button type="button" disabled class="text-xs font-bold text-slate-400 bg-slate-100 px-4 py-2 rounded-lg cursor-not-allowed" title="Circulation records are coming soon">Records coming soon</button>
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
            <tbody class="divide-y divide-slate-100">
                <tr class="hover:bg-slate-50 transition-colors group">
                    <td class="px-5 py-4 font-bold text-slate-900 group-hover:text-blue-600 transition-colors">Juan Dela Cruz</td>
                    <td class="px-5 py-4 font-medium">Advanced Calculus</td>
                    <td class="px-5 py-4 text-slate-500 text-xs">July 08, 2026</td>
                    <td class="px-5 py-4 text-right">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold text-emerald-700 bg-emerald-100 border border-emerald-200">
                            Active
                        </span>
                    </td>
                </tr>
                <tr class="hover:bg-slate-50 transition-colors group">
                    <td class="px-5 py-4 font-bold text-slate-900 group-hover:text-blue-600 transition-colors">Maria Clara</td>
                    <td class="px-5 py-4 font-medium">Philippine History</td>
                    <td class="px-5 py-4 text-slate-500 text-xs">June 15, 2026</td>
                    <td class="px-5 py-4 text-right">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold text-red-700 bg-red-100 border border-red-200">
                            Overdue
                        </span>
                    </td>
                </tr>
                <tr class="hover:bg-slate-50 transition-colors group">
                    <td class="px-5 py-4 font-bold text-slate-900 group-hover:text-blue-600 transition-colors">Jose Rizal</td>
                    <td class="px-5 py-4 font-medium">Noli Me Tangere</td>
                    <td class="px-5 py-4 text-slate-500 text-xs">July 10, 2026</td>
                    <td class="px-5 py-4 text-right">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold text-emerald-700 bg-emerald-100 border border-emerald-200">
                            Active
                        </span>
                    </td>
                </tr>
                <tr class="hover:bg-slate-50 transition-colors group">
                    <td class="px-5 py-4 font-bold text-slate-900 group-hover:text-blue-600 transition-colors">Andres Bonifacio</td>
                    <td class="px-5 py-4 font-medium">Data Structures</td>
                    <td class="px-5 py-4 text-slate-500 text-xs">July 11, 2026</td>
                    <td class="px-5 py-4 text-right">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold text-emerald-700 bg-emerald-100 border border-emerald-200">
                            Active
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
