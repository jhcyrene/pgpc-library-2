<x-layout.admin>
    <div class="flex-1 flex flex-col min-h-0 h-full p-6 bg-gray-50/50">
        <div class="flex items-center justify-between mb-6 shrink-0">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Batch Add Books</h1>
                <p class="text-sm text-gray-500 mt-1 font-medium">Upload a CSV file to add multiple books or copies at once.</p>
            </div>
            
            <div class="flex gap-3">
                <a href="{{ route('admin.books.batch-template') }}" class="flex items-center gap-2 bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 text-sm font-bold px-4 py-2.5 rounded-lg transition-all shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Download Template
                </a>
                <a href="{{ route('admin.books.index') }}" class="flex items-center gap-2 text-[#1A2B56] bg-white border border-gray-200 hover:bg-gray-50 text-sm font-bold px-4 py-2.5 rounded-lg transition-all shadow-sm">
                    Back to Catalog
                </a>
            </div>
        </div>

        <div class="flex-1 overflow-y-auto">
            <div class="max-w-2xl mx-auto mt-8">
                
                @if(session('error'))
                    <x-admin.partials.alert type="error" message="{{ session('error') }}" />
                @endif
                
                @if($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-md">
                        <ul class="list-disc pl-5 text-sm text-red-700">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="bg-white p-8 rounded-xl border border-gray-200 shadow-sm text-center">
                    <form action="{{ route('admin.books.batch-preview') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-12 hover:bg-gray-50 transition-colors relative">
                            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <div class="text-sm text-gray-600 mb-2">
                                <label for="csv_file" class="relative cursor-pointer bg-white rounded-md font-medium text-[#1A2B56] hover:text-[#243B73] focus-within:outline-none">
                                    <span>Upload a file</span>
                                    <input id="csv_file" name="csv_file" type="file" class="sr-only" accept=".csv" required>
                                </label>
                                <p class="pl-1 inline">or drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">CSV up to 10MB</p>
                        </div>

                        <button type="submit" class="w-full px-5 py-3 text-sm font-medium text-white bg-[#1A2B56] border border-transparent rounded-lg hover:bg-[#243B73] focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-[#1A2B56] transition-colors shadow-sm flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            Preview Import
                        </button>
                    </form>
                </div>
                
                <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-5">
                    <h4 class="text-sm font-bold text-blue-800 mb-2">Important Notes</h4>
                    <ul class="list-disc pl-5 text-sm text-blue-700 space-y-1">
                        <li>Required columns: <code class="bg-blue-100 px-1 py-0.5 rounded text-xs">book_title</code>, <code class="bg-blue-100 px-1 py-0.5 rounded text-xs">author_last_name</code>, <code class="bg-blue-100 px-1 py-0.5 rounded text-xs">accession_number</code>.</li>
                        <li>If a book with the same ISBN or Title+Year exists, the system will add it as a new physical copy to the existing title.</li>
                        <li>Invalid rows will be skipped during import.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Simple script to show selected filename
        document.getElementById('csv_file').addEventListener('change', function(e) {
            var fileName = e.target.files[0].name;
            var label = e.target.nextElementSibling;
            if(label) label.innerText = fileName;
        });
    </script>
</x-layout.admin>
