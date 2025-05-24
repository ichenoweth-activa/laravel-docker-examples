<script>
import { Bubble } from "vue-chartjs";
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    LinearScale,
    PointElement,
} from "chart.js";

ChartJS.register(Title, Tooltip, Legend, LinearScale, PointElement);

export default {
    name: "BubbleChart",
    components: { Bubble },
    props: {
        dataset: {
            type: Array,
            default: () => [],
        },
    },
    setup(props) {
        const chartData = {
            datasets: props.dataset,
        };

        const chartOptions = {};

        return { chartData, chartOptions };
    },
};
</script>

<template>
    <Bubble :data="chartData" :options="chartOptions" />
</template>
