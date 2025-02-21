import { defineConfig } from "vite";
import leaf from "@leafphp/vite-plugin";
import { svelte } from '@sveltejs/vite-plugin-svelte';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        tailwindcss(),
        leaf({
            input: ['app/views/js/app.js', 'app/views/css/app.css'],
            refresh: true,
        }),
        svelte(),
    ],
});
