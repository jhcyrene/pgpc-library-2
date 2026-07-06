<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Circulation - PGPC Library</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; background-color: #F4F7F6; }
    </style>
</head>
<body class="bg-[#F4F7F6] text-gray-800 h-screen overflow-hidden flex">
    <x-admin.navbar />
    <div class="flex-1 flex flex-col min-w-0 h-screen overflow-hidden bg-[#F4F7F6]">
        <x-admin.header />
        <main class="flex-1 flex flex-col p-6 min-h-0 overflow-y-auto">
            <div class="flex items-center justify-between mb-6 shrink-0">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800" id="pageTitle">Fast Cataloging</h1>
                    <p class="text-sm text-gray-500 mt-1">Processing item...</p>
                </div>
                <a href="/admin/circulation" class="btn bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded-lg font-bold text-sm">Back to Hub</a>
            </div>
            
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden flex flex-col max-w-xl">
                <div class="bg-[#1A2B56] text-white p-4 shrink-0">
                    <h2 class="font-bold">Scan Barcode</h2>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Input Barcode</label>
                            <input type="text" class="block w-full pl-4 pr-3 py-3 border border-gray-200 rounded-lg text-sm focus:ring-1 focus:ring-[#1A2B56] focus:border-[#1A2B56] outline-none shadow-inner" placeholder="Scan here..." autofocus>
                        </div>
                    </div>
                    <button class="w-full bg-[#1A2B56] hover:bg-[#243B73] text-white font-bold py-3.5 rounded-lg mt-6 shadow-sm transition-colors">Process</button>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
