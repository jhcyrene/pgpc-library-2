<!DOCTYPE html>
<html lang="en" data-theme="pgpc">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Terms of Service - Padre Garcia Polytechnic College Library</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    
    @vite(['resources/css/welcome.css', 'resources/js/app.js'])
</head>
<body class="antialiased font-sans bg-gray-50 text-base-content min-h-screen flex flex-col">

    <!-- Header -->
    <x-navbar />

    <!-- Page Header -->
    <section class="relative pt-40 pb-20 overflow-hidden bg-primaryfade">
        <div class="absolute inset-0 z-0 bg-cover bg-center bg-fixed" style="background-image: url('{{ Vite::asset('resources/images/pgpc-ng.png') }}')"></div>
        <div class="absolute inset-0 z-10 bg-gradient-hero"></div>
        <div class="container mx-auto px-6 relative z-20 text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Terms of Service</h1>
            <p class="text-blue-100 text-lg">Last updated: June 2026</p>
        </div>
    </section>

    <!-- Content -->
    <section class="py-16 flex-grow">
        <div class="container mx-auto px-6 md:px-12 max-w-4xl bg-white rounded-3xl shadow-sm border border-gray-100 p-8 md:p-12">
            
            <!-- Back Button -->
            <div class="mb-8 pb-6 border-b border-gray-100">
                <a href="javascript:history.back()" class="inline-flex items-center gap-2 text-gray-500 hover:text-primary transition-colors font-medium group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Go Back
                </a>
            </div>

            <div class="space-y-8 text-gray-700 leading-relaxed">
                <section>
                    <h2 class="text-2xl font-bold text-gray-900 mb-4 pb-2 border-b border-gray-100">1. Acceptance of Terms</h2>
                    <p>By accessing and using the Padre Garcia Polytechnic College (PGPC) Library System, you accept and agree to be bound by the terms and provisions of this agreement. In addition, when using this system's particular services, you shall be subject to any posted guidelines or rules applicable to such services.</p>
                </section>

                <section>
                    <h2 class="text-2xl font-bold text-gray-900 mb-4 pb-2 border-b border-gray-100">2. Provision of Services</h2>
                    <p>PGPC Library reserves the right to modify, suspend, or discontinue the system with or without notice at any time and without any liability to you. The system is provided on an "as is" and "as available" basis.</p>
                </section>

                <section>
                    <h2 class="text-2xl font-bold text-gray-900 mb-4 pb-2 border-b border-gray-100">3. User Conduct</h2>
                    <p class="mb-4">As a user of the library system, you agree to the following:</p>
                    <ul class="list-disc pl-6 space-y-2">
                        <li>You will not use the system for any illegal purposes.</li>
                        <li>You will not use the system to distribute malicious software or spam.</li>
                        <li>You are responsible for maintaining the confidentiality of your account credentials.</li>
                        <li>You will report any unauthorized use of your account immediately to the library administration.</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-2xl font-bold text-gray-900 mb-4 pb-2 border-b border-gray-100">4. Borrowing and Returns</h2>
                    <p>Physical books reserved through the system must be picked up within 48 hours. Users are responsible for the physical condition of borrowed materials and will be subject to fines for late returns, damages, or lost items in accordance with the official PGPC Library Handbook.</p>
                </section>

                <section>
                    <h2 class="text-2xl font-bold text-gray-900 mb-4 pb-2 border-b border-gray-100">5. Termination</h2>
                    <p>PGPC Library reserves the right to terminate your access to the system for violations of any of the terms outlined in this agreement, or for any conduct that the administration believes is harmful to other users, to the library, or to the college.</p>
                </section>
            </div>
            
        </div>
    </section>

    <x-footer />

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
                mobileMenu.classList.toggle('opacity-0');
                mobileMenu.classList.toggle('scale-y-0');
                mobileMenu.classList.toggle('pointer-events-none');
                mobileMenu.classList.toggle('opacity-100');
                mobileMenu.classList.toggle('scale-y-100');
                mobileMenu.classList.toggle('pointer-events-auto');
            });
        });
    </script>
</body>
</html>
