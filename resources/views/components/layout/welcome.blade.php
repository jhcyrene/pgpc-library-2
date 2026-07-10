<!DOCTYPE html>
<html lang="en" data-theme="pgpc">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Padre Garcia Polytechnic College - Library System</title>
    <meta name="description"
        content="Discover your next great read at the Padre Garcia Polytechnic College Library. Explore our collection of Science, Literature, History, Technology, Arts, and Geography.">
    <meta name="robots" content="index, follow">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap"
        rel="stylesheet">
    <link rel="shortcut icon" href="{{ Vite::asset('resources/images/hd-pgpc-logo.png') }}" type="image/x-icon">

    @vite(['resources/css/welcome.css', 'resources/js/app.js'])

    <style>
        body {
            margin: 0;
            overflow: hidden;
        }

        #site-preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background-color: #212E5E;
            /* background-color: #ffffff; */
            /* Tailwind blue-900 to blue-500 */
            z-index: 9999;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-family: 'Open Sans', sans-serif;
            transition: opacity 0.5s ease-in-out;
        }


        .pgpc-preloader-logo {
            width: 250px;
            height: 250px;
            /* Must match the width exactly */
            object-fit: cover;
            /* Ensures the image doesn't stretch or warp */
            border-radius: 50%;
            /* This creates the perfect circle */
            margin-bottom: 30px;
            /* box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2); */
            animation: pgpc-pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        .pgpc-spinner {
            width: 60px;
            height: 60px;
            border: 4px solid rgba(255, 255, 255, 0.2);
            border-top: 4px solid #ffffff;
            border-radius: 50%;
            animation: pgpc-spin 1s linear infinite;
        }

        .pgpc-loader-text {
            margin-top: 25px;
            font-size: 20px;
            font-weight: 600;
            color: #ffffff;
            letter-spacing: 0.5px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        @keyframes pgpc-spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes pgpc-pulse {

            0%,
            100% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.05);
                opacity: 0.9;
            }
        }
    </style>


</head>

<body class="antialiased font-sans bg-base-100 text-base-content min-h-screen flex flex-col">

    <div id="site-preloader">
        <img src="{{ Vite::asset('resources/images/hd-pgpc-logo.png') }}" alt="PGPC Logo" class="pgpc-preloader-logo"
            onerror="this.style.display='none'">
    </div>
    {{-- <script src="{{ Vite::asset('resources/js/loader.js') }}"></script> --}}

    <x-navbar />

    <main class="w-full flex-grow">
        {{ $slot }}
    </main>

    <x-footer />

    <script>
        // 1. Create a promise that finishes when the minimum time (2500ms) is up
        const minimumTimePromise = new Promise((resolve) => {
            setTimeout(resolve, 1000);
        });

        // 2. Create a promise that finishes when the browser says all CSS/images are loaded
        const windowLoadPromise = new Promise((resolve) => {
            window.addEventListener('load', resolve);
        });

        Promise.all([minimumTimePromise, windowLoadPromise]).then(() => {
            const preloader = document.getElementById('site-preloader');
            const mainApp = document.getElementById('main-app-wrapper');
            if (preloader) {
                // Fade out the preloader
                preloader.style.opacity = '0';

                // Instantly reveal the styled content underneath
                if (mainApp) mainApp.style.display = 'block'; 

                setTimeout(() => {
                    preloader.style.display = 'none';
                }, 500);
            }
        });
    </script>


</body>

</html>
