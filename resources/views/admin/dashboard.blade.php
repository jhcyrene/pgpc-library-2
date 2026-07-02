<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - PGPC Library</title>
    @vite(['resources/css/welcome.css', 'resources/css/admin_dashboard.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased overflow-hidden">

    <!-- Global App Layout: strict 100vh, hidden overflow -->
    <div class="flex h-screen w-full overflow-hidden">

        <!-- Left Sidebar -->
        <x-admin.navbar />

        <!-- Right Area: Header + Main Content -->
        <div class="flex flex-col flex-1 min-w-0 overflow-hidden relative">
            
            <!-- Top Header -->
            <x-admin.header />

                        <!-- 2. Main Greeting Banner (Dark Navy Background) -->
            <div class="bg-[#1A2B56] p-8 relative overflow-hidden flex flex-col md:flex-row md:items-center justify-between gap-6 w-full shrink-0">
                <!-- Decorative subtle wave/shape -->
                <div class="absolute right-0 top-0 h-full w-1/3 opacity-10 pointer-events-none">
                    <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg" class="w-full h-full transform scale-150 translate-x-1/4 -translate-y-1/4">
                        <path fill="#FFFFFF" d="M44.7,-76.4C58.8,-69.2,71.8,-59.1,81.6,-46.3C91.4,-33.5,98,-18.1,97.7,-3C97.4,12.1,90.2,26.9,80.5,39.4C70.8,51.9,58.6,62,45.1,70.5C31.6,79,16.8,85.9,0.9,84.4C-15,82.9,-30,73,-43.3,64.2C-56.6,55.4,-68.2,47.7,-77.2,36.1C-86.2,24.5,-92.6,9,-91.6,-5.8C-90.6,-20.6,-82.2,-34.7,-71.4,-45.5C-60.6,-56.3,-47.4,-63.8,-34.4,-71.5C-21.4,-79.2,-8.6,-87.1,4.9,-95.3C18.4,-103.5,30.6,-83.6,44.7,-76.4Z" transform="translate(100 100)" />
                    </svg>
                </div>

                <!-- Left Side Content -->
                <div class="relative z-10 flex flex-col gap-1">
                    <p class="text-white/60 text-sm font-medium mb-1 uppercase tracking-wide">
                        {{ now()->format('l, F j, Y') }}
                    </p>
                    <h1 class="text-3xl font-bold text-white leading-tight">
                        Good {{ now()->hour < 12 ? 'morning' : (now()->hour < 18 ? 'afternoon' : 'evening') }}, 
                        <span class="text-[#FFC107]">Admin</span> 👋
                    </h1>
                    <p class="text-white/70 text-base mt-1 font-medium">
                        Here's an overview of the library system today.
                    </p>
                </div>

                <!-- Right Side Actions -->
                <div class="relative z-10 flex items-center gap-4 shrink-0">
                    <!-- Button 1: Export Report (Secondary) -->
                    <button class="flex items-center gap-2 bg-transparent border-2 border-white/80 hover:border-white text-white hover:bg-white/10 text-base font-bold px-5 py-2.5 rounded-lg transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Export Report
                    </button>
                    
                    <!-- Button 2: Add New Book (Primary) -->
                    <button class="flex items-center gap-2 bg-[#FFC107] hover:bg-[#FFD54F] text-[#1A2B56] text-base font-bold px-5 py-2.5 rounded-lg transition-all shadow-lg shadow-[#FFC107]/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Add New Book
                    </button>
                </div>
            </div>


            <!-- Main Dashboard Content (Bento Box Grid) -->
            <main class="flex-1 flex flex-col p-4 md:p-5 min-h-0 gap-4">
                
                <!-- ROW 1: High-Priority Alerts & Actions (3 Columns: Overdue, Reservations, Quick Actions) -->
                <div class="grid gap-4 shrink-0" style="grid-template-columns: 4fr 4fr 3fr;">
                    
                    <!-- Card 1: Overdue Alerts (4fr) -->
                    <div class="bg-white border-l-4 border-l-red-500 border-y border-r border-gray-200 rounded-xl p-4 shadow-sm relative overflow-hidden group flex flex-col">
                        <div class="absolute -right-6 -bottom-6 text-red-50 opacity-50 group-hover:scale-110 transition-transform pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-32 w-32" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                        </div>
                        <h2 class="text-sm font-bold text-gray-800 uppercase tracking-wider flex items-center gap-2 mb-4 relative z-10">
                            <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
                            Action Required
                        </h2>
                        
                        <div class="flex items-stretch gap-4 flex-1 relative z-10">
                            <!-- Left: Large number & Button -->
                            <div class="flex flex-col justify-center w-1/3 border-r border-gray-100 pr-4">
                                <div class="mb-2">
                                    <p class="text-5xl font-black text-red-600 leading-none mb-1">24</p>
                                    <p class="text-[10px] font-bold text-gray-500 leading-tight uppercase tracking-wide">Overdue</p>
                                </div>
                                <button class="w-full text-xs font-bold text-red-600 hover:text-white border border-red-200 hover:bg-red-500 py-1.5 px-2 rounded transition-colors text-center shadow-sm">
                                    View All
                                </button>
                            </div>
                            
                            <!-- Right: List -->
                            <div class="flex flex-col gap-2.5 flex-1 justify-center">
                                <div class="flex justify-between items-center group/item cursor-pointer">
                                    <span class="text-xs font-semibold text-gray-700 truncate group-hover/item:text-red-600 transition-colors pr-2">Philippine History</span>
                                    <span class="text-[9px] font-bold px-1.5 py-0.5 rounded text-red-600 bg-red-50 whitespace-nowrap border border-red-100">22d late</span>
                                </div>
                                <div class="flex justify-between items-center group/item cursor-pointer">
                                    <span class="text-xs font-semibold text-gray-700 truncate group-hover/item:text-red-600 transition-colors pr-2">Data Struct. in C++</span>
                                    <span class="text-[9px] font-bold px-1.5 py-0.5 rounded text-red-600 bg-red-50 whitespace-nowrap border border-red-100">15d late</span>
                                </div>
                                <div class="flex justify-between items-center group/item cursor-pointer">
                                    <span class="text-xs font-semibold text-gray-700 truncate group-hover/item:text-red-600 transition-colors pr-2">Advanced Calculus</span>
                                    <span class="text-[9px] font-bold px-1.5 py-0.5 rounded text-red-600 bg-red-50 whitespace-nowrap border border-red-100">8d late</span>
                                </div>
                                <a href="#" class="text-[10px] font-bold text-gray-400 hover:text-red-500 transition-colors text-right mt-0.5">+ See all 21 others</a>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2: List of Reservations (5fr = ~45%) -->
                    <div class="bg-white border border-gray-200 rounded-xl p-4 flex flex-col justify-between shadow-sm">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-sm font-bold text-gray-800 uppercase tracking-wider flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                Pending Reservations
                            </h2>
                            <span class="text-xs font-bold text-blue-700 bg-blue-50 px-2 py-0.5 rounded-full border border-blue-100">5 New</span>
                        </div>
                        
                        <div class="flex flex-col gap-3 flex-1 justify-center">
                            <!-- Reservation Item -->
                            <div class="flex items-center justify-between p-2 hover:bg-gray-50 rounded-lg border border-transparent hover:border-gray-100 transition-colors cursor-pointer group">
                                <div class="flex items-center gap-3 overflow-hidden">
                                    <div class="w-8 h-8 rounded bg-blue-50 text-blue-600 flex items-center justify-center shrink-0 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                                    </div>
                                    <div class="truncate">
                                        <p class="text-sm font-bold text-gray-800 truncate">Software Engineering</p>
                                        <p class="text-xs text-gray-500 truncate">Reserved by J. Dela Cruz • 2 hrs ago</p>
                                    </div>
                                </div>
                                <button class="text-xs font-bold bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white px-3 py-1.5 rounded-md transition-colors shrink-0 border border-blue-100 shadow-sm ml-2">
                                    Process
                                </button>
                            </div>

                            <!-- Reservation Item -->
                            <div class="flex items-center justify-between p-2 hover:bg-gray-50 rounded-lg border border-transparent hover:border-gray-100 transition-colors cursor-pointer group">
                                <div class="flex items-center gap-3 overflow-hidden">
                                    <div class="w-8 h-8 rounded bg-blue-50 text-blue-600 flex items-center justify-center shrink-0 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                                    </div>
                                    <div class="truncate">
                                        <p class="text-sm font-bold text-gray-800 truncate">Intro to Psychology</p>
                                        <p class="text-xs text-gray-500 truncate">Reserved by M. Smith • 5 hrs ago</p>
                                    </div>
                                </div>
                                <button class="text-xs font-bold bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white px-3 py-1.5 rounded-md transition-colors shrink-0 border border-blue-100 shadow-sm ml-2">
                                    Process
                                </button>
                            </div>
                        </div>
                        <a href="/admin/reservations" class="w-full mt-3 py-2 px-3 text-xs font-bold bg-gray-50 text-gray-600 border border-gray-200 rounded-lg hover:bg-gray-100 hover:text-gray-800 transition-colors flex items-center justify-center gap-2">
                            View all pending reservations
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                        </a>
                    </div>

                    <!-- Card 3: Quick Actions (3fr = ~27%) -->
                    <div class="bg-[#1A2B56] border border-[#243560] rounded-xl p-4 flex flex-col justify-between shadow-sm relative overflow-hidden">
                        <div class="absolute right-0 top-0 w-32 h-32 bg-white/5 rounded-bl-full pointer-events-none"></div>
                        <h2 class="text-sm font-bold text-white/90 uppercase tracking-wider mb-4">Quick Actions</h2>
                        <div class="flex flex-col gap-3 flex-1 justify-center relative z-10">
                            <button class="flex items-center gap-3 text-sm font-bold text-[#1A2B56] bg-[#FFC107] hover:bg-[#FFD54F] py-2.5 px-4 rounded-lg transition-all shadow-md group border border-[#FFC107]">
                                <div class="bg-white/30 p-1 rounded-md group-hover:scale-110 transition-transform">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                                </div>
                                Add New Book
                            </button>
                            <button class="flex items-center gap-3 text-sm font-bold text-white bg-white/10 hover:bg-white/20 border border-white/10 py-2.5 px-4 rounded-lg transition-all group">
                                <div class="bg-white/10 p-1 rounded-md group-hover:scale-110 transition-transform">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>
                                </div>
                                Register User
                            </button>
                            <button class="flex items-center gap-3 text-sm font-bold text-white bg-white/10 hover:bg-white/20 border border-white/10 py-2.5 px-4 rounded-lg transition-all group">
                                <div class="bg-white/10 p-1 rounded-md group-hover:scale-110 transition-transform">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg>
                                </div>
                                Process Return
                            </button>
                        </div>
                    </div>
                </div>

                <!-- ROW 2: Metrics -->
                <div class="grid grid-cols-4 gap-4 shrink-0">
                    <!-- Total Books -->
                    <div class="bg-white border border-gray-200 rounded-xl p-4 flex flex-col justify-center relative overflow-hidden group hover:border-purple-200 transition-colors">
                        <div class="absolute right-0 top-0 w-16 h-16 bg-gradient-to-bl from-purple-50 to-transparent rounded-bl-full"></div>
                        <p class="text-sm font-bold text-gray-500 mb-1">Total Books</p>
                        <h3 class="text-2xl font-bold text-gray-800">8,432</h3>
                        <p class="text-xs text-emerald-600 font-bold mt-1">+12 this week</p>
                    </div>
                    <!-- Active Borrows -->
                    <div class="bg-white border border-gray-200 rounded-xl p-4 flex flex-col justify-center relative overflow-hidden group hover:border-blue-200 transition-colors">
                        <div class="absolute right-0 top-0 w-16 h-16 bg-gradient-to-bl from-blue-50 to-transparent rounded-bl-full"></div>
                        <p class="text-sm font-bold text-gray-500 mb-1">Active Borrows</p>
                        <h3 class="text-2xl font-bold text-gray-800">456</h3>
                        <p class="text-xs text-emerald-600 font-bold mt-1">Currently Out</p>
                    </div>
                    <!-- Books Due Today -->
                    <div class="bg-white border border-gray-200 rounded-xl p-4 flex flex-col justify-center relative overflow-hidden group hover:border-amber-200 transition-colors">
                        <div class="absolute right-0 top-0 w-16 h-16 bg-gradient-to-bl from-amber-50 to-transparent rounded-bl-full"></div>
                        <p class="text-sm font-bold text-gray-500 mb-1">Books Due Today</p>
                        <h3 class="text-2xl font-bold text-gray-800">12</h3>
                        <p class="text-xs text-amber-600 font-bold mt-1">Action Needed</p>
                    </div>
                    <!-- New Users -->
                    <div class="bg-white border border-gray-200 rounded-xl p-4 flex flex-col justify-center relative overflow-hidden group hover:border-green-200 transition-colors">
                        <div class="absolute right-0 top-0 w-16 h-16 bg-gradient-to-bl from-green-50 to-transparent rounded-bl-full"></div>
                        <p class="text-sm font-bold text-gray-500 mb-1">New Users</p>
                        <h3 class="text-2xl font-bold text-gray-800">45</h3>
                        <p class="text-xs text-gray-400 font-bold mt-1">This Week</p>
                    </div>
                </div>

                <!-- ROW 3: Data Tables & Logs (3 Columns: 1fr 1fr 1fr) -->
                <div class="grid grid-cols-3 gap-4 flex-1 min-h-0">

                    <!-- Card 1: Top Borrowed Books -->
                    <div class="bg-white border border-gray-200 rounded-xl p-4 flex flex-col min-h-0">
                        <div class="flex justify-between items-center mb-3 shrink-0">
                            <h2 class="text-sm font-bold text-gray-500 uppercase tracking-wider">Top Borrowed Books</h2>
                            <a href="borrows" class="text-xs font-bold text-blue-600 bg-blue-50 hover:bg-blue-600 hover:text-white px-3 py-1.5 rounded-md transition-colors shrink-0 border border-blue-100 shadow-sm">View All</a>
                        </div>
                        <div class="overflow-y-auto flex-1 min-h-0 divide-y divide-gray-50">
                            <div class="flex items-center justify-between py-2">
                                <div class="flex items-center gap-2.5">
                                    <span class="text-sm font-bold text-gray-300 w-4 text-center">1</span>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-800">Software Engineering</p>
                                        <p class="text-xs text-gray-400">Computer Science</p>
                                    </div>
                                </div>
                                <span class="text-sm font-bold text-emerald-600 shrink-0">45</span>
                            </div>
                            <div class="flex items-center justify-between py-2">
                                <div class="flex items-center gap-2.5">
                                    <span class="text-sm font-bold text-gray-300 w-4 text-center">2</span>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-800">Advanced Calculus</p>
                                        <p class="text-xs text-gray-400">Mathematics</p>
                                    </div>
                                </div>
                                <span class="text-sm font-bold text-emerald-600 shrink-0">38</span>
                            </div>
                            <div class="flex items-center justify-between py-2">
                                <div class="flex items-center gap-2.5">
                                    <span class="text-sm font-bold text-gray-300 w-4 text-center">3</span>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-800">Philippine History</p>
                                        <p class="text-xs text-gray-400">History</p>
                                    </div>
                                </div>
                                <span class="text-sm font-bold text-emerald-600 shrink-0">31</span>
                            </div>
                            <div class="flex items-center justify-between py-2">
                                <div class="flex items-center gap-2.5">
                                    <span class="text-sm font-bold text-gray-300 w-4 text-center">4</span>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-800">Intro to Psychology</p>
                                        <p class="text-xs text-gray-400">Psychology</p>
                                    </div>
                                </div>
                                <span class="text-sm font-bold text-emerald-600 shrink-0">29</span>
                            </div>
                            <div class="flex items-center justify-between py-2">
                                <div class="flex items-center gap-2.5">
                                    <span class="text-sm font-bold text-gray-300 w-4 text-center">5</span>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-800">Basic Physics</p>
                                        <p class="text-xs text-gray-400">Physics</p>
                                    </div>
                                </div>
                                <span class="text-sm font-bold text-emerald-600 shrink-0">22</span>
                            </div>
                            <div class="flex items-center justify-between py-2">
                                <div class="flex items-center gap-2.5">
                                    <span class="text-sm font-bold text-gray-300 w-4 text-center">6</span>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-800">Data Structures in C++</p>
                                        <p class="text-xs text-gray-400">Computer Science</p>
                                    </div>
                                </div>
                                <span class="text-sm font-bold text-emerald-600 shrink-0">18</span>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2: Recent Transactions (Hero Data for Library) -->
                    <div class="bg-white border border-gray-200 rounded-xl p-4 flex flex-col min-h-0">
                        <div class="flex justify-between items-center mb-3 shrink-0">
                            <h2 class="text-sm font-bold text-gray-500 uppercase tracking-wider">Recent Transactions</h2>
                            <a href="#" class="text-xs font-bold text-blue-600 bg-blue-50 hover:bg-blue-600 hover:text-white px-3 py-1.5 rounded-md transition-colors shrink-0 border border-blue-100 shadow-sm">View All</a>
                        </div>
                        <!-- Table Header -->
                        <div class="grid grid-cols-3 pb-2 mb-1 border-b border-gray-100 shrink-0">
                            <span class="text-xs font-bold text-gray-400 uppercase">User</span>
                            <span class="text-xs font-bold text-gray-400 uppercase">Book</span>
                            <span class="text-xs font-bold text-gray-400 uppercase text-right">Status</span>
                        </div>
                        <div class="overflow-y-auto flex-1 min-h-0 divide-y divide-gray-50">
                            <div class="grid grid-cols-3 py-2 items-center">
                                <span class="text-sm font-semibold text-gray-700">J. Dela Cruz</span>
                                <span class="text-sm text-gray-500 truncate pr-2">Software Eng.</span>
                                <span class="text-right"><span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded">Active</span></span>
                            </div>
                            <div class="grid grid-cols-3 py-2 items-center">
                                <span class="text-sm font-semibold text-gray-700">M. Santos</span>
                                <span class="text-sm text-gray-500 truncate pr-2">Adv. Calculus</span>
                                <span class="text-right"><span class="text-xs font-bold text-amber-600 bg-amber-50 px-1.5 py-0.5 rounded">Due Today</span></span>
                            </div>
                            <div class="grid grid-cols-3 py-2 items-center">
                                <span class="text-sm font-semibold text-gray-700">A. Reyes</span>
                                <span class="text-sm text-gray-500 truncate pr-2">Phil. History</span>
                                <span class="text-right"><span class="text-xs font-bold text-red-600 bg-red-50 px-1.5 py-0.5 rounded">Overdue</span></span>
                            </div>
                            <div class="grid grid-cols-3 py-2 items-center">
                                <span class="text-sm font-semibold text-gray-700">K. Garcia</span>
                                <span class="text-sm text-gray-500 truncate pr-2">Intro to Psych</span>
                                <span class="text-right"><span class="text-xs font-bold text-gray-500 bg-gray-100 px-1.5 py-0.5 rounded">Returned</span></span>
                            </div>
                            <div class="grid grid-cols-3 py-2 items-center">
                                <span class="text-sm font-semibold text-gray-700">R. Mendoza</span>
                                <span class="text-sm text-gray-500 truncate pr-2">Basic Physics</span>
                                <span class="text-right"><span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded">Active</span></span>
                            </div>
                            <div class="grid grid-cols-3 py-2 items-center">
                                <span class="text-sm font-semibold text-gray-700">L. Torres</span>
                                <span class="text-sm text-gray-500 truncate pr-2">Data Struct.</span>
                                <span class="text-right"><span class="text-xs font-bold text-red-600 bg-red-50 px-1.5 py-0.5 rounded">Overdue</span></span>
                            </div>
                        </div>
                    </div>

                    <!-- Card 3: Recent Activity Log (Simple flat list, no timeline design) -->
                    <div class="bg-white border border-gray-200 rounded-xl p-4 flex flex-col min-h-0">
                        <div class="flex justify-between items-center mb-3 shrink-0">
                            <h2 class="text-sm font-bold text-gray-500 uppercase tracking-wider">Activity Log</h2>
                            <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse shrink-0" title="Live"></span>
                        </div>
                        <div class="overflow-y-auto flex-1 min-h-0 divide-y divide-gray-50">
                            <div class="py-2">
                                <div class="flex justify-between items-baseline mb-0.5">
                                    <span class="text-sm font-semibold text-gray-800">New Borrow</span>
                                    <span class="text-xs text-gray-400">2 min ago</span>
                                </div>
                                <p class="text-xs text-gray-500">Software Engineering — J. Dela Cruz</p>
                            </div>
                            <div class="py-2">
                                <div class="flex justify-between items-baseline mb-0.5">
                                    <span class="text-sm font-semibold text-gray-800">Book Returned</span>
                                    <span class="text-xs text-gray-400">15 min ago</span>
                                </div>
                                <p class="text-xs text-gray-500">Advanced Calculus — M. Johnson</p>
                            </div>
                            <div class="py-2">
                                <div class="flex justify-between items-baseline mb-0.5">
                                    <span class="text-sm font-semibold text-gray-800">User Registered</span>
                                    <span class="text-xs text-gray-400">1 hr ago</span>
                                </div>
                                <p class="text-xs text-gray-500">New student account — STU-2024</p>
                            </div>
                            <div class="py-2">
                                <div class="flex justify-between items-baseline mb-0.5">
                                    <span class="text-sm font-semibold text-red-700">Overdue Flagged</span>
                                    <span class="text-xs text-gray-400">3 hrs ago</span>
                                </div>
                                <p class="text-xs text-gray-500">Philippine History — A. Reyes</p>
                            </div>
                            <div class="py-2">
                                <div class="flex justify-between items-baseline mb-0.5">
                                    <span class="text-sm font-semibold text-gray-800">Reservation Made</span>
                                    <span class="text-xs text-gray-400">4 hrs ago</span>
                                </div>
                                <p class="text-xs text-gray-500">Intro to Psychology — K. Garcia</p>
                            </div>
                            <div class="py-2">
                                <div class="flex justify-between items-baseline mb-0.5">
                                    <span class="text-sm font-semibold text-gray-800">New Book Added</span>
                                    <span class="text-xs text-gray-400">Yesterday</span>
                                </div>
                                <p class="text-xs text-gray-500">Operating Systems 4th Ed. (x3 copies)</p>
                            </div>
                        </div>
                        <button class="w-full mt-3 py-2 px-3 text-xs font-bold bg-gray-50 text-gray-600 border border-gray-200 rounded-lg hover:bg-gray-100 hover:text-gray-800 transition-colors flex items-center justify-center gap-2">
                            View all activity logs
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                        </button>
                    </div>

                </div>

            </main>
        </div>
    </div>

</body>
</html>

