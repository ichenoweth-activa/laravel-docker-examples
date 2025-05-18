<script>
import { Radar } from "vue-chartjs";
import {
    Chart as ChartJS,
    RadialLinearScale,
    PointElement,
    LineElement,
    Filler,
    Tooltip,
    Legend,
} from "chart.js";

ChartJS.register(
    RadialLinearScale,
    PointElement,
    LineElement,
    Filler,
    Tooltip,
    Legend,
);

export default {
    name: "RadarChart",
    components: { Radar },
    props: {
        labels: {
            type: Array,
            default: () => [],
        },
        datasets:{
            type: Array,
            default: () => [],
        },
    },
    setup(props) {
        const chartData = {
            labels: props.labels,
            datasets: props.datasets,
        };

        const chartOptions = {
            elements: {
                line: {
                    borderWidth: 3,
                },
            },
        };

        return { chartData, chartOptions };
    },
};
</script>

<template>
    <Radar :data="chartData" :options="chartOptions" />
</template>
