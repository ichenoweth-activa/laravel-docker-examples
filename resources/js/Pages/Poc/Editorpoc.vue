<script setup>
import MyEditor from "../../Components/MyEditor.vue";
import { Head,useForm } from "@inertiajs/vue3";

const form = useForm({
    contenido: "",
    title: "probando editor desde form",
});
</script>

<template>
    <Head title="Editr prueba" />

    <v-row>
        <v-col cols="12">
            <h1>{{ form.title }}</h1>
        </v-col>
    </v-row>

    <v-row>
        <v-col cols="12">
            <MyEditor v-model="form.contenido" />
        </v-col>
    </v-row>
</template>
