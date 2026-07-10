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

    <link rel="stylesheet" href="{{ Vite::asset('resources/css/preloader.css') }}">


</head>

<body class="antialiased font-sans bg-base-100 text-base-content min-h-screen flex flex-col">

    <x-preloader />
    <script src="{{ Vite::asset('resources/js/loader.js') }}"></script>

    <x-navbar />

    <main class="w-full flex-grow">
        {{ $slot }}
    </main>

    <x-footer />
</body>

</html>
