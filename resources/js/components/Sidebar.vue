<template>
    <aside class="w-64 bg-gray-100 p-6">
        <h2 class="text-lg font-bold mb-4">Filtros</h2>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium">Tipo de Investimento</label>
                <select v-model="filters.investmentType" class="w-full border p-2 rounded">
                    <option value="all">Todos</option>
                    <option value="stocks">Ações</option>
                    <option value="funds">Fundos Imobiliários</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium">Intervalo de Data</label>
                <input type="date" v-model="filters.startDate" class="w-full border p-2 rounded mb-2" />
                <input type="date" v-model="filters.endDate" class="w-full border p-2 rounded" />
            </div>
            <button @click="applyFilters" class="w-full bg-blue-500 text-white py-2 rounded">Aplicar Filtros</button>
        </div>
    </aside>
</template>

<script>
export default {
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
            this.$emit("filter", this.filters);
        },
    },
};
</script>
