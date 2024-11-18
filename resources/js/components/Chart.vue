<template>
    <div class="chart-container">
        <canvas ref="chartCanvas"></canvas>
    </div>
</template>

<script>
import { toRaw } from "vue";
import Chart from "chart.js/auto";

export default {
    props: {
        chartType: {
            type: String,
            required: true,
        },
        chartData: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            chartInstance: null,
        };
    },
    methods: {
        createChart() {
            if (this.chartInstance) {
                this.chartInstance.destroy(); // Destroi o gráfico antigo
            }

            const ctx = this.$refs.chartCanvas.getContext("2d");
            const rawData = toRaw(this.chartData); // Evita referências reativas

            this.chartInstance = new Chart(ctx, {
                type: this.chartType,
                data: rawData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false, // Evita distorções no tamanho
                    plugins: {
                        legend: {
                            display: true,
                            position: "top",
                        },
                    },
                },
            });
        },
    },
    mounted() {
        this.createChart();
    },
    watch: {
        chartData: {
            deep: true,
            handler() {
                this.createChart();
            },
        },
    },
    beforeUnmount() {
        if (this.chartInstance) {
            this.chartInstance.destroy();
        }
    },
};
</script>

<style scoped>
.chart-container {
    position: relative;
    height: 400px;
    width: 100%;
}
</style>
