<!DOCTYPE html>
<html lang="{{ strtolower(app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ Vite::asset('resources/images/webp/hd-pgpc-logo.webp') }}">
    <link rel="shortcut icon" href="{{ Vite::asset('resources/images/webp/hd-pgpc-logo.webp') }}" type="image/x-icon">


    <title>{{ isset($title) ? $title . ' | ' : '' }}PGPC Library</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">

    @vite(['resources/css/preloader.css', 'resources/js/app.js', 'resources/css/loginauth.css', 'resources/js/loader.js'])
</head>

<body class="antialiased font-sans min-h-[100dvh] flex flex-col relative overflow-x-hidden bg-gray-50" id="portal-content">

    <x-preloader />

    <div class="fixed inset-0 z-0 bg-cover bg-center bg-fixed pointer-events-none"
        style="background-image: url('{{ Vite::asset('resources/images/webp/pgpc-ng.webp') }}')"></div>
    <div class="fixed inset-0 z-10 bg-gradient-hero backdrop-blur-sm pointer-events-none"></div>

    <div id="main-app-wrapper">
        <x-auth.backButton />

        <div class="relative z-20 w-full flex justify-center m-auto top-10">
            {{ $slot }}
        </div>

    </div>





</body>

</html>
