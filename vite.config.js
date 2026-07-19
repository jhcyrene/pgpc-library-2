import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';


export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/app.js',
                'resources/js/loader.js',
                'resources/js/borrows.js',
                'resources/css/welcome.css',
                'resources/css/preloader.css',
                'resources/css/loginauth.css',
            ],
            assets: [
                'resources/images/**'
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        host: '0.0.0.0',
        port: 5173,
        strictPort: true,
        allowedHosts: true, // Permits requests from your IP / network hosts
        cors: true,         // Allows local development requests
    },
});

