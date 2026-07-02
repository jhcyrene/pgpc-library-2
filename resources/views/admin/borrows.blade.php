<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrows Management - PGPC Library</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; background-color: #F4F7F6; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="bg-[#F4F7F6] text-gray-800 h-screen overflow-hidden flex">

    <!-- Sidebar Navbar -->
    <x-admin.navbar />  

    <!-- Main Content Wrapper -->
    <div class="flex-1 flex flex-col min-w-0 h-screen overflow-hidden bg-[#F4F7F6]">
        
        <!-- Top Header -->
        <x-admin.header />

        <!-- Main Dashboard Content -->
        <main class="flex-1 flex flex-col p-6 min-h-0 overflow-y-auto">
            <!-- Page Header -->
            <div class="flex items-center justify-between mb-6 shrink-0">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Borrows Management</h1>
                    <p class="text-sm text-gray-500 mt-1">Track active borrows, returns, and overdue items.</p>
                </div>
                <button class="flex items-center gap-2 bg-[#1A2B56] hover:bg-[#243B73] text-white text-sm font-bold px-4 py-2.5 rounded-lg transition-all shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    New Borrow Record
                </button>
            </div>

            <!-- Filters & Search -->
            <div class="bg-white rounded-t-xl border border-gray-200 p-4 flex flex-col sm:flex-row items-center justify-between gap-4 shrink-0">
                <div class="relative w-full sm:w-96">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" class="block w-full pl-9 pr-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-1 focus:ring-[#1A2B56] focus:border-[#1A2B56] outline-none" placeholder="Search by Transaction ID, User, or Book...">
                </div>
                <div class="flex items-center gap-3 w-full sm:w-auto">
                    <select class="border border-gray-200 rounded-lg text-sm px-3 py-2 outline-none focus:ring-1 focus:ring-[#1A2B56] bg-gray-50 text-gray-700 font-medium">
                        <option>All Status</option>
                        <option>Active</option>
                        <option>Overdue</option>
                        <option>Returned</option>
                    </select>
                </div>
            </div>

            <!-- Table -->
            <div class="bg-white border-x border-b border-gray-200 rounded-b-xl shadow-sm flex flex-col min-h-0 flex-1">
                <div class="overflow-x-auto flex-1">
                    <table class="w-full text-left border-collapse">
                        <thead class="sticky top-0 z-10 bg-gray-50 border-y border-gray-200 text-xs font-bold text-gray-500 uppercase tracking-wider shadow-sm">
                            <tr>
                                <th class="px-6 py-3">Transaction ID</th>
                                <th class="px-6 py-3">User Details</th>
                                <th class="px-6 py-3">Book Details</th>
                                <th class="px-6 py-3">Dates</th>
                                <th class="px-6 py-3">Status</th>
                                <th class="px-6 py-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <!-- Row 1: Overdue -->
                            <tr class="bg-red-50/50 hover:bg-red-50 transition-colors group border-l-2 border-l-red-500">
                                <td class="px-6 py-4 text-sm font-bold text-gray-800">#TRX-99321</td>
                                <td class="px-6 py-4">
                                    <p class="text-sm font-bold text-gray-800">Michael Johnson</p>
                                    <p class="text-xs text-gray-500">Student • 2020-0982</p>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-sm font-bold text-gray-800">Data Structures in C++</p>
                                    <p class="text-xs text-gray-500">ISBN: 978-0134444336</p>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <p class="text-gray-500">Borrowed: <span class="text-gray-800 font-medium">Oct 12, 2023</span></p>
                                    <p class="text-red-600 font-bold mt-0.5">Due: Oct 26, 2023</p>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-md text-xs font-bold bg-red-100 text-red-700 border border-red-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-600 animate-pulse"></span> Overdue (12 Days)
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button class="bg-green-50 text-green-600 hover:text-white hover:bg-green-600 border border-green-100 hover:border-green-600 transition-colors px-2 py-1.5 rounded-md flex items-center justify-center shadow-sm" title="Mark as Returned">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                        </button>
                                        <button class="bg-blue-50 text-blue-600 hover:text-white hover:bg-blue-600 border border-blue-100 hover:border-blue-600 transition-colors px-2 py-1.5 rounded-md flex items-center justify-center shadow-sm" title="Notify User">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            
                            <!-- Row 2: Active -->
                            <tr class="hover:bg-gray-50 transition-colors group">
                                <td class="px-6 py-4 text-sm font-bold text-gray-800">#TRX-99405</td>
                                <td class="px-6 py-4">
                                    <p class="text-sm font-bold text-gray-800">Jane Smith</p>
                                    <p class="text-xs text-gray-500">Faculty • F-2019-032</p>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-sm font-bold text-gray-800">Advanced Engineering Mathematics</p>
                                    <p class="text-xs text-gray-500">ISBN: 978-0470458365</p>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <p class="text-gray-500">Borrowed: <span class="text-gray-800 font-medium">Nov 02, 2023</span></p>
                                    <p class="text-gray-500 mt-0.5">Due: <span class="text-gray-800 font-medium">Nov 16, 2023</span></p>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-md text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Active
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button class="bg-green-50 text-green-600 hover:text-white hover:bg-green-600 border border-green-100 hover:border-green-600 transition-colors px-2 py-1.5 rounded-md flex items-center justify-center shadow-sm" title="Mark as Returned">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                        </button>
                                        <button class="bg-blue-50 text-blue-600 hover:text-white hover:bg-blue-600 border border-blue-100 hover:border-blue-600 transition-colors px-2 py-1.5 rounded-md flex items-center justify-center shadow-sm" title="View Details">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            
                            <!-- Row 3: Returned -->
                            <tr class="hover:bg-gray-50 transition-colors group opacity-75">
                                <td class="px-6 py-4 text-sm font-bold text-gray-500">#TRX-99002</td>
                                <td class="px-6 py-4">
                                    <p class="text-sm font-bold text-gray-800">John Doe</p>
                                    <p class="text-xs text-gray-500">Student • 2021-0145</p>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-sm font-bold text-gray-800">Software Engineering 10th Ed.</p>
                                    <p class="text-xs text-gray-500">ISBN: 978-0133943030</p>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <p class="text-gray-500">Borrowed: <span class="text-gray-600">Sep 15, 2023</span></p>
                                    <p class="text-gray-500 mt-0.5">Returned: <span class="text-gray-600 font-medium">Sep 28, 2023</span></p>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-md text-xs font-bold bg-green-50 text-green-700 border border-green-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg> Returned
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button class="bg-blue-50 text-blue-600 hover:text-white hover:bg-blue-600 border border-blue-100 hover:border-blue-600 transition-colors px-2 py-1.5 rounded-md flex items-center justify-center shadow-sm" title="View Details">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex items-center justify-between shrink-0">
                    <span class="text-sm text-gray-500">Showing <span class="font-bold text-gray-800">1</span> to <span class="font-bold text-gray-800">3</span> of <span class="font-bold text-gray-800">1,402</span> records</span>
                    <div class="flex items-center gap-1">
                        <button class="px-3 py-1.5 border border-gray-300 rounded text-sm font-medium text-gray-500 bg-white hover:bg-gray-50 disabled:opacity-50 transition-colors" disabled>Previous</button>
                        <button class="px-3 py-1.5 border border-[#1A2B56] rounded text-sm font-bold text-white bg-[#1A2B56] shadow-sm">1</button>
                        <button class="px-3 py-1.5 border border-gray-300 rounded text-sm font-medium text-gray-600 bg-white hover:bg-gray-50 transition-colors">2</button>
                        <button class="px-3 py-1.5 border border-gray-300 rounded text-sm font-medium text-gray-600 bg-white hover:bg-gray-50 transition-colors">3</button>
                        <span class="px-2 text-gray-400">...</span>
                        <button class="px-3 py-1.5 border border-gray-300 rounded text-sm font-medium text-gray-600 bg-white hover:bg-gray-50 transition-colors">141</button>
                        <button class="px-3 py-1.5 border border-gray-300 rounded text-sm font-medium text-gray-600 bg-white hover:bg-gray-50 transition-colors">Next</button>
                    </div>
                </div>
            </div>

        </main>
    </div>
</body>
</html>
