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
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },

        // hmr: {
        //     host: 'pglibsystem.test',
        // },

    },
});
