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
        <div v-if="error" class="text-red-500 mb-4">{{ error }}</div>
        <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded">Login</button>

        <!-- Adicione o link para a página de registro -->
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

export default {
    setup() {
        const authStore = useAuthStore();

        const email = ref("");
        const password = ref("");
        const error = ref(""); // Declare `error` como uma referência reativa

        const login = async () => {
            try {
                await authStore.login({ email: email.value, password: password.value });
                console.log("User logged in:", authStore.user);
            } catch (err) {
                error.value = "Login failed. Please check your credentials."; // Atualiza o erro
            }
        };

        return { email, password, error, login }; // Certifique-se de retornar `error`
    },
};
</script>

