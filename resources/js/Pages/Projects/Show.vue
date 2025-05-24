<script setup>
import { Head, router } from "@inertiajs/vue3";
import { ref } from "vue";

//const props = defineProps(["project"]);
const props = defineProps({
    project: {
        type: Object, 
        default: () => ({}),
    }
});

const breadcrumbs = ref([
    { text: "Inicio ", disabled: false, to: "projects.index" },
    { text: "Proyectos ", disabled: true },
]);

const headers = [
    { title: "Sesión", key: "sesion", align: "start", width: 100 },
    {
        title: "Instrucciones",
        key: "instrucciones_estudiante",
        align: "start",
    },
];
let goToProjectDetail = (project) => {
    // eslint-disable-next-line
    router.visit(route("project.edit", { project: project }));
};

const dialog = ref(false);
const loading = ref(false);

const implementarProyecto = () => {
    loading.value = true;
    // eslint-disable-next-line
    router.post(route("proyector.implementar"), props.project, {
        onFinish: () => {
            dialog.value = false;
            loading.value = false;
        },
    });
};
</script>

<template>
    <v-dialog v-model="dialog" max-width="500">
        <v-card>
            <v-card-title class="text-h6"> Confirmación </v-card-title>
            <v-card-text>
                ¿Estás seguro de que deseas iniciar el proceso de implementación
                del proyecto?
            </v-card-text>
            <v-card-actions class="justify-end">
                <v-btn text color="grey" @click="dialog = false">
                    Cancelar
                </v-btn>
                <v-btn color="blue-darken-4" text @click="implementarProyecto">
                    Confirmar
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
    <v-container>

        <Head title="Inicio" />
        <h2>Impulsa</h2>
        <v-app-bar scroll-behavior="elevate ">
            <v-breadcrumbs>
                <template v-for="(breadcrumb, index) in breadcrumbs" :key="index">
                    <v-breadcrumbs-item class="breadcrumb-link" :disabled="breadcrumb.disabled"
                                        @click="navigate(breadcrumb)">
                        {{ breadcrumb.text }}
                    </v-breadcrumbs-item>
                    <span v-if="index < breadcrumbs.length - 1" class="breadcrumb-divider">/</span>
                </template>
            </v-breadcrumbs>
        </v-app-bar>

        <v-card :disabled="loading" :loading="loading" class="mx-auto" max-width="974">
            <template v-slot:loader="{ isActive }">
                <v-progress-linear :active="isActive" color="deep-purple" height="4" indeterminate></v-progress-linear>
            </template>

            <v-img height="250" :src="project.url_location_file" cover></v-img>

            <v-card-item>
                <v-card-title class="wrap-text">{{ project.nombre }}
                </v-card-title>

                <v-card-subtitle></v-card-subtitle>
            </v-card-item>

            <v-card-text>
                <v-row align="center" class="mx-0">
                    <div class="px-4 mb-2">
                        <v-chip color="indigo" size="small" class="ma-1">
                            Nivel:{{ project.nivel }}
                        </v-chip>
                        <v-chip color="green" size="small" class="ma-1">
                            {{ project.grado_escolar }}
                        </v-chip>
                        <v-chip v-for="metodologia in project.metodologias" :key="metodologia.id" class="ma-1"
                                color="red" label size="small" variant="outlined">
                            {{ metodologia.name }}
                        </v-chip>
                        <v-chip v-for="campo in project.campo_formativos" :key="campo.id" class="ma-1" color="secondary"
                                size="small">
                            {{ campo.name }}
                        </v-chip>
                    </div>
                </v-row>

                <div class="my-4 text-subtitle-1 wrap-text text-justify">
                    {{ project.descripcion }}
                </div>

                <div class="wrap-text text-justify">
                    {{ project.contenido }}
                </div>
            </v-card-text>

            <v-divider class="mx-4 mb-1"></v-divider>

            <v-card-title class="text-subtitle-1">
                <div class="wrap-text text-justify">
                    {{ project.proceso_desarrollo_aprendizaje }}
                </div>
            </v-card-title>

            <v-data-table :headers="headers" :items="project.project_session" item-value="id" hide-default-footer
                          show-expand dense class="wrap-text custom-table">
                <template v-slot:item.data-table-expand="{
                    internalItem,
                    isExpanded,
                    toggleExpand,
                }">
                    <v-btn :append-icon="isExpanded(internalItem)
                               ? 'mdi-chevron-up'
                               : 'mdi-chevron-down'
                           " :text="isExpanded(internalItem) ? 'cerrar' : 'Materiales'
                           " class="text-none wrap-text" color="medium-emphasis" size="small" variant="text" border slim
                           @click="toggleExpand(internalItem)"></v-btn>
                </template>

                <template v-slot:expanded-row="{ columns, item }">
                    <tr>
                        <td :colspan="columns.length" class="py-2">
                            <v-sheet rounded="lg" border>
                                <v-table density="compact">
                                    <tbody class="bg-surface-light">
                                        <tr>
                                            <th style="width: 200px">
                                                Material
                                            </th>
                                            <th style="width: 300px">Url</th>
                                        </tr>
                                    </tbody>

                                    <tbody>
                                        <tr v-for="(
                                            material, index
                                        ) in item.materials" :key="index">
                                            <td>
                                                {{ material.nombre_material }}
                                            </td>
                                            <td>
                                                <a :href="material.liga" target="_blank" rel="noopener noreferrer"
                                                   class="text-primary wrap-text text-decoration-underline">
                                                    {{ material.liga }}
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </v-table>
                            </v-sheet>
                        </td>
                    </tr>
                </template>
            </v-data-table>

            <v-card-actions class="justify-center px-6 py-3">
                <v-btn class="text-none flex-grow-1 text-none" color="grey-lighten-3" variant="flat"
                       @click="goToProjectDetail(project)">
                    Editar
                </v-btn>

                <v-btn class="text-white flex-grow-1 text-none" color="blue-darken-4" rounded="0" variant="flat"
                       @click="dialog = true">
                    Implementar
                </v-btn>
            </v-card-actions>
        </v-card>
        <!-- Listado de proyectos -->
        <!--        <v-row>
            <v-col cols="12">
                <v-card-title> Proyecto</v-card-title>
                <v-card flat border>
                    <v-card-text>
                        <v-list>
                            <v-list-item>
                                <v-row>
                                    <v-col cols="auto">
                                        <v-list-item-title class="my-2">
                                            <h2></h2>
                                        </v-list-item-title>
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col cols="auto">
                                        <v-chip
                                            color="indigo"
                                            size="small"
                                            class="ma-1"
                                        >
                                            Nivel:{{ project.nivel }}
                                        </v-chip>
                                        <v-chip
                                            color="green"
                                            size="small"
                                            class="ma-1"
                                        >
                                            {{ project.grado_escolar }}
                                        </v-chip>
                                        <v-chip
                                            v-for="metodologia in project.metodologias"
                                            :key="metodologia.id"
                                            class="ma-1"
                                            color="red"
                                            label
                                            size="small"
                                            variant="outlined"
                                        >
                                            {{ metodologia.name }}
                                        </v-chip>
                                        <v-chip
                                            v-for="campo in project.campo_formativos"
                                            :key="campo.id"
                                            class="ma-1"
                                            color="secondary"
                                            size="small"
                                        >
                                            {{ campo.name }}
                                        </v-chip>
                                    </v-col>
                                </v-row>

                                <template v-slot:prepend>
                                    &lt;!&ndash; Imagen del proyecto &ndash;&gt;
                                    <div class="estilo_imagen_centrada me-4">
                                        <v-img
                                            :src="project.url_location_file"
                                            height="220"
                                            width="340"
                                            class="rounded-lg object-fit-cover"
                                        ></v-img>
                                    </div>
                                </template>

                                &lt;!&ndash; Detalles del proyecto &ndash;&gt;
                                <v-list-item-content>
                                    <v-list-item-subtitle>
                                        <div v-text="project.descripcion"></div>
                                    </v-list-item-subtitle>
                                    <v-list-item-subtitle>
                                        <div v-text="project.contenido"></div>
                                    </v-list-item-subtitle>
                                    <v-list-item-subtitle>
                                        <div
                                            v-text="
                                                project.proceso_desarrollo_aprendizaje
                                            "
                                        ></div>
                                    </v-list-item-subtitle>
                                </v-list-item-content>
                            </v-list-item>
                        </v-list>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>-->
    </v-container>
</template>

<style scoped>
.project-item:hover {
    cursor: pointer;
}

.breadcrumb-link {
    cursor: pointer;
}

.breadcrumb-link:hover {
    text-decoration: underline;
}

.estilo_imagen_centrada {
    display: flex;
    align-items: center;
    height: 220px;
    /* Altura fija para la imagen */
    justify-content: center;
}

.rounded-lg {
    border-radius: 10px;
    /* Bordes redondeados */
}

.object-fit-cover {
    object-fit: cover;
    /* Ajustar la imagen sin distorsión */
}

.wrap-text {
    white-space: normal !important;
    word-break: break-word;
}

.custom-table th {
    white-space: nowrap;
    /* Evita que el texto se divida en varias líneas */
    min-width: 100px;
    /* Ajusta el valor según sea necesario */
}

.no-wrap {
    white-space: nowrap;
}
</style>
