<x-layout.admin>
    <div class="flex-1 flex flex-col min-h-0 h-full p-6 bg-gray-50/50">
        <div class="flex items-center justify-between mb-6 shrink-0">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Import MARC Records</h1>
                <p class="text-sm text-gray-500 mt-1 font-medium">Upload a MARC file to import bibliographic records into the catalog.</p>
            </div>
            
            <div class="flex gap-3">
                <a href="{{ route('admin.books.index') }}" class="flex items-center gap-2 text-[#1A2B56] bg-white border border-gray-200 hover:bg-gray-50 text-sm font-bold px-4 py-2.5 rounded-lg transition-all shadow-sm">
                    Back to Catalog
                </a>
            </div>
        </div>

        <div class="flex-1 overflow-y-auto">
            <div class="max-w-2xl mx-auto mt-8">
                
                @if(session('error'))
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-md">
                        <div class="flex items-center gap-2">
                            <svg class="h-5 w-5 text-red-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M5.07 19h13.86a2 2 0 001.74-3l-6.93-12a2 2 0 00-3.48 0L3.33 16a2 2 0 001.74 3z" />
                            </svg>
                            <p class="text-sm text-red-700 font-medium">{{ session('error') }}</p>
                        </div>
                    </div>
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
                    <form id="marc-upload-form" action="{{ route('admin.books.marc-preview') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        
                        <label for="marc_file" id="drop-zone" class="block border-2 border-dashed border-gray-300 rounded-lg p-12 hover:bg-gray-50 transition-colors relative cursor-pointer text-center w-full">
                            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            <div class="text-sm text-gray-600 mb-2">
                                <span id="file-label" class="font-medium text-[#1A2B56] hover:text-[#243B73]">Choose a MARC file</span>
                                <span class="pl-1">or drag and drop</span>
                            </div>
                            <p id="file-meta" class="text-xs text-gray-500">.mrc, .marc, .xml, or .marcxml — up to 10 MB</p>
                            <p id="file-error" class="mt-2 hidden text-xs font-semibold text-red-600" role="alert"></p>
                            <input id="marc_file" name="marc_file" type="file" class="sr-only" accept=".mrc,.marc,.xml,.marcxml" required>
                        </label>

                        <button id="submit-btn" type="submit" disabled class="flex w-full items-center justify-center gap-2 rounded-lg border border-transparent bg-[#1A2B56] px-5 py-3 text-sm font-medium text-white shadow-sm transition-colors hover:bg-[#243B73] focus:outline-none focus:ring-2 focus:ring-[#1A2B56] focus:ring-offset-1 disabled:cursor-not-allowed disabled:opacity-50">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            Preview Records
                        </button>
                    </form>
                </div>
                
                <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-5">
                    <h4 class="text-sm font-bold text-blue-800 mb-3">About MARC Import</h4>
                    <ul class="list-disc pl-5 text-sm text-blue-700 space-y-1.5">
                        <li>Supports <strong>MARC 21 binary</strong> (.mrc, .marc) and <strong>MARCXML</strong> (.xml, .marcxml) formats.</li>
                        <li>Extracted fields: title, author, ISBN, ISSN, publisher, year, edition, pages, call number, classification, language, subjects, and description.</li>
                        <li>If a book with the same ISBN or title + year already exists, the system will flag it as a duplicate.</li>
                        <li>You can optionally assign <strong>accession numbers</strong> to each record on the preview page to create physical copies.</li>
                        <li>Records without accession numbers are imported as bibliographic metadata only — copies can be added later.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        (() => {
            const form = document.getElementById('marc-upload-form');
            const fileInput = document.getElementById('marc_file');
            const dropZone = document.getElementById('drop-zone');
            const fileLabel = document.getElementById('file-label');
            const fileMeta = document.getElementById('file-meta');
            const fileError = document.getElementById('file-error');
            const submitBtn = document.getElementById('submit-btn');
            const allowedExtensions = new Set(['mrc', 'marc', 'xml', 'marcxml']);
            const maxFileSize = 10 * 1024 * 1024;

            const formatFileSize = (bytes) => {
                if (bytes < 1024) return `${bytes} B`;
                if (bytes < 1024 * 1024) return `${(bytes / 1024).toFixed(1)} KB`;
                return `${(bytes / (1024 * 1024)).toFixed(1)} MB`;
            };

            const extensionOf = (filename) => filename.includes('.')
                ? filename.split('.').pop().toLowerCase()
                : '';

            const validateFile = (file) => {
                if (! file) return 'Please choose a MARC file first.';
                if (! allowedExtensions.has(extensionOf(file.name))) {
                    return 'Choose a .mrc, .marc, .xml, or .marcxml file.';
                }
                if (file.size === 0) return 'The selected MARC file is empty.';
                if (file.size > maxFileSize) return 'The MARC file must not be larger than 10 MB.';
                return null;
            };

            const showError = (message) => {
                fileError.textContent = message;
                fileError.classList.remove('hidden');
                submitBtn.disabled = true;
                dropZone.classList.remove('border-[#1A2B56]', 'bg-blue-50');
                dropZone.classList.add('border-red-300', 'bg-red-50');
            };

            const showSelectedFile = (file) => {
                const error = validateFile(file);
                if (error) {
                    fileInput.value = '';
                    showError(error);
                    return false;
                }

                fileLabel.textContent = file.name;
                fileMeta.textContent = `${formatFileSize(file.size)} • ${extensionOf(file.name).toUpperCase()}`;
                fileError.textContent = '';
                fileError.classList.add('hidden');
                dropZone.classList.remove('border-gray-300', 'border-red-300', 'bg-red-50');
                dropZone.classList.add('border-[#1A2B56]', 'bg-blue-50');
                submitBtn.disabled = false;
                return true;
            };

            fileInput.addEventListener('change', (event) => {
                showSelectedFile(event.target.files[0]);
            });

            form.addEventListener('submit', (event) => {
                const file = fileInput.files[0];
                const error = validateFile(file);

                if (error) {
                    event.preventDefault();
                    showError(error);
                    return;
                }

                submitBtn.disabled = true;
                submitBtn.innerHTML = '<svg class="h-5 w-5 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Processing MARC file...';
            });

            ['dragenter', 'dragover'].forEach((eventName) => {
                dropZone.addEventListener(eventName, (event) => {
                    event.preventDefault();
                    dropZone.classList.remove('border-gray-300');
                    dropZone.classList.add('border-[#1A2B56]', 'bg-blue-50');
                });
            });

            ['dragleave', 'drop'].forEach((eventName) => {
                dropZone.addEventListener(eventName, (event) => {
                    event.preventDefault();
                    dropZone.classList.remove('bg-blue-50');
                });
            });

            dropZone.addEventListener('drop', (event) => {
                const file = event.dataTransfer?.files?.[0];
                if (! file) return;

                const transfer = new DataTransfer();
                transfer.items.add(file);
                fileInput.files = transfer.files;
                showSelectedFile(file);
            });
        })();
    </script>
</x-layout.admin>
