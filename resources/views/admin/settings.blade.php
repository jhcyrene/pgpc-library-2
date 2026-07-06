<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - PGPC Library</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; background-color: #F4F7F6; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        
        /* Custom Toggle Switch */
        .toggle-checkbox:checked {
            right: 0;
            border-color: #1A2B56;
        }
        .toggle-checkbox:checked + .toggle-label {
            background-color: #1A2B56;
        }
        .toggle-checkbox {
            right: 0;
            z-index: 1;
            border-color: #e2e8f0;
            transition: all 0.3s;
        }
        .toggle-label {
            width: 3rem;
            height: 1.5rem;
            background-color: #cbd5e1;
            border-radius: 9999px;
            position: relative;
            cursor: pointer;
            transition: all 0.3s;
        }
        .toggle-label:after {
            content: '';
            position: absolute;
            top: 0.125rem;
            left: 0.125rem;
            width: 1.25rem;
            height: 1.25rem;
            background-color: white;
            border-radius: 50%;
            transition: all 0.3s;
        }
        .toggle-checkbox:checked + .toggle-label:after {
            transform: translateX(1.5rem);
        }
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
                    <h1 class="text-2xl font-bold text-gray-800">System Settings</h1>
                    <p class="text-sm text-gray-500 mt-1">Configure global rules, notifications, and library policies.</p>
                </div>
                <div class="flex items-center gap-3">
                    <button class="bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 text-sm font-bold px-4 py-2.5 rounded-lg transition-all shadow-sm">
                        Cancel
                    </button>
                    <button class="bg-[#1A2B56] hover:bg-[#243B73] text-white text-sm font-bold px-4 py-2.5 rounded-lg transition-all shadow-sm">
                        Save Changes
                    </button>
                </div>
            </div>

            <div class="flex flex-col md:flex-row gap-6 flex-1 min-h-0">
                
                <!-- Settings Navigation Sidebar -->
                <div class="w-full md:w-64 shrink-0">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-2">
                        <nav class="space-y-1">
                            <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg bg-blue-50 text-[#1A2B56] font-bold transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                General Settings
                            </a>
                            <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 hover:bg-gray-50 font-medium transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                                Library Rules
                            </a>
                            <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 hover:bg-gray-50 font-medium transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
                                Notifications
                            </a>
                            <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 hover:bg-gray-50 font-medium transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                                Security
                            </a>
                        </nav>
                    </div>
                </div>

                <!-- Settings Forms Content -->
                <div class="flex-1 overflow-y-auto">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-8">
                        
                        <!-- Section 1 -->
                        <div>
                            <h2 class="text-lg font-bold text-gray-800 border-b border-gray-100 pb-3 mb-5">System Details</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Library Name</label>
                                    <input type="text" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-[#1A2B56]/20 focus:border-[#1A2B56] outline-none transition-all" value="PGPC Library">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Contact Email</label>
                                    <input type="email" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-[#1A2B56]/20 focus:border-[#1A2B56] outline-none transition-all" value="admin@pgpc.edu.ph">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Library Address</label>
                                    <textarea class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-[#1A2B56]/20 focus:border-[#1A2B56] outline-none transition-all h-20 resize-none">123 University Avenue, Academic District</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Section 2 -->
                        <div>
                            <h2 class="text-lg font-bold text-gray-800 border-b border-gray-100 pb-3 mb-5">Borrowing Policies</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Max Borrowing Days (Students)</label>
                                    <div class="relative">
                                        <input type="number" class="w-full border border-gray-300 rounded-lg px-4 py-2 pr-16 text-sm focus:ring-2 focus:ring-[#1A2B56]/20 focus:border-[#1A2B56] outline-none transition-all" value="14">
                                        <span class="absolute right-3 top-2 text-gray-400 text-sm font-medium">Days</span>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Max Borrowing Days (Faculty)</label>
                                    <div class="relative">
                                        <input type="number" class="w-full border border-gray-300 rounded-lg px-4 py-2 pr-16 text-sm focus:ring-2 focus:ring-[#1A2B56]/20 focus:border-[#1A2B56] outline-none transition-all" value="30">
                                        <span class="absolute right-3 top-2 text-gray-400 text-sm font-medium">Days</span>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Max Books per Student</label>
                                    <input type="number" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-[#1A2B56]/20 focus:border-[#1A2B56] outline-none transition-all" value="3">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Overdue Fine (Per Day)</label>
                                    <div class="relative">
                                        <span class="absolute left-3 top-2 text-gray-400 text-sm font-bold">₱</span>
                                        <input type="number" class="w-full border border-gray-300 rounded-lg pl-8 pr-4 py-2 text-sm focus:ring-2 focus:ring-[#1A2B56]/20 focus:border-[#1A2B56] outline-none transition-all" value="10.00">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section 3 -->
                        <div>
                            <h2 class="text-lg font-bold text-gray-800 border-b border-gray-100 pb-3 mb-5">Features & Automation</h2>
                            
                            <div class="space-y-4">
                                <!-- Feature Toggle 1 -->
                                <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg bg-gray-50/50 hover:bg-gray-50 transition-colors">
                                    <div>
                                        <p class="font-bold text-gray-800 text-sm">Automated Overdue Emails</p>
                                        <p class="text-xs text-gray-500 mt-0.5">Automatically send warning emails when a book becomes overdue.</p>
                                    </div>
                                    <div class="relative inline-block w-12 align-middle select-none transition duration-200 ease-in">
                                        <input type="checkbox" name="toggle" id="toggle1" class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer" checked/>
                                        <label for="toggle1" class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                                    </div>
                                </div>

                                <!-- Feature Toggle 2 -->
                                <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg bg-gray-50/50 hover:bg-gray-50 transition-colors">
                                    <div>
                                        <p class="font-bold text-gray-800 text-sm">Allow Self-Registration</p>
                                        <p class="text-xs text-gray-500 mt-0.5">Let new students create their own accounts (requires email verification).</p>
                                    </div>
                                    <div class="relative inline-block w-12 align-middle select-none transition duration-200 ease-in">
                                        <input type="checkbox" name="toggle" id="toggle2" class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer"/>
                                        <label for="toggle2" class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </main>
    </div>
</body>
</html>
