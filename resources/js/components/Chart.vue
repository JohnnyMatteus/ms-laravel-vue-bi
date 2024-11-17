<template>
    <div>
        <canvas ref="chartCanvas"></canvas>
    </div>
</template>

<script>
import { onMounted, ref } from "vue";
import Chart from "chart.js/auto";

export default {
    props: ["chartType", "chartData"],
    setup(props) {
        const chartCanvas = ref(null);

        onMounted(() => {
            new Chart(chartCanvas.value, {
                type: props.chartType,
                data: props.chartData,
            });
        });

        return {chartCanvas};
    },
};
</script>
