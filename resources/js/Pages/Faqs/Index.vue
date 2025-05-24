<script setup>
import { Head } from "@inertiajs/vue3";
import { ref } from "vue";

const breadcrumbs = ref([
    { text: "Inicio ", disabled: false, to: "projects.index" },
    { text: "Preguntas frecuentes ", disabled: true },
]);

const faqs = ref([
    {
        emoji: "📚",
        question: "¿Qué es Impulsa?",
        answer: "Alejandría es una plataforma diseñada para apoyar a docentes en la planificación de proyectos educativos interdisciplinarios.",
    },
    {
        emoji: "🔐",
        question: "¿Necesito una cuenta para usar la plataforma?",
        answer: "Sí, debes contar con una cuenta activa validada por tu institución educativa.",
    },
    {
        emoji: "✏️",
        question: "¿Puedo editar un proyecto ya creado?",
        answer: "Sí, puedes editar tus propios proyectos o hacer una copia de otros proyectos públicos y personalizarlos.",
    },
    {
        emoji: "🎓",
        question: "¿Qué niveles educativos están soportados?",
        answer: "Actualmente, la plataforma soporta proyectos para Primaria, Secundaria y Bachillerato.",
    },
    {
        emoji: "☁️",
        question: "¿Dónde se almacenan los archivos de los proyectos?",
        answer: "Todos los materiales y documentos se almacenan de forma segura en Google Cloud Storage.",
    },
]);
</script>

<template>
    <v-container>

        <Head title="Inicio" />

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

        <v-row justify="center">
            <v-col cols="12" md="10" lg="8">
                <h2 class="text-h4 font-weight-bold mb-6 text-center">
                    ❓ Preguntas Frecuentes
                </h2>

                <v-expansion-panels variant="accordion" class="faq-panel">
                    <v-expansion-panel v-for="(faq, index) in faqs" :key="index" elevation="1" class="mb-2">
                        <v-expansion-panel-title class="faq-title">
                            <span class="faq-emoji">{{ faq.emoji }}</span>
                            <span>{{ faq.question }}</span>
                        </v-expansion-panel-title>
                        <v-expansion-panel-text class="faq-text">
                            {{ faq.answer }}
                        </v-expansion-panel-text>
                    </v-expansion-panel>
                </v-expansion-panels>
            </v-col>
        </v-row>
    </v-container>
</template>

<style scoped>
h2 {
    color: #2c3e50;
}

.faq-panel {
    background-color: #fafafa;
    border-radius: 8px;
}

.faq-title {
    font-weight: 600;
    font-size: 1.1rem;
    display: flex;
    align-items: center;
    gap: 10px;
}

.faq-emoji {
    font-size: 1.3rem;
}

.faq-text {
    font-size: 0.95rem;
    color: #444;
    line-height: 1.5;
}
</style>
