import '../css/app.css';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from '@leafphp/vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';
import { initializeTheme } from './utils/app-mode';

const appName = import.meta.env.VITE_APP_NAME || 'Leaf PHP';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./pages/${name}.vue`,
            import.meta.glob('./pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .mount(el);
    },
    progress: {
        color: '#3eaf7c',
    },
});

// This will set light / dark mode on page load...
initializeTheme();
