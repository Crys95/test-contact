import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import AppLayout from '@/Layouts/AppLayout.vue';  
import Toast from 'vue-toastification';
import 'vue-toastification/dist/index.css';
import './assets/tailwind.css';

createInertiaApp({
  resolve: async (name) => {
    const page = await resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue'));

    if (!page.default.layout) {
      page.default.layout = AppLayout;
    }

    return page;
  },
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(Toast, {
        position: 'top-right',
        timeout: 3000,
        closeOnClick: true,
        pauseOnHover: true,
      })
      .mount(el);
  },
});
