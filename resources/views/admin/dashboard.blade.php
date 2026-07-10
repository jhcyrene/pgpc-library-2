<x-layout.admin>
    
    <div class="mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>
            <p class="text-sm text-gray-500">Welcome back, Admin! Here is the overview of the library system.</p>
        </div>
        <div class="flex items-center gap-2">
            <button class="btn btn-primary text-white">Generate Report</button>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Card 1 -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-start gap-4">
            <div class="w-12 h-12 rounded-lg bg-blue-50 text-blue-500 flex items-center justify-center shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Total Books</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-1">12,450</h3>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-start gap-4">
            <div class="w-12 h-12 rounded-lg bg-green-50 text-green-500 flex items-center justify-center shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Active Members</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-1">3,210</h3>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-start gap-4">
            <div class="w-12 h-12 rounded-lg bg-orange-50 text-orange-500 flex items-center justify-center shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Books Borrowed</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-1">845</h3>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-start gap-4">
            <div class="w-12 h-12 rounded-lg bg-red-50 text-red-500 flex items-center justify-center shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Overdue Returns</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-1">42</h3>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Recent Activities -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-lg font-bold text-gray-800">Recent Transactions</h3>
                <a href="#" class="text-sm text-primary font-medium hover:underline">View All</a>
            </div>
            <div class="overflow-x-auto">
                <table class="table w-full">
                    <!-- head -->
                    <thead>
                        <tr class="bg-gray-50 text-gray-500 uppercase text-xs">
                            <th class="px-6 py-4 font-semibold tracking-wider">User</th>
                            <th class="px-6 py-4 font-semibold tracking-wider">Book</th>
                            <th class="px-6 py-4 font-semibold tracking-wider">Action</th>
                            <th class="px-6 py-4 font-semibold tracking-wider">Date</th>
                            <th class="px-6 py-4 font-semibold tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        <!-- row 1 -->
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-800">Juan Dela Cruz</td>
                            <td class="px-6 py-4 text-gray-600">Introduction to Algorithms</td>
                            <td class="px-6 py-4 text-gray-600">Borrow</td>
                            <td class="px-6 py-4 text-gray-500">Today, 10:23 AM</td>
                            <td class="px-6 py-4"><span class="badge badge-success badge-sm text-white border-none py-2 px-3">Active</span></td>
                        </tr>
                        <!-- row 2 -->
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-800">Maria Clara</td>
                            <td class="px-6 py-4 text-gray-600">Noli Me Tangere</td>
                            <td class="px-6 py-4 text-gray-600">Return</td>
                            <td class="px-6 py-4 text-gray-500">Today, 09:15 AM</td>
                            <td class="px-6 py-4"><span class="badge badge-ghost badge-sm py-2 px-3">Completed</span></td>
                        </tr>
                        <!-- row 3 -->
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-800">Jose Rizal</td>
                            <td class="px-6 py-4 text-gray-600">El Filibusterismo</td>
                            <td class="px-6 py-4 text-gray-600">Borrow</td>
                            <td class="px-6 py-4 text-gray-500">Yesterday, 03:45 PM</td>
                            <td class="px-6 py-4"><span class="badge badge-error badge-sm text-white border-none py-2 px-3">Overdue</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Right Sidebar (Alerts/Notifications) -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">System Alerts</h3>
            
            <div class="space-y-4">
                <div class="flex gap-4 p-4 rounded-xl bg-orange-50 border border-orange-100">
                    <div class="text-orange-500 mt-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-medium text-orange-800 text-sm">High Server Load</h4>
                        <p class="text-xs text-orange-600 mt-1">Database CPU utilization exceeded 85% for the last 10 minutes.</p>
                    </div>
                </div>

                <div class="flex gap-4 p-4 rounded-xl bg-blue-50 border border-blue-100">
                    <div class="text-blue-500 mt-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-medium text-blue-800 text-sm">System Update Available</h4>
                        <p class="text-xs text-blue-600 mt-1">Version 2.4.1 is ready to be installed. Please schedule downtime.</p>
                    </div>
                </div>
                
                <div class="flex gap-4 p-4 rounded-xl bg-green-50 border border-green-100">
                    <div class="text-green-500 mt-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-medium text-green-800 text-sm">Backup Successful</h4>
                        <p class="text-xs text-green-600 mt-1">Daily database backup completed successfully at 03:00 AM.</p>
                    </div>
                </div>
            </div>
            
            <button class="w-full mt-6 btn btn-outline btn-sm text-gray-500">View All Notifications</button>
        </div>
    </div>
</x-layout.admin>
