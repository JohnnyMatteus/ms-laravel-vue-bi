<template>
    <AuthenticatedLayout>
        <div class="container mx-auto p-4">
            <h1 class="text-2xl font-bold mb-6">Dashboard</h1>
            <div class="grid grid-cols-2 gap-6">
                <div
                    v-for="chart in charts"
                    :key="chart.id"
                    class="border rounded-lg p-4 shadow hover:shadow-lg transition"
                >
                    <h2 class="text-lg font-bold mb-2">{{ chart.title }}</h2>
                    <Chart :chart-type="chart.type" :chart-data="chart.data" />
                    <router-link
                        :to="{ name: 'details', params: { id: chart.id } }"
                        class="mt-4 inline-block bg-blue-500 text-white py-2 px-4 rounded"
                    >
                        Ver Detalhes
                    </router-link>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import Chart from "../components/Chart.vue";
import AuthenticatedLayout from "../layouts/AuthenticatedLayout.vue";

export default {
    components: { Chart, AuthenticatedLayout },
    setup() {
        const charts = [
            {
                id: 1,
                title: "Retorno por Ação",
                type: "bar",
                data: {
                    labels: ["PETR4", "VALE3", "ITUB4", "BBAS3"],
                    datasets: [{ label: "Retorno (%)", data: [10, 20, 15, 25], backgroundColor: "blue" }],
                },
            },
            {
                id: 2,
                title: "Evolução do Patrimônio",
                type: "line",
                data: {
                    labels: ["Jan", "Feb", "Mar", "Apr"],
                    datasets: [{ label: "Evolução", data: [100, 200, 300, 400], borderColor: "green" }],
                },
            },
            {
                id: 3,
                title: "Distribuição de Ativos",
                type: "pie",
                data: {
                    labels: ["Ações", "FIIs", "Bancos"],
                    datasets: [{ label: "Distribuição", data: [60, 30, 10], backgroundColor: ["red", "blue", "yellow"] }],
                },
            },
        ];

        return { charts };
    },
};
</script>
