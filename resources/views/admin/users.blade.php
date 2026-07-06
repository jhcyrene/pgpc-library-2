<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management - PGPC Library</title>
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
                    <h1 class="text-2xl font-bold text-gray-800">User Management</h1>
                    <p class="text-sm text-gray-500 mt-1">Manage library patrons, students, and faculty members.</p>
                </div>
                <button class="flex items-center gap-2 bg-[#1A2B56] hover:bg-[#243B73] text-white text-sm font-bold px-4 py-2.5 rounded-lg transition-all shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Add New User
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
                    <input type="text" class="block w-full pl-9 pr-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-1 focus:ring-[#1A2B56] focus:border-[#1A2B56] outline-none" placeholder="Search by name, email, or ID number...">
                </div>
                <div class="flex items-center gap-3 w-full sm:w-auto">
                    <select class="border border-gray-200 rounded-lg text-sm px-3 py-2 outline-none focus:ring-1 focus:ring-[#1A2B56] bg-gray-50 text-gray-700 font-medium">
                        <option>All Types</option>
                        <option>Student</option>
                        <option>Faculty</option>
                        <option>Staff</option>
                    </select>
                    <select class="border border-gray-200 rounded-lg text-sm px-3 py-2 outline-none focus:ring-1 focus:ring-[#1A2B56] bg-gray-50 text-gray-700 font-medium">
                        <option>All Status</option>
                        <option>Active</option>
                        <option>Suspended</option>
                        <option>Inactive</option>
                    </select>
                </div>
            </div>

            <!-- Table -->
            <div class="bg-white border-x border-b border-gray-200 rounded-b-xl shadow-sm flex flex-col min-h-0 flex-1">
                <div class="overflow-x-auto flex-1">
                    <table class="w-full text-left border-collapse">
                        <thead class="sticky top-0 z-10 bg-gray-50 border-y border-gray-200 text-xs font-bold text-gray-500 uppercase tracking-wider shadow-sm">
                            <tr>
                                <th class="px-6 py-3">Student Details</th>
                                <th class="px-6 py-3">ID Number</th>
                                <th class="px-6 py-3">Type</th>
                                <th class="px-6 py-3">Current Borrows</th>
                                <th class="px-6 py-3">Status</th>
                                <th class="px-6 py-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <!-- Row 1 -->
                            <tr class="hover:bg-gray-50 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 bg-blue-100 rounded-full border border-blue-200 flex items-center justify-center shrink-0 text-blue-700 font-bold text-sm">
                                            JD
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-800">John Doe</p>
                                            <p class="text-xs text-gray-500 mt-0.5">john.doe@student.pgpc.edu.ph</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-700">2021-0145</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-indigo-50 text-indigo-700 border border-indigo-100">Student</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm font-bold text-gray-800">2 <span class="text-gray-400 font-normal">/ 3</span></span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-md text-xs font-bold bg-green-50 text-green-700 border border-green-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Active
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button class="bg-blue-50 text-blue-600 hover:text-white hover:bg-blue-600 border border-blue-100 hover:border-blue-600 transition-colors px-2 py-1.5 rounded-md flex items-center justify-center shadow-sm" title="View Profile">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                        </button>
                                        <button class="bg-gray-50 text-gray-500 hover:text-[#1A2B56] hover:bg-gray-100 border border-gray-200 transition-colors px-2 py-1.5 rounded-md flex items-center justify-center shadow-sm" title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                        </button>
                                        <button class="bg-red-50 text-red-500 hover:text-white hover:bg-red-500 border border-red-100 hover:border-red-500 transition-colors px-2 py-1.5 rounded-md flex items-center justify-center shadow-sm" title="Suspend">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" /></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            
                            <!-- Row 2 -->
                            <tr class="hover:bg-gray-50 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 bg-purple-100 rounded-full border border-purple-200 flex items-center justify-center shrink-0 text-purple-700 font-bold text-sm">
                                            JS
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-800">Jane Smith</p>
                                            <p class="text-xs text-gray-500 mt-0.5">jane.smith@faculty.pgpc.edu.ph</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-700">F-2019-032</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-purple-50 text-purple-700 border border-purple-100">Faculty</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm font-bold text-gray-800">1 <span class="text-gray-400 font-normal">/ 5</span></span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-md text-xs font-bold bg-green-50 text-green-700 border border-green-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Active
                                    </span>
                                </td>
                              <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button class="bg-blue-50 text-blue-600 hover:text-white hover:bg-blue-600 border border-blue-100 hover:border-blue-600 transition-colors px-2 py-1.5 rounded-md flex items-center justify-center shadow-sm" title="View Profile">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                        </button>
                                        <button class="bg-gray-50 text-gray-500 hover:text-[#1A2B56] hover:bg-gray-100 border border-gray-200 transition-colors px-2 py-1.5 rounded-md flex items-center justify-center shadow-sm" title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                        </button>
                                        <button class="bg-red-50 text-red-500 hover:text-white hover:bg-red-500 border border-red-100 hover:border-red-500 transition-colors px-2 py-1.5 rounded-md flex items-center justify-center shadow-sm" title="Suspend">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" /></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            
                            <!-- Row 3 -->
                            <tr class="hover:bg-gray-50 transition-colors group bg-red-50/30">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 bg-red-100 rounded-full border border-red-200 flex items-center justify-center shrink-0 text-red-700 font-bold text-sm">
                                            MJ
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-800">Michael Johnson</p>
                                            <p class="text-xs text-gray-500 mt-0.5">michael.j@student.pgpc.edu.ph</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-700">2020-0982</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-indigo-50 text-indigo-700 border border-indigo-100">Student</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm font-bold text-gray-800">0 <span class="text-gray-400 font-normal">/ 3</span></span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-md text-xs font-bold bg-red-50 text-red-700 border border-red-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Suspended
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button class="bg-blue-50 text-blue-600 hover:text-white hover:bg-blue-600 border border-blue-100 hover:border-blue-600 transition-colors px-2 py-1.5 rounded-md flex items-center justify-center shadow-sm" title="View Profile">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                        </button>
                                        <button class="bg-gray-50 text-gray-500 hover:text-[#1A2B56] hover:bg-gray-100 border border-gray-200 transition-colors px-2 py-1.5 rounded-md flex items-center justify-center shadow-sm" title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                        </button>
                                        <button class="bg-red-50 text-red-500 hover:text-white hover:bg-red-500 border border-red-100 hover:border-red-500 transition-colors px-2 py-1.5 rounded-md flex items-center justify-center shadow-sm" title="Suspend">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" /></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex items-center justify-between shrink-0">
                    <span class="text-sm text-gray-500">Showing <span class="font-bold text-gray-800">1</span> to <span class="font-bold text-gray-800">3</span> of <span class="font-bold text-gray-800">892</span> users</span>
                    <div class="flex items-center gap-1">
                        <button class="px-3 py-1.5 border border-gray-300 rounded text-sm font-medium text-gray-500 bg-white hover:bg-gray-50 disabled:opacity-50 transition-colors" disabled>Previous</button>
                        <button class="px-3 py-1.5 border border-[#1A2B56] rounded text-sm font-bold text-white bg-[#1A2B56] shadow-sm">1</button>
                        <button class="px-3 py-1.5 border border-gray-300 rounded text-sm font-medium text-gray-600 bg-white hover:bg-gray-50 transition-colors">2</button>
                        <button class="px-3 py-1.5 border border-gray-300 rounded text-sm font-medium text-gray-600 bg-white hover:bg-gray-50 transition-colors">3</button>
                        <span class="px-2 text-gray-400">...</span>
                        <button class="px-3 py-1.5 border border-gray-300 rounded text-sm font-medium text-gray-600 bg-white hover:bg-gray-50 transition-colors">89</button>
                        <button class="px-3 py-1.5 border border-gray-300 rounded text-sm font-medium text-gray-600 bg-white hover:bg-gray-50 transition-colors">Next</button>
                    </div>
                </div>
            </div>

        </main>
    </div>
</body>
</html>
