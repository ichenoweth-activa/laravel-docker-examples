<script setup>
import { Head, router } from "@inertiajs/vue3";
import { VContainer, VRow, VCol, VBtn } from "vuetify/components";

const createInstructor = () => {
    // eslint-disable-next-line
    router.visit(route("users.create"));
};
</script>

<template>
    <v-container>
        <Head title="Usuarios" />
        <v-row>
            <v-col cols="12" md="6">
                <div class="my-jumbotron">
                    <h1>Regístrar como instructora</h1>
                    <p class="mb-3 subtitle-1">
                        Universitarias de 18 a 24 años que se encuentren
                        estudiando una carrera STEM.
                    </p>
                    <v-btn
                        @click="createInstructor()"
                        class="mt-5"
                        append-icon="mdi-human-female-girl"
                        color="primary"
                        large
                    >
                        Crear
                    </v-btn>
                </div>
            </v-col>

            <v-col cols="12" md="6">
                <div class="my-jumbotron">
                    <h1>Regístrar como alumna</h1>
                    <p class="mb-3 subtitle-1">
                        Niñas y adolescentes de 12 y 17 años, que cursen la
                        secundaria.
                    </p>
                    <v-btn
                        class="mt-5"
                        append-icon="mdi-face-woman-shimmer-outline"
                        color="secondary"
                        large
                    >
                        Crear
                    </v-btn>
                </div>
            </v-col>
        </v-row>
    </v-container>
</template>
<style>
.my-jumbotron {
    height: auto;
    padding: 20px;
    margin: 10px;
    background-color: #eee;
    border-radius: 8px;
    text-align: center;
}
</style>
