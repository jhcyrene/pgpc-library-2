<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard - PGPC Library</title>
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
<body class="bg-[#F4F7F6] text-gray-800 min-h-screen flex">

    <!-- Sidebar Navbar -->
    <x-users.navbar />

    <!-- Main Content Wrapper -->
    <div class="flex-1 flex flex-col min-w-0 min-h-screen bg-[#F4F7F6]">
        
        <!-- Top Header -->
        <x-users.header />

        <!-- Main Dashboard Content -->
        <main class="flex-1 flex flex-col p-4 md:p-6">
            
            <!-- Welcome Banner -->
            <div class="bg-gradient-to-r from-[#1A2B56] to-[#2A407C] rounded-2xl p-6 text-white shadow-md mb-6 shrink-0 relative overflow-hidden">
                <!-- Decorative Circle -->
                <div class="absolute -right-10 -top-24 w-64 h-64 bg-white opacity-5 rounded-full blur-2xl"></div>
                
                <div class="relative z-10">
                    <h1 class="text-2xl font-extrabold tracking-tight mb-1">Welcome back, Student! 👋</h1>
                    <p class="text-blue-100 text-sm max-w-xl">Ready to discover your next great read? Check out our latest arrivals or track your current borrows below.</p>
                </div>
            </div>

            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6 shrink-0">
                
                <!-- Stat Card 1 -->
                <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm flex flex-col justify-between transition-all hover:shadow-md hover:border-[#1A2B56]/30 group">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Active Borrows</p>
                            <h3 class="text-2xl font-black text-gray-800">2</h3>
                        </div>
                        <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                        </div>
                    </div>
                    <div class="flex items-center text-xs font-medium text-gray-500">
                        <span>Max limit: 3 books</span>
                    </div>
                </div>

                <!-- Stat Card 2 -->
                <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm flex flex-col justify-between transition-all hover:shadow-md hover:border-[#1A2B56]/30 group">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Overdue Items</p>
                            <h3 class="text-2xl font-black text-gray-800">0</h3>
                        </div>
                        <div class="w-10 h-10 rounded-lg bg-green-50 text-green-600 flex items-center justify-center group-hover:bg-green-600 group-hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                    </div>
                    <div class="flex items-center text-xs font-medium text-green-600 gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        <span>All clear! No fines.</span>
                    </div>
                </div>

                <!-- Stat Card 3 -->
                <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm flex flex-col justify-between transition-all hover:shadow-md hover:border-[#1A2B56]/30 group">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Total Read</p>
                            <h3 class="text-2xl font-black text-gray-800">14</h3>
                        </div>
                        <div class="w-10 h-10 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center group-hover:bg-purple-600 group-hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" /></svg>
                        </div>
                    </div>
                    <div class="flex items-center text-xs font-medium text-gray-500">
                        <span>Since Aug 2025</span>
                    </div>
                </div>

            </div>

            <!-- Bottom Grid Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 pb-6">
                
                <!-- Left Column (Current Borrows) -->
                <div class="lg:col-span-2 flex flex-col gap-6">
                    <!-- Current Borrows Section -->
                    <div class="bg-white border border-gray-200 rounded-xl shadow-sm">
                        <div class="flex items-center justify-between p-4 border-b border-gray-200 bg-gray-50/50 rounded-t-xl">
                            <h2 class="text-sm font-bold text-gray-800 uppercase tracking-wider">Your Current Borrows</h2>
                            <a href="/users/borrows" class="text-xs font-bold text-[#1A2B56] hover:text-blue-600 transition-colors">View All Details</a>
                        </div>
                        
                        <div class="p-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                
                                <!-- Book Item -->
                                <div class="flex gap-4 p-4 border border-gray-100 rounded-xl hover:border-gray-200 hover:shadow-sm transition-all bg-white group">
                                    <div class="w-16 h-24 bg-gray-200 rounded-md shrink-0 overflow-hidden shadow-sm">
                                        <!-- Placeholder for book cover -->
                                        <div class="w-full h-full bg-blue-100 flex items-center justify-center text-blue-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                        </div>
                                    </div>
                                    <div class="flex flex-col justify-between flex-1 min-w-0">
                                        <div>
                                            <h3 class="font-bold text-gray-800 text-sm truncate group-hover:text-[#1A2B56] transition-colors">Introduction to Algorithms</h3>
                                            <p class="text-xs text-gray-500 mt-0.5 truncate">Thomas H. Cormen</p>
                                        </div>
                                        <div class="mt-2">
                                            <div class="flex justify-between text-xs mb-1">
                                                <span class="text-gray-500">Return by:</span>
                                                <span class="font-bold text-orange-600">Tomorrow</span>
                                            </div>
                                            <div class="w-full bg-gray-100 rounded-full h-1.5">
                                                <div class="bg-orange-500 h-1.5 rounded-full" style="width: 90%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Book Item -->
                                <div class="flex gap-4 p-4 border border-gray-100 rounded-xl hover:border-gray-200 hover:shadow-sm transition-all bg-white group">
                                    <div class="w-16 h-24 bg-gray-200 rounded-md shrink-0 overflow-hidden shadow-sm">
                                        <!-- Placeholder for book cover -->
                                        <div class="w-full h-full bg-indigo-100 flex items-center justify-center text-indigo-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                        </div>
                                    </div>
                                    <div class="flex flex-col justify-between flex-1 min-w-0">
                                        <div>
                                            <h3 class="font-bold text-gray-800 text-sm truncate group-hover:text-[#1A2B56] transition-colors">Clean Code</h3>
                                            <p class="text-xs text-gray-500 mt-0.5 truncate">Robert C. Martin</p>
                                        </div>
                                        <div class="mt-2">
                                            <div class="flex justify-between text-xs mb-1">
                                                <span class="text-gray-500">Return by:</span>
                                                <span class="font-bold text-green-600">In 5 days</span>
                                            </div>
                                            <div class="w-full bg-gray-100 rounded-full h-1.5">
                                                <div class="bg-green-500 h-1.5 rounded-full" style="width: 40%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Right Column (Holds & Announcements) -->
                <div class="flex flex-col gap-6">
                    <!-- Reservations -->
                    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                        <div class="flex items-center justify-between p-4 border-b border-gray-200 bg-gray-50/50">
                            <h2 class="text-sm font-bold text-gray-800 uppercase tracking-wider">Reservations</h2>
                            <a href="/users/reservations" class="text-xs font-bold text-[#1A2B56] hover:text-blue-600 transition-colors">View All</a>
                        </div>
                        <div class="p-4">
                            <div class="flex flex-col gap-4">
                                <div class="flex gap-3 pb-4 border-b border-gray-100">
                                    <div class="w-12 h-16 bg-blue-50 border border-blue-100 rounded-md shrink-0 flex items-center justify-center text-blue-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                                    </div>
                                    <div class="flex-1 min-w-0 flex flex-col justify-center">
                                        <h4 class="text-sm font-bold text-gray-800 truncate leading-tight mb-1">Design Patterns</h4>
                                        <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold bg-green-100 text-green-700 w-max">READY FOR PICKUP</span>
                                    </div>
                                </div>
                                <div class="flex gap-3">
                                    <div class="w-12 h-16 bg-indigo-50 border border-indigo-100 rounded-md shrink-0 flex items-center justify-center text-indigo-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                                    </div>
                                    <div class="flex-1 min-w-0 flex flex-col justify-center">
                                        <h4 class="text-sm font-bold text-gray-800 truncate leading-tight mb-1">Sapiens</h4>
                                        <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold bg-amber-100 text-amber-700 w-max">#2 IN QUEUE</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Announcements -->
                    <div class="bg-[#1A2B56] text-white border border-transparent rounded-xl shadow-sm overflow-hidden relative">
                        <div class="absolute right-0 top-0 opacity-10 pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-32 w-32 -mt-4 -mr-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 22a10 10 0 100-20 10 10 0 000 20zm0-2a8 8 0 110-16 8 8 0 010 16z"/></svg>
                        </div>
                        <div class="p-4 border-b border-white/10 relative z-10">
                            <h2 class="text-sm font-bold uppercase tracking-wider text-[#FFC107] flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" /></svg>
                                Announcements
                            </h2>
                        </div>
                        <div class="p-4 relative z-10">
                            <ul class="space-y-4">
                                <li>
                                    <span class="text-xs text-blue-200 block mb-1 font-medium">Tomorrow</span>
                                    <a href="#" class="text-sm font-bold hover:text-[#FFC107] hover:underline transition-colors block leading-snug">Library Closed on Monday for Maintenance</a>
                                </li>
                                <li class="border-t border-white/10 pt-4">
                                    <span class="text-xs text-blue-200 block mb-1 font-medium">Oct 20</span>
                                    <a href="#" class="text-sm font-bold hover:text-[#FFC107] hover:underline transition-colors block leading-snug">New E-Books added to the Science Collection!</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </main>
    </div>
</body>
</html>
