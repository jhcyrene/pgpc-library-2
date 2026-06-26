<!DOCTYPE html>
<html lang="en" data-theme="pgpc">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Padre Garcia Polytechnic College - Library System</title>
    <meta name="description" content="Discover your next great read at the Padre Garcia Polytechnic College Library. Explore our collection of Science, Literature, History, Technology, Arts, and Geography.">
    <meta name="robots" content="index, follow">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])


</head>
<body class="antialiased font-sans bg-base-100 text-base-content min-h-screen flex flex-col">

    <!-- Header -->
    <x-navbar />


    <!-- Hero Section -->
    <section class="relative min-h-screen flex items-center justify-center pt-20 overflow-hidden">
        <!-- Background Image -->
        <div class="absolute inset-0 z-0 bg-cover bg-center bg-fixed" style="background-image: url('{{ Vite::asset('resources/images/library-hero.jpg') }}')"></div>

        <!-- Gradient Overlay -->
        <div class="absolute inset-0 z-10 bg-gradient-hero"></div>

        <!-- Hero Content -->
        <div class="container mx-auto px-6 relative z-20 flex flex-col items-center text-center mt-12">

            <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold text-white mb-6 leading-tight max-w-4xl tracking-tight">
                Discover your next great read
            </h1>

            <p class="text-lg md:text-xl text-blue-100 mb-10 max-w-2xl font-light">
                Access thousands of academic resources, journals, and literature to empower your educational journey at Padre Garcia Polytechnic College.
            </p>

            <!-- Search Bar -->
            <div class="w-full max-w-3xl bg-white p-2 rounded-full shadow-elegant flex items-center mb-8 transform transition-transform hover:scale-[1.01]">
                <div class="pl-4 pr-2 text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" placeholder="Search by title, author, or ISBN..." class="flex-1 bg-transparent border-none outline-none py-3 px-2 text-gray-700 text-lg placeholder:text-gray-400 focus:ring-0" />

                <button class="btn bg-primary text-white hover:bg-primary/90 rounded-full px-8 min-h-0 h-12 border-none text-base">
                    Search
                </button>
            </div>

            <!-- Popular Chips -->
            <div class="flex flex-wrap items-center justify-center gap-3 text-sm">
                <span class="text-blue-200 font-medium">Popular:</span>
                <button class="badge badge-outline border-white/20 text-white hover:bg-primary hover:text-white hover:border-primary transition-colors py-3 px-4">Software Engineering</button>
                <button class="badge badge-outline border-white/20 text-white hover:bg-primary hover:text-white hover:border-primary transition-colors py-3 px-4">Philippine History</button>
                <button class="badge badge-outline border-white/20 text-white hover:bg-primary hover:text-white hover:border-primary transition-colors py-3 px-4">Calculus</button>
                <button class="badge badge-outline border-white/20 text-white hover:bg-primary hover:text-white hover:border-primary transition-colors py-3 px-4">Anatomy</button>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section id="categories" class="py-24 bg-gray-50">
        <div class="container mx-auto px-6 md:px-12">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-primaryfade mb-4">Explore by Category</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Browse our extensive collection categorized by fields of study to quickly find the resources you need.</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
                <!-- Science -->
                <a href="#" class="group bg-white p-6 rounded-2xl shadow-sm hover:shadow-elegant border border-gray-100 flex flex-col items-center text-center transition-all duration-300 hover:-translate-y-2 hover:border-primaryfade/30">
                    <div class="group-hover:scale-110 transition-transform duration-300 mb-4 text-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="color:bg-primary"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
                    </div>
                    <h3 class="font-bold text-gray-800 mb-1">Science</h3>
                    <p class="text-sm text-gray-500">2,400+ books</p>
                </a>
                <!-- Literature -->
                <a href="#" class="group bg-white p-6 rounded-2xl shadow-sm hover:shadow-elegant border border-gray-100 flex flex-col items-center text-center transition-all duration-300 hover:-translate-y-2 hover:border-accent/30">
                    <div class="group-hover:scale-110 transition-transform duration-300 mb-4 text-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                    </div>
                    <h3 class="font-bold text-gray-800 mb-1">Literature</h3>
                    <p class="text-sm text-gray-500">5,100+ books</p>
                </a>
                <!-- History -->
                <a href="#" class="group bg-white p-6 rounded-2xl shadow-sm hover:shadow-elegant border border-gray-100 flex flex-col items-center text-center transition-all duration-300 hover:-translate-y-2 hover:border-accent/30">
                    <div class="group-hover:scale-110 transition-transform duration-300 mb-4 text-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <h3 class="font-bold text-gray-800 mb-1">History</h3>
                    <p class="text-sm text-gray-500">1,800+ books</p>
                </a>
                <!-- Technology -->
                <a href="#" class="group bg-white p-6 rounded-2xl shadow-sm hover:shadow-elegant border border-gray-100 flex flex-col items-center text-center transition-all duration-300 hover:-translate-y-2 hover:border-accent/30">
                    <div class="group-hover:scale-110 transition-transform duration-300 mb-4 text-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                    </div>
                    <h3 class="font-bold text-gray-800 mb-1">Technology</h3>
                    <p class="text-sm text-gray-500">3,200+ books</p>
                </a>
                <!-- Arts -->
                <a href="#" class="group bg-white p-6 rounded-2xl shadow-sm hover:shadow-elegant border border-gray-100 flex flex-col items-center text-center transition-all duration-300 hover:-translate-y-2 hover:border-accent/30">
                    <div class="group-hover:scale-110 transition-transform duration-300 mb-4 text-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" /></svg>
                    </div>
                    <h3 class="font-bold text-gray-800 mb-1">Arts</h3>
                    <p class="text-sm text-gray-500">1,200+ books</p>
                </a>
                <!-- Geography -->
                <a href="#" class="group bg-white p-6 rounded-2xl shadow-sm hover:shadow-elegant border border-gray-100 flex flex-col items-center text-center transition-all duration-300 hover:-translate-y-2 hover:border-accent/30">
                    <div class="group-hover:scale-110 transition-transform duration-300 mb-4 text-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <h3 class="font-bold text-gray-800 mb-1">Geography</h3>
                    <p class="text-sm text-gray-500">900+ books</p>
                </a>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-24 bg-primary text-white relative overflow-hidden">
        <!-- Subtle background decoration -->
        <div class="absolute top-0 right-0 w-96 h-96 rounded-full blur-3xl -mr-48 -mt-48 bg-accent/10"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 rounded-full blur-3xl -ml-48 -mb-48 bg-white/5"></div>

        <div class="container mx-auto px-6 md:px-12 relative z-10">
            <div class="flex flex-col lg:flex-row items-center gap-16">

                <!-- Copy -->
                <div class="lg:w-1/2">
                    <h2 class="text-3xl md:text-4xl font-bold mb-6">About the Library</h2>
                    <p class="text-blue-100 mb-6 text-lg leading-relaxed font-light">
                        The Padre Garcia Polytechnic College Library is the heart of academic research and learning on campus. We provide students and faculty with comprehensive resources, quiet study spaces, and access to both digital and physical literature.
                    </p>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-center gap-3 text-blue-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-accent shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            <span>Extensive collection of academic journals</span>
                        </li>
                        <li class="flex items-center gap-3 text-blue-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-accent shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            <span>Quiet zones for focused study</span>
                        </li>
                        <li class="flex items-center gap-3 text-blue-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-accent shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            <span>Access to digital databases</span>
                        </li>
                    </ul>
                    <button class="flex items-center gap-2 text-accent font-semibold hover:text-white transition-colors group bg-transparent border-none p-0 cursor-pointer">
                        Learn more about our facilities
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                    </button>
                </div>

                <!-- Stat Cards -->
                <div class="lg:w-1/2 w-full grid gap-6">
                    <div class="bg-white/10 backdrop-blur-md border border-white/10 p-8 rounded-2xl flex items-center gap-6 transform transition-transform hover:-translate-y-1 hover:bg-white/15">
                        <div class="w-16 h-16 rounded-full flex items-center justify-center shrink-0 bg-accent/20">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                        </div>
                        <div>
                            <div class="text-3xl font-bold text-white mb-1">25,000+</div>
                            <div class="text-blue-200 font-medium">Physical Titles</div>
                        </div>
                    </div>

                    <div class="bg-white/10 backdrop-blur-md border border-white/10 p-8 rounded-2xl flex items-center gap-6 transform transition-transform hover:-translate-y-1 hover:bg-white/15 ml-0 lg:ml-8">
                        <div class="w-16 h-16 rounded-full flex items-center justify-center shrink-0 bg-accent/20">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                        </div>
                        <div>
                            <div class="text-3xl font-bold text-white mb-1">5,000+</div>
                            <div class="text-blue-200 font-medium">Active Members</div>
                        </div>
                    </div>

                    <div class="bg-white/10 backdrop-blur-md border border-white/10 p-8 rounded-2xl flex items-center gap-6 transform transition-transform hover:-translate-y-1 hover:bg-white/15">
                        <div class="w-16 h-16 rounded-full flex items-center justify-center shrink-0 bg-accent/20">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <div>
                            <div class="text-3xl font-bold text-white mb-1">Mon - Sat</div>
                            <div class="text-blue-200 font-medium">7:00 AM to 6:00 PM</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact" class="bg-gray-900 text-gray-300 py-16">
        <div class="container mx-auto px-6 md:px-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">

                <!-- Brand Column -->
                <div>
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center overflow-hidden">
                            <img src="/images/logo.jfif" alt="PGPC Logo" class="w-full h-full object-cover" onerror="this.src='https://ui-avatars.com/api/?name=PG&background=fcc719&color=212e5e'" />
                        </div>
                        <span class="font-bold text-xl text-white">PGPC Library</span>
                    </div>
                    <p class="text-sm text-gray-400 leading-relaxed mb-6">
                        Empowering students with knowledge, fostering a culture of research, and supporting academic excellence.
                    </p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-white font-bold mb-6 text-lg">Quick Links</h4>
                    <ul class="space-y-3 text-sm">
                        <li><a href="#" class="hover:text-accent transition-colors">Home</a></li>
                        <li><a href="#about" class="hover:text-accent transition-colors">About Us</a></li>
                        <li><a href="#" class="hover:text-accent transition-colors">OPAC Search</a></li>
                        <li><a href="#" class="hover:text-accent transition-colors">New Arrivals</a></li>
                        <li><a href="#" class="hover:text-accent transition-colors">Rules & Regulations</a></li>
                    </ul>
                </div>

                <!-- Categories -->
                <div>
                    <h4 class="text-white font-bold mb-6 text-lg">Top Categories</h4>
                    <ul class="space-y-3 text-sm">
                        <li><a href="#" class="hover:text-accent transition-colors">Computer Science</a></li>
                        <li><a href="#" class="hover:text-accent transition-colors">Engineering</a></li>
                        <li><a href="#" class="hover:text-accent transition-colors">Education</a></li>
                        <li><a href="#" class="hover:text-accent transition-colors">Business & Accountancy</a></li>
                        <li><a href="#" class="hover:text-accent transition-colors">General References</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h4 class="text-white font-bold mb-6 text-lg">Contact Us</h4>
                    <ul class="space-y-4 text-sm">
                        <li class="flex items-start gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-accent shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            <span>Padre Garcia, Batangas, Philippines</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-accent shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                            <span>(043) 123-4567</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-accent shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                            <span>library@pgpc.edu.ph</span>
                        </li>
                    </ul>
                </div>

            </div>

            <div class="border-t border-gray-800 mt-16 pt-8 text-center text-sm text-gray-500">
                <p>&copy; 2026 Padre Garcia Polytechnic College Library. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Interactive Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const header = document.getElementById('main-header');
            const mobileMenuBtn = document.getElementById('mobile-menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');

            // Scroll effect
            window.addEventListener('scroll', () => {
                if (window.scrollY > 20) {
                    header.classList.add('scrolled');
                } else {
                    header.classList.remove('scrolled');
                }
            });

            // Mobile menu toggle
            mobileMenuBtn.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
                mobileMenu.classList.toggle('flex');
            });
        });
    </script>
</body>
</html>
