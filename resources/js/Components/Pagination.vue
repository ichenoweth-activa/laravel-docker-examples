<!-- resources/js/Components/Pagination.vue -->
<script setup>
import { router } from "@inertiajs/vue3";

defineProps({
    links: {
        type: Array,
        default: () => [],
    }
});

const navigate = (link) => {
    if (!link.url || link.active) return;

    router.get(
        link.url,
        {},
        {
            preserveScroll: true,
            preserveState: true,
        },
    );
};
</script>

<template>
    <nav class="pagination-nav" aria-label="Pagination">
        <ul class="pagination-list">
            <li v-for="(link, index) in links" :key="index" class="pagination-item"
                :class="{ 'is-active': link.active, 'is-disabled': !link.url }">
                <button v-html="link.label" @click="navigate(link)" :disabled="!link.url" />
            </li>
        </ul>
    </nav>
</template>

<style scoped>
.pagination-list {
    display: flex;
    list-style: none;
    padding: 0;
}

.pagination-item {
    margin: 0 4px;
}

button {
    padding: 6px 12px;
    border: none;
    border-radius: 4px;
    background-color: transparent;
    cursor: pointer;
    font-size: 0.9rem;
}

button:hover {
    background-color: #eee;
}

.is-active button {
    background-color: #1976d2;
    color: white;
    font-weight: bold;
}

.is-disabled button {
    cursor: not-allowed;
    opacity: 0.5;
}
</style>
