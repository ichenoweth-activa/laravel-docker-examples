import "./bootstrap";
import "../css/app.css";
import "@mdi/font/css/materialdesignicons.css"; // Ensure you are using css-loader
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy/dist/vue.m";

import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";

import Bugsnag from "@bugsnag/js";
import BugsnagPluginVue from "@bugsnag/plugin-vue";
import BugsnagPerformance from "@bugsnag/browser-performance";

Bugsnag.start({
    apiKey: "6a7b91401414bce213c4001ac6388c77",
    plugins: [new BugsnagPluginVue()],
    enabledReleaseStages: ["production", "staging"],
});

BugsnagPerformance.start({ apiKey: "6a7b91401414bce213c4001ac6388c77" });
const bugsnagVue = Bugsnag.getPlugin("vue");

// Vuetify
import "vuetify/styles";
import { createVuetify } from "vuetify";
import * as components from "vuetify/components";
import * as directives from "vuetify/directives";
// Translations provided by Vuetify
import { es } from "vuetify/locale";

const vuetify = createVuetify({
    components,
    directives,
    icons: {
        defaultSet: "mdi", // This is already the default value - only for display purposes
    },
    locale: {
        locale: "es",
        messages: { es },
    },
});

const toastOptions = {
    transition: "Vue-Toastification__fade",
    maxToasts: 5,
    newestOnTop: true,
};

const appName = import.meta.env.VITE_APP_NAME || "Impulsa";

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => {
        const page = resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue"),
        );
        page.then((module) => {
            module.default.layout =
                module.default.layout || AuthenticatedLayout;
        });
        return page;
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(vuetify)
            .use(bugsnagVue)
            .use(plugin)
            .use(ZiggyVue)
            .use(Toast, toastOptions)
            .mount(el);
    },
    progress: {
        color: "#2c80ff",
    },
});
