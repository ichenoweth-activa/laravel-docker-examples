<script>
import { Pie } from "vue-chartjs";
import { Chart as ChartJS, Title, Tooltip, Legend, ArcElement } from "chart.js";

ChartJS.register(Title, Tooltip, Legend, ArcElement);

export default {
    name: "PieChart",
    components: { Pie },
    props: {
        labels: {
            type: Array,
            default: () => [],
        },
        data: {
            type: Array,
            default: () => [],
        },
        backgroundColors:{
            type: Array,
            default: () => [],
        },
    },
    data() {
        return {
            chartData: {
                labels: this.labels,
                datasets: [
                    {
                        data: this.data,
                        backgroundColor: this.backgroundColors,
                        hoverOffset: 4,
                    },
                ],
            },
            chartOptions: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: "top",
                    },
                    title: {
                        display: true,
                        text: "Pie Chart Visualization",
                    },
                },
            },
        };
    },
};
</script>

<template>
    <Pie :options="chartOptions" :data="chartData" />
</template>
