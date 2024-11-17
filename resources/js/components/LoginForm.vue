<template>
    <form @submit.prevent="login" class="max-w-md mx-auto p-6 bg-white shadow-md rounded">
        <h2 class="text-xl font-bold mb-4">Login</h2>
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Email</label>
            <input v-model="email" type="email" class="w-full p-2 border rounded" required />
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Password</label>
            <input v-model="password" type="password" class="w-full p-2 border rounded" required />
        </div>
        <div v-if="loading" class="text-blue-500 mb-4">Logging in...</div>
        <div v-if="error" class="text-red-500 mb-4">{{ error }}</div>
        <button type="submit" :disabled="loading" class="w-full bg-blue-500 text-white py-2 rounded">
            Login
        </button>

        <p class="mt-4 text-center">
            Don't have an account?
            <router-link to="/register" class="text-blue-500 hover:underline">
                Register here
            </router-link>
        </p>
    </form>
</template>

<script>
import { ref } from "vue";
import { useAuthStore } from "../stores/auth";
import { useRouter } from "vue-router";
import axios from "axios";

export default {
    setup() {
        const authStore = useAuthStore();
        const router = useRouter();

        const email = ref("");
        const password = ref("");
        const error = ref("");
        const loading = ref(false);

        const login = async () => {
            loading.value = true;
            error.value = "";

            try {
                const response = await axios.post("/api/login", {
                    email: email.value,
                    password: password.value,
                });

                const token = response.data.token;

                // Atualizar o auth store com o token
                authStore.login(token);

                // Redirecionar para o dashboard após login bem-sucedido
                await router.push("/dashboard");
            } catch (err) {
                error.value = err.response?.data?.message || "Login failed. Please try again.";
            } finally {
                loading.value = false;
            }
        };

        return { email, password, error, loading, login };
    },
};
</script>
