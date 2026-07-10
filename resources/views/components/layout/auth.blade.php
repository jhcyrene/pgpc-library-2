<!DOCTYPE html>
<html lang="{{ strtolower(app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ Vite::asset('resources/images/hd-pgpc-logo.jpg') }}">

    <title>{{ isset($title) ? $title . ' | ' : '' }}PGPC Library</title>
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/preloader.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/loginauth.css'])
</head>

<body class="antialiased font-sans min-h-screen flex items-center justify-center relative overflow-hidden bg-gray-50">

    <x-preloader />

    <div class="absolute inset-0 z-0 bg-cover bg-center bg-fixed"
        style="background-image: url('{{ Vite::asset('resources/images/pgpc-ng.png') }}')"></div>
    <div class="absolute inset-0 z-10 bg-gradient-hero backdrop-blur-sm"></div>

    <x-auth.backButton />

    <div class="relative z-20 w-full flex justify-center">
        {{ $slot }}
    </div>

    @vite('resources/js/loader.js')

</body>

</html>
