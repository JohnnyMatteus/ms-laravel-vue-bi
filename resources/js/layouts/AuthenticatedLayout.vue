<template>
    <div class="h-screen flex flex-col">
        <!-- Navbar -->
        <Navbar />

        <div class="flex flex-1 overflow-hidden">
            <!-- Sidebar -->
            <Sidebar @filter="applyFilters" />
            <slot :applyFilters="applyFilters" />

        </div>
    </div>
</template>

<script>
import Navbar from "../components/Navbar.vue";
import Sidebar from "../components/Sidebar.vue";

export default {
    name: "AuthenticatedLayout",
    components: {Navbar, Sidebar},
    methods: {
        applyFilters(filters) {
            this.$emit("filter", filters); // Emite o evento para o componente pai
        },
    },
};
</script>

<style scoped>
/* Adicione estilos necessários para o layout */
</style>
