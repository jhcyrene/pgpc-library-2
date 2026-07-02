<!DOCTYPE html>
<html lang="en" data-theme="pgpc">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>OPAC - Padre Garcia Polytechnic College</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">

    @vite(['resources/css/welcome.css', 'resources/js/app.js'])
</head>
<body class="antialiased font-sans bg-base-100 text-base-content min-h-screen flex flex-col">

    <!-- Header -->
    <x-navbar />

    <!-- Hero Section -->
    <section class="relative min-h-[50vh] flex items-center justify-center pt-20 overflow-hidden">
        <!-- Background Image -->
        <div class="absolute inset-0 z-0 bg-cover bg-center bg-fixed" style="background-image: url('{{ Vite::asset('resources/images/pgpc-ng.png') }}')"></div>
        <!-- Gradient Overlay -->
        <div class="absolute inset-0 z-10 bg-gradient-hero"></div>

        <!-- Hero Content -->
        <div class="container mx-auto px-4 md:px-6 relative z-20 flex flex-col items-center text-center mt-5">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4 leading-tight max-w-4xl [text-shadow:_0_4px_8px_var(--color-black)]">
                Online Public Access Catalog
            </h1>
            <p class="text-lg text-white/90 font-medium max-w-2xl mx-auto drop-shadow-md mb-8">
                Search the PGPC Library collection to find books, journals, and other resources.
            </p>

            <!-- Search Bar -->
            <div class="w-full max-w-3xl bg-white p-1 md:p-2 rounded-full shadow-elegant flex items-center mb-8 transform transition-transform hover:scale-[1.01]">
                <div class="w-full md:w-48 shrink-0 border-r border-gray-200 hidden md:block">
                    <select class="w-full h-full py-2 px-4 rounded-l-full border-none focus:ring-0 text-gray-700 bg-transparent outline-none cursor-pointer text-sm font-medium">
                        <option>Everything</option>
                        <option>Books</option>
                        <option>Journals</option>
                    </select>
                </div>
                <div class="pl-3 md:pl-4 pr-1 md:pr-2 text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:h-6 md:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" placeholder="Search by title, author, or ISBN..." class="flex-1 w-full min-w-0 bg-transparent border-none outline-none py-2 md:py-3 px-2 text-gray-700 text-sm md:text-lg placeholder:text-gray-500 focus:ring-0 truncate" />

                <button class="btn bg-primaryfade text-white hover:bg-primary/90 rounded-full px-5 md:px-8 min-h-0 h-10 md:h-12 border-none text-sm md:text-base font-bold shrink-0">
                    Search
                </button>
            </div>
        </div>
    </section>

    <!-- Main Content (Catalog Grid) -->
    <section class="py-12 md:py-16 bg-gray-50 flex-1">
        <div class="container mx-auto px-4 md:px-12">
            <div class="flex flex-col md:flex-row gap-8">
                
                <!-- Left Sidebar Filters -->
                <aside class="w-full md:w-64 shrink-0">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 md:sticky md:top-24">
                        <h3 class="font-bold text-gray-800 text-lg mb-4 border-b border-gray-100 pb-2">Filters</h3>
                        
                        <!-- Filter Group 1: Availability -->
                        <div class="mb-5">
                            <h4 class="font-semibold text-xs text-gray-500 mb-3 uppercase tracking-wider">Availability</h4>
                            <div class="space-y-2">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" class="checkbox checkbox-sm checkbox-primary rounded" checked />
                                    <span class="text-sm text-gray-700 font-medium">Available Now</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" class="checkbox checkbox-sm checkbox-primary rounded" />
                                    <span class="text-sm text-gray-700 font-medium">Include Borrowed</span>
                                </label>
                            </div>
                        </div>

                        <!-- Filter Group 2: Item Type -->
                        <div class="mb-5 border-t border-gray-100 pt-5">
                            <h4 class="font-semibold text-xs text-gray-500 mb-3 uppercase tracking-wider">Format</h4>
                            <div class="space-y-2">
                                <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" class="checkbox checkbox-sm checkbox-primary rounded" checked/><span class="text-sm text-gray-700 font-medium">Books</span></label>
                                <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" class="checkbox checkbox-sm checkbox-primary rounded" /><span class="text-sm text-gray-700 font-medium">E-Books</span></label>
                                <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" class="checkbox checkbox-sm checkbox-primary rounded" /><span class="text-sm text-gray-700 font-medium">Journals / Serials</span></label>
                                <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" class="checkbox checkbox-sm checkbox-primary rounded" /><span class="text-sm text-gray-700 font-medium">Audio Visual</span></label>
                            </div>
                        </div>

                        <!-- Filter Group 3: Categories -->
                        <div class="mb-5 border-t border-gray-100 pt-5">
                            <h4 class="font-semibold text-xs text-gray-500 mb-3 uppercase tracking-wider">Subject / Category</h4>
                            <div class="space-y-2">
                                <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" class="checkbox checkbox-sm checkbox-primary rounded" /><span class="text-sm text-gray-700 font-medium">Computer Science</span></label>
                                <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" class="checkbox checkbox-sm checkbox-primary rounded" /><span class="text-sm text-gray-700 font-medium">Nursing & Medicine</span></label>
                                <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" class="checkbox checkbox-sm checkbox-primary rounded" /><span class="text-sm text-gray-700 font-medium">Business & Management</span></label>
                                <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" class="checkbox checkbox-sm checkbox-primary rounded" /><span class="text-sm text-gray-700 font-medium">Education</span></label>
                                <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" class="checkbox checkbox-sm checkbox-primary rounded" /><span class="text-sm text-gray-700 font-medium">History</span></label>
                            </div>
                        </div>
                        
                        <!-- Filter Group 4: Language -->
                        <div class="mb-5 border-t border-gray-100 pt-5">
                            <h4 class="font-semibold text-xs text-gray-500 mb-3 uppercase tracking-wider">Language</h4>
                            <div class="space-y-2">
                                <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" class="checkbox checkbox-sm checkbox-primary rounded" checked/><span class="text-sm text-gray-700 font-medium">English</span></label>
                                <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" class="checkbox checkbox-sm checkbox-primary rounded" /><span class="text-sm text-gray-700 font-medium">Tagalog</span></label>
                            </div>
                        </div>
                        
                        <!-- Filter Group 5: Publication Year -->
                        <div class="mb-5 border-t border-gray-100 pt-5">
                            <h4 class="font-semibold text-xs text-gray-500 mb-3 uppercase tracking-wider">Publication Year</h4>
                            <div class="space-y-2">
                                <label class="flex items-center gap-2 cursor-pointer"><input type="radio" name="year" class="radio radio-sm radio-primary" /><span class="text-sm text-gray-700 font-medium">Last 5 Years</span></label>
                                <label class="flex items-center gap-2 cursor-pointer"><input type="radio" name="year" class="radio radio-sm radio-primary" /><span class="text-sm text-gray-700 font-medium">Last 10 Years</span></label>
                                <label class="flex items-center gap-2 cursor-pointer"><input type="radio" name="year" class="radio radio-sm radio-primary" checked/><span class="text-sm text-gray-700 font-medium">Any Year</span></label>
                            </div>
                        </div>

                        <button class="btn bg-primaryfade text-white hover:bg-primary/90 w-full btn-sm mt-2 border-none">Apply Filters</button>
                    </div>
                </aside>

                <!-- Right Side List -->
                <div class="flex-1 min-w-0">
                    <!-- Title and Sort -->
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
                        <h2 class="text-2xl md:text-3xl font-bold text-primaryfade">Search Results</h2>
                        <div class="flex gap-2 w-full sm:w-auto">
                            <select class="select select-sm select-bordered w-full sm:w-auto font-medium text-gray-600">
                                <option>Sort: Newest</option>
                                <option>Sort: Oldest</option>
                                <option>Sort: A-Z</option>
                                <option>Sort: Z-A</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex flex-col gap-4">
                <!-- Book Item 1 -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 md:p-6 hover:shadow-md transition-all duration-300 flex flex-col sm:flex-row gap-6">
                    <!-- Book Cover -->
                    <div class="w-24 sm:w-32 shrink-0 mx-auto sm:mx-0 flex flex-col gap-3">
                        <div class="aspect-[2/3] bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg relative overflow-hidden flex items-center justify-center shadow-sm border border-blue-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-blue-300 opacity-75" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                        </div>
                    </div>
                    
                    <!-- Book Details -->
                    <div class="flex-1 flex flex-col min-w-0">
                        <div class="flex flex-col md:flex-row justify-between items-start gap-4 mb-3">
                            <div>
                                <span class="inline-flex items-center gap-1.5 text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                                    Printed Book &bull; Computer Science
                                </span>
                                <a href="#" class="block font-bold text-gray-800 text-xl md:text-2xl leading-tight mb-2 hover:text-primaryfade transition-colors">The Pragmatic Programmer: Your Journey to Mastery</a>
                                <p class="text-sm text-gray-600 font-medium">By: <a href="#" class="text-primaryfade hover:underline">David Thomas</a>, <a href="#" class="text-primaryfade hover:underline">Andrew Hunt</a></p>
                            </div>
                            <div class="shrink-0 flex items-center justify-start w-full md:w-auto">
                                <span class="badge badge-success badge-sm border-none text-white font-bold px-3 py-3 rounded-md shadow-sm w-auto">AVAILABLE</span>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-x-6 gap-y-3 mt-2 text-sm text-gray-600 mb-6 bg-gray-50 p-4 rounded-xl border border-gray-100">
                            <div class="flex flex-col gap-0.5">
                                <span class="text-xs text-gray-400 font-bold uppercase tracking-wider">Publisher</span>
                                <span class="truncate font-medium text-gray-700">Addison-Wesley, 2019</span>
                            </div>
                            <div class="flex flex-col gap-0.5">
                                <span class="text-xs text-gray-400 font-bold uppercase tracking-wider">ISBN</span>
                                <span class="font-medium text-gray-700">978-0135957059</span>
                            </div>
                            <div class="flex flex-col gap-0.5">
                                <span class="text-xs text-gray-400 font-bold uppercase tracking-wider">Call Number</span>
                                <span class="font-mono bg-gray-200 text-gray-800 px-1.5 py-0.5 rounded text-xs font-bold w-fit">QA76.6 .T48 2019</span>
                            </div>
                            <div class="flex flex-col gap-0.5">
                                <span class="text-xs text-gray-400 font-bold uppercase tracking-wider">Location</span>
                                <span class="font-medium text-gray-700">Main Collection</span>
                            </div>
                        </div>
                        
                        <!-- Actions -->
                        <div class="mt-auto pt-4 border-t border-gray-100 flex flex-wrap items-center justify-between gap-4">
                            <div class="text-sm text-gray-500 font-medium">
                                <span class="text-green-600 font-bold">2</span> of 3 copies available
                            </div>
                            <div class="flex gap-2">
                                <button class="btn btn-sm bg-gray-100 text-gray-700 hover:bg-gray-200 border-none px-4 gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
                                    Save
                                </button>
                                <button class="btn btn-sm bg-primaryfade text-white hover:bg-primary border-none px-6 gap-2 shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                    Place Hold
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Book Item 2 -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 md:p-6 hover:shadow-md transition-all duration-300 flex flex-col sm:flex-row gap-6">
                    <!-- Book Cover -->
                    <div class="w-24 sm:w-32 shrink-0 mx-auto sm:mx-0 flex flex-col gap-3">
                        <div class="aspect-[2/3] bg-gradient-to-br from-red-50 to-red-100 rounded-lg relative overflow-hidden flex items-center justify-center shadow-sm border border-red-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-red-300 opacity-75" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                        </div>
                    </div>
                    
                    <!-- Book Details -->
                    <div class="flex-1 flex flex-col min-w-0">
                        <div class="flex flex-col md:flex-row justify-between items-start gap-4 mb-3">
                            <div>
                                <span class="inline-flex items-center gap-1.5 text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                                    Printed Book &bull; Nursing & Medicine
                                </span>
                                <a href="#" class="block font-bold text-gray-800 text-xl md:text-2xl leading-tight mb-2 hover:text-primaryfade transition-colors">Medical-Surgical Nursing: Assessment and Management</a>
                                <p class="text-sm text-gray-600 font-medium">By: <a href="#" class="text-primaryfade hover:underline">Sharon L. Lewis</a>, <a href="#" class="text-primaryfade hover:underline">Shannon Ruff Dirksen</a></p>
                            </div>
                            <div class="shrink-0 flex items-center justify-start w-full md:w-auto">
                                <span class="badge badge-warning badge-sm border-none text-white font-bold px-3 py-3 rounded-md shadow-sm w-auto">BORROWED</span>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-x-6 gap-y-3 mt-2 text-sm text-gray-600 mb-6 bg-gray-50 p-4 rounded-xl border border-gray-100">
                            <div class="flex flex-col gap-0.5">
                                <span class="text-xs text-gray-400 font-bold uppercase tracking-wider">Publisher</span>
                                <span class="truncate font-medium text-gray-700">Mosby, 2017</span>
                            </div>
                            <div class="flex flex-col gap-0.5">
                                <span class="text-xs text-gray-400 font-bold uppercase tracking-wider">ISBN</span>
                                <span class="font-medium text-gray-700">978-0323328524</span>
                            </div>
                            <div class="flex flex-col gap-0.5">
                                <span class="text-xs text-gray-400 font-bold uppercase tracking-wider">Call Number</span>
                                <span class="font-mono bg-gray-200 text-gray-800 px-1.5 py-0.5 rounded text-xs font-bold w-fit">RT41 .M43 2017</span>
                            </div>
                            <div class="flex flex-col gap-0.5">
                                <span class="text-xs text-gray-400 font-bold uppercase tracking-wider">Location</span>
                                <span class="font-medium text-gray-700">Nursing Branch</span>
                            </div>
                        </div>
                        
                        <!-- Actions -->
                        <div class="mt-auto pt-4 border-t border-gray-100 flex flex-wrap items-center justify-between gap-4">
                            <div class="text-sm text-gray-500 font-medium">
                                <span class="text-red-500 font-bold">0</span> of 2 copies available (Due back in 3 days)
                            </div>
                            <div class="flex gap-2">
                                <button class="btn btn-sm bg-gray-100 text-gray-700 hover:bg-gray-200 border-none px-4 gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
                                    Save
                                </button>
                                <button class="btn btn-sm bg-primaryfade text-white hover:bg-primary border-none px-6 gap-2 shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                    Place Hold
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-12 flex justify-center">
                <div class="join">
                    <button class="join-item btn btn-outline border-gray-300">«</button>
                    <button class="join-item btn btn-active bg-primaryfade border-primaryfade text-white hover:bg-primary">1</button>
                    <button class="join-item btn btn-outline border-gray-300">2</button>
                    <button class="join-item btn btn-outline border-gray-300">3</button>
                    <button class="join-item btn btn-outline border-gray-300">»</button>
                </div>
            </div>
            
            </div> <!-- End Right Side List -->
            </div> <!-- End Flex Layout -->
        </div>
    </section>

    <!-- Footer -->
    <x-footer />

</body>
</html>
