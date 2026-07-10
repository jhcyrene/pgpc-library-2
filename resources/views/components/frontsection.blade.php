<!-- Hero Section -->
<section class="relative min-h-screen flex items-center justify-center pt-20 overflow-hidden">
    <!-- Background Image -->
    <div class="absolute inset-0 z-0 bg-cover bg-center bg-fixed"
        style="background-image: url('{{ Vite::asset('resources/images/pgpc-ng.png') }}')"></div>
    <!-- Gradient Overlay -->
    <div class="absolute inset-0 z-10 bg-gradient-hero"></div>

    <!-- Hero Content -->
    <div class="container mx-auto px-6 relative z-20 flex flex-col items-center text-center mt-5">

        <h1
            class="text-4xl md:text-6xl lg:text-7xl font-bold text-white mb-6 leading-tight max-w-4x [text-shadow:_0_4px_8px_var(--color-black)]">
            Welcome to the PGPC Library
        </h1>

        <p class="text-lg text-white/90 font-medium max-w-2xl mx-auto drop-shadow-md mb-12">
            Access thousands of academic resources, journals, and literature to empower your educational journey at
            Padre Garcia Polytechnic College.
        </p>

        <!-- Search Bar -->
        <form action="/opac" method="GET"
            class="w-full max-w-3xl bg-white p-1 md:p-2 rounded-full shadow-elegant flex items-center mb-8 transform transition-transform hover:scale-[1.01]">
            <div class="pl-3 md:pl-4 pr-1 md:pr-2 text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:h-6 md:w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input type="text" name="q" placeholder="Search by title, author, or ISBN..."
                class="flex-1 w-full bg-transparent border-none outline-none py-2 md:py-3 px-2 text-gray-700 text-sm md:text-lg placeholder:text-gray-500 focus:ring-0 truncate" />

            <button type="submit"
                class="btn bg-primaryfade text-white hover:bg-primary/90 rounded-full px-5 md:px-8 min-h-0 h-10 md:h-12 border-none text-sm md:text-base font-bold shrink-0">
                Search
            </button>
        </form>

        <!-- Popular -->
        <div class="flex flex-wrap items-center justify-center gap-3 text-sm">
            <span class="text-blue-200 font-medium">Popular:</span>
            <button
                class="badge badge-outline border-white/20 text-white hover:bg-primary hover:text-white hover:border-primary transition-colors py-3 px-4">
                Software Engineering</button>
            <button
                class="badge badge-outline border-white/20 text-white hover:bg-primary hover:text-white hover:border-primary transition-colors py-3 px-4">
                Philippine History</button>
            <button
                class="badge badge-outline border-white/20 text-white hover:bg-primary hover:text-white hover:border-primary transition-colors py-3 px-4">
                Calculus</button>
            <button
                class="badge badge-outline border-white/20 text-white hover:bg-primary hover:text-white hover:border-primary transition-colors py-3 px-4">
                Anatomy</button>
        </div>
    </div>
</section>
