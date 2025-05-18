<script>
import { PolarArea } from "vue-chartjs";
import { Chart as ChartJS, ArcElement, Tooltip, Legend } from "chart.js";

ChartJS.register(ArcElement, Tooltip, Legend);

export default {
    name: "PolarAreaChart",
    components: { PolarArea },
    props: {
        labels: {
            type: Array,
            default: () => [],
        },
        datasets: {
            type: Array,
            default: () => [],
        },
    },
    setup(props) {
        const chartData = {
            labels: props.labels,
            datasets: props.datasets,
        };

        const chartOptions = {};

        return { chartData, chartOptions };
    },
};
</script>

<template>
    <PolarArea :data="chartData" :options="chartOptions" />
</template>
