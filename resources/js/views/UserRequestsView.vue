<template>
    <AuthenticatedLayout>
        <div class="container mx-auto py-6 px-4">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-bold">User Requests</h1>
                <!-- Botão para voltar -->
                <button
                    @click="goToDashboard"
                    class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition"
                >
                    Voltar para a Página Principal
                </button>
            </div>

            <!-- Quantitativos -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                <div
                    v-for="stat in aggregatedStats"
                    :key="stat.endpoint"
                    class="bg-blue-100 p-4 rounded shadow-md"
                >
                    <h2 class="text-lg font-bold">{{ stat.endpoint }}</h2>
                    <p class="text-gray-700">Total: {{ stat.total_count }}</p>
                </div>
            </div>

            <!-- Tabela -->
            <div class="overflow-x-auto bg-white shadow-md rounded">
                <table class="min-w-full border-collapse border border-gray-200">
                    <thead>
                    <tr class="bg-gray-100">
                        <th class="border border-gray-200 px-4 py-2">User</th>
                        <th class="border border-gray-200 px-4 py-2">Endpoint</th>
                        <th class="border border-gray-200 px-4 py-2">Total Access</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr
                        v-for="request in paginatedRequests"
                        :key="request.id"
                        class="hover:bg-gray-50"
                    >
                        <td class="border border-gray-200 px-4 py-2">{{ request.user }}</td>
                        <td class="border border-gray-200 px-4 py-2">{{ request.endpoint }}</td>
                        <td class="border border-gray-200 px-4 py-2">{{ request.total_count }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <!-- Paginação -->
            <div class="flex justify-end mt-4">
                <button
                    v-for="page in totalPages"
                    :key="page"
                    @click="currentPage = page"
                    class="px-4 py-2 mx-1 border rounded"
                    :class="{'bg-blue-500 text-white': currentPage === page, 'bg-gray-100': currentPage !== page}"
                >
                    {{ page }}
                </button>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import API from "../utils/api";
import AuthenticatedLayout from "../layouts/AuthenticatedLayout.vue";

export default {
    components: { AuthenticatedLayout },
    data() {
        return {
            rawData: [], // Dados brutos da API
            requests: [], // Dados processados para tabela
            aggregatedStats: [], // Dados agregados para visualização estatística
            currentPage: 1,
            itemsPerPage: 10,
        };
    },
    computed: {
        totalPages() {
            return Math.ceil(this.requests.length / this.itemsPerPage);
        },
        paginatedRequests() {
            const start = (this.currentPage - 1) * this.itemsPerPage;
            return this.requests.slice(start, start + this.itemsPerPage);
        },
    },
    methods: {
        async fetchUserRequests() {
            try {
                const response = await API.get("/user-requests");
                this.rawData = response.data;

                // Processar dados para a tabela
                this.requests = this.rawData.flatMap((item) =>
                    item.requests.map((request) => ({
                        id: `${item.user.id}-${request.endpoint}`,
                        user: item.user.name,
                        endpoint: request.endpoint,
                        total_count: request.total_count,
                    }))
                );

                // Agregar estatísticas para o quantitativo
                const statsMap = {};
                this.requests.forEach((req) => {
                    if (!statsMap[req.endpoint]) {
                        statsMap[req.endpoint] = { endpoint: req.endpoint, total_count: 0 };
                    }
                    statsMap[req.endpoint].total_count += req.total_count;
                });
                this.aggregatedStats = Object.values(statsMap);
            } catch (error) {
                console.error("Failed to fetch user requests:", error);
            }
        },
        goToDashboard() {
            this.$router.push("/dashboard");
        },
    },
    mounted() {
        this.fetchUserRequests();
    },
};
</script>

<style scoped>
button {
    transition: background-color 0.3s;
}
button:hover {
    background-color: #e0e0e0;
}
</style>
