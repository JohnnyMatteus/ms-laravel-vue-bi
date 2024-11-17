<template>
    <header class="bg-blue-500 text-white p-4">
        <div class="flex justify-between items-center">
            <h1 class="text-lg font-bold">Meu Sistema</h1>
            <button @click="logout" class="text-sm text-white hover:underline">Logout</button>
        </div>
    </header>
</template>

<script>
export default {
    name: "Header",
    methods: {
        logout() {
            localStorage.removeItem("token");
            this.$router.push("/login");
        },
    },
};
</script>
