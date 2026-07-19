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

    @vite(['resources/css/preloader.css', 'resources/css/welcome.css', 'resources/js/app.js', 'resources/js/loader.js'])

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

<body class="is-loading antialiased font-sans bg-base-100 text-base-content min-h-dvh flex flex-col"
    id="portal-content">

    <x-preloader />

    <x-navbar :active="$active" />

    <main class="w-full flex-grow">
        {{ $slot }}
    </main>

    <x-footer />

</body>

</html>
