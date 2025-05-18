<script>
import { Bar } from "vue-chartjs";
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale,
} from "chart.js";

ChartJS.register(
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale,
);

export default {
    name: "BarChart",
    components: { Bar },
    props: {
        labels: {
            type: Array,
            default: () => [],
        },
        data: {
            type: Array,
            default: () => [],
        },
        label: {
            type: String,
            default: "",
        },
        horizontal: {
            type: Boolean,
            default: false,
        }
    },
    data() {
        return {
            chartData: {
                labels: this.labels,
                datasets: [
                    {
                        label: this.label,
                        data: this.data,
                        backgroundColor: [
                            "rgba(255,79,187,255)",
                            "rgba(105,53,142,255)",
                            "rgba(255,145,77,255)",
                        ],
                        borderColor: [
                            "rgba(255,79,187,255)",
                            "rgba(105,53,142,255)",
                            "rgba(255,145,77,255)",
                        ],
                        borderWidth: 1,
                    },
                ],
            },
            chartOptions: {
                responsive: true,
                indexAxis: this.horizontal ? "y" : "x", // Configura el eje basado en la propiedad horizontal
                plugins: {
                    legend: {
                        display: true,
                    },
                    title: {
                        display: true,
                        text: this.label,
                    },
                },
            },
        };
    },
};
</script>

<template>
    <Bar :id="`my-chart-id-${horizontal ? 'horizontal' : 'vertical'}`" :options="chartOptions" :data="chartData" />
</template>
