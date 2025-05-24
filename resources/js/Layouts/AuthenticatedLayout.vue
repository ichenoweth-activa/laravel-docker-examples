<script setup>
import { router, usePage, useForm } from "@inertiajs/vue3";
import { computed, ref, watch } from "vue";
import { useDisplay } from "vuetify";
import { useToast } from "vue-toastification";

import dayjs from "dayjs";
import relativeTime from "dayjs/plugin/relativeTime";
import dayjsEs from "dayjs/locale/es.js";

// Destructure only the keys you want to use
const {smAndDown } = useDisplay();

const drawer = ref(true);
const rail = ref(false);
const items = [
    // {
    //     text: "Comunidad",
    //     icon: "mdi-home-account",
    //     route: route("posts.index"),
    //     activeRoute: "posts.*",
    //     visible: true,
    //     permiso: "",
    // },
    /*    {
        text: "Mis cursos",
        icon: "mdi-school",
        route: route("project.index"),
        activeRoute: "mycourses.*",
        visible: true,
        permiso: "ver cursos",
    },*/
    /*
    {
        text: "Campañas",
        icon: "mdi-folder-account-outline",
        route: route("campaigns.index"),
        activeRoute: "campaigns.*",
        permiso: "admin usuarios",
    },

    {
        text: "Solicitudes",
        icon: "mdi-badge-account-alert",
        route: route("admissions.index"),
        activeRoute: "admissions.*",
        permiso: "admin usuarios",
    },
    {
        text: "Pagos",
        icon: "mdi-cash-clock",
        route: route("payments.index"),
        activeRoute: "payments.*",
        permiso: "admin usuarios",
    },*/
];
const clickMenu = (url) => {
    router.visit(url, { preserveScroll: true });
};
const logout = () => {
    // eslint-disable-next-line no-undef
    router.post(route("logout"));
};
const clickHamburger = () => {
    if (smAndDown.value) {
        drawer.value = !drawer.value;
        rail.value = false;
        return;
    }

    drawer.value = true;
    rail.value = !rail.value;
};

const mensaje = computed(() => usePage().props.flash);
const toast = useToast();
watch(mensaje, async (flash) => {
    if (flash.error) {
        toast.error(flash.error);
    }

    if (flash.success) {
        toast.success(flash.success);
    }

    if (flash.warning) {
        toast.warning(flash.warning);
    }
    if (flash.message) {
        toast(flash.message);
    }

    if (flash.info) {
        toast.info(flash.info);
    }
});
const showProfile = (user) => {
    // eslint-disable-next-line no-undef
    router.visit(route("users.show", { user: user }));
};
const showPost = (post) => {
    // eslint-disable-next-line no-undef
    router.visit(route("posts.show", { id: post }));
};

const form = useForm({
    user_id: null,
});

const submitForm = () => {
    // eslint-disable-next-line no-undef
    form.post(route("notifications.update"), {
        preserveScroll: true,
    });
};
dayjs.locale(dayjsEs);
dayjs.extend(relativeTime);
const mensajeFecha = (title, created) =>
    computed(() => title + " . . . " + dayjs(created).fromNow());


// onMounted(() => {
//     Inertia.get('/user/notifications', {}, {
//         onSuccess: (page) => {
//             notifications.value = page.props.notifications;
//         }
//     });
// });
</script>

<template>
    <v-app id="inspire" key="inspire">
        <v-layout class="rounded rounded-lg">
            <v-navigation-drawer
                v-model="drawer"
                :rail="rail"
                expand-on-hover
                :permanent="!smAndDown"
                :temporary="smAndDown"
            >
                <v-list>
                    <v-list-item title="Impulsa">
                        <template v-slot:prepend>
                            <v-avatar rounded="0">
                                <v-img
                                    v-once
                                    src="/favicon99.png"
                                    alt="Impulsa"
                                ></v-img>
                            </v-avatar>
                        </template>
                    </v-list-item>
                </v-list>
                <!--            <v-list>-->
                <!--                <v-list-item-->
                <!--                    :prepend-avatar="$page.props.auth.user.avatar"-->
                <!--                    :title="$page.props.auth.user.name"-->
                <!--                    :subtitle="$page.props.auth.user.email"-->
                <!--                >-->
                <!--                    <template v-slot:append>-->
                <!--                        <v-btn-->
                <!--                            size="small"-->
                <!--                            variant="text"-->
                <!--                            icon="mdi-menu-down"-->
                <!--                        ></v-btn>-->
                <!--                    </template>-->
                <!--                </v-list-item>-->
                <!--            </v-list>-->

                <!--            <v-divider></v-divider>-->

                <v-list :lines="false" density="compact" nav>
                    <div v-for="(item, i) in items">
                        <v-list-item
                            :key="i"
                            :value="item"
                            color="primary"
                            rounded="lg"
                            :active="route().current(item.activeRoute)"
                            @click="clickMenu(item.route)"
                        >
                            <template v-slot:prepend>
                                <v-icon :icon="item.icon"></v-icon>
                            </template>

                            <v-list-item-title v-text="item.text">
                            </v-list-item-title>
                        </v-list-item>
                    </div>

                    <v-list-item
                        color="primary"
                        rounded="lg"
                        :active="route().current('posts.*')"
                        @click="clickMenu(route('posts.index'))"
                    >
                        <template v-slot:prepend>
                            <v-icon icon="mdi-home-account"></v-icon>
                        </template>

                        <v-list-item-title> Proyectos </v-list-item-title>
                    </v-list-item>

                    <v-list-item
                        color="primary"
                        rounded="lg"
                        :active="route().current('file.*')"
                        @click="clickMenu(route('file.index'))"
                    >
                        <template v-slot:prepend>
                            <v-icon icon="mdi-cloud-upload"></v-icon>
                        </template>

                        <v-list-item-title>
                            Mis implementaciones
                        </v-list-item-title>
                    </v-list-item>

                    <v-list-item
                        color="primary"
                        rounded="lg"
                        :active="route().current('faqs.*')"
                        @click="clickMenu(route('faqs.index'))"
                    >
                        <template v-slot:prepend>
                            <v-icon icon="mdi-lightbulb-outline"></v-icon>
                        </template>

                        <v-list-item-title>
                            Preguntas Frecuentes
                        </v-list-item-title>
                    </v-list-item>

                    <v-list-item
                        color="primary"
                        rounded="lg"
                        :active="route().current('project.*')"
                        @click="clickMenu(route('project.index'))"
                    >
                        <template v-slot:prepend>
                            <v-icon icon="mdi-cloud-upload"></v-icon>
                        </template>

                        <v-list-item-title> Demo </v-list-item-title>
                    </v-list-item>

                    <!--                    <v-list-item

                        color="primary"
                        rounded="lg"
                        :active="route().current('studentdashboard.*')"
                        @click="clickMenu(route('studentdashboard.index'))"
                    >
                        <template v-slot:prepend>
                            <v-icon icon="mdi-account-school"></v-icon>
                        </template>

                        <v-list-item-title> Alumnas </v-list-item-title>
                    </v-list-item>

                    <v-list-item
                        v-if="$page.props.auth.roles.includes('instructor')"
                        color="primary"
                        rounded="lg"
                        :active="route().current('mycourses.*')"
                        @click="clickMenu(route('mycourses.index'))"
                    >
                        <template v-slot:prepend>
                            <v-icon icon="mdi-school"></v-icon>
                        </template>

                        <v-list-item-title> Mis cursos </v-list-item-title>
                    </v-list-item>-->

                    <!--                    {-->
                    <!--                    text: "Alumna",-->
                    <!--                    icon: "mdi-account-school",-->
                    <!--                    route: route("studentdashboard.index"),-->
                    <!--                    activeRoute: "studentdashboard.*",-->
                    <!--                    visible: true,-->
                    <!--                    permiso: "",-->
                    <!--                    },-->

                    <!--                    <v-list-item
                        v-if="$page.props.auth.roles.includes('admin')"
                        color="primary"
                        rounded="lg"
                        :active="route().current('admin.*')"
                        @click="clickMenu(route('admin.index'))"
                    >
                        <template v-slot:prepend>
                            <v-icon icon="mdi-account-key"></v-icon>
                        </template>

                        <v-list-item-title> Admin </v-list-item-title>
                    </v-list-item>-->

                    <!--                    {-->
                    <!--                    text: "Reportes",-->
                    <!--                    icon: "mdi-chart-line",-->
                    <!--                    route: route("reports.index"),-->
                    <!--                    activeRoute: "reports.*",-->
                    <!--                    permiso: "admin usuarios",-->
                    <!--                    },-->

                    <v-list-group
                        value="Reportes"
                        v-if="$page.props.auth.roles.includes('admin')"
                    >
                        <template v-slot:activator="{ props }">
                            <v-list-item
                                :active="route().current('reports.*')"
                                v-bind="props"
                                prepend-icon="mdi-chart-line"
                                title="Reportes"
                            ></v-list-item>
                        </template>

                        <v-list-item
                            color="primary"
                            rounded="lg"
                            :active="route().current('reports.evaluaciones')"
                            @click="clickMenu(route('reports.evaluaciones'))"
                        >
                            <template v-slot:prepend>
                                <v-icon
                                    icon="mdi-chart-timeline-variant-shimmer"
                                ></v-icon>
                            </template>

                            <v-list-item-title>
                                Evaluaciones
                            </v-list-item-title>
                        </v-list-item>

                        <v-list-item
                            color="primary"
                            rounded="lg"
                            :active="
                                route().current('reports.cursosinformacion')
                            "
                            @click="
                                clickMenu(route('reports.cursosinformacion'))
                            "
                        >
                            <template v-slot:prepend>
                                <v-icon icon="mdi-finance"></v-icon>
                            </template>

                            <v-list-item-title> Cursos </v-list-item-title>
                        </v-list-item>

                        <v-list-item
                            color="primary"
                            rounded="lg"
                            :active="route().current('reports.estudiantes')"
                            @click="clickMenu(route('reports.estudiantes'))"
                        >
                            <template v-slot:prepend>
                                <v-icon>mdi-account-group</v-icon>
                            </template>

                            <v-list-item-title> Estudiantes </v-list-item-title>
                        </v-list-item>

                        <v-list-item
                            color="primary"
                            rounded="lg"
                            :active="route().current('reports.pagos')"
                            @click="clickMenu(route('reports.pagos'))"
                        >
                            <template v-slot:prepend>
                                <v-icon left>mdi-credit-card-outline</v-icon>
                            </template>

                            <v-list-item-title> Pagos </v-list-item-title>
                        </v-list-item>

                        <v-list-item
                            color="primary"
                            rounded="lg"
                            :active="route().current('reports.graficas')"
                            @click="clickMenu(route('reports.graficas'))"
                        >
                            <template v-slot:prepend>
                                <v-icon icon="mdi-chart-multiple"></v-icon>
                            </template>

                            <v-list-item-title> Gráficas </v-list-item-title>
                        </v-list-item>
                    </v-list-group>

                    <!--                    <v-list-item-->
                    <!--                        color="primary"-->
                    <!--                        rounded="lg"-->
                    <!--                        :active="route().current('posts.*')"-->
                    <!--                        @click="clickMenu(route('posts.index'))"-->
                    <!--                        v-if="$page.props.auth.roles.includes('instructor')"-->
                    <!--                    >-->
                    <!--                        <template v-slot:prepend>-->
                    <!--                            <v-icon icon="mdi-home-account"></v-icon>-->
                    <!--                        </template>-->

                    <!--                        <v-list-item-title> Comunidad </v-list-item-title>-->
                    <!--                    </v-list-item>-->
                </v-list>
            </v-navigation-drawer>
            <v-app-bar density="compact" :elevation="0">
                <template v-slot:prepend>
                    <v-app-bar-nav-icon
                        @click="clickHamburger"
                    ></v-app-bar-nav-icon>
                </template>

                <template v-slot:append>
                    <v-menu offset-y>
                        <template v-slot:activator="{ props }">
                            <v-btn
                                @blur="submitForm"
                                v-bind="props"
                                v-on="on"
                                class="text-none"
                                stacked=""
                            >
                                <div
                                    v-if="
                                        $page.props.auth.user
                                            .unreadNotificationsCount > 0
                                    "
                                >
                                    <v-badge
                                        :content="
                                            $page.props.auth.user
                                                .unreadNotificationsCount
                                        "
                                        color="error"
                                    >
                                        <v-icon>mdi-bell-outline</v-icon>
                                    </v-badge>
                                </div>
                                <div v-else>
                                    <v-icon>mdi-bell-outline</v-icon>
                                </div>
                            </v-btn>
                        </template>

                        <v-list>
                            <v-list-item
                                v-for="notification in $page.props.auth.user
                                    .unreadNotifications"
                                :key="notification.id"
                            >
                                <v-list-item-content>
                                    <v-btn
                                        variant="plain"
                                        @click="showPost(notification.type_id)"
                                    >
                                        <v-icon
                                            v-if="
                                                notification.data.read_at !=
                                                    null
                                            "
                                            color="warning"
                                        >mdi-exclamation-thick</v-icon
                                        >
                                        <small>
                                            <!--                                          {{ notification.data.message }}️-->
                                            {{
                                                mensajeFecha(
                                                    notification.data.message,
                                                    notification.data
                                                        .created_at,
                                                )
                                            }}
                                        </small>
                                    </v-btn>
                                </v-list-item-content>

                                <v-divider class="my-2"></v-divider>
                            </v-list-item>
                        </v-list>
                    </v-menu>

                    <v-menu min-width="200px">
                        <template v-slot:activator="{ props }">
                            <v-btn icon v-bind="props">
                                <v-avatar
                                    v-once
                                    color="brown"
                                    :image="$page.props.auth.user.imagen"
                                >
                                </v-avatar>
                            </v-btn>
                        </template>
                        <v-card>
                            <v-card-text>
                                <div class="mx-auto text-center">
                                    <v-avatar
                                        v-once
                                        color="brown"
                                        :image="$page.props.auth.user.imagen"
                                        size="x-large"
                                    >
                                    </v-avatar>
                                    <h3>{{ $page.props.auth.user.name }}</h3>
                                    <p class="text-caption mt-1">
                                        {{ $page.props.auth.user.email }}
                                    </p>
                                    <!--                                <v-divider class="my-3"></v-divider>-->
                                    <!--                                <v-btn-->
                                    <!--                                    rounded-->
                                    <!--                                    variant="text"-->
                                    <!--                                >-->
                                    <!--                                    Edit Account-->
                                    <!--                                </v-btn>-->
                                    <v-divider class="my-3"></v-divider>
                                    <v-btn
                                        rounded
                                        variant="text"
                                        color="primary"
                                        @click="
                                            showProfile($page.props.auth.user)
                                        "
                                    >
                                        👤 Ver perfil
                                    </v-btn>
                                    <v-divider class="my-3"></v-divider>
                                    <v-btn
                                        rounded
                                        variant="text"
                                        color="primary"
                                        @click="logout"
                                    >
                                        🚪 Cerrar Sesion
                                    </v-btn>
                                </div>
                            </v-card-text>
                        </v-card>
                    </v-menu>
                </template>
            </v-app-bar>

            <v-main class="d-flex justify-center" style="min-height: 300px">
                <v-container>
                    <slot />
                </v-container>
            </v-main>
        </v-layout>
    </v-app>
</template>
