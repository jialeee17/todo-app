import './bootstrap';
import '../css/app.css';

import AOS from 'aos';
import 'aos/dist/aos.css';
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import AuthenticatedLayout from './Layouts/AuthenticatedLayout.vue';
import ContainerLayout from './Layouts/ContainerLayout.vue';
import VButton from './Components/VButton.vue';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({
            render: () => h(App, props),
            mounted() {
                AOS.init();
            }
        })
        .component('AuthenticatedLayout', AuthenticatedLayout)
        .component('ContainerLayout', ContainerLayout)
        .component('VButton', VButton)
        .use(plugin)
        .use(ZiggyVue, Ziggy)
        .mount(el);
    },
    progress: {
        color: '#4B5563',
        showSpinner: true,
    },
});
