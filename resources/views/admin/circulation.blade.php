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
<body class="bg-[#F4F7F6] text-gray-800 min-h-screen flex">

    <!-- Sidebar Navbar -->
    <x-admin.navbar />

    <!-- Main Content Wrapper -->
    <div class="flex-1 flex flex-col min-w-0 min-h-screen bg-[#F4F7F6]">
        
        <!-- Top Header -->
        <x-admin.header />

        <!-- Main Dashboard Content -->
        <main class="flex-1 flex flex-col p-6 min-h-0">
            <!-- Page Header -->
            <div class="flex items-center justify-between mb-6 shrink-0">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Circulation Desk</h1>
                    <p class="text-sm text-gray-500 mt-1">Quickly issue and return library materials via barcode scanning.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10 shrink-0 w-full">
                <!-- Column 1: Circulation -->
                <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                    <h3 class="text-base font-bold text-gray-700 mb-4 pb-1">Circulation</h3>
                    <div class="flex flex-col gap-2.5">
                        <a href="#" class="flex items-center gap-3 bg-[#e2e8f0] hover:bg-[#cbd5e1] text-gray-900 rounded-md px-4 py-2.5 text-sm font-bold transition-colors shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" /></svg>
                            Scan qr code
                        </a>
                        <a href="/admin/circulation/checkout" class="flex items-center gap-3 bg-[#e2e8f0] hover:bg-[#cbd5e1] text-gray-900 rounded-md px-4 py-2.5 text-sm font-bold transition-colors shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" /></svg>
                            Check out
                        </a>
                        <a href="/admin/circulation/checkin" class="flex items-center gap-3 bg-[#e2e8f0] hover:bg-[#cbd5e1] text-gray-900 rounded-md px-4 py-2.5 text-sm font-bold transition-colors shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                            Check in
                        </a>
                        <a href="/admin/circulation/renew" class="flex items-center gap-3 bg-[#e2e8f0] hover:bg-[#cbd5e1] text-gray-900 rounded-md px-4 py-2.5 text-sm font-bold transition-colors shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                            Renew
                        </a>
                        <a href="/admin/circulation/fast-cataloging" class="flex items-center gap-3 bg-[#e2e8f0] hover:bg-[#cbd5e1] text-gray-900 rounded-md px-4 py-2.5 text-sm font-bold transition-colors shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
                            Fast cataloging
                        </a>
                    </div>
                </div>

                <!-- Column 2: Holds and bookings -->
                <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                    <h3 class="text-base font-bold text-gray-700 mb-4 pb-1">Holds and bookings</h3>
                    <div class="flex flex-col gap-2.5">
                        <a href="/admin/reservations" class="flex items-center gap-3 bg-[#e2e8f0] hover:bg-[#cbd5e1] text-gray-900 rounded-md px-4 py-2.5 text-sm font-bold transition-colors shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16" /></svg>
                            Holds queue / Reservations
                        </a>
                        <a href="/admin/borrows" class="flex items-center gap-3 bg-[#e2e8f0] hover:bg-[#cbd5e1] text-gray-900 rounded-md px-4 py-2.5 text-sm font-bold transition-colors shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                            All Borrows
                        </a>
                    </div>
                </div>

                <!-- Column 3: Overdues / Transfers -->
                <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                    <h3 class="text-base font-bold text-gray-700 mb-4 pb-1">Overdues</h3>
                    <div class="flex flex-col gap-2.5">
                        <a href="#" class="flex items-center gap-3 bg-[#e2e8f0] hover:bg-[#cbd5e1] text-gray-900 rounded-md px-4 py-2.5 text-sm font-bold transition-colors shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            Overdues
                        </a>
                        <a href="#" class="flex items-center gap-3 bg-[#e2e8f0] hover:bg-[#cbd5e1] text-gray-900 rounded-md px-4 py-2.5 text-sm font-bold transition-colors shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            Overdues with fines
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recent Activity Table -->
            <div class="flex-1 flex flex-col min-h-0 bg-white border border-gray-200 rounded-xl shadow-sm">
                <div class="p-4 border-b border-gray-200 flex items-center justify-between bg-gray-50/50 rounded-t-xl shrink-0">
                    <h2 class="text-sm font-bold text-gray-800 uppercase tracking-wider">Today's Circulation Log</h2>
                    <a href="/admin/borrows" class="text-xs font-bold text-blue-600 hover:underline">View All Records</a>
                </div>
                
                <div class="overflow-x-auto overflow-y-auto flex-1">
                    <table class="w-full text-left border-collapse min-w-[800px]">
                        <thead class="sticky top-0 bg-white border-b border-gray-200 text-xs font-bold text-gray-500 uppercase tracking-wider z-10 shadow-sm">
                            <tr>
                                <th class="px-6 py-3">Time</th>
                                <th class="px-6 py-3">Action</th>
                                <th class="px-6 py-3">User</th>
                                <th class="px-6 py-3">Book</th>
                                <th class="px-6 py-3 text-right">Processed By</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <!-- Row 1 -->
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 text-sm text-gray-500 font-medium">10:42 AM</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-md text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                        Check-Out
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-sm font-bold text-gray-800">Jane Smith</p>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-sm font-bold text-gray-800">Advanced Engineering Mathematics</p>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 text-right">Admin User</td>
                            </tr>
                            
                            <!-- Row 2 -->
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 text-sm text-gray-500 font-medium">09:15 AM</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-md text-xs font-bold bg-green-50 text-green-700 border border-green-200">
                                        Return
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-sm font-bold text-gray-800">Michael Johnson</p>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-sm font-bold text-gray-800">Data Structures in C++</p>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 text-right">Admin User</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>
</body>
</html>
