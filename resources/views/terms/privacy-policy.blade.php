<!DOCTYPE html>
<html lang="en" data-theme="pgpc">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Privacy Policy - Padre Garcia Polytechnic College Library</title>
    
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
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Privacy Policy</h1>
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
                    <h2 class="text-2xl font-bold text-gray-900 mb-4 pb-2 border-b border-gray-100">1. Information Collection</h2>
                    <p>When you use the PGPC Library System, we collect information you provide directly to us, such as when you create an account, update your profile, or communicate with us. This may include your name, student/faculty ID, email address, and borrowing history.</p>
                </section>

                <section>
                    <h2 class="text-2xl font-bold text-gray-900 mb-4 pb-2 border-b border-gray-100">2. Use of Information</h2>
                    <p class="mb-4">We use the information we collect to:</p>
                    <ul class="list-disc pl-6 space-y-2">
                        <li>Provide, maintain, and improve the library services.</li>
                        <li>Process and track book reservations and borrowing.</li>
                        <li>Send you technical notices, updates, and security alerts.</li>
                        <li>Respond to your comments, questions, and customer service requests.</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-2xl font-bold text-gray-900 mb-4 pb-2 border-b border-gray-100">3. Information Sharing</h2>
                    <p>We do not share your personal information with outside parties except to the extent necessary to operate the system (e.g., cloud hosting providers) or when required by law or by the academic administration of Padre Garcia Polytechnic College.</p>
                </section>

                <section>
                    <h2 class="text-2xl font-bold text-gray-900 mb-4 pb-2 border-b border-gray-100">4. Data Security</h2>
                    <p>We implement reasonable security measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction. However, no internet transmission is completely secure, and we cannot guarantee absolute security.</p>
                </section>

                <section>
                    <h2 class="text-2xl font-bold text-gray-900 mb-4 pb-2 border-b border-gray-100">5. Contact Us</h2>
                    <p>If you have any questions or concerns about this Privacy Policy or how your data is handled, please contact the PGPC Library Administration office or the IT Support Desk.</p>
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
