<script setup>
import { Head, router } from "@inertiajs/vue3";
import { debounce } from "lodash";
import { computed, ref, watch } from "vue";


const props = defineProps({
  projects: {
    type: Array,
    default: () => [],
  },
  metodologiasData: {
    type: Array,
    default: () => [],
  },
  camposformativosData: {
    type: Array,
    default: () => [],
  },
  disciplinasData: {
    type: Array,
    default: () => [],
  },
  projectNombre: {
    type: String,
    default: '',
  },
  metodologias: {
    type: Array,
    default: () => [],
  },
   
  camposFormativos: {
    type: Array,
    default: () => [],
  },
  nivel: {
    type: String,
    default: '',
  },
  disciplinas: {
    type: Array,
    default: () => [],
  },
  unidadAprendizajes: {
    type: Array,
    default: () => [],
  },
  unidadAprendizajesData: {
    type: Array,
    default: () => [],
  },
  areaconocimientos: {
    type: Array,
    default: () => [],
  },
  areaconocimientosData: {
    type: Array,
    default: () => [],
  },
  idioma: {
    type: String,
    default: '',
  },
});


const selectedprojectNombre = ref(props.projectNombre);
const selectedMetodologias = ref(props.metodologias);
const selectedCamposFormativos = ref(props.camposFormativos);
const selectedDisciplinas = ref(props.disciplinas);
const selectedNivel = ref(props.nivel);
const selectedUnidadAprendizaje = ref(props.unidadAprendizajes);
const selectedAreaconocimiento = ref(props.areaconocimientos);
const selectedIdioma = ref(props.idioma);


const breadcrumbs = ref([
    { text: "Inicio ", disabled: false, to: "projects.index" },
    { text: "Proyectos ", disabled: true },
]);

const searchProjects = debounce(() => {
    isLoading.value = true;
    router.get(
        // eslint-disable-next-line
        route("project.index", {
            _query: {
                projectNombre: selectedprojectNombre.value,
                metodologias: selectedMetodologias.value,
                campos_formativos: selectedCamposFormativos.value,
                disciplinas: selectedDisciplinas.value,
                unidadAprendizajes: selectedUnidadAprendizaje.value,
                areaConocimientos: selectedAreaconocimiento.value,
                idioma: selectedIdioma.value,
                nivel: selectedNivel.value,
            },
        }),
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
            onFinish: () => {
                isLoading.value = false;
            },
        },
    );
}, 800);
watch(selectedprojectNombre, searchProjects);

watch(selectedMetodologias, () => {
    isLoading.value = true;

    router.get(
        // eslint-disable-next-line
        route("project.index"),
        {
            projectNombre: selectedprojectNombre.value,
            metodologias: selectedMetodologias.value,
            campos_formativos: selectedCamposFormativos.value,
            nivel: selectedNivel.value,
            disciplinas: selectedDisciplinas.value,
            unidadAprendizajes: selectedUnidadAprendizaje.value,
            areaConocimientos: selectedAreaconocimiento.value,
            idioma: selectedIdioma.value,
            page: currentPage.value,
        },
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
            onFinish: () => {
                isLoading.value = false;
            },
        },
    );
});

watch(selectedCamposFormativos, () => {
    isLoading.value = true;

    router.get(
        // eslint-disable-next-line
        route("project.index"),
        {
            projectNombre: selectedprojectNombre.value,
            metodologias: selectedMetodologias.value,
            campos_formativos: selectedCamposFormativos.value,
            nivel: selectedNivel.value,
            disciplinas: selectedDisciplinas.value,
            unidadAprendizajes: selectedUnidadAprendizaje.value,
            areaConocimientos: selectedAreaconocimiento.value,
            idioma: selectedIdioma.value,
            page: currentPage.value,
        },
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
            onFinish: () => {
                isLoading.value = false;
            },
        },
    );
});

watch(selectedNivel, () => {
    isLoading.value = true;

    const nivel = nivelUnico.value;

    if (nivel === "Primaria") {
        selectedAreaconocimiento.value = [];
        selectedUnidadAprendizaje.value = [];
        selectedDisciplinas.value = [];
    }

    if (nivel === "Secundaria") {
        selectedAreaconocimiento.value = [];
        selectedUnidadAprendizaje.value = [];
    }

    if (nivel === "Bachillerato") {
        selectedCamposFormativos.value = [];
        selectedDisciplinas.value = [];
    }

    router.get(
        // eslint-disable-next-line
        route("project.index"),
        {
            projectNombre: selectedprojectNombre.value,
            metodologias: selectedMetodologias.value,
            campos_formativos: selectedCamposFormativos.value,
            nivel: selectedNivel.value,
            disciplinas: selectedDisciplinas.value,
            unidadAprendizajes: selectedUnidadAprendizaje.value,
            areaConocimientos: selectedAreaconocimiento.value,
            idioma: selectedIdioma.value,
            page: currentPage.value,
        },
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
            onFinish: () => {
                isLoading.value = false;
            },
        },
    );
});

watch(selectedIdioma, () => {
    isLoading.value = true;

    router.get(
        // eslint-disable-next-line no-undef
        route("project.index"),
        {
            projectNombre: selectedprojectNombre.value,
            metodologias: selectedMetodologias.value,
            campos_formativos: selectedCamposFormativos.value,
            nivel: selectedNivel.value,
            disciplinas: selectedDisciplinas.value,
            unidadAprendizajes: selectedUnidadAprendizaje.value,
            areaConocimientos: selectedAreaconocimiento.value,
            idioma: selectedIdioma.value,
            page: currentPage.value,
        },
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
            onFinish: () => {
                isLoading.value = false;
            },
        },
    );
});

watch(selectedDisciplinas, () => {
    isLoading.value = true;

    router.get(
        // eslint-disable-next-line no-undef
        route("project.index"),
        {
            projectNombre: selectedprojectNombre.value,
            metodologias: selectedMetodologias.value,
            campos_formativos: selectedCamposFormativos.value,
            nivel: selectedNivel.value,
            disciplinas: selectedDisciplinas.value,
            unidadAprendizajes: selectedUnidadAprendizaje.value,
            areaConocimientos: selectedAreaconocimiento.value,
            idioma: selectedIdioma.value,
            page: currentPage.value,
        },
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
            onFinish: () => {
                isLoading.value = false;
            },
        },
    );
});

watch(selectedUnidadAprendizaje, () => {
    isLoading.value = true;

    router.get(
        // eslint-disable-next-line
        route("project.index"),
        {
            projectNombre: selectedprojectNombre.value,
            metodologias: selectedMetodologias.value,
            campos_formativos: selectedCamposFormativos.value,
            nivel: selectedNivel.value,
            disciplinas: selectedDisciplinas.value,
            unidadAprendizajes: selectedUnidadAprendizaje.value,
            areaConocimientos: selectedAreaconocimiento.value,
            idioma: selectedIdioma.value,
            page: currentPage.value,
        },
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
            onFinish: () => {
                isLoading.value = false;
            },
        },
    );
});

watch(selectedAreaconocimiento, () => {
    isLoading.value = true;

    router.get(
        // eslint-disable-next-line
        route("project.index"),
        {
            projectNombre: selectedprojectNombre.value,
            metodologias: selectedMetodologias.value,
            campos_formativos: selectedCamposFormativos.value,
            nivel: selectedNivel.value,
            disciplinas: selectedDisciplinas.value,
            unidadAprendizajes: selectedUnidadAprendizaje.value,
            areaConocimientos: selectedAreaconocimiento.value,
            idioma: selectedIdioma.value,
            page: currentPage.value,
        },
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
            onFinish: () => {
                isLoading.value = false;
            },
        },
    );
});

const formattedMetodologias = computed(() => {
    return props.metodologiasData.map((metodologiasData) => {
        return {
            title: `${metodologiasData.name}`,
            value: metodologiasData.id,
        };
    });
});

const formattedCamposformativos = computed(() => {
    const originales = props.camposformativosData.map((c) => ({
        title: c.name,
        value: c.id,
        name: c.name,
    }));

    if (nivelUnico.value === "Primaria" || nivelUnico.value === "Secundaria") {
        return originales.filter((item) =>
            camposFormativosPermitidosPrimariaSecundaria.includes(item.name),
        );
    }

    return originales;
});

const formattedDisciplinas = computed(() => {
    const todas = props.disciplinasData.map((d) => ({
        title: d.name,
        value: d.id,
        name: d.name,
    }));

    if (nivelUnico.value !== "Secundaria") return todas;

    const mapaCampos = {
        Lenguajes: ["Español", "Inglés", "Artes"],
        "Sáberes y pensamiento científico": [
            "Matemáticas",
            "Biología",
            "Física",
            "Química",
        ],
        "Ética, naturaleza y sociedades": [
            "Geografía",
            "Historia",
            "Formación Cívica y Ética",
        ],
        "De lo humano y lo comunitario": [
            "Tecnología",
            "Educación Física",
            "Educación Socioemocional/Tutoría",
        ],
    };

    if (!campoFormativoUnico.value) return [];

    const campoNombre = props.camposformativosData.find(
        (cf) => cf.id === campoFormativoUnico.value,
    )?.name;

    const permitidos = mapaCampos[campoNombre] ?? [];
    return todas.filter((d) => permitidos.includes(d.name));
});

const formattedAreaconocimientosData = computed(() => {
    return props.areaconocimientosData.map((areaconocimientosData) => {
        return {
            title: `${areaconocimientosData.name}`,
            value: areaconocimientosData.id,
        };
    });
});

const opcionesNivel = [
    { title: "Primaria", value: "Primaria" },
    { title: "Secundaria", value: "Secundaria" },
    { title: "Bachillerato", value: "Bachillerato" },
];

const opcionesIdioma = [
    { title: "Español", value: "Español" },
    { title: "Inglés", value: "Inglés" },
];

let goToProjectDetail = (project) => {
    // eslint-disable-next-line
    router.visit(route("project.show", { project: project }));
};

const currentPage = ref(props.projects.current_page);

watch(currentPage, (page) => {
    if (page === props.projects.current_page) return;

    router.get(
        // eslint-disable-next-line
        route("project.index"),
        {
            projectNombre: selectedprojectNombre.value,
            metodologias: selectedMetodologias.value,
            campos_formativos: selectedCamposFormativos.value,
            nivel: selectedNivel.value,
            page: page,
        },
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        },
    );
});

const isLoading = ref(false);

watch(currentPage, (page) => {
    if (page === props.projects.current_page) return;

    isLoading.value = true;

    router.get(
        // eslint-disable-next-line
        route("project.index"),
        {
            projectNombre: selectedprojectNombre.value,
            metodologias: selectedMetodologias.value,
            campos_formativos: selectedCamposFormativos.value,
            nivel: selectedNivel.value,
            page: page,
        },
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
            onFinish: () => {
                isLoading.value = false;
            },
        },
    );
});

const nivelUnico = computed(() => {
    return Array.isArray(selectedNivel.value) &&
        selectedNivel.value.length === 1
        ? selectedNivel.value[0]
        : null;
});

const campoFormativoUnico = computed(() => {
    return Array.isArray(selectedCamposFormativos.value) &&
        selectedCamposFormativos.value.length === 1
        ? selectedCamposFormativos.value[0]
        : null;
});

const camposFormativosPermitidosPrimariaSecundaria = [
    "Lenguajes",
    "Sáberes y pensamiento científico",
    "Ética, naturaleza y sociedades",
    "De lo humano y lo comunitario",
];

const formattedUnidadAprendizajes = computed(() => {
    const mapeo = {
        "Ciencias Sociales": [
            "Ciencias Sociales I",
            "Ciencias Sociales II",
            "Ciencias Sociales III",
        ],
        "Conciencia Histórica": [
            "Conciencia Histórica I",
            "Conciencia Histórica II",
            "Conciencia Histórica III",
        ],
        Humanidades: ["Humanidades I", "Humanidades II", "Humanidades III"],
        "Lengua y Comunicación": [
            "Lengua y Comunicación I",
            "Lengua y comunicación II",
            "Lengua y Comunicación III",
        ],
        "Ciencias naturales, experimentales y tecnología": [
            "La materia y sus interacciones CENEYT I",
            "Conservación de la energía y sus interacciones con la material CNEYT II",
            "Ecosistema, interacciones, energía y dinámica CNEYT III",
            "Reacciones químicas conservación de la materia en la formación de nuevas sustancias CNEYT IV",
            "La energía en los procesos de la vida CNEYT V",
            "Organismos, estructuras y procesos. Herencia y evolución biológica CNEYT VI",
        ],
        "Pensamiento Matemático": [
            "Pensamiento Matemático I",
            "Pensamiento Matemático II",
            "Pensamiento Matemático III",
        ],
        "Cultura Digital": [
            "Cultura DIgital I",
            "Cultura Digital II",
            "Cultura digital III",
        ],
        Inglés: [
            "Inglés I",
            "Inglés II",
            "Inglés III",
            "Inglés IV",
            "Inglés V",
            "Inglés VI",
        ],
    };

    const todas = props.unidadAprendizajesData.map((ua) => ({
        title: ua.name,
        value: ua.id,
        name: ua.name,
    }));

    if (nivelUnico.value !== "Bachillerato") return todas;

    // Si no hay área seleccionada aún, no mostrar nada
    if (
        !Array.isArray(selectedAreaconocimiento.value) ||
        selectedAreaconocimiento.value.length === 0
    ) {
        return [];
    }

    const nombresSeleccionados = props.areaconocimientosData
        .filter((a) => selectedAreaconocimiento.value.includes(a.id))
        .map((a) => a.name);

    const permitidos = nombresSeleccionados.flatMap(
        (nombre) => mapeo[nombre] || [],
    );

    return todas.filter((ua) => permitidos.includes(ua.name));
});
</script>

<template>
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

        <v-row class="mt-4">
            <v-col cols="12">
                <v-text-field v-model="selectedprojectNombre" label="Buscar proyectos"
                              placeholder="Escribe para buscar..." clearable variant="underlined" full-width
                              prepend-inner-icon="mdi-magnify"></v-text-field>
            </v-col>
        </v-row>

        <v-row>
            <v-col cols="2">
                <v-autocomplete v-model="selectedIdioma" variant="underlined" clearable class="" :items="opcionesIdioma"
                                label="Idioma"></v-autocomplete>
            </v-col>
            <v-col cols="3">
                <v-autocomplete v-model="selectedNivel" chips variant="underlined" clearable class=""
                                :items="opcionesNivel" label="Nivel" multiple></v-autocomplete>
            </v-col>
            <v-col cols="3">
                <v-autocomplete v-model="selectedMetodologias" chips variant="underlined" clearable class=""
                                :items="formattedMetodologias" label="Metodologías" multiple></v-autocomplete>
            </v-col>
            <v-col cols="4">
                <v-autocomplete v-model="selectedCamposFormativos" variant="underlined" chips clearable class=""
                                :items="formattedCamposformativos" :disabled="nivelUnico !== 'Primaria' && nivelUnico !== 'Secundaria'
                                " label="Campos Formativos" multiple></v-autocomplete>
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="4">
                <v-autocomplete v-model="selectedDisciplinas" variant="underlined" chips clearable class=""
                                :items="formattedDisciplinas" :disabled="nivelUnico !== 'Secundaria'" label="Disciplinas"
                                multiple></v-autocomplete>
            </v-col>
            <v-col cols="4">
                <v-autocomplete variant="underlined" v-model="selectedAreaconocimiento" chips clearable class=""
                                :items="formattedAreaconocimientosData" :disabled="nivelUnico !== 'Bachillerato'"
                                label="Area de conocimientos" multiple></v-autocomplete>
            </v-col>
            <v-col cols="4">
                <v-autocomplete v-model="selectedUnidadAprendizaje" variant="underlined" chips clearable class=""
                                :items="formattedUnidadAprendizajes" :disabled="nivelUnico !== 'Bachillerato' ||
                                    selectedAreaconocimiento.length === 0
                                " label="Unidad de Aprendizaje" multiple></v-autocomplete>
            </v-col>
        </v-row>

        <!-- Listado de proyectos -->
        <v-row>
            <v-col cols="12">
                <v-card-title> Proyectos actuales</v-card-title>
                <v-card flat border>
                    <v-card-text>
                        <v-row justify="center" v-if="isLoading" class="my-8">
                            <v-progress-circular indeterminate color="primary" size="48"></v-progress-circular>
                        </v-row>

                        <transition name="fade">
                            <v-row v-if="!isLoading">
                                <v-list>
                                    <v-list-item v-for="project in projects.data" :key="project.id"
                                                 class="mb-4 project-item" @click="goToProjectDetail(project)">
                                        <v-chip v-for="metodologia in project.metodologias" :key="metodologia.id"
                                                class="ma-1" color="red" label size="x-small" variant="outlined">
                                            {{ metodologia.name }}
                                        </v-chip>

                                        <v-chip size="x-small" v-for="disciplina in project.disciplinas"
                                                :key="disciplina.id" class="ma-1" color="teal" small>
                                            {{ disciplina.name }}
                                        </v-chip>

                                        <v-chip size="x-small" v-for="unidadAprendizaje in project.unidades_aprendizaje"
                                                :key="unidadAprendizaje.id" class="ma-1" color="pink" small>
                                            {{ unidadAprendizaje.name }}
                                        </v-chip>

                                        <template v-slot:prepend>
                                            <div class="estilo_imagen_centrada me-4">
                                                <v-img :src="project.url_location_file
                                                       " height="220" width="340"
                                                       class="rounded-lg object-fit-cover"></v-img>
                                            </div>
                                        </template>

                                        <!-- Detalles del proyecto -->
                                        <v-list-item-content>
                                            <v-list-item-title class="my-2 d-flex align-center">
                                                <!-- Nombre del proyecto -->
                                                <h2 class="me-4 mb-0">
                                                    {{ project.nombre }}
                                                </h2>

                                                <!-- Íconos de ejes articuladores -->
                                                <div class="d-flex align-center flex-wrap">
                                                    <v-img v-for="eje in project.ejes_articuladores" :key="eje.id"
                                                           :src="`/images/ejes_articuladores/${eje.image_url}`" width="32"
                                                           height="32" class="rounded-circle me-2" cover
                                                           :alt="`${eje.name}`"></v-img>
                                                </div>
                                            </v-list-item-title>
                                            <v-list-item-subtitle>
                                                {{ project.descripcion }}
                                            </v-list-item-subtitle>
                                            <v-list-item-subtitle>
                                                <small>
                                                    Nivel:
                                                    {{ project.nivel }}</small>
                                            </v-list-item-subtitle>
                                        </v-list-item-content>

                                        <v-chip v-for="campo in project.campo_formativos" :key="campo.id" class="ma-1"
                                                color="secondary" size="x-small">
                                            {{ campo.name }}
                                        </v-chip>

                                        <v-chip size="x-small" variant="flat"
                                                v-for="areaconocimiento in project.area_conocimientos"
                                                :key="areaconocimiento.id" class="ma-1" color="blue" small>
                                            {{ areaconocimiento.name }}
                                        </v-chip>
                                    </v-list-item>
                                </v-list>
                            </v-row>
                        </transition>
                        <v-row justify="center" class="mt-4">
                            <v-chip variant="outlined" color="primary">
                                Mostrando {{ projects.from }} -
                                {{ projects.to }} de
                                {{ projects.total }} proyectos
                            </v-chip>
                        </v-row>
                        <v-row justify="center" class="mt-6">
                            <v-pagination v-model="currentPage" :length="projects.last_page" :total-visible="5"
                                          color="primary" rounded prev-icon="mdi-chevron-left" next-icon="mdi-chevron-right"
                                          elevation="1"></v-pagination>
                        </v-row>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
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

.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
