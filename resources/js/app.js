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
import InputText from 'primevue/inputtext';
import InputTextarea from 'primevue/textarea';
import Dropdown from 'primevue/dropdown';
import FileUpload from 'primevue/fileupload';
import Editor from 'primevue/editor';

// PrimeVue icons (theme/core CSS omitted to avoid package/theme resolution issues)
// We rely on Tailwind for most styling; keep primeicons for icons.
import 'primeicons/primeicons.css';

import '@primevue/themes/lara';


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
            .component('InputText', InputText)
            .component('InputTextarea', InputTextarea)
            .component('Dropdown', Dropdown)
            .component('FileUpload', FileUpload)
            .component('Editor', Editor)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
