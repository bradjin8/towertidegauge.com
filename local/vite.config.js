import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig(({ mode }) => ({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    ...(mode === 'development' && {
        server: {
            host: '127.0.0.1',
            port: 5173,
            hmr: {
                host: 'localhost'
            }
        }
    }),
    build: {
        manifest: true,
        outDir: '../build',
        rollupOptions: {
            input: [
                'resources/js/app.js',
                'resources/css/app.css',
            ],
        },
    }
}));
