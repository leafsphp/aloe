import { defineConfig } from "vite";
import leaf from '@leafphp/vite-plugin';
import { svelte } from '@sveltejs/vite-plugin-svelte';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        tailwindcss(),
        leaf({
            input: ['app/views/js/app.js'],
            refresh: true,
        }),
        svelte(),
    ],
    resolve: {
        alias: {
            '@': '/app/views/js',
        },
    },
});
