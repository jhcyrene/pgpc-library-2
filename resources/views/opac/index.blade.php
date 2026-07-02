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
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-8">
                <h2 class="text-2xl md:text-3xl font-bold text-primaryfade">Search Results</h2>
                <div class="flex gap-2 w-full sm:w-auto">
                    <button class="btn btn-sm btn-outline border-gray-300 text-gray-600 hover:bg-gray-100 hover:text-gray-800">Filter</button>
                    <button class="btn btn-sm btn-outline border-gray-300 text-gray-600 hover:bg-gray-100 hover:text-gray-800">Sort: Newest</button>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 md:gap-6">
                <!-- Book Item 1 -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-elegant transition-all duration-300 hover:-translate-y-2 flex flex-row sm:flex-col">
                    <div class="w-32 sm:w-auto shrink-0 aspect-[2/3] bg-gray-200 relative overflow-hidden flex items-center justify-center">
                        <div class="absolute inset-0 bg-blue-100 flex items-center justify-center text-blue-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                        </div>
                        <span class="absolute top-2 right-2 badge badge-success badge-sm border-none text-white font-bold shadow-sm">AVAILABLE</span>
                    </div>
                    <div class="p-4 flex flex-col flex-1">
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Computer Science</span>
                        <h3 class="font-bold text-gray-800 text-sm md:text-base leading-tight mb-1 line-clamp-2">The Pragmatic Programmer</h3>
                        <p class="text-xs text-gray-500 mb-3 line-clamp-1">David Thomas, Andrew Hunt</p>
                        <div class="mt-auto pt-3 border-t border-gray-50">
                            <button class="btn btn-sm btn-outline border-primaryfade text-primaryfade hover:bg-primaryfade hover:text-white hover:border-primaryfade w-full transition-colors">
                                View Details
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Book Item 2 -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-elegant transition-all duration-300 hover:-translate-y-2 flex flex-row sm:flex-col">
                    <div class="w-32 sm:w-auto shrink-0 aspect-[2/3] bg-gray-200 relative overflow-hidden flex items-center justify-center">
                        <div class="absolute inset-0 bg-red-100 flex items-center justify-center text-red-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                        </div>
                        <span class="absolute top-2 right-2 badge badge-warning badge-sm border-none text-white font-bold shadow-sm">BORROWED</span>
                    </div>
                    <div class="p-4 flex flex-col flex-1">
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Nursing</span>
                        <h3 class="font-bold text-gray-800 text-sm md:text-base leading-tight mb-1 line-clamp-2">Medical-Surgical Nursing</h3>
                        <p class="text-xs text-gray-500 mb-3 line-clamp-1">Sharon L. Lewis</p>
                        <div class="mt-auto pt-3 border-t border-gray-50">
                            <button class="btn btn-sm btn-outline border-primaryfade text-primaryfade hover:bg-primaryfade hover:text-white hover:border-primaryfade w-full transition-colors">
                                View Details
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Book Item 3 -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-elegant transition-all duration-300 hover:-translate-y-2 flex flex-row sm:flex-col">
                    <div class="w-32 sm:w-auto shrink-0 aspect-[2/3] bg-gray-200 relative overflow-hidden flex items-center justify-center">
                        <div class="absolute inset-0 bg-amber-100 flex items-center justify-center text-amber-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                        </div>
                        <span class="absolute top-2 right-2 badge badge-success badge-sm border-none text-white font-bold shadow-sm">AVAILABLE</span>
                    </div>
                    <div class="p-4 flex flex-col flex-1">
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Business</span>
                        <h3 class="font-bold text-gray-800 text-sm md:text-base leading-tight mb-1 line-clamp-2">Principles of Marketing</h3>
                        <p class="text-xs text-gray-500 mb-3 line-clamp-1">Philip Kotler</p>
                        <div class="mt-auto pt-3 border-t border-gray-50">
                            <button class="btn btn-sm btn-outline border-primaryfade text-primaryfade hover:bg-primaryfade hover:text-white hover:border-primaryfade w-full transition-colors">
                                View Details
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Book Item 4 -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-elegant transition-all duration-300 hover:-translate-y-2 flex flex-row sm:flex-col">
                    <div class="w-32 sm:w-auto shrink-0 aspect-[2/3] bg-gray-200 relative overflow-hidden flex items-center justify-center">
                        <div class="absolute inset-0 bg-purple-100 flex items-center justify-center text-purple-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                        </div>
                        <span class="absolute top-2 right-2 badge badge-success badge-sm border-none text-white font-bold shadow-sm">AVAILABLE</span>
                    </div>
                    <div class="p-4 flex flex-col flex-1">
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Education</span>
                        <h3 class="font-bold text-gray-800 text-sm md:text-base leading-tight mb-1 line-clamp-2">Educational Psychology</h3>
                        <p class="text-xs text-gray-500 mb-3 line-clamp-1">Anita Woolfolk</p>
                        <div class="mt-auto pt-3 border-t border-gray-50">
                            <button class="btn btn-sm btn-outline border-primaryfade text-primaryfade hover:bg-primaryfade hover:text-white hover:border-primaryfade w-full transition-colors">
                                View Details
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Book Item 5 -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-elegant transition-all duration-300 hover:-translate-y-2 flex flex-row sm:flex-col">
                    <div class="w-32 sm:w-auto shrink-0 aspect-[2/3] bg-gray-200 relative overflow-hidden flex items-center justify-center">
                        <div class="absolute inset-0 bg-pink-100 flex items-center justify-center text-pink-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                        </div>
                        <span class="absolute top-2 right-2 badge badge-success badge-sm border-none text-white font-bold shadow-sm">AVAILABLE</span>
                    </div>
                    <div class="p-4 flex flex-col flex-1">
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Science</span>
                        <h3 class="font-bold text-gray-800 text-sm md:text-base leading-tight mb-1 line-clamp-2">Biology</h3>
                        <p class="text-xs text-gray-500 mb-3 line-clamp-1">Neil A. Campbell</p>
                        <div class="mt-auto pt-3 border-t border-gray-50">
                            <button class="btn btn-sm btn-outline border-primaryfade text-primaryfade hover:bg-primaryfade hover:text-white hover:border-primaryfade w-full transition-colors">
                                View Details
                            </button>
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
        </div>
    </section>

    <!-- Footer -->
    <x-footer />

</body>
</html>
