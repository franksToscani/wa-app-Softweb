import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.js',
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    // Expose server configuration so the dev server host/port and CORS
    // policy can be controlled from environment. This keeps the dev server
    // consistent with the Blade `VITE_DEV_URL` setting used in local views.
    server: {
        // allow overriding via VITE_HOST / VITE_PORT in the environment
        host: process.env.VITE_HOST || 'localhost',
        port: process.env.VITE_PORT ? Number(process.env.VITE_PORT) : 5173,
        // enable CORS for the dev server so module requests from the app
        // origin succeed even when hosts differ (useful in complex dev setups)
        cors: true,
    },
});
