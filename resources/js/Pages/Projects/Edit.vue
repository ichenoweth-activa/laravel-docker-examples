<script setup>
import { Head,useForm } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({
  project: {
    type: Object,
    required: true,
  },
  metodologiasData: {
    type: Array,
    default: () => [],
  },
  camposFormativosData: {
    type: Array,
    default: () => [],
  },
  disciplinasData: {
    type: Array,
    default: () => [],
  },
  unidadesAprendizajeData: {
    type: Array,
    default: () => [],
  },
  areasConocimientosData: {
    type: Array,
    default: () => [],
  },
});


const headers = [
    {
        title: "Sesión",
        value: "sesion",
        align: "justify",
        width: "80px",
        cellClass: "justify-cell",
    },
    {
        title: "Instrucciones",
        align: "start",
        value: "instrucciones_estudiante",
    },
    { text: "Acciones", value: "acciones", sortable: false },
];

const form = useForm({
    id: props.project.id,
    nombre: props.project.nombre,
    descripcion: props.project.descripcion,
    contenido: props.project.contenido,
    nivel: props.project.nivel,
    grado_escolar: props.project.grado_escolar,
    metodologias: props.project.metodologias,
    campoFormativo: props.project.campo_formativos,
    area_conocimientos: props.project.area_conocimientos,
    proceso_desarrollo_aprendizaje:
        props.project.proceso_desarrollo_aprendizaje,
    disciplinas_selected: props.project.disciplinas,
    unidad_aprendizaje_selected: props.project.unidades_aprendizaje,
});

const formSesion = useForm({
    id: null,
    project_id: "",
    sesion: "",
    instrucciones_docente: "",
    instrucciones_estudiante: "",
});

const formMaterialSeleccionado = useForm({
    id: null,
    nombre_material: "",
    liga: "",
});

const breadcrumbs = ref([
    { text: "Inicio ", disabled: false, to: "projects.index" },
    { text: "Proyectos ", disabled: true },
]);
const niveles = ["Primaria", "Secundaria", "Bachillerato"];
const grados = ["1", "2", "3", "4", "5", "6"];


const updateForm = () => {

    form.put(
        // eslint-disable-next-line no-undef    
        route("project.update", { id: form.id }), {
        preserveScroll: true,
        onSuccess: () => {
            form.nombre = "";
            form.nivel = "";
            form.grado_escolar = "";
            form.metodologias = "";
        },
        onError: () => {
            //              console.error("Error en la subida:", errors);
        },
    });
    form.reset();
};

const updateDialogSesion = () => {
    dialog.value = false;
    formSesion.put(
        // eslint-disable-next-line no-undef
        route("project.sesion.update", { project: props.project.id }),
        {
            preserveScroll: true,
            onSuccess: () => {
                formSesion.sesion = "";
                formSesion.instrucciones_docente = "";
                formSesion.instrucciones_estudiante = "";
                formSesion.project_id = "";
            },
            onError: () => {
                //              console.error("Error en la subida:", errors);
            },
        },
    );
    formSesion.reset();
};
const guardarCambiosMaterial = () => {
    dialogEditarMaterial.value = false;
    formMaterialSeleccionado.put(
        // eslint-disable-next-line no-undef
        route("project.material.update", { project: props.project.id }),
        {
            preserveScroll: true,
            onSuccess: () => {
                formMaterialSeleccionado.id = "";
                formMaterialSeleccionado.nombre_material = "";
                formMaterialSeleccionado.liga = "";
            },
            onError: () => {
                //              console.error("Error en la subida:", errors);
            },
        },
    );
    formSesion.reset();
};

/*inicio codigo para abrir el dialog de edicion de la sesión seleccionada */
const dialog = ref(false);
//const selectedSession = ref(null);

const goToSession = (project, session) => {
    dialog.value = true;
    formSesion.id = session.id;
    formSesion.sesion = session.sesion;
    formSesion.instrucciones_docente = session.instrucciones_docente;
    formSesion.instrucciones_estudiante = session.instrucciones_estudiante;
    formSesion.project_id = project;
};
/*fin codigo para abrir el dialog de edicion de la sesión seleccionada */


const dialogEditarMaterial = ref(false);
const abrirModal = (material) => {
    // Guarda los datos del material seleccionado
    //materialSeleccionado.value = material;
    formMaterialSeleccionado.id = material.id;
    formMaterialSeleccionado.nombre_material = material.nombre_material;
    formMaterialSeleccionado.liga = material.liga;

    // Abre el modal (dependiendo de cómo lo manejes tú)
    dialogEditarMaterial.value = true;
};
</script>

<template>
    <v-dialog v-model="dialogEditarMaterial" max-width="650px" persistent>
        <v-card class="text-h6">
            <v-card-title> Editar Material</v-card-title>
            <v-form @submit.prevent="guardarCambiosMaterial" class="my-1">
                <v-card-text>
                    <v-row>
                        <v-col>
                            <v-text-field class="w-100" label="Nombre del Material" v-model="formMaterialSeleccionado.nombre_material
                            "></v-text-field>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="12">
                            <v-text-field class="w-100" label="Liga"
                                          v-model="formMaterialSeleccionado.liga"></v-text-field>
                        </v-col>
                    </v-row>
                </v-card-text>
            </v-form>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn text @click="dialogEditarMaterial = false">Cancelar
                </v-btn>
                <v-btn color="primary" @click="guardarCambiosMaterial">Guardar
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>

    <v-dialog v-model="dialog" max-width="650" persistent>
        <v-card>
            <v-card-title class="text-h6">Editar Sesión: {{ formSesion.sesion }}
            </v-card-title>
            <v-form @submit.prevent="updateDialogSesion" class="my-1">
                <v-card-text>
                    <!-- Aquí puedes colocar campos para editar la sesión -->

                    <div>
                        <v-textarea type="text" v-model="formSesion.sesion" label="Nombre de la sesión" required
                                    variant="outlined" auto-grow></v-textarea>
                    </div>
                    <div>
                        <v-textarea type="text" v-model="formSesion.instrucciones_estudiante"
                                    label="Instrucciones del estudiante" required variant="outlined" auto-grow></v-textarea>
                    </div>
                    <div>
                        <v-textarea type="text" v-model="formSesion.instrucciones_docente"
                                    label="Instrucciones del docente" required variant="outlined" auto-grow></v-textarea>
                    </div>
                    <!-- Agrega aquí más campos si lo deseas -->
                </v-card-text>
                <v-card-actions>
                    <v-spacer />
                    <v-btn color="blue darken-1" text @click="dialog = false">Cerrar
                    </v-btn>
                    <v-btn color="blue darken-1" text @click="updateDialogSesion()">Actualizar
                    </v-btn>
                </v-card-actions>
            </v-form>
        </v-card>
    </v-dialog>

    <v-container>

        <Head title="Editar proyecto" />
        <h2>Impulsa</h2>
        {{ formSesion.instrucciones_docente }}
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
        <v-card :disabled="loading" :loading="loading" class="mx-auto my-1" max-width="874">
            <h1>Editar proyecto</h1>
            <v-row justify="center" class="mx-auto">
                <v-container>
                    <v-form @submit.prevent="updateForm" class="mx-auto my-1">
                        <v-row>
                            <v-col cols="12">
                                <v-text-field clearable type="text" v-model="form.nombre" label="Nombre del proyecto"
                                              required></v-text-field>
                            </v-col>
                        </v-row>

                        <v-row>
                            <v-col cols="4">
                                <v-select v-model="form.nivel" :items="niveles" :rules="[(v) => !!v || 'es requerido']"
                                          label="Nivel" required></v-select>
                            </v-col>
                            <v-col cols="4">
                                <v-select v-model="form.grado_escolar" :items="grados"
                                          :rules="[(v) => !!v || 'es requerido']" label="Grado" required></v-select>
                            </v-col>
                            <v-col cols="4">
                                <v-select v-model="form.metodologias" :items="metodologiasData" item-title="name"
                                          item-value="id" label="Metodología" return-object multiple
                                          persistent-hint></v-select>
                            </v-col>
                        </v-row>

                        <v-row>
                            <v-col cols="6">
                                <v-select v-model="form.campoFormativo" :items="camposFormativosData" item-title="name"
                                          item-value="id" label="Campo formativo" return-object multiple
                                          persistent-hint></v-select>
                            </v-col>
                            <v-col cols="6">
                                <v-select v-model="form.disciplinas_selected" :items="disciplinasData" item-title="name"
                                          item-value="id" label="Disciplinas" return-object multiple
                                          persistent-hint></v-select>
                            </v-col>
                        </v-row>

                        <v-row>
                            <v-col cols="6">
                                <v-select v-model="form.area_conocimientos" :items="areasConocimientosData"
                                          item-title="name" item-value="id" label="Área de conocimientos" return-object
                                          multiple persistent-hint></v-select>
                            </v-col>
                            <v-col cols="6">
                                <v-select v-model="form.unidad_aprendizaje_selected" :items="unidadesAprendizajeData"
                                          item-title="name" item-value="id" label="Unidad de aprendizaje:" return-object
                                          multiple persistent-hint></v-select>
                            </v-col>
                        </v-row>

                        <v-row>
                            <v-col cols="12">
                                <v-textarea clearable type="text" v-model="form.descripcion"
                                            label="Descripción del proyecto" required></v-textarea>
                            </v-col>
                        </v-row>

                        <v-row>
                            <v-col cols="12">
                                <v-textarea clearable type="text" v-model="form.contenido"
                                            label="Contenido del proyecto" required></v-textarea>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12">
                                <v-textarea clearable type="text" v-model="form.proceso_desarrollo_aprendizaje
                                " label="Proceso de desarrollo de aprendizaje" required></v-textarea>
                            </v-col>
                        </v-row>

                        <div class="d-flex justify-end">
                            <v-btn color="success" class="mr-3" @click="updateForm">
                                Guardar
                                <v-icon icon="mdi-check" end></v-icon>
                            </v-btn>
                        </div>
                    </v-form>
                </v-container>
            </v-row>
            <v-row>
                <v-col cols="12">
                    <v-data-table :headers="headers" :items="project.project_session" item-value="id"
                                  hide-default-footer show-expand dense class="custom-table">
                        <template v-slot:item.instrucciones_estudiante="{ item }">
                            <td class="text-justify">
                                {{ item.instrucciones_estudiante }}
                            </td>
                        </template>
                        <template v-slot:item.acciones="{ item }">
                            <v-btn color="primary" variant="flat" size="small" @click="goToSession(project.id, item)">
                                Editar
                            </v-btn>
                        </template>
                        <template v-slot:item.data-table-expand="{
                            internalItem,
                            isExpanded,
                            toggleExpand,
                        }">
                            <v-btn :append-icon="isExpanded(internalItem)
                                       ? 'mdi-chevron-up'
                                       : 'mdi-chevron-down'
                                   " :text="isExpanded(internalItem)
                                       ? 'cerrar'
                                       : 'Materiales'
                                   " class="text-none wrap-text" color="medium-emphasis" size="small" variant="text"
                                   border slim @click="toggleExpand(internalItem)"></v-btn>
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
                                                </tr>
                                            </tbody>

                                            <tbody>
                                                <tr v-for="(
                                                    material, index
                                                ) in item.materials" :key="index">
                                                    <!--                                                    <td>
                                            <a
                                                :href="
                                                    material.liga
                                                "
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                class="text-primary wrap-text text-decoration-underline"
                                            >
                                                {{
                                                    material.nombre_material
                                                }}
                                            </a>
                                        </td>-->
                                                    <td>
                                                        <v-btn variant="text"
                                                               class="text-primary wrap-text text-decoration-underline"
                                                               @click="
                                                                   abrirModal(
                                                                       material,
                                                                   )
                                                               ">
                                                            {{
                                                                material.nombre_material
                                                            }}
                                                        </v-btn>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </v-table>
                                    </v-sheet>
                                </td>
                            </tr>
                        </template>
                    </v-data-table>
                </v-col>
            </v-row>
        </v-card>
    </v-container>
</template>

<style scoped>
.custom-table tbody tr:nth-child(even) {
    background-color: #f5f5f5;
    /* Cambia el color si deseas otro */
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
