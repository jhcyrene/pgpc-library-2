<!DOCTYPE html>
<html lang="en" data-theme="pgpc">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard - PGPC Library System</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link rel="icon" href="{{ Vite::asset('resources/images/hd-pgpc-logo.png') }}">

    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    @vite(['resources/css/welcome.css', 'resources/js/app.js'])

    

</head>
<body class="bg-base-200 min-h-screen flex text-base-content antialiased font-sans">
    
    <x-admin.sidebar />

    <div class="flex-1 flex flex-col h-screen">
        <x-admin.header />
    
        <!-- Content -->
        <main class="flex-1 overflow-y-auto p-6">
            {{ $slot }}
        </main>

    </div>
    
    <script>
        function toggleNavGroup(button) {
            const expanded = button.getAttribute('aria-expanded') === 'true';
            button.setAttribute('aria-expanded', !expanded);
            
            const chevron = button.querySelector('.nav-group-chevron');
            if (chevron) {
                if (expanded) {
                    chevron.classList.remove('rotate-90', 'text-white');
                    chevron.classList.add('text-gray-400', 'group-hover:text-gray-300');
                    
                    button.classList.remove('bg-white/10', 'text-white', 'font-bold', 'shadow-sm');
                    button.classList.add('text-gray-300', 'font-medium');
                    
                    const icon = button.querySelector('.w-5.h-5');
                    if (icon) {
                        icon.classList.remove('text-white');
                        icon.classList.add('text-gray-400', 'group-hover:text-gray-300');
                    }
                } else {
                    chevron.classList.add('rotate-90', 'text-white');
                    chevron.classList.remove('text-gray-400', 'group-hover:text-gray-300');
                    
                    button.classList.add('bg-white/10', 'text-white', 'font-bold', 'shadow-sm');
                    button.classList.remove('text-gray-300', 'font-medium');
                    
                    const icon = button.querySelector('.w-5.h-5');
                    if (icon) {
                        icon.classList.add('text-white');
                        icon.classList.remove('text-gray-400', 'group-hover:text-gray-300');
                    }
                }
            }
            
            const children = button.nextElementSibling;
            if (children) {
                if (expanded) {
                    children.classList.remove('max-h-96', 'opacity-100');
                    children.classList.add('max-h-0', 'opacity-0');
                } else {
                    children.classList.remove('max-h-0', 'opacity-0');
                    children.classList.add('max-h-96', 'opacity-100');
                }
            }
        }
    </script>

    @stack('scripts')
</body>
</html>
