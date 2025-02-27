import '../css/app.css';

import { createRoot } from 'react-dom/client';
import { createInertiaApp } from '@inertiajs/react';
import { resolvePageComponent } from '@leafphp/vite-plugin/inertia-helpers';
import { initializeTheme } from './utils/app-mode';

const appName = import.meta.env.VITE_APP_NAME || 'Leaf PHP';

createInertiaApp({
  title: (title) => `${title} - ${appName}`,
  resolve: (name) =>
    resolvePageComponent(
      `./pages/${name}.jsx`,
      import.meta.glob('./pages/**/*.jsx')
    ),
  setup({ el, App, props }) {
    createRoot(el).render(<App {...props} />);
  },
  progress: {
    color: '#3eaf7c',
  },
});

// This will set light / dark mode on page load...
initializeTheme();
