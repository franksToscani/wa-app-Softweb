import '../css/app.css';
import './bootstrap';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';
// PrimeVue imports
import PrimeVue from 'primevue/config';
import Card from 'primevue/card';
import Button from 'primevue/button';
import Dialog from 'primevue/dialog';
// PrimeVue icons (theme/core CSS omitted to avoid package/theme resolution issues)
// We rely on Tailwind for most styling; keep primeicons for icons.
import 'primeicons/primeicons.css';
// NOTE: PrimeVue v4 ships styles differently (@primeuix / @primevue/themes). The
// previously used paths (primevue/resources/... and @primevue/themes/saga-blue)
// do not exist in this install and caused Vite import-resolution errors.
// To avoid the dev server 500 errors we remove those imports here. If you want
// PrimeVue component styling, choose one of the available theme packages under
// node_modules/@primevue/themes (for example `lara`, `aura`, `material`, or
// `nora`) or import styles from `@primeuix/styles` per the PrimeVue v4 docs.
// Example (only if the package exists):
// import '@primevue/themes/lara/index.mjs';
// For now we rely on Tailwind / local CSS to avoid blocking HMR.
// Quill editor styles (required by PrimeVue Editor)
import 'quill/dist/quill.snow.css';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            // PrimeVue plugin and global components
            .use(PrimeVue)
            .component('Card', Card)
            .component('PButton', Button)
            .component('Dialog', Dialog)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
