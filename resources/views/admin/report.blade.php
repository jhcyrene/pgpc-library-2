<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports - PGPC Library</title>
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
                    <h1 class="text-2xl font-bold text-gray-800">System Reports</h1>
                    <p class="text-sm text-gray-500 mt-1">Generate and view analytics for library operations.</p>
                </div>
                <button class="flex items-center gap-2 bg-[#1A2B56] hover:bg-[#243B73] text-white text-sm font-bold px-4 py-2.5 rounded-lg transition-all shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Export All Data
                </button>
            </div>

            <!-- Report Options -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6 shrink-0">
                <!-- Report Card 1 -->
                <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm flex flex-col">
                    <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800">Circulation Report</h3>
                    <p class="text-sm text-gray-500 mt-1 mb-4 flex-1">Overview of borrowed, returned, and overdue books over time.</p>
                    <button class="text-sm font-bold text-[#1A2B56] hover:text-[#243B73] flex items-center gap-1 transition-colors">
                        Generate Report
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    </button>
                </div>

                <!-- Report Card 2 -->
                <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm flex flex-col">
                    <div class="w-12 h-12 bg-green-50 text-green-600 rounded-lg flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800">User Activity</h3>
                    <p class="text-sm text-gray-500 mt-1 mb-4 flex-1">Detailed statistics on user registrations, logins, and reading habits.</p>
                    <button class="text-sm font-bold text-[#1A2B56] hover:text-[#243B73] flex items-center gap-1 transition-colors">
                        Generate Report
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    </button>
                </div>

                <!-- Report Card 3 -->
                <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm flex flex-col">
                    <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-lg flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800">Fines & Penalties</h3>
                    <p class="text-sm text-gray-500 mt-1 mb-4 flex-1">Financial summary of collected fines from overdue and lost items.</p>
                    <button class="text-sm font-bold text-[#1A2B56] hover:text-[#243B73] flex items-center gap-1 transition-colors">
                        Generate Report
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    </button>
                </div>
            </div>

            <!-- Recent Generated Reports List -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm flex flex-col min-h-0 flex-1">
                <div class="p-4 border-b border-gray-200 bg-gray-50/50 rounded-t-xl flex justify-between items-center">
                    <h2 class="text-sm font-bold text-gray-800 uppercase tracking-wider">Recently Generated Reports</h2>
                </div>
                <div class="overflow-x-auto flex-1">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-white border-b border-gray-200 text-xs font-bold text-gray-500 uppercase tracking-wider">
                            <tr>
                                <th class="px-6 py-3">Report Name</th>
                                <th class="px-6 py-3">Date Generated</th>
                                <th class="px-6 py-3">Generated By</th>
                                <th class="px-6 py-3">Format</th>
                                <th class="px-6 py-3 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <!-- Row 1 -->
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                        <span class="text-sm font-bold text-gray-800">Monthly Circulation - June 2026</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">Today, 10:45 AM</td>
                                <td class="px-6 py-4 text-sm text-gray-600">Admin User</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-50 text-red-700 border border-red-100">PDF</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button class="text-[#1A2B56] hover:text-[#243B73] font-medium text-sm">Download</button>
                                </td>
                            </tr>
                            
                            <!-- Row 2 -->
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                        <span class="text-sm font-bold text-gray-800">Overdue Books Summary</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">Yesterday, 4:20 PM</td>
                                <td class="px-6 py-4 text-sm text-gray-600">Librarian Staff</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-50 text-green-700 border border-green-100">Excel</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button class="text-[#1A2B56] hover:text-[#243B73] font-medium text-sm">Download</button>
                                </td>
                            </tr>
                            
                            <!-- Row 3 -->
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                        <span class="text-sm font-bold text-gray-800">Annual User Registration Stats</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">June 25, 2026</td>
                                <td class="px-6 py-4 text-sm text-gray-600">Admin User</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">CSV</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button class="text-[#1A2B56] hover:text-[#243B73] font-medium text-sm">Download</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>
</body>
</html>
