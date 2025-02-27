import '../css/app.css';

import { createInertiaApp } from '@inertiajs/svelte';
import { resolvePageComponent } from '@leafphp/vite-plugin/inertia-helpers';
import { mount } from 'svelte';
import { initializeTheme } from './utils/app-mode';

const appName = import.meta.env.VITE_APP_NAME || 'Leaf PHP';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./pages/${name}.svelte`,
            import.meta.glob('./pages/**/*.svelte', { eager: true })
        ),
        // or with persistent layouts
        // {
        //     const pages = import.meta.glob('./Pages/**/*.svelte', { eager: true });
        //     let page = pages[`./Pages/${name}.svelte`];
        //     return { default: page.default, layout: page.layout || Layout };
        // },
    setup({ el, App, props, plugin }) {
        mount(App, { target: el, props });
    },
    progress: {
        color: '#3eaf7c',
    },
});

// This will set light / dark mode on page load...
initializeTheme();
