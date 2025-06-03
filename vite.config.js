import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    server: {
        host: true,
        hmr: {
            host: 'ef63-158-49-46-223.ngrok-free.app',
            protocol: 'https',
        },
    },
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
          //  buildDirectory: 'build', // <-- agrega esta línea
        }),
    ],
    /*build: {
        manifest: true,
        outDir: 'public/build',
        assetsDir: 'assets',
        rollupOptions: {
            input: ['resources/css/app.css', 'resources/js/app.js'],
        },
    },*/

});
