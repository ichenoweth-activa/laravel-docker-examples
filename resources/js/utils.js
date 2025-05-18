import { usePage } from "@inertiajs/vue3";
export function getQuery() {
    let query = usePage().props.ziggy.query;
    return query;
}
