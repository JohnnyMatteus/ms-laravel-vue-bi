import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    server: {
        host: '0.0.0.0', // Permitir conexões externas
        port: 5173,      // Porta do Vite
        strictPort: true, // Garante que o Vite não altere a porta
        hmr: {
            host: 'localhost', // Define o host do HMR
            port: 5173,       // Porta para Hot Module Replacement
        },
    },
});
