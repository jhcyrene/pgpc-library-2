<x-layout.admin>
    <div class="flex-1 flex flex-col min-h-0 h-full p-6 bg-gray-50/50">
        <div class="flex items-center justify-between mb-6 shrink-0">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Manage Physical Copies</h1>
                <p class="text-sm text-gray-500 mt-1 font-medium">{{ $bookData->book_title }} - {{ $bookData->bookDetail?->isbn ?? 'No ISBN' }}</p>
            </div>
            
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.books.index') }}" class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg shadow-sm text-sm font-medium hover:bg-gray-50">Back to Books</a>
                <a href="{{ route('admin.books.copies.create', $bookData->book_data_id) }}" class="flex items-center gap-2 bg-[#102b70] hover:bg-[#0b225e] text-white text-sm font-bold px-4 py-2 rounded-lg transition-all shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Add Copy
                </a>
            </div>
        </div>

        @if(session('success'))
            <x-alert type="success" message="{{ session('success') }}" />
        @endif
        @if(session('error'))
            <x-alert type="error" message="{{ session('error') }}" />
        @endif

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="px-6 py-3 text-xs font-semibold text-gray-600 uppercase tracking-wider">Accession Number</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-600 uppercase tracking-wider">Barcode</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-600 uppercase tracking-wider">Location</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-600 uppercase tracking-wider text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @php
                            $barcodeGenerator = new \Picqer\Barcode\BarcodeGeneratorPNG();
                        @endphp
                        @forelse($bookData->books as $copy)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 text-sm font-bold text-gray-800">{{ $copy->accession_number }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $copy->barcode ?? 'N/A' }}
                                    @if($copy->barcode)
                                        @php
                                            $barcodeBase64 = base64_encode($barcodeGenerator->getBarcode($copy->barcode, $barcodeGenerator::TYPE_CODE_128));
                                            $qrSvg = \SimpleSoftwareIO\QrCode\Facades\QrCode::size(150)->generate($copy->barcode);
                                        @endphp
                                        <div class="hidden" id="barcode-data-{{ $copy->book_id }}">data:image/png;base64,{{ $barcodeBase64 }}</div>
                                        <div class="hidden" id="qr-data-{{ $copy->book_id }}">{!! $qrSvg !!}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $copy->location ?? 'N/A' }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        {{ $copy->status === 'Available' ? 'bg-green-100 text-green-800' : 
                                           ($copy->status === 'Borrowed' ? 'bg-blue-100 text-blue-800' : 
                                           ($copy->status === 'Archived' ? 'bg-gray-100 text-gray-800' : 'bg-red-100 text-red-800')) }}">
                                        {{ $copy->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.book-copies.edit', $copy->book_id) }}" class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 p-1.5 rounded-md transition-colors" title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                        </a>
                                        @if($copy->barcode)
                                            <button type="button" onclick="showBarcodeModal('{{ $copy->book_id }}', '{{ $copy->barcode }}')" class="text-gray-600 hover:text-gray-900 bg-gray-50 hover:bg-gray-200 p-1.5 rounded-md transition-colors" title="View Barcode">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                                </svg>
                                            </button>
                                        @endif
                                        @if($copy->status !== 'Archived')
                                        <form action="{{ route('admin.book-copies.destroy', $copy->book_id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to archive this copy?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 p-1.5 rounded-md transition-colors" title="Archive">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                                </svg>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    <p class="text-sm">No physical copies found for this book.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Barcode & QR Code Modal -->
    <div id="barcodeModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closeBarcodeModal()"></div>

        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-sm">
                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left w-full">
                                <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Barcode Information</h3>
                                <div class="mt-4 flex flex-col items-center justify-center gap-6">
                                    <div class="text-center w-full">
                                        <p class="text-sm font-medium text-gray-500 mb-2">Barcode</p>
                                        <img id="modalBarcodeImg" src="" alt="Barcode" class="mx-auto h-16 w-auto" />
                                        <p id="modalBarcodeText" class="text-xs text-gray-700 mt-1 font-mono tracking-widest"></p>
                                    </div>
                                    <div class="w-full border-t border-gray-100"></div>
                                    <div class="text-center w-full">
                                        <p class="text-sm font-medium text-gray-500 mb-2">QR Code</p>
                                        <div id="modalQrContainer" class="mx-auto flex justify-center"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                        <button type="button" onclick="closeBarcodeModal()" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Close</button>
                        <button type="button" onclick="window.print()" class="mr-3 mt-3 inline-flex w-full justify-center rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 sm:mt-0 sm:w-auto">Print</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showBarcodeModal(bookId, barcodeText) {
            const barcodeData = document.getElementById('barcode-data-' + bookId).innerText;
            const qrData = document.getElementById('qr-data-' + bookId).innerHTML;
            
            document.getElementById('modalBarcodeImg').src = barcodeData;
            document.getElementById('modalBarcodeText').innerText = barcodeText;
            document.getElementById('modalQrContainer').innerHTML = qrData;
            
            document.getElementById('barcodeModal').classList.remove('hidden');
        }

        function closeBarcodeModal() {
            document.getElementById('barcodeModal').classList.add('hidden');
        }
    </script>
</x-layout.admin>
