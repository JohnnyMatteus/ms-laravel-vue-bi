<template>
    <div class="h-screen flex flex-col">
        <!-- Navbar -->
        <Navbar />

        <div class="flex flex-1 overflow-hidden">
            <!-- Sidebar -->
            <Sidebar @filter="applyFilters" />

            <!-- Main Content -->
            <main class="flex-1 overflow-y-auto p-6">
                <slot />
            </main>
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
            // Transmitir os filtros para os gráficos ou dados
            this.$emit("filter", filters);
        },
    },
};
</script>

<style scoped>
/* Adicione estilos necessários para o layout */
</style>
