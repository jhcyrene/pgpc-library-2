<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply for a Reservation - PGPC Library</title>
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
        <main class="flex-1 flex flex-col p-4 md:p-8">
            
            <!-- Page Header -->
            <div class="mb-8 shrink-0">
                <h1 class="text-3xl font-extrabold tracking-tight text-gray-900 mb-2">Book Reservation</h1>
                <p class="text-sm text-gray-500 max-w-xl">Request a book from our catalog to be set aside for you. You will be notified once the book is ready for pickup.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Reservation Form (Left Column, takes 2 spaces) -->
                <div class="lg:col-span-2">
                    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 sm:p-10 relative overflow-hidden">
                        <!-- Decorative Header line -->
                        <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-[#1A2B56] to-[#FFC107]"></div>
                        
                        <form action="#" method="POST" class="space-y-8 mt-2">
                            
                            <!-- Search & Book Info -->
                            <div>
                                <h3 class="text-lg font-bold text-[#1A2B56] mb-4 flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#FFC107]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                                    Select a Book
                                </h3>
                                
                                <div>
                                    <label for="book_search" class="block text-sm font-semibold text-gray-700 mb-1.5">Book Title, Author, or ISBN <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                                        </div>
                                        <input type="text" id="book_search" name="book_search" class="pl-11 w-full rounded-xl border-gray-300 border px-4 py-3.5 text-sm focus:border-[#1A2B56] focus:ring-[#1A2B56] transition-all bg-gray-50 focus:bg-white" placeholder="e.g. Introduction to Algorithms..." required>
                                        
                                        <!-- Quick Link to Catalog -->
                                        <div class="absolute inset-y-0 right-2 flex items-center">
                                            <a href="/catalog" class="text-[11px] font-bold bg-white border border-gray-200 text-gray-600 px-2.5 py-1 rounded-lg hover:bg-gray-50 transition-colors">Browse Catalog</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <hr class="border-gray-100">

                            <!-- Pickup Details -->
                            <div>
                                <h3 class="text-lg font-bold text-[#1A2B56] mb-4 flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#FFC107]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                    Pickup Details
                                </h3>
                                
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                    <div>
                                        <label for="pickup_location" class="block text-sm font-semibold text-gray-700 mb-1.5">Pickup Branch <span class="text-red-500">*</span></label>
                                        <select id="pickup_location" name="pickup_location" class="w-full rounded-xl border-gray-300 border px-4 py-3.5 text-sm focus:border-[#1A2B56] focus:ring-[#1A2B56] transition-colors bg-gray-50 focus:bg-white" required>
                                            <option value="">Select a branch</option>
                                            <option value="main" selected>Main Library - Circulation Desk</option>
                                            <option value="science">Science & Tech Branch</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label for="pickup_date" class="block text-sm font-semibold text-gray-700 mb-1.5">Reservations Date</label>
                                        <input type="date" id="pickup_date" name="pickup_date" class="w-full rounded-xl border-gray-300 border px-4 py-3.5 text-sm focus:border-[#1A2B56] focus:ring-[#1A2B56] transition-colors bg-gray-50 focus:bg-white">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Additional Information -->
                            <div>
                                <label for="notes" class="block text-sm font-semibold text-gray-700 mb-1.5">Remarks / Instructions (Optional)</label>
                                <textarea id="notes" name="notes" rows="3" class="w-full rounded-xl border-gray-300 border px-4 py-3.5 text-sm focus:border-[#1A2B56] focus:ring-[#1A2B56] transition-colors bg-gray-50 focus:bg-white placeholder-gray-400" placeholder="Let us know if you need a specific volume or edition..."></textarea>
                            </div>

                            <!-- Submission -->
                            <div class="pt-6 flex flex-col sm:flex-row items-center justify-end gap-3 sm:gap-4 border-t border-gray-100">
                                <a href="/users/dashboard" class="w-full sm:w-auto px-6 py-3.5 text-sm font-bold text-gray-500 hover:text-gray-900 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors text-center">Cancel</a>
                                <button type="button" onclick="alert('Reservation submitted successfully!')" class="w-full sm:w-auto bg-[#FFC107] hover:bg-[#e0a800] text-[#1A2B56] px-8 py-3.5 rounded-xl text-sm font-bold shadow-sm hover:shadow transition-all flex justify-center items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    Confirm Reservation
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Guidelines & Info (Right Column) -->
                <div class="flex flex-col gap-6">
                    <!-- Guidelines Card -->
                    <div class="bg-blue-50/50 border border-blue-100 rounded-2xl p-6 relative overflow-hidden group">
                        <div class="absolute -right-6 -top-6 text-blue-100/50 group-hover:scale-110 transition-transform duration-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-32 w-32" fill="currentColor" viewBox="0 0 24 24"><path d="M12 22a10 10 0 100-20 10 10 0 000 20zm-1-11v6h2v-6h-2zm0-4v2h2V7h-2z"/></svg>
                        </div>
                        
                        <h3 class="font-extrabold text-[#1A2B56] mb-4 flex items-center gap-2 relative z-10 text-lg">
                            Reservation Policies
                        </h3>
                        
                        <ul class="space-y-4 text-sm text-[#1A2B56]/80 relative z-10 font-medium">
                            <li class="flex items-start gap-3 bg-white/60 p-3 rounded-lg border border-blue-50/50">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                <span>Reservations are held for a maximum of <strong>3 days</strong> once they become available.</span>
                            </li>
                            <li class="flex items-start gap-3 bg-white/60 p-3 rounded-lg border border-blue-50/50">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                                <span>Students can have up to <strong>2 active reservations</strong> simultaneously.</span>
                            </li>
                            <li class="flex items-start gap-3 bg-white/60 p-3 rounded-lg border border-blue-50/50">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" /></svg>
                                <span>Reference materials and periodicals cannot be reserved.</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            
        </main>
    </div>
</body>
</html>
