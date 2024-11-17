<template>
    <div class="mb-4">
        <h3 class="font-bold text-gray-700 mb-2">Filters</h3>
        <div v-for="filter in filters" :key="filter.id" class="mb-2">
            <label :for="filter.id" class="block text-sm">{{ filter.label }}</label>
            <input
                :id="filter.id"
                :type="filter.type"
                v-model="filter.value"
                class="w-full p-2 border rounded"
            />
        </div>
        <button class="w-full bg-blue-500 text-white py-2 rounded" @click="applyFilters">Apply Filters</button>
    </div>
</template>

<script>
export default {
    name: "Filters",
    data() {
        return {
            filters: [
                { id: "filter1", label: "Filter 1", type: "text", value: "" },
                { id: "filter2", label: "Filter 2", type: "number", value: "" },
            ],
        };
    },
    methods: {
        applyFilters() {
            console.log("Filters applied:", this.filters);
        },
    },
};
</script>
