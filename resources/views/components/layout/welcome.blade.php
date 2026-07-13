@props([
    'title' => 'PGPC Library System | Padre Garcia Polytechnic College',
    'active' => 'home',
])

<!DOCTYPE html>
<html lang="en" data-theme="pgpc">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title }}</title>
    <meta name="description"
        content="Access the PGPC Library System to search the catalog, check availability, reserve library resources, and review borrow transactions.">
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
        }

        body.is-loading {
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

    <noscript>
        <style>
            #site-preloader {
                display: none !important;
            }

            body {
                overflow: auto !important;
            }
        </style>
    </noscript>


</head>

<body class="is-loading antialiased font-sans bg-base-100 text-base-content min-h-screen flex flex-col">

    <div id="site-preloader">
        <img src="{{ Vite::asset('resources/images/hd-pgpc-logo.png') }}" alt="PGPC Logo" class="pgpc-preloader-logo"
            onerror="this.style.display='none'">
    </div>

    <x-navbar :active="$active" />

    <main class="w-full flex-grow">
        {{ $slot }}
    </main>

    <x-footer />

    <script>
        const minimumTimePromise = new Promise((resolve) => {
            setTimeout(resolve, 1000);
        });

        const windowLoadPromise = new Promise((resolve) => {
            if (document.readyState === 'complete') {
                resolve();
                return;
            }

            window.addEventListener('load', resolve, {
                once: true
            });
        });

        let preloaderFinished = false;

        function finishPreloader() {
            if (preloaderFinished) {
                return;
            }

            preloaderFinished = true;
            const preloader = document.getElementById('site-preloader');
            document.body.classList.remove('is-loading');

            if (preloader) {
                preloader.style.opacity = '0';
                preloader.setAttribute('aria-hidden', 'true');

                setTimeout(() => {
                    preloader.style.display = 'none';
                }, 500);
            }
        }

        Promise.all([minimumTimePromise, windowLoadPromise]).then(finishPreloader);

        // Keep the page usable even if a third-party font or image never fires a load event.
        setTimeout(finishPreloader, 5000);
    </script>


</body>

</html>
