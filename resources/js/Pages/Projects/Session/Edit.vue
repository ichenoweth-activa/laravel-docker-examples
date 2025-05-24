<script setup>
import { Head,useForm } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({
    project:{
        type: Object, 
        default: () => ({}),
    },
    session:{
        type: Object, 
        default: () => ({}),
    }
});

const form = useForm({
    id: props.project.id,
    sesion: props.session.sesion,
    instrucciones_docente: props.session.instrucciones_docente,
    instrucciones_estudiante: props.session.instrucciones_estudiante,
});

const breadcrumbs = ref([
    { text: "Inicio ", disabled: false, to: "projects.index" },
    { text: "Proyectos ", disabled: true },
]);



const updateForm = () => {
    // eslint-disable-next-line
    form.put(route("project.update", { id: form.id }), {
        preserveScroll: true,
        onSuccess: () => {
            form.nombre = "";
            form.nivel = "";
            form.grado_escolar = "";
            form.metodologias = "";
        },
        onError: () => {
            //console.error("Error en la subida:", errors);
        },
    });
    form.reset();
};
</script>

<template>
    <v-container>
        <Head title="Editar sesión" />
        <h2>Impulsa</h2>
        <v-app-bar scroll-behavior="elevate ">
            <v-breadcrumbs>
                <template
                    v-for="(breadcrumb, index) in breadcrumbs"
                    :key="index"
                >
                    <v-breadcrumbs-item
                        class="breadcrumb-link"
                        :disabled="breadcrumb.disabled"
                        @click="navigate(breadcrumb)"
                    >
                        {{ breadcrumb.text }}
                    </v-breadcrumbs-item>
                    <span
                        v-if="index < breadcrumbs.length - 1"
                        class="breadcrumb-divider"
                    >/</span
                    >
                </template>
            </v-breadcrumbs>
        </v-app-bar>
        <v-card
            :disabled="loading"
            :loading="loading"
            class="mx-auto my-12"
            max-width="874"
        >
            <h1>Editar Sesión</h1>
            <v-row justify="center" class="mx-auto my-12">
                <v-container>
                    <v-form @submit.prevent="updateForm" class="mx-auto my-12">
                        <v-row>
                            <v-col cols="3">
                                <v-text-field
                                    clearable
                                    type="text"
                                    v-model="form.sesion"
                                    label="Sesión"
                                    required
                                ></v-text-field>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12">
                                <v-textarea
                                    clearable
                                    type="text"
                                    v-model="form.instrucciones_docente"
                                    label="Instrucciones docente"
                                    required
                                ></v-textarea>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12">
                                <!--                                <v-textarea
                                    clearable
                                    type="text"
                                    v-model="form.instrucciones_estudiante"
                                    label="Instrucciones estudiante"
                                    required
                                ></v-textarea>-->
                            </v-col>
                        </v-row>
                        <div class="d-flex justify-end">
                            <v-btn
                                color="success"
                                class="mr-3"
                                @click="updateForm"
                            >
                                Guardar
                                <v-icon icon="mdi-check" end></v-icon>
                            </v-btn>
                        </div>
                    </v-form>
                </v-container>
            </v-row>
        </v-card>
    </v-container>
</template>

<style scoped>
.ql-container {
    height: 300px; /* O el tamaño que desees */
}
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
    height: 220px; /* Altura fija para la imagen */
    justify-content: center;
}

.rounded-lg {
    border-radius: 10px; /* Bordes redondeados */
}

.object-fit-cover {
    object-fit: cover; /* Ajustar la imagen sin distorsión */
}

.wrap-text {
    white-space: normal !important;
    word-break: break-word;
}

.custom-table th {
    white-space: nowrap; /* Evita que el texto se divida en varias líneas */
    min-width: 100px; /* Ajusta el valor según sea necesario */
}

.no-wrap {
    white-space: nowrap;
}
</style>
