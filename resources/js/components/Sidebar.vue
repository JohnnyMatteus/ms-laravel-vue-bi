<template>
    <aside class="w-64 bg-gray-100 p-6">
        <h2 class="text-lg font-bold mb-4">Filtros</h2>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium">Tipo de Investimento</label>
                <select v-model="filters.investmentType" class="w-full border p-2 rounded">
                    <option value="all">Todos</option>
                    <option value="1">Ações</option>
                    <option value="2">Fundos Imobiliários</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium">Intervalo de Data</label>
                <input type="date" v-model="filters.startDate" class="w-full border p-2 rounded mb-2" />
                <input type="date" v-model="filters.endDate" class="w-full border p-2 rounded" />
            </div>
            <button
                :disabled="loading"
                @click="applyFilters"
                class="w-full bg-blue-500 text-white py-2 rounded disabled:opacity-50"
            >
                Aplicar Filtros
            </button>
            <button
                :disabled="loading"
                @click="clearFilters"
                class="w-full bg-gray-500 text-white py-2 rounded disabled:opacity-50 mt-2"
            >
                Limpar Filtros
            </button>
        </div>
    </aside>
</template>

<script>
export default {
    props: {
        loading: {
            type: Boolean,
            default: false,
        },
    },
    data() {
        return {
            filters: {
                investmentType: "all",
                startDate: "",
                endDate: "",
            },
        };
    },
    methods: {
        applyFilters() {
            this.$emit("filter", { ...this.filters });
        },
        clearFilters() {
            this.filters = {
                investmentType: "all",
                startDate: "",
                endDate: "",
            };
            this.$emit("filter", {...this.filters});
        },
    },
};
</script>
