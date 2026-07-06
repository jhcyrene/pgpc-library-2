<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile - PGPC Library</title>
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
                    <h1 class="text-2xl font-bold text-gray-800">Admin Profile</h1>
                    <p class="text-sm text-gray-500 mt-1">Manage your personal account settings and security.</p>
                </div>
                <button class="bg-[#1A2B56] hover:bg-[#243B73] text-white text-sm font-bold px-5 py-2.5 rounded-lg transition-all shadow-sm">
                    Save Profile
                </button>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column: Profile Card -->
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 flex flex-col items-center text-center">
                        <div class="relative mb-4 group cursor-pointer">
                            <div class="w-24 h-24 rounded-full flex items-center justify-center text-3xl font-bold text-[#1A2B56] shadow-sm transition-all group-hover:opacity-80" style="background-color: #FFC107;">
                                AD
                            </div>
                            <div class="absolute inset-0 bg-black/50 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            </div>
                        </div>
                        <h2 class="text-lg font-bold text-gray-800">Admin User</h2>
                        <p class="text-sm text-gray-500 mb-4">Administrator</p>
                        
                        <div class="w-full border-t border-gray-100 pt-4 flex justify-around text-center">
                            <div>
                                <p class="text-xl font-bold text-gray-800">12</p>
                                <p class="text-xs text-gray-500">Books Added</p>
                            </div>
                            <div>
                                <p class="text-xl font-bold text-gray-800">45</p>
                                <p class="text-xs text-gray-500">Approvals</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Settings Forms -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Personal Info -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h2 class="text-lg font-bold text-gray-800 border-b border-gray-100 pb-3 mb-5">Personal Information</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">First Name</label>
                                <input type="text" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-[#1A2B56]/20 focus:border-[#1A2B56] outline-none transition-all" value="Admin">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Last Name</label>
                                <input type="text" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-[#1A2B56]/20 focus:border-[#1A2B56] outline-none transition-all" value="User">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-bold text-gray-700 mb-1">Email Address</label>
                                <input type="email" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-[#1A2B56]/20 focus:border-[#1A2B56] outline-none transition-all bg-gray-50" value="admin@pgpc.edu.ph" readonly>
                                <p class="text-xs text-gray-500 mt-1">Email address cannot be changed.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Change Password -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h2 class="text-lg font-bold text-gray-800 border-b border-gray-100 pb-3 mb-5">Change Password</h2>
                        <div class="space-y-5">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Current Password</label>
                                <input type="password" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-[#1A2B56]/20 focus:border-[#1A2B56] outline-none transition-all" placeholder="••••••••">
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">New Password</label>
                                    <input type="password" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-[#1A2B56]/20 focus:border-[#1A2B56] outline-none transition-all" placeholder="••••••••">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Confirm New Password</label>
                                    <input type="password" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-[#1A2B56]/20 focus:border-[#1A2B56] outline-none transition-all" placeholder="••••••••">
                                </div>
                            </div>
                            <div class="pt-2">
                                <button class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 text-sm font-bold px-4 py-2 rounded-lg transition-all">
                                    Update Password
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </main>
    </div>
</body>
</html>
