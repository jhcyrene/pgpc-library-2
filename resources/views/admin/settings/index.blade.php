<x-layout.admin>
    <div class="h-full flex flex-col bg-gray-50/50 p-4 md:p-6 lg:p-8">
        
        <!-- PAGE HEADER -->
        <div class="mb-8">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900 tracking-tight">System Settings</h1>
            <p class="text-sm md:text-base text-gray-500 mt-1">Configure library rules and operational parameters.</p>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-start gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 text-emerald-500 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="font-medium text-sm">{{ session('success') }}</div>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200 text-red-800 flex items-start gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 text-red-500 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <ul class="font-medium text-sm list-disc pl-4">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 flex flex-col max-w-3xl">
            <div class="p-5 border-b border-gray-100 flex items-center gap-4 bg-gray-50/50 rounded-t-2xl">
                <div class="w-10 h-10 rounded-full bg-brand-navy/10 text-brand-navy flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-gray-900 leading-tight">Circulation Rules</h2>
                    <p class="text-xs text-gray-500">Manage borrowing limits, duration, and penalties.</p>
                </div>
            </div>

            <form action="{{ route('admin.settings.store') }}" method="POST" class="p-6 md:p-8 space-y-6">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Borrow Duration -->
                    <div class="form-control">
                        <label class="label font-semibold text-gray-700">
                            <span class="label-text">Default Borrow Duration (Days)</span>
                        </label>
                        <div class="relative">
                            <input type="number" name="default_borrow_days" value="{{ old('default_borrow_days', $defaultBorrowDays) }}" class="input input-bordered w-full pr-16 focus:border-blue-500 focus:ring-blue-500" min="1" required>
                            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm font-medium">Days</span>
                        </div>
                        <p class="mt-2 text-xs text-gray-500 whitespace-normal leading-relaxed">
                            The number of days a book can be borrowed before it is considered overdue.
                        </p>
                    </div>

                    <!-- Daily Fine -->
                    <div class="form-control">
                        <label class="label font-semibold text-gray-700">
                            <span class="label-text">Daily Fine Amount (₱)</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 font-medium">₱</span>
                            <input type="number" step="0.01" name="daily_fine_amount" value="{{ old('daily_fine_amount', $dailyFineAmount) }}" class="input input-bordered w-full pl-8 focus:border-blue-500 focus:ring-blue-500" min="0" required>
                        </div>
                        <p class="mt-2 text-xs text-gray-500 whitespace-normal leading-relaxed">
                            The amount to charge the user for each day a book is overdue.
                        </p>
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-100 flex justify-end">
                    <button type="submit" class="btn bg-brand-navy hover:bg-brand-navy-light text-white border-none shadow-md shadow-brand-navy/20 px-8 transition-colors">
                        Save Settings
                    </button>
                </div>
            </form>
        </div>

    </div>
</x-layout.admin>
