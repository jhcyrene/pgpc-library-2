<x-layout.admin>
    <div class="flex-1 flex flex-col min-h-0 h-full p-6 bg-gray-50/50">
        <div class="flex items-center justify-between mb-6 shrink-0">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Preview Batch Import</h1>
                <p class="text-sm text-gray-500 mt-1 font-medium">Review rows before finalizing the import.</p>
            </div>
            
            <div class="flex gap-3">
                <a href="{{ route('admin.books.batch-create') }}" class="px-4 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-lg shadow-sm text-sm font-medium hover:bg-gray-50">Cancel</a>
                
                <form action="{{ route('admin.books.batch-store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="batch_id" value="{{ $batchId }}">
                    <button type="submit" class="flex items-center gap-2 bg-[#102b70] hover:bg-[#0b225e] text-white text-sm font-bold px-4 py-2.5 rounded-lg transition-all shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Confirm Import
                    </button>
                </form>
            </div>
        </div>

        @php
            $total = count($validatedRows);
            $valid = collect($validatedRows)->whereIn('status', ['valid', 'existing_title'])->count();
            $invalid = $total - $valid;
        @endphp

        <div class="grid grid-cols-3 gap-4 mb-6 shrink-0">
            <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 font-medium uppercase">Total Rows</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $total }}</p>
                </div>
                <div class="p-3 bg-gray-50 rounded-lg text-gray-400">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" /></svg>
                </div>
            </div>
            <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 font-medium uppercase">Valid (Will Import)</p>
                    <p class="text-2xl font-bold text-green-600">{{ $valid }}</p>
                </div>
                <div class="p-3 bg-green-50 rounded-lg text-green-500">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                </div>
            </div>
            <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 font-medium uppercase">Invalid (Will Skip)</p>
                    <p class="text-2xl font-bold text-red-600">{{ $invalid }}</p>
                </div>
                <div class="p-3 bg-red-50 rounded-lg text-red-500">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </div>
            </div>
        </div>

        <div class="flex-1 bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden flex flex-col">
            <div class="overflow-y-auto flex-1">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50 sticky top-0 z-10 shadow-sm">
                        <tr>
                            <th class="px-4 py-3 text-xs font-semibold text-gray-600 uppercase">Row</th>
                            <th class="px-4 py-3 text-xs font-semibold text-gray-600 uppercase">Status</th>
                            <th class="px-4 py-3 text-xs font-semibold text-gray-600 uppercase">Title</th>
                            <th class="px-4 py-3 text-xs font-semibold text-gray-600 uppercase">Author</th>
                            <th class="px-4 py-3 text-xs font-semibold text-gray-600 uppercase">Accession</th>
                            <th class="px-4 py-3 text-xs font-semibold text-gray-600 uppercase">Remarks</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($validatedRows as $row)
                            <tr class="hover:bg-gray-50 transition-colors {{ $row['status'] === 'invalid' ? 'bg-red-50/50' : '' }}">
                                <td class="px-4 py-3 text-sm text-gray-500">{{ $row['index'] + 2 }}</td> <!-- +2 for header and 0-index -->
                                <td class="px-4 py-3">
                                    @if($row['status'] === 'valid')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">New Title</span>
                                    @elseif($row['status'] === 'existing_title')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">Add Copy</span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">Invalid</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm font-medium text-gray-800">{{ $row['parsed']['book_title'] ?? 'N/A' }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $row['parsed']['main_author_last_name'] ?? 'N/A' }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $row['parsed']['accession_number'] ?? 'N/A' }}</td>
                                <td class="px-4 py-3 text-xs text-red-600">
                                    @if(!empty($row['errors']))
                                        <ul class="list-disc pl-4">
                                            @foreach($row['errors'] as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layout.admin>
