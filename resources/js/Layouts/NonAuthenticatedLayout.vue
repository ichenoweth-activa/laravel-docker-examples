<script setup>

import { usePage } from "@inertiajs/vue3";
import { computed, watch } from "vue";
import { useToast } from "vue-toastification";

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
</script>

<template>
    <v-app id="inspire" key="inspire">
        <v-layout class="rounded rounded-lg">
            <v-main class="d-flex justify-center" style="min-height: 300px">
                <v-container>
                    <slot />
                </v-container>
            </v-main>
        </v-layout>
    </v-app>
</template>
