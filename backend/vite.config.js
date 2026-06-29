import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        open: false, // Ép Vite KHÔNG tự động kích hoạt mở trình duyệt lung tung
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
