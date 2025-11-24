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
