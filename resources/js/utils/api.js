import axios from "axios";
import { useAuthStore } from "../stores/auth";

const API = axios.create({
    baseURL: import.meta.env.VITE_API_BASE_URL || "http://localhost:8000/api",
    headers: {
        "Content-Type": "application/json",
    },
});

// Adiciona um interceptor para configurar o cabeçalho Authorization
API.interceptors.request.use(
    (config) => {
        const authStore = useAuthStore();

        if (authStore.token) {
            config.headers.Authorization = `Bearer ${authStore.token}`;
        }

        return config;
    },
    (error) => {
        return Promise.reject(error);
    }
);

// Adiciona um interceptor para capturar respostas
API.interceptors.response.use(
    (response) => {
        // Retorna a resposta normalmente se não houver erro
        return response;
    },
    (error) => {
        const authStore = useAuthStore();

        // Verifica se a mensagem de erro é "Unauthenticated."
        if (error.response?.data?.message === "Unauthenticated." && authStore.token) {
            // Desloga o usuário
            authStore.logout();

            // Opcional: Redireciona para a página de login
            window.location.href = "/login";
        }

        // Rejeita a promessa para continuar com o fluxo de erro do Axios
        return Promise.reject(error);
    }
);

export default API;
