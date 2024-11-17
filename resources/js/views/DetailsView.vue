<template>
    <AuthenticatedLayout>
        <div class="container mx-auto p-4">
            <div v-if="chartDetails">
                <h1 class="text-2xl font-bold mb-4">{{ chartDetails.title }}</h1>
                <Chart :chart-type="chartDetails.type" :chart-data="chartDetails.data" />
                <h2 class="text-xl font-bold mt-6">Dados Detalhados</h2>
                <table class="table-auto w-full border-collapse border border-gray-300 mt-4">
                    <thead class="bg-gray-100">
                    <tr>
                        <th class="border border-gray-300 px-4 py-2">Nome</th>
                        <th class="border border-gray-300 px-4 py-2">Valor</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(item, index) in chartDetails.data.labels" :key="index">
                        <td class="border border-gray-300 px-4 py-2">{{ item }}</td>
                        <td class="border border-gray-300 px-4 py-2">
                            {{ chartDetails.data.datasets[0].data[index] }}
                        </td>
                    </tr>
                    </tbody>
                </table>
                <!-- Botão de Voltar -->
                <div class="mt-6">
                    <router-link
                        to="/dashboard"
                        class="inline-block bg-gray-500 text-white py-2 px-4 rounded hover:bg-gray-600 transition"
                    >
                        Voltar
                    </router-link>
                </div>
            </div>
            <div v-else>
                <h1 class="text-2xl font-bold text-red-500">Gráfico não encontrado!</h1>
                <router-link to="/dashboard" class="text-blue-500 underline">Voltar para o Dashboard</router-link>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import { computed } from "vue";
import { useRoute } from "vue-router";
import Chart from "../components/Chart.vue";
import AuthenticatedLayout from "../layouts/AuthenticatedLayout.vue";

export default {
    components: { Chart, AuthenticatedLayout },
    setup() {
        const route = useRoute();
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

        const chartDetails = computed(() => {
            const chartId = Number(route.params.id);
            return charts.find((chart) => chart.id === chartId);
        });

        return { chartDetails };
    },
};
</script>
