import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from '@leafphp/vite-plugin/inertia-helpers';
import { createApp, DefineComponent, h } from 'vue';

import '../css/app.css';

const appName = import.meta.env.VITE_APP_NAME || 'Leaf PHP';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob<DefineComponent>('./Pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .mount(el);
    },
    progress: {
        color: '#3eaf7c',
    },
});
