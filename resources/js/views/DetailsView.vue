<template>
    <AuthenticatedLayout @filter="applyFilters">
        <div class="container mx-auto p-4 overflow-y-auto">
            <!-- Título, Botão de Voltar e Barra de Pesquisa -->
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold">{{ chartDetails?.title || "Detalhes do Gráfico" }}</h1>
                <div class="flex items-center gap-4">
                    <input
                        type="text"
                        v-model="searchQuery"
                        placeholder="Pesquisar..."
                        class="border rounded px-4 py-2"
                    />
                    <router-link
                        to="/dashboard"
                        class="inline-block bg-gray-500 text-white py-2 px-4 rounded hover:bg-gray-600 transition"
                    >
                        Voltar
                    </router-link>
                </div>
            </div>

            <!-- Gráfico -->
            <div v-if="chartDetails" class="mb-6">
                <Chart :chart-type="chartDetails.type" :chart-data="chartDetails.data" />
            </div>

            <!-- Mensagem de Erro -->
            <div v-else>
                <h1 class="text-xl text-red-500">Gráfico não encontrado!</h1>
            </div>

            <!-- Tabela com Dados -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="table-auto w-full border-collapse border border-gray-300">
                        <thead class="bg-gray-100">
                        <tr>
                            <th
                                v-for="(header, index) in tableHeaders"
                                :key="index"
                                class="border border-gray-300 px-4 py-2 cursor-pointer"
                                @click="sortTable(header.field)"
                            >
                                {{ header.name }}
                                <span v-if="sortField === header.field">
                                        {{ sortOrder === "asc" ? "▲" : "▼" }}
                                    </span>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr
                            v-for="(item, index) in paginatedData"
                            :key="index"
                            class="hover:bg-gray-100"
                        >
                            <td class="border border-gray-300 px-4 py-2">
                                {{ item[tableHeaders[0].field] }}
                            </td>
                            <td class="border border-gray-300 px-4 py-2">
                                {{ item[tableHeaders[1].field] }}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <!-- Paginação -->
                <div class="flex justify-between items-center mt-4 p-4">
                    <button
                        class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600"
                        :disabled="currentPage === 1"
                        @click="currentPage--"
                    >
                        Anterior
                    </button>
                    <span>Página {{ currentPage }} de {{ totalPages }}</span>
                    <button
                        class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600"
                        :disabled="currentPage === totalPages"
                        @click="currentPage++"
                    >
                        Próxima
                    </button>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import { ref, reactive, onMounted, computed, watch } from "vue";
import { useRoute } from "vue-router";
import API from "../utils/api.js";
import Chart from "../components/Chart.vue";
import AuthenticatedLayout from "../layouts/AuthenticatedLayout.vue";

export default {
    components: { Chart, AuthenticatedLayout },
    setup() {
        const route = useRoute();
        const chartDetails = ref(null);
        const data = ref([]);
        const paginatedData = ref([]);
        const itemsPerPage = 10;
        const currentPage = ref(1);
        const searchQuery = ref("");

        const filters = reactive({
            investmentType: "all",
            startDate: "",
            endDate: "",
        });

        const sortField = ref(null);
        const sortOrder = ref("asc");

        const tableHeaders = ref([]);

        const fetchChartDetails = async () => {
            try {
                const chartType = route.params.chartType;

                if (!chartType) {
                    throw new Error("chartType não definido na rota.");
                }

                const response = await API.get(`/dashboard/details/${chartType}`, {
                    params: {
                        investment_type_id:
                            filters.investmentType !== "all" ? filters.investmentType : null,
                        date_range:
                            filters.startDate && filters.endDate
                                ? [filters.startDate, filters.endDate]
                                : null,
                    },
                });

                // Configuração de gráfico para diferentes tipos
                const chartMapping = {
                    actionReturns: {
                        title: "Retorno por Ação",
                        type: "bar",
                        labelsKey: "action_code",
                        dataKey: "average_return",
                        headers: [
                            { name: "Código", field: "action_code" },
                            { name: "Retorno (%)", field: "average_return" },
                        ],
                    },
                    patrimonyEvolution: {
                        title: "Evolução do Patrimônio",
                        type: "line",
                        labelsKey: "month",
                        dataKey: "value",
                        headers: [
                            { name: "Mês", field: "month" },
                            { name: "Valor", field: "value" },
                        ],
                    },
                    assetDistribution: {
                        title: "Distribuição de Ativos",
                        type: "pie",
                        labelsKey: "category",
                        dataKey: "percentage",
                        headers: [
                            { name: "Categoria", field: "category" },
                            { name: "Percentual (%)", field: "percentage" },
                        ],
                    },
                    sectorReturns: {
                        title: "Rentabilidade por Setor",
                        type: "bar",
                        labelsKey: "sector",
                        dataKey: "return_percentage",
                        headers: [
                            { name: "Setor", field: "sector" },
                            { name: "Retorno (%)", field: "return_percentage" },
                        ],
                    },
                    regionGrowth: {
                        title: "Crescimento por Região",
                        type: "line",
                        labelsKey: "region",
                        dataKey: "growth_rate",
                        headers: [
                            { name: "Região", field: "region" },
                            { name: "Crescimento (%)", field: "growth_rate" },
                        ],
                    },
                };

                const chartConfig = chartMapping[chartType];

                if (!chartConfig) {
                    throw new Error(`Configuração para ${chartType} não encontrada.`);
                }

                // Atualizar detalhes do gráfico
                chartDetails.value = {
                    title: chartConfig.title,
                    type: chartConfig.type,
                    data: {
                        labels: response.data.map((item) => item[chartConfig.labelsKey]),
                        datasets: [
                            {
                                label: chartConfig.title,
                                data: response.data.map((item) => item[chartConfig.dataKey]),
                                backgroundColor:
                                    chartConfig.type === "pie"
                                        ? ["#FF6384", "#36A2EB", "#FFCE56"]
                                        : "blue",
                                borderColor: chartConfig.type === "line" ? "green" : undefined,
                            },
                        ],
                    },
                };

                // Configurar dados da tabela
                data.value = response.data;

                tableHeaders.value = chartConfig.headers;

                // Atualizar paginação
                updatePagination();
            } catch (error) {
                console.error("Erro ao buscar detalhes do gráfico:", error);
                chartDetails.value = null;
            }
        };

        const totalPages = computed(() => Math.ceil(filteredData.value.length / itemsPerPage));

        const updatePagination = () => {
            const start = (currentPage.value - 1) * itemsPerPage;
            const end = start + itemsPerPage;
            paginatedData.value = filteredData.value.slice(start, end);
        };

        const applyFilters = (newFilters) => {
            Object.assign(filters, newFilters);
            fetchChartDetails(); // Recarrega o gráfico e a tabela
        };

        const filteredData = computed(() => {
            const query = searchQuery.value.toLowerCase();
            return data.value.filter((item) =>
                Object.values(item).some((val) =>
                    String(val).toLowerCase().includes(query)
                )
            );
        });

        const sortTable = (field) => {
            if (sortField.value === field) {
                sortOrder.value = sortOrder.value === "asc" ? "desc" : "asc";
            } else {
                sortField.value = field;
                sortOrder.value = "asc";
            }

            data.value.sort((a, b) => {
                if (sortOrder.value === "asc") {
                    return a[field] > b[field] ? 1 : -1;
                } else {
                    return a[field] < b[field] ? 1 : -1;
                }
            });

            updatePagination();
        };

        watch([currentPage, filteredData], updatePagination);

        onMounted(fetchChartDetails);

        return {
            chartDetails,
            data,
            paginatedData,
            itemsPerPage,
            currentPage,
            searchQuery,
            filters,
            sortField,
            sortOrder,
            tableHeaders,
            applyFilters,
            totalPages,
            sortTable,
            filteredData,
        };
    },
};
</script>
