<x-layout.admin>
    <div class="flex-1 flex flex-col min-h-0 h-full p-4 md:p-6 bg-gray-50/50">
        <div class="flex items-center justify-between mb-4 shrink-0">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Book Details</h1>
            </div>
            
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.books.index') }}" class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg shadow-sm text-sm font-medium hover:bg-gray-50">Back</a>
                <a href="{{ route('admin.books.edit', $bookData->book_data_id) }}" class="flex items-center gap-2 bg-[#1A2B56] hover:bg-[#243B73] text-white text-sm font-bold px-4 py-2 rounded-lg transition-all shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                    Edit
                </a>
            </div>
        </div>

        <div class="flex-1 overflow-y-auto">
            <div class="max-w-7xl mx-auto space-y-4">
                
                <!-- Main Book Details Card -->
                <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm flex flex-col md:flex-row gap-6">
                    <!-- Cover Image -->
                    <div class="w-40 shrink-0">
                        <div class="bg-gray-100 w-full aspect-[2/3] rounded-lg border border-gray-200 flex items-center justify-center shadow-sm">
                            @if($bookData->bookDetail?->cover_image)
                                <img src="{{ str_starts_with($bookData->bookDetail->cover_image, 'data:image') ? $bookData->bookDetail->cover_image : asset('storage/' . ltrim($bookData->bookDetail->cover_image, '/')) }}" alt="Cover" class="w-full h-full object-cover rounded-lg">
                            @else
                                <svg class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Title and Info -->
                    <div class="flex-1 flex flex-col">
                        <h2 class="text-2xl font-bold text-gray-800 leading-tight">{{ $bookData->book_title }}</h2>
                        @if($bookData->subtitle)
                            <h3 class="text-lg text-gray-600 mt-1">{{ $bookData->subtitle }}</h3>
                        @endif
                        
                        <p class="text-md text-[#1A2B56] font-semibold mt-1">
                            By 
                            @forelse($bookData->authors as $author)
                                {{ $author->first_name }} {{ $author->last_name }}@if(!$loop->last), @endif
                            @empty
                                Unknown Author
                            @endforelse
                        </p>
                        
                        <div class="flex flex-wrap gap-2 mt-2">
                            @foreach($bookData->categories as $category)
                                <span class="px-2 py-0.5 bg-gray-100 text-gray-700 rounded text-xs font-semibold">{{ $category->category_name }}</span>
                            @endforeach
                        </div>

                        <div class="mt-3 text-sm text-gray-600 max-w-3xl line-clamp-3" title="{{ $bookData->description }}">
                            {{ $bookData->description ?? 'No description available.' }}
                        </div>
                    </div>

                    <!-- QR and Barcode Display -->
                    @php
                        $firstCopy = $bookData->books->firstWhere('barcode', '!=', null);
                        $barcodeGenerator = new \Picqer\Barcode\BarcodeGeneratorPNG();
                    @endphp
                    @if($firstCopy)
                        <div class="w-48 shrink-0 flex flex-col items-center justify-center p-3 bg-gray-50 border border-gray-100 rounded-lg">
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Copy #{{ $firstCopy->accession_number }}</span>
                            <div class="bg-white p-2 rounded shadow-sm border border-gray-100 mb-2">
                                {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(80)->generate($firstCopy->barcode) !!}
                            </div>
                            <img src="data:image/png;base64,{{ base64_encode($barcodeGenerator->getBarcode($firstCopy->barcode, $barcodeGenerator::TYPE_CODE_128)) }}" alt="Barcode" class="h-8 object-contain mix-blend-multiply">
                            <span class="text-xs text-gray-600 font-medium mt-1 tracking-widest">{{ $firstCopy->barcode }}</span>
                        </div>
                    @endif
                </div>

                <!-- Combined Details Grid -->
                <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 text-sm">
                    <div>
                        <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider">ISBN</span>
                        <span class="font-medium text-gray-800">{{ $bookData->bookDetail?->isbn ?? 'N/A' }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Publisher</span>
                        <span class="font-medium text-gray-800">{{ $bookData->bookDetail?->publisher?->publisher_name ?? 'N/A' }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Publication Year</span>
                        <span class="font-medium text-gray-800">{{ $bookData->bookDetail?->publication_year ?? 'N/A' }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Edition / Pages</span>
                        <span class="font-medium text-gray-800">{{ $bookData->bookDetail?->edition ?? 'N/A' }} / {{ $bookData->bookDetail?->pages ?? 'N/A' }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Call Number</span>
                        <span class="font-medium text-gray-800">{{ $bookData->bookDetail?->call_number ?? 'N/A' }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Classification</span>
                        <span class="font-medium text-gray-800">{{ $bookData->bookDetail?->classification ?? 'N/A' }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Format</span>
                        <span class="font-medium text-gray-800">{{ $bookData->bookDetail?->format ?? 'N/A' }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Language</span>
                        <span class="font-medium text-gray-800">{{ $bookData->language ?? 'N/A' }}</span>
                    </div>
                </div>

                <!-- Physical Copies -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm flex flex-col h-full">
                    <div class="flex items-center justify-between p-4 border-b border-gray-100 bg-gray-50/50 rounded-t-xl shrink-0">
                        <h3 class="text-sm font-bold text-[#1A2B56] uppercase tracking-wider">Physical Copies ({{ $bookData->books->count() }})</h3>
                        <a href="{{ route('admin.books.copies.index', $bookData->book_data_id) }}" class="text-xs text-blue-600 hover:text-blue-800 font-bold bg-blue-50 px-3 py-1 rounded-full">Manage Copies</a>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead>
                                <tr class="text-gray-500 border-b border-gray-100 bg-white">
                                    <th class="py-3 px-4 font-semibold">Accession #</th>
                                    <th class="py-3 px-4 font-semibold">Barcode</th>
                                    <th class="py-3 px-4 font-semibold">Status</th>
                                    <th class="py-3 px-4 font-semibold text-right">Location</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($bookData->books as $copy)
                                    <tr class="hover:bg-gray-50/50 transition-colors">
                                        <td class="py-3 px-4 font-medium text-gray-800">{{ $copy->accession_number }}</td>
                                        <td class="py-3 px-4 text-gray-600">
                                            <div class="flex items-center gap-2">
                                                <span class="font-mono text-xs bg-gray-100 px-2 py-1 rounded">{{ $copy->barcode ?? 'N/A' }}</span>
                                                @if($copy->barcode)
                                                    @php
                                                        $barcodeBase64 = base64_encode($barcodeGenerator->getBarcode($copy->barcode, $barcodeGenerator::TYPE_CODE_128));
                                                        $qrSvg = \SimpleSoftwareIO\QrCode\Facades\QrCode::size(120)->generate($copy->barcode);
                                                    @endphp
                                                    <div class="hidden" id="barcode-data-{{ $copy->book_id }}">data:image/png;base64,{{ $barcodeBase64 }}</div>
                                                    <div class="hidden" id="qr-data-{{ $copy->book_id }}">{!! $qrSvg !!}</div>
                                                    <button type="button" onclick="showBarcodeModal('{{ $copy->book_id }}', '{{ $copy->barcode }}')" class="text-[#1A2B56] hover:text-blue-700 bg-blue-50 hover:bg-blue-100 p-1.5 rounded transition-colors" title="View Barcode">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                                        </svg>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="py-3 px-4">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold tracking-wide
                                                {{ $copy->status === 'Available' ? 'bg-green-100 text-green-800' : 
                                                   ($copy->status === 'Borrowed' ? 'bg-blue-100 text-blue-800' : 
                                                   ($copy->status === 'Archived' ? 'bg-gray-100 text-gray-800' : 'bg-red-100 text-red-800')) }}">
                                                {{ $copy->status }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-4 text-right text-gray-600 font-medium">{{ $copy->location ?? 'N/A' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-8 text-center text-gray-500 bg-gray-50/30">No physical copies found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Barcode & QR Code Modal -->
    <div id="barcodeModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closeBarcodeModal()"></div>
        
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-sm">
                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <div class="text-center">
                            <h3 class="text-lg font-bold leading-6 text-gray-900 mb-4" id="modal-title">Barcode Information</h3>
                            
                            <div class="flex flex-col items-center gap-6">
                                <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 w-full flex flex-col items-center">
                                    <span class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">QR Code</span>
                                    <div id="modal-qr-container" class="bg-white p-3 rounded-lg shadow-sm border border-gray-100 inline-block"></div>
                                </div>
                                
                                <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 w-full flex flex-col items-center">
                                    <span class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Barcode</span>
                                    <img id="modal-barcode-img" src="" alt="Barcode" class="h-16 object-contain mix-blend-multiply bg-white px-4 py-2 rounded-lg shadow-sm border border-gray-100 w-full">
                                    <p id="modal-barcode-text" class="mt-2 text-lg font-mono font-bold tracking-widest text-gray-800"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                        <button type="button" onclick="closeBarcodeModal()" class="mt-3 inline-flex w-full justify-center rounded-lg bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showBarcodeModal(id, barcodeText) {
            const qrHtml = document.getElementById('qr-data-' + id).innerHTML;
            const barcodeBase64 = document.getElementById('barcode-data-' + id).innerHTML;
            
            document.getElementById('modal-qr-container').innerHTML = qrHtml;
            document.getElementById('modal-barcode-img').src = barcodeBase64;
            document.getElementById('modal-barcode-text').innerText = barcodeText;
            
            document.getElementById('barcodeModal').classList.remove('hidden');
        }

        function closeBarcodeModal() {
            document.getElementById('barcodeModal').classList.add('hidden');
        }
    </script>
</x-layout.admin>
