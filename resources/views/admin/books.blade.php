<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Management - PGPC Library</title>
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
                    <h1 class="text-2xl font-bold text-gray-800">Book Management</h1>
                    <p class="text-sm text-gray-500 mt-1">Manage the library's entire catalog of books and resources.</p>
                </div>
                <button class="flex items-center gap-2 bg-[#1A2B56] hover:bg-[#243B73] text-white text-sm font-bold px-4 py-2.5 rounded-lg transition-all shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Add New Book
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
                    <input type="text" class="block w-full pl-9 pr-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-1 focus:ring-[#1A2B56] focus:border-[#1A2B56] outline-none" placeholder="Search by title, author, or ISBN...">
                </div>
                <div class="flex items-center gap-3 w-full sm:w-auto">
                    <select class="border border-gray-200 rounded-lg text-sm px-3 py-2 outline-none focus:ring-1 focus:ring-[#1A2B56] bg-gray-50 text-gray-700 font-medium">
                        <option>All Categories</option>
                        <option>Computer Science</option>
                        <option>History</option>
                        <option>Mathematics</option>
                    </select>
                    <select class="border border-gray-200 rounded-lg text-sm px-3 py-2 outline-none focus:ring-1 focus:ring-[#1A2B56] bg-gray-50 text-gray-700 font-medium">
                        <option>All Status</option>
                        <option>Available</option>
                        <option>Borrowed</option>
                        <option>Lost</option>
                    </select>
                </div>
            </div>

            <!-- Table -->
            <div class="bg-white border-x border-b border-gray-200 rounded-b-xl shadow-sm flex flex-col min-h-0 flex-1">
                <div class="overflow-x-auto flex-1">
                    <table class="w-full text-left border-collapse">
                        <thead class="sticky top-0 z-10 bg-gray-50 border-y border-gray-200 text-xs font-bold text-gray-500 uppercase tracking-wider shadow-sm">
                            <tr>
                                <th class="px-6 py-3">Book Details</th>
                                <th class="px-6 py-3">Author</th>
                                <th class="px-6 py-3">Category</th>
                                <th class="px-6 py-3">Status</th>
                                <th class="px-6 py-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <!-- Row 1 -->
                            <tr class="hover:bg-gray-50 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-12 bg-gray-200 rounded border border-gray-300 flex items-center justify-center shrink-0 shadow-sm overflow-hidden text-gray-400 font-bold text-xs uppercase text-center leading-tight">
                                            SE<br>10th
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-800">Software Engineering 10th Ed.</p>
                                            <p class="text-xs text-gray-500 mt-0.5">ISBN: 978-0133943030</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-700">Ian Sommerville</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">Computer Science</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-md text-xs font-bold bg-green-50 text-green-700 border border-green-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Available
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button class="text-gray-400 hover:text-[#1A2B56] transition-colors p-1" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                    </button>
                                    <button class="text-gray-400 hover:text-red-600 transition-colors p-1 ml-1" title="Delete">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                </td>
                            </tr>
                            
                            <!-- Row 2 -->
                            <tr class="hover:bg-gray-50 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-12 bg-gray-200 rounded border border-gray-300 flex items-center justify-center shrink-0 shadow-sm overflow-hidden text-gray-400 font-bold text-xs uppercase text-center leading-tight">
                                            DS<br>C++
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-800">Data Structures in C++</p>
                                            <p class="text-xs text-gray-500 mt-0.5">ISBN: 978-0134444336</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-700">D.S. Malik</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">Computer Science</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-md text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span> Borrowed
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button class="bg-gray-50 text-gray-500 hover:text-[#1A2B56] hover:bg-gray-100 border border-gray-200 transition-colors px-2 py-1.5 rounded-md flex items-center justify-center shadow-sm" title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                        </button>
                                        <button class="bg-red-50 text-red-500 hover:text-white hover:bg-red-500 border border-red-100 hover:border-red-500 transition-colors px-2 py-1.5 rounded-md flex items-center justify-center shadow-sm" title="Delete">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            
                            <!-- Row 3 -->
                            <tr class="hover:bg-gray-50 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-12 bg-gray-200 rounded border border-gray-300 flex items-center justify-center shrink-0 shadow-sm overflow-hidden text-gray-400 font-bold text-xs uppercase text-center leading-tight">
                                            AEM<br>10th
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-800">Advanced Engineering Mathematics</p>
                                            <p class="text-xs text-gray-500 mt-0.5">ISBN: 978-0470458365</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-700">Erwin Kreyszig</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-purple-50 text-purple-700 border border-purple-100">Mathematics</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-md text-xs font-bold bg-green-50 text-green-700 border border-green-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Available
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button class="text-gray-400 hover:text-[#1A2B56] transition-colors p-1" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                    </button>
                                    <button class="text-gray-400 hover:text-red-600 transition-colors p-1 ml-1" title="Delete">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex items-center justify-between shrink-0">
                    <span class="text-sm text-gray-500">Showing <span class="font-bold text-gray-800">1</span> to <span class="font-bold text-gray-800">3</span> of <span class="font-bold text-gray-800">124</span> books</span>
                    <div class="flex items-center gap-1">
                        <button class="px-3 py-1.5 border border-gray-300 rounded text-sm font-medium text-gray-500 bg-white hover:bg-gray-50 disabled:opacity-50 transition-colors" disabled>Previous</button>
                        <button class="px-3 py-1.5 border border-[#1A2B56] rounded text-sm font-bold text-white bg-[#1A2B56] shadow-sm">1</button>
                        <button class="px-3 py-1.5 border border-gray-300 rounded text-sm font-medium text-gray-600 bg-white hover:bg-gray-50 transition-colors">2</button>
                        <button class="px-3 py-1.5 border border-gray-300 rounded text-sm font-medium text-gray-600 bg-white hover:bg-gray-50 transition-colors">3</button>
                        <span class="px-2 text-gray-400">...</span>
                        <button class="px-3 py-1.5 border border-gray-300 rounded text-sm font-medium text-gray-600 bg-white hover:bg-gray-50 transition-colors">13</button>
                        <button class="px-3 py-1.5 border border-gray-300 rounded text-sm font-medium text-gray-600 bg-white hover:bg-gray-50 transition-colors">Next</button>
                    </div>
                </div>
            </div>

        </main>
    </div>
    @include('admin.addBooks')
    @include('admin.viewBook')
</body>
</html>
