<script>
import { Line } from "vue-chartjs";
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    LineElement,
    CategoryScale,
    LinearScale,
    PointElement,
} from "chart.js";

ChartJS.register(
    Title,
    Tooltip,
    Legend,
    LineElement,
    CategoryScale,
    LinearScale,
    PointElement,
);

export default {
    name: "LineChart",
    components: { Line },
    props: {
        labels: {
            type: Array,
            default: () => [],
        },
        data: {
            type: Array,
            default: () => [],
        },
        dataPreviousYear: {
            type: Array,
            default: () => [],
        },
        label: {
            type: String,
            default: '',
        },
        labelPreviousYear: {
            type: String,
            default: '',
        },
    }
    ,
    data() {
        return {
            chartData: {
                labels: this.labels,
                datasets: [
                    {
                        label: this.label,
                        data: this.data,
                        fill: false,
                        borderColor: "#6a348d",
                        tension: 0.1,
                    },
                    {
                        label: this.labelPreviousYear,
                        data: this.dataPreviousYear,
                        fill: false,
                        borderColor: "#ff8bc7",
                        tension: 0.1,
                    },
                ],
            },
            chartOptions: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                    },
                    title: {
                        display: true,
                        text: "Comparativo de Alumnas por Mes",
                    },
                },
            },
        };
    },
};
</script>

<template>
    <Line :options="chartOptions" :data="chartData" />
</template>
