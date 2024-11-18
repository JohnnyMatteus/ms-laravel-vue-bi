<template>
    <AuthenticatedLayout @filter="applyFilters">
        <div class="container mx-auto p-4 overflow-auto h-full">
            <h1 class="text-2xl font-bold mb-6">Dashboard</h1>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div
                    v-for="chart in charts"
                    :key="chart.id"
                    class="border rounded-lg p-4 shadow hover:shadow-lg transition"
                >
                    <h2 class="text-lg font-bold mb-2">{{ chart.title }}</h2>
                    <Chart :chart-type="chart.type" :chart-data="chart.data" />
                    <router-link
                        v-if="chart.detailsLink"
                        :to="{ name: 'details', params: { chartType: chart.id } }"
                        class="mt-4 inline-block bg-blue-500 text-white py-2 px-4 rounded"
                    >
                        Ver Mais Detalhes
                    </router-link>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import { reactive, ref, onMounted } from "vue";
import API from "../utils/api.js";
import Chart from "../components/Chart.vue";
import AuthenticatedLayout from "../layouts/AuthenticatedLayout.vue";

export default {
    components: { Chart, AuthenticatedLayout },
    setup() {
        const charts = ref([]);
        const filters = reactive({
            investmentType: "all",
            startDate: "",
            endDate: "",
        });
        const loading = ref(false); // Estado de carregamento

        const fetchCharts = async () => {
            loading.value = true; // Ativa o loader
            try {
                const response = await API.get("/dashboard", {
                    params: {
                        investment_type_id:
                            filters.investmentType !== "all" ? filters.investmentType : null,
                        date_range:
                            filters.startDate && filters.endDate
                                ? [filters.startDate, filters.endDate]
                                : null,
                    },
                });

                charts.value = [
                    {
                        id: "actionReturns",
                        title: "Retorno por Ação",
                        type: "bar",
                        data: {
                            labels: response.data.actionReturns.map((item) => item.action_code),
                            datasets: [
                                {
                                    label: "Retorno (%)",
                                    data: response.data.actionReturns.map((item) => item.average_return),
                                    backgroundColor: "blue",
                                },
                            ],
                        },
                        detailsLink: { name: "details", params: { id: "actionReturns" } }, // Link detalhado
                    },
                    {
                        id: "patrimonyEvolution",
                        title: "Evolução do Patrimônio",
                        type: "line",
                        data: {
                            labels: response.data.patrimonyEvolution.map((item) => item.period),
                            datasets: [
                                {
                                    label: "Evolução",
                                    data: response.data.patrimonyEvolution.map((item) => item.total_value),
                                    borderColor: "green",
                                },
                            ],
                        },
                        detailsLink: { name: "details", params: { id: "patrimonyEvolution" } },
                    },
                    {
                        id: "assetDistribution",
                        title: "Distribuição de Ativos",
                        type: "pie",
                        data: {
                            labels: response.data.assetDistribution.map((item) => item.label),
                            datasets: [
                                {
                                    label: "Distribuição",
                                    data: response.data.assetDistribution.map((item) => item.value),
                                    backgroundColor: ["red", "blue", "yellow"],
                                },
                            ],
                        },
                        detailsLink: { name: "details", params: { id: "assetDistribution" } },
                    },
                    {
                        id: "sectorReturns",
                        title: "Rentabilidade por Setor",
                        type: "bar",
                        data: {
                            labels: response.data.sectorReturns.map((item) => item.label),
                            datasets: [
                                {
                                    label: "Rentabilidade (%)",
                                    data: response.data.sectorReturns.map((item) => item.value),
                                    backgroundColor: "purple",
                                },
                            ],
                        },
                        detailsLink: { name: "details", params: { id: "sectorReturns" } },
                    },
                    {
                        id: "regionGrowth",
                        title: "Crescimento por Região",
                        type: "line",
                        data: {
                            labels: response.data.regionGrowth.map((item) => item.label),
                            datasets: [
                                {
                                    label: "Crescimento",
                                    data: response.data.regionGrowth.map((item) => item.value),
                                    borderColor: "orange",
                                },
                            ],
                        },
                        detailsLink: { name: "details", params: { id: "regionGrowth" } },
                    },
                ];
            } catch (error) {
                console.error("Erro ao buscar os gráficos:", error);
            } finally {
                loading.value = false; // Desativa o loader
            }
        };

        const applyFilters = (newFilters) => {
            Object.assign(filters, newFilters);
            fetchCharts();
        };

        onMounted(fetchCharts);

        return {
            charts,
            applyFilters,
            loading,
        };
    },
};
</script>

<style scoped>
.loader {
    display: inline-block;
    border: 4px solid rgba(0, 0, 0, 0.1);
    border-radius: 50%;
    border-top-color: #3498db;
    width: 40px;
    height: 40px;
    animation: spin 1s ease-in-out infinite;
}

@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}
</style>
