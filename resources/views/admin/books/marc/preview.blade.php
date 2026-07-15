<x-layout.admin>
    <div class="flex-1 flex flex-col min-h-0 h-full p-6 bg-gray-50/50">
        <div class="flex items-center justify-between mb-6 shrink-0">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Preview MARC Import</h1>
                <p class="text-sm text-gray-500 mt-1 font-medium">Review parsed records and optionally assign accession numbers before importing.</p>
            </div>
            
            <div class="flex gap-3">
                <a href="{{ route('admin.books.batch-create') }}" class="px-4 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-lg shadow-sm text-sm font-medium hover:bg-gray-50">Cancel</a>
            </div>
        </div>

        @php
            $total   = count($validatedRows);
            $valid   = collect($validatedRows)->whereIn('status', ['valid', 'existing_title'])->count();
            $newCount = collect($validatedRows)->where('status', 'valid')->count();
            $dupeCount = collect($validatedRows)->where('status', 'existing_title')->count();
            $invalid = $total - $valid;
        @endphp

        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6 shrink-0">
            <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 font-medium uppercase">Total Records</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $total }}</p>
                </div>
                <div class="p-3 bg-gray-50 rounded-lg text-gray-400">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" /></svg>
                </div>
            </div>
            <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 font-medium uppercase">New Titles</p>
                    <p class="text-2xl font-bold text-green-600">{{ $newCount }}</p>
                </div>
                <div class="p-3 bg-green-50 rounded-lg text-green-500">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                </div>
            </div>
            <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 font-medium uppercase">Existing Titles</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $dupeCount }}</p>
                </div>
                <div class="p-3 bg-blue-50 rounded-lg text-blue-500">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2" /></svg>
                </div>
            </div>
            <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 font-medium uppercase">Invalid (Skip)</p>
                    <p class="text-2xl font-bold text-red-600">{{ $invalid }}</p>
                </div>
                <div class="p-3 bg-red-50 rounded-lg text-red-500">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.books.marc-store') }}" method="POST" class="flex-1 flex flex-col min-h-0">
            @csrf
            <input type="hidden" name="batch_id" value="{{ $batchId }}">

            <div class="flex-1 bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden flex flex-col">
                <div class="overflow-y-auto flex-1">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-50 sticky top-0 z-10 shadow-sm">
                            <tr>
                                <th class="px-4 py-3 text-xs font-semibold text-gray-600 uppercase w-12">#</th>
                                <th class="px-4 py-3 text-xs font-semibold text-gray-600 uppercase">Status</th>
                                <th class="px-4 py-3 text-xs font-semibold text-gray-600 uppercase">Title</th>
                                <th class="px-4 py-3 text-xs font-semibold text-gray-600 uppercase">Author</th>
                                <th class="px-4 py-3 text-xs font-semibold text-gray-600 uppercase">ISBN</th>
                                <th class="px-4 py-3 text-xs font-semibold text-gray-600 uppercase">Publisher</th>
                                <th class="px-4 py-3 text-xs font-semibold text-gray-600 uppercase">Year</th>
                                <th class="px-4 py-3 text-xs font-semibold text-gray-600 uppercase min-w-[160px]">Accession No.</th>
                                <th class="px-4 py-3 text-xs font-semibold text-gray-600 uppercase">Remarks</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($validatedRows as $row)
                                <tr class="hover:bg-gray-50 transition-colors {{ $row['status'] === 'invalid' ? 'bg-red-50/50' : '' }}">
                                    <td class="px-4 py-3 text-sm text-gray-500">{{ $row['index'] + 1 }}</td>
                                    <td class="px-4 py-3">
                                        @if($row['status'] === 'valid')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">New Title</span>
                                        @elseif($row['status'] === 'existing_title')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">Existing</span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">Invalid</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-sm font-medium text-gray-800 max-w-[200px] truncate" title="{{ $row['parsed']['book_title'] ?? '' }}">
                                        {{ $row['parsed']['book_title'] ?? 'N/A' }}
                                        @if(!empty($row['parsed']['subtitle']))
                                            <span class="block text-xs text-gray-500 truncate">{{ $row['parsed']['subtitle'] }}</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-600">
                                        {{ $row['parsed']['main_author_last_name'] ?? '' }}{{ !empty($row['parsed']['main_author_first_name']) ? ', ' . $row['parsed']['main_author_first_name'] : '' }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-600 font-mono text-xs">{{ $row['parsed']['isbn'] ?? '—' }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-600 max-w-[120px] truncate">{{ $row['parsed']['publisher'] ?? '—' }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">{{ $row['parsed']['publication_year'] ?? '—' }}</td>
                                    <td class="px-4 py-3">
                                        @if($row['status'] !== 'invalid')
                                            <input
                                                type="text"
                                                name="accessions[{{ $row['index'] }}]"
                                                placeholder="e.g. ACC-1001"
                                                class="w-full text-sm border border-gray-200 rounded-lg px-3 py-1.5 placeholder:text-gray-400 focus:border-[#102b70] focus:ring-2 focus:ring-blue-100 outline-none"
                                            >
                                        @else
                                            <span class="text-xs text-gray-400">—</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-xs text-red-600">
                                        @if(!empty($row['errors']))
                                            <ul class="list-disc pl-4">
                                                @foreach($row['errors'] as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        @elseif($row['status'] === 'existing_title')
                                            <span class="text-blue-600">Title already in catalog</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-4 flex items-center justify-between shrink-0">
                <p class="text-sm text-gray-500">
                    <strong>{{ $valid }}</strong> record(s) will be processed. Records with accession numbers will also create physical copies.
                </p>
                <button type="submit" class="flex items-center gap-2 bg-[#102b70] hover:bg-[#0b225e] text-white text-sm font-bold px-6 py-2.5 rounded-lg transition-all shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Confirm Import
                </button>
            </div>
        </form>
    </div>
</x-layout.admin>
