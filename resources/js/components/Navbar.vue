<template>
    <header class="bg-blue-500 text-white px-6 py-4 flex justify-between items-center">
        <h1 class="text-xl font-bold">Dashboard</h1>
        <nav>
            <router-link to="/user-requests" class="mr-4">User Requests</router-link>
            <button @click="logout" class="bg-red-500 px-4 py-2 rounded">Logout</button>
        </nav>
    </header>
</template>

<script>
export default {
    methods: {
        logout() {
            localStorage.removeItem("authToken");
            this.$router.push("/login");
        },
    },
};
</script>
