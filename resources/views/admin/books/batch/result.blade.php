<x-layout.admin>
    <div class="flex-1 flex flex-col min-h-0 h-full p-6 bg-gray-50/50">
        
        <div class="max-w-2xl mx-auto mt-12 w-full">
            <div class="bg-white p-8 rounded-xl border border-gray-200 shadow-sm text-center">
                
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-6">
                    <svg class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Import Completed!</h2>
                <p class="text-gray-500 mb-8">The batch import process has finished executing.</p>

                <div class="grid grid-cols-2 gap-4 text-left mb-8">
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                        <p class="text-xs text-gray-500 uppercase font-bold tracking-wider mb-1">Total Processed</p>
                        <p class="text-xl font-bold text-gray-800">{{ $summary['total'] }} rows</p>
                    </div>
                    <div class="bg-green-50 p-4 rounded-lg border border-green-100">
                        <p class="text-xs text-green-600 uppercase font-bold tracking-wider mb-1">New Titles</p>
                        <p class="text-xl font-bold text-green-800">{{ $summary['imported_titles'] }} titles</p>
                    </div>
                    <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                        <p class="text-xs text-blue-600 uppercase font-bold tracking-wider mb-1">Total Copies Added</p>
                        <p class="text-xl font-bold text-blue-800">{{ $summary['imported_copies'] }} copies</p>
                    </div>
                    <div class="bg-red-50 p-4 rounded-lg border border-red-100">
                        <p class="text-xs text-red-600 uppercase font-bold tracking-wider mb-1">Failed / Skipped</p>
                        <p class="text-xl font-bold text-red-800">{{ $summary['failed'] }} rows</p>
                    </div>
                </div>

                <div class="flex items-center justify-center gap-4">
                    <a href="{{ route('admin.books.batch-create') }}" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-gray-200 transition-colors shadow-sm">
                        Import Another File
                    </a>
                    <a href="{{ route('admin.books.index') }}" class="px-5 py-2.5 text-sm font-medium text-white bg-[#102b70] border border-transparent rounded-lg hover:bg-[#0b225e] focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-[#102b70] transition-colors shadow-sm">
                        Go to Book Manager
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-layout.admin>
